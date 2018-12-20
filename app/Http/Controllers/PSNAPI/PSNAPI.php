<?php

namespace App\Http\Controllers\PSNAPI;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class PSNAPI
{
    /**
     * @var string
     */
    protected $psnKey;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var array
     */
    const VALID_RESOURCES = [
        'PSVR'              => 'STORE-MSF77008-GAMESPSVR',
        'CUSTOM'            => 'STORE-MSF77008-HOLIDAYSALEPSVR',
        'BASE'              => 'STORE-MSF77008-BASE',
        'PLAYSTATIONPLUS'   => 'STORE-MSF77008-PLAYSTATIONPLUS',
        'WEEKLYDEALS'       => 'STORE-MSF77008-WEEKLYDEALS',
        'BUNDLESGRID'       => 'STORE-MSF77008-BUNDLESGRID',
        'SEPARATOR2'        => 'STORE-MSF77008-SEPARATOR2'
    ];

    # Known Possible End Points
    // STORE-MSF77008-9_INDIEGAMES
    //STORE-MSF77008-9_PS4PREORDERS
    //STORE-MSF77008-ACTION
    //STORE-MSF77008-ADDONSMUSICTRACK
    //STORE-MSF77008-ADDONSONLINEPASS
    //STORE-MSF77008-ALLADDONS
    //STORE-MSF77008-ALLAVATARSG
    //STORE-MSF77008-ALLDEMOS
    //STORE-MSF77008-ALLGAMES
    //STORE-MSF77008-AOSEASONPASSES
    //STORE-MSF77008-APPS
    //STORE-MSF77008-BESTOFPS3G
    //STORE-MSF77008-BUNDLES
    //STORE-MSF77008-BUNDLESGRID
    //STORE-MSF77008-CASUAL
    //STORE-MSF77008-CLASSICS
    //STORE-MSF77008-DISCOVERCREATRLP
    //STORE-MSF77008-DISCOVERMUSTWLP
    //STORE-MSF77008-EDCHOICE18LP
    //STORE-MSF77008-EXTRASPS3_C_G
    //STORE-MSF77008-EXTRASPS4_C_G
    //STORE-MSF77008-FIGHTING
    //STORE-MSF77008-GAMESFREETOPLAY
    //STORE-MSF77008-GAMESPSVRWEBHP
    //STORE-MSF77008-HOLIDAYSALELP
    //STORE-MSF77008-MINIS
    //STORE-MSF77008-MOSTDOWNLOADED
    //STORE-MSF77008-MUSIC
    //STORE-MSF77008-NEWADDONS
    //STORE-MSF77008-NEWGAMESGRID
    //STORE-MSF77008-NEWPS4ADDONSCATE
    //STORE-MSF77008-NEWPS4DEMOSCATEG
    //STORE-MSF77008-NEWPS4GAMESCATEG
    //STORE-MSF77008-NEWRELEASESPS3
    //STORE-MSF77008-NEWTHISMONTH
    //STORE-MSF77008-NEWTHISWEEK
    //STORE-MSF77008-PLATFORMER
    //STORE-MSF77008-PLAYSTATIONHITS
    //STORE-MSF77008-PLAYSTATIONPLUS
    //STORE-MSF77008-PLAYTHISNEXTLP
    //STORE-MSF77008-PS2GAMESONPS4G
    //STORE-MSF77008-PS3ALLPS3GAMES
    //STORE-MSF77008-PS3AOSUBSCRIPTIO
    //STORE-MSF77008-PS3BETAS
    //STORE-MSF77008-PS3DIGITALPS3
    //STORE-MSF77008-PS3F2PPS3
    //STORE-MSF77008-PS3FULLGAMES
    //STORE-MSF77008-PS3FULLGAMESPS3
    //STORE-MSF77008-PS3INDIESPS3
    //STORE-MSF77008-PS3PSNPREORDERS
    //STORE-MSF77008-PS3PSPLUSFGTRIAL
    //STORE-MSF77008-PS3TOPS4
    //STORE-MSF77008-PS4ALLGAMESCATEG
    //STORE-MSF77008-PS4DIGITALONLYCT
    //STORE-MSF77008-PS4EXCLUSIVESCAT
    //STORE-MSF77008-PS4FREETOPLAYCAT
    //STORE-MSF77008-PS4FULLGAMESCATE
    //STORE-MSF77008-PS4INDIESGAMECAT
    //STORE-MSF77008-PSNGAMES
    //STORE-MSF77008-PSNOWSUBSCRIBEG
    //STORE-MSF77008-PSPALLPSPGAMES
    //STORE-MSF77008-PSTVCOMPATIBLE
    //STORE-MSF77008-PSVITAALLGAMES
    //STORE-MSF77008-PSVRADDONSG
    //STORE-MSF77008-PSVRAPPSG
    //STORE-MSF77008-PSVRCOMPATG
    //STORE-MSF77008-PSVRFREEG
    //STORE-MSF77008-PSVRNEWG
    //STORE-MSF77008-PSVRPOPULARG
    //STORE-MSF77008-PSVRREQUIREDG
    //STORE-MSF77008-PSVUEWEBLP
    //STORE-MSF77008-RACING
    //STORE-MSF77008-RETRO
    //STORE-MSF77008-ROLEPLAYINGGAME
    //STORE-MSF77008-SHOOTEMUP
    //STORE-MSF77008-SHOOTER
    //STORE-MSF77008-SPORTS
    //STORE-MSF77008-STRATEGY
    //STORE-MSF77008-THEMESALLTHEMES
    //STORE-MSF77008-THEMESDYNTHEMES
    //STORE-MSF77008-TOPGAMES
    //STORE-MSF77008-TOPPS3ADDONS
    //STORE-MSF77008-TOPPSNGAMES
    //STORE-MSF77008-ULTIMATEEDITIONS
    //STORE-MSF77008-UNIQUE
    //STORE-MSF77008-VIRTUALREALITYG
    //STORE-MSF77008-WEEKLYDEALS


