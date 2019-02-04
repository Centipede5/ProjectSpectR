<?php

namespace App\Http\Controllers\NINAPI;

use App\Http\Controllers\LogIt;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

/**
 * Class NINAPI
 * @package App\Http\Controllers\NINAPI
 */
class NINAPI
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
    protected $maxReturnSize = 60;
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
     * Nintendo API constructor
     *
     * url is defined within the .env file under NINAPI_URL
     * @param $url
     *
     * @throws \Exception
     */
    public function __construct($url)
    {
        if (!is_string($url) || empty($url)) {
            // TODO: Add a system Alert here

            throw new \Exception('NINAPI Request URL is required!');
        }

        $this->baseUrl = $url;
        $this->httpClient = new Client();
    }

    /**
     * MAIN Method: Takes a given endpoint and returns the data as JSON
     *
     * @param $endPoint
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getGamesByEndpoint($endPoint)
    {
        # 1) Get the Total Item Results Count
        //   This will return a small result set that contains the total count of games available with the API CALL
        $apiUrl =  rtrim($this->baseUrl, '/').'/'.$endPoint.'/';
        $paramsForTotal = [
            'size'=>0,
            'bucket'=>'games',
            'start'=>0
        ];

        $apiDataForTotal = $this->apiGet($apiUrl, $paramsForTotal);
        $dataWithTotal = $this->decodeResponse($apiDataForTotal);
        $totalResults =  $dataWithTotal->{'data'}->{'attributes'}->{'total-results'};
        echo "Games Expected: " . $totalResults . PHP_EOL;

        # 2) Determine the amount of API Iterations
        $apiCallCount = ceil($totalResults / $this->maxReturnSize);
        echo "Making " . $apiCallCount . " API Calls..." . PHP_EOL;

        # 3) Make Each API Call, Strip out duplicates and Return Complete List of Games
        $games = []; // Array of Games
        $totalCounter=0;
        for($i=0;$i<$apiCallCount;$i++){
            $apiStart = $this->maxReturnSize * $i;
            $params = [
                'start'  => $apiStart,
                'size'   => $this->maxReturnSize,
                'bucket' => 'games'
            ];

            echo $i+1 . ") " . $apiStart . "/" . $totalResults. PHP_EOL;

            $apiData = $this->apiGet($apiUrl, $params);
            $apiGames = $this->decodeResponse($apiData);

            // Build a list of ALL the Game Data and Clean Up
            // Duplicate Game Listings by stripping out the legacy-sku's
            foreach($apiGames->{'included'} as $game){
                if($game->{'type'} != 'legacy-sku'){
                    $totalCounter++;
                    array_push($games,$game);
                }
            }
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
        // Update the API counter within nin_api_usage table
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
     * Increments the daily counter in nin_api_usage. This is used to track each API Request.
     *
     * @throws \Exception
     *
     * TODO: I need to separate the DB usage for any instances that the DB is not setup
     */
    public function updateApiCounter()
    {
        // Get monthly total API calls
        $apiCalls = DB::table('nin_api_usage')->get();
        $totalCalls=0;
        foreach($apiCalls as $apiCall){

            $now = time(); // or your date as well
            $your_date = strtotime($apiCall->updated_at);
            $daysPassed = round(($now - $your_date) / (60 * 60 * 24));

            if($daysPassed>=30){
                DB::table('nin_api_usage')
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
            DB::table('nin_api_usage')
                ->where('id', date("j"))
                ->update(['count' => $newDaily,'updated_at' => \Carbon\Carbon::now()]);
        }
    }

    /**
     * Decode the response from Nintendo eShop, extract the multiple resource object.
     * This was migrated from the IGDB Controller that had extra logic that was unnecessary.
     * This might be a great place to refactor the API response
     *
     * @param  string $apiData the api response from IGDB
     * @throws \Exception
     * @return \StdClass  an NIN resource object
     */
    private function decodeResponse(&$apiData)
    {
        $resObj = json_decode($apiData);
        return $resObj;
    }
}
