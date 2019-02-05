<?php

namespace App\Http\Controllers\XBOXAPI;

use App\Http\Controllers\LogIt;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

/**
 * Class XBOXAPI
 * @package App\Http\Controllers\XBOXAPI
 */
class XBOXAPI
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * The baseUrl is set within the constructor. It is defined in the .env file.
     * @var string
     */
    protected $baseUrl;

    /**
     * This is the maximum allowed items return size for each API CALL
     *
     * @var int
     */
    protected $maxReturnSize = 20;


    protected $market = "US";
    protected $languages = "en-us";
    protected $mscv = "DGU1mcuYo0WMMp+F.1";

    /**
     * These are a list of valid endpoints that can be
     * used with a readable variable name
     *
     * @var array
     */
    const VALID_RESOURCES = [
        'BASE'              => 'STORE-MSF77008-BASE',
    ];

    /**
     * XBOX API constructor
     *
     * url is defined within the .env file under XBOXAPI_URL
     * @param $url
     *
     * @throws \Exception
     */
    public function __construct($url)
    {
        if (!is_string($url) || empty($url)) {
            // TODO: Add a system Alert here

            throw new \Exception('XBOXAPI Request URL is required!');
        }

        $this->baseUrl = $url;
        $this->httpClient = new Client();
    }


    /**
     * The Xbox Game IDs are stored within a javascript file and need to be parsed out
     * This is a little ugly, but it works.
     *
     * @return array|mixed|string
     */
    public function getAllGameIds()
    {
        $gameArray = [];
        $contents = file_get_contents('https://www.xbox.com/en-US/games/xbox-one/js/xcat-bi-urls.json');
        $searchfor = 'fullGameArray';   //fullGameArray = ["BV9V78HQ6PK3", "9NB5XZ7DK7L7", etc.

        // Search for the given string, clean and save the gameIds to a PHP Array
        $pattern = preg_quote($searchfor, '/');
        $pattern = "/^.*$pattern.*\$/m";
        if(preg_match_all($pattern, $contents, $matches)){
            $gameArray = implode("\n", $matches[0]);
            $gameArray = str_replace('"','',substr($gameArray,17,-2));
            $gameArray = explode(', ',$gameArray);
        } else {
            echo "ALERT: No matches found";
        }

        return $gameArray;
    }

    public function getGamesByEndpoint($gamesArray, $endPoint="products")
    {
        $apiUrl =  rtrim($this->baseUrl, '/').'/'.$endPoint.'/';

        # 1) Get the Total Item Results Count
        $totalResults =  count($gamesArray);
        echo "Games Expected: " . $totalResults . PHP_EOL;

        # 2) Determine the amount of API Iterations
        $apiCallCount = ceil($totalResults / $this->maxReturnSize);
        echo "Making " . $apiCallCount . " API Calls..." . PHP_EOL;

        # 3) Make Each API Call
        $games = []; // Array of Games to return
//        $gameIdsLoaded = []; // Array of Games to return
        $totalCounter=0;
        for($i=0;$i<$apiCallCount;$i++){
            $gameStart = $this->maxReturnSize * $i;
            $gameEnd = $gameStart + $this->maxReturnSize;

            $bigIds="";
            for($ctr=$gameStart;$ctr<=$gameEnd;$ctr++){
                if($ctr<$totalResults){
                    $bigIds .= $gamesArray[$ctr] . ",";
                }
            }

            $params = [
                'market'    => $this->market,
                'languages' => $this->languages,
                'MS-CV'     => $this->mscv,
                'bigIds'    => trim($bigIds,',')
            ];

            echo $i+1 . ") " . $gameStart . "/" . $totalResults. PHP_EOL;

            $apiData = $this->apiGet($apiUrl, $params);
            $apiGames = $this->decodeResponse($apiData);

            // Build a list of ALL the Game Data and Clean Up
            foreach($apiGames->{'Products'} as $game){
//                array_push($gameIdsLoaded,$game->{'ProductId'});
                $totalCounter++;
                array_push($games,$game);
            }

//            Missing Games that did not load from the API Call
//            $checkingIds = explode(",",$bigIds);
//
//            foreach($checkingIds as $gameId){
//                if(!in_array($gameId,$gameIdsLoaded)){
//                    echo $gameId . PHP_EOL;
//                }
//            }
        }

        # 4) Return Results
        return $games;
    }

    /**
     * Get the games that are Unreleased and available for pre-order
     *
     * @param int $limit
     * @return \StdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFutureGames($limit=0)
    {
        $params = [];
        $apiUrl = $this->getEndpoint('COMINGSOON');

        if($limit!=0){
            $params = [
                'size' => $limit
            ];
        }

        $apiData = $this->apiGet($apiUrl, $params);
        return $this->decodeResponse($apiData);
    }

    /**
     * @param int $limit
     * @return \StdClass
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPSVRGames($limit=0)
    {
        $params = [];
        $apiUrl = $this->getEndpoint('PSVR');

        if($limit!=0){
            $params = [
                'size' => $limit
            ];
        }

        $apiData = $this->apiGet($apiUrl, $params);
        return $this->decodeResponse($apiData);
    }


    /**
     * getSaleItems will search through the base API and
     * Return the Children under the STORE-MSF77008-SAVE item id
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSaleItems () {
        $saleIds = [];   // The Sale URL IDs
        $apiUrl = $this->getEndpoint('BASE');

        $params = [];
        $apiData = $this->apiGet($apiUrl, $params);
        $items = $this->decodeResponse($apiData);

        // $items will include several of the BASE API End Points
        // The STORE-MSF77008-SAVE end point contains the Current Sales
        foreach($items->{'included'} as $item){
            if($item->{'id'} == 'STORE-MSF77008-SAVE'){
                foreach ($item->{'relationships'}->{'children'}->{'data'} as $saleItem){
                    array_push($saleIds,$saleItem->{'id'});
                }
            }
        }

        return $saleIds;
    }

    /**
     * This will build and return the base API URL including the given endpoint.
     * It also will validate the given ENDPOINT with those registered in VALID_RESOURCES
     *
     * @param $name
     * @return mixed
     */
    private function getEndpoint($name)
    {
        return rtrim($this->baseUrl, '/').'/'.self::VALID_RESOURCES[$name].'/';
    }

    /**
     * Using cURL to issue a GET request
     *
     * @param $url
     * @param $params
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function apiGet($url, $params)
    {
        // Update the API counter within xbox_api_usage table
        try{
            $this->updateApiCounter();
        } catch (\Exception $e) {
            // TODO: Add a system Alert here
            echo "ERROR!!!! " . PHP_EOL;
            LogIt::error($e);
            die($e);
        }

        // Build the Final URL for the API call using the given $params
        $url = $url . (strpos($url, '?') === false ? '?' : '') . http_build_query($params);
        LogIt::info("[API CALL] " . $url);

        try {
            $response = $this->httpClient->request(
                'GET', $url, [
                    'headers' => [
                        'Accept' => 'application/json'
                    ]
                ]
            );
        } catch (RequestException $exception) {
            // TODO: Add a system Alert here
            if ($response = $exception->getResponse()) {
                throw new \Exception($exception);
            }
            throw new \Exception($exception);
        } catch (Exception $exception) {
            // TODO: Add a system Alert here
            throw new \Exception($exception);
        }

        return $response->getBody();
    }

    /**
     * Increments the daily counter in xbox_api_usage. This is used to track each API Request.
     *
     * @throws \Exception
     *
     * TODO: I need to separate the DB usage for any instances that the DB is not setup
     */
    public function updateApiCounter()
    {
        // Get monthly total API calls
        $apiCalls = DB::table('xbox_api_usage')->get();
        $totalCalls=0;
        foreach($apiCalls as $apiCall){

            $now = time(); // or your date as well
            $your_date = strtotime($apiCall->updated_at);
            $daysPassed = round(($now - $your_date) / (60 * 60 * 24));

            if($daysPassed>=30){
                DB::table('xbox_api_usage')
                    ->where('id', $apiCall->id)
                    ->update(['count' => 0,'updated_at' => \Carbon\Carbon::now()]);
                $apiCount = 0;
            } else {
                $apiCount = $apiCall->count;
            }

            $totalCalls = $apiCount + $totalCalls;
            if($apiCall->id == date("j")){
                $currentDailyCount = $apiCount;
            }
        }

        if ($totalCalls>2999) {
            // TODO: Add a system Alert here
            throw new \Exception('API Limit has been reached for the month');
        } else {
            $newDaily = $currentDailyCount + 1;
            DB::table('xbox_api_usage')
                ->where('id', date("j"))
                ->update(['count' => $newDaily,'updated_at' => \Carbon\Carbon::now()]);
        }
    }

    /**
     * Decode the response from XBOX, extract the multiple resource object.
     * This was migrated from the IGDB Controller that had extra logic that was unnecessary.
     * This might be a great place to refactor the API response
     *
     * @param  string $apiData the api response from IGDB
     * @throws \Exception
     * @return \StdClass  an XBOX resource object
     */
    private function decodeResponse(&$apiData)
    {
        $resObj = json_decode($apiData);
        return $resObj;
    }
}