    /**
     * PSN constructor.
     *
     * @param $key
     *
     * @param $url
     *
     * @throws \Exception
     */
    public function __construct($url)
    {
        if (!is_string($url) || empty($url)) {
            throw new \Exception('PSNAPI Request URL is required!');
        }

        $this->baseUrl = $url;
        $this->httpClient = new Client();
    }

    /**
     * Get people information by ID
     *
     * @param integer $limit
     *
     * @return \StdClass
     * @throws \Exception
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
        return $this->decodeMultiple($apiData);
    }

    public function getCustomSaleGames($endPoint)
    {
        // 1) Get the Total Results Count
        $apiUrl =  rtrim($this->baseUrl, '/').'/'.$endPoint.'/';
        $paramsForTotal = [
            'size'=>0,
            'bucket'=>'games',
            'start'=>0
        ];

        $apiDataForTotal = $this->apiGet($apiUrl, $paramsForTotal);
        $dataWithTotal = $this->decodeMultiple($apiDataForTotal);

        $totalResults =  $dataWithTotal->{'data'}->{'attributes'}->{'total-results'};

        echo "Games Expected: " . $totalResults . PHP_EOL;

        // 2) Determine the amount of API Iterations
        $apiSize = 60;
        $apiCallCount = ceil($totalResults / $apiSize);

        // 3) Make Each API Call and Strip out duplicates
        $games = [];
        $validGames = [];
        $totalCounter=1;
        for($i=0;$i<$apiCallCount;$i++){
            $apiStart = $apiSize * $i;
            $params = [
                'size'=>$apiSize,
                'bucket'=>'games',
                'start'=>$apiStart
            ];

            echo $i . ") " . $apiStart . "/" . $totalResults. PHP_EOL;

            $apiData = $this->apiGet($apiUrl, $params);
            $apiGames = $this->decodeMultiple($apiData);
            // Clean Up Duplicate Game Listings
            foreach($apiGames->{'included'} as $game){
                // Build a list of ALL the Game Ids excluding the legacy-sku's
                if($game->{'type'} != 'legacy-sku'){
                    $totalCounter++;
                    array_push($games,$game);
                }
            }
        }
        // 4) Return Results
        return $games;
    }

    /**
     * getSaleItems will search through the base API and
     * Return the Children under the STORE-MSF77008-SAVE item id
     *
     * @return array
     * @throws \Exception
     */
    public function getSaleItems () {
        $saleIds = [];   // The Sale URL IDs
        $apiUrl = $this->getEndpoint('BASE');

        $params = [];
        $apiData = $this->apiGet($apiUrl, $params);
        $items = $this->decodeMultiple($apiData);

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

    public function updateApiCounter () {

        # Get monthly total API calls
        $apiCalls = DB::table('psn_api_usage')->get();
        $totalCalls=0;
        foreach($apiCalls as $apiCall){

            $now = time(); // or your date as well
            $your_date = strtotime($apiCall->updated_at);
            $daysPassed = round(($now - $your_date) / (60 * 60 * 24));

            if($daysPassed>=30){
                DB::table('psn_api_usage')
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
            throw new \Exception('API Limit has been reached for the month');
        } else {
            $newDaily = $currentDailyCount + 1;
            DB::table('psn_api_usage')
                ->where('id', date("j"))
                ->update(['count' => $newDaily,'updated_at' => \Carbon\Carbon::now()]);
        }

    }

    /*
     *  Internally used Methods, set visibility to public to enable more flexibility
     */
    /**
     * @param $name
     * @return mixed
     */
    private function getEndpoint($name)
    {
        return rtrim($this->baseUrl, '/').'/'.self::VALID_RESOURCES[$name].'/';
    }

    /**
     * Decode the response from PSN, extract the single resource object.
     * (Don't use this to decode the response containing list of objects)
     *
     * @param  string $apiData the api response from IGDB
     * @throws \Exception
     * @return \StdClass  an PSN resource object
     */
    private function decodeSingle(&$apiData)
    {
        $resObj = json_decode($apiData);

        if (isset($resObj->status)) {
            $msg = "Error " . $resObj->status . " " . $resObj->message;
            throw new \Exception($msg);
        }

        if (!is_array($resObj) || count($resObj) == 0) {
            return false;
        }

        return $resObj[0];
    }

    /**
     * Decode the response from PSN, extract the multiple resource object.
     *
     * @param  string $apiData the api response from IGDB
     * @throws \Exception
     * @return \StdClass  an PSN resource object
     */
    private function decodeMultiple(&$apiData)
    {
        $resObj = json_decode($apiData);

                return $resObj;
//        if (isset($resObj->status)) {
//            $msg = "Error " . $resObj->status . " " . $resObj->message;
//            throw new \Exception($msg);
//        } else {
//            //$itemsArray = $resObj->items;
//            if (!is_array($resObj)) {
//                return false;
//            } else {
//                return $resObj;
//            }
//        }
    }

    /**
     * Using CURL to issue a GET request
     *
     * @param $url
     * @param $params
     * @return mixed
     * @throws \Exception
     */
    private function apiGet($url, $params)
    {
        $this->updateApiCounter();   // Update Local API counter
        $url = $url . (strpos($url, '?') === false ? '?' : '') . http_build_query($params);

        try {
            $response = $this->httpClient->request('GET', $url, [
                'headers' => [
                    'user-key' => $this->psnKey,
                    'Accept' => 'application/json'
                ]
            ]);
        } catch (RequestException $exception) {
            if ($response = $exception->getResponse()) {
                throw new \Exception($exception);
            }
            throw new \Exception($exception);
        } catch (Exception $exception) {
            throw new \Exception($exception);
        }

        return $response->getBody();
    }
}
