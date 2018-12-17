<?php

namespace App\Http\Controllers\PSNAPI;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class PSNAPI
{
    /**
     * @var string
     */
    protected $igdbKey;

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
        'PSVR' => 'STORE-MSF77008-GAMESPSVR',
    ];


    /**
     * IGDB constructor.
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
     * Decode the response from IGDB, extract the single resource object.
     * (Don't use this to decode the response containing list of objects)
     *
     * @param  string $apiData the api response from IGDB
     * @throws \Exception
     * @return \StdClass  an IGDB resource object
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
     * Decode the response from IGDB, extract the multiple resource object.
     *
     * @param  string $apiData the api response from IGDB
     * @throws \Exception
     * @return \StdClass  an IGDB resource object
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
                    'user-key' => $this->igdbKey,
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
