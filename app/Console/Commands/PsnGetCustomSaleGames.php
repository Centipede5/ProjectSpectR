<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PsnGetCustomSaleGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psn:getCustomSales {--excludeApiCall}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grabs the SALE API Endpoints and Builds out JSON Files for them';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit','512M');
        $continue = true;
        $saleEndPoints =[];

        // Returns the Children under the STORE-MSF77008-SAVE item id
        echo "Retrieving Sale Items..." . PHP_EOL;
        $saleItems = \PSNAPI::getSaleItems();
        foreach ($saleItems as $endPoint){
            if($continue == true){
                // The items that follow the STORE-MSF77008-SEPARATOR2 are the new Sales
                if($endPoint == 'STORE-MSF77008-SEPARATOR2'){
                    $continue = false;
                }
            } else {
                array_push($saleEndPoints,$endPoint);
            }
        }

        foreach($saleEndPoints as $endPoint){
            echo "Getting Games for: " . $endPoint . PHP_EOL;
            sleep(2);
            if(!$this->option('excludeApiCall')){
                $saleGames = \PSNAPI::getGamesByEndpoint($endPoint);
                echo "Total Games: " . count($saleGames) . PHP_EOL;
                if ($saleGames != false) {
                    echo "LOADING JSON" . PHP_EOL;

                    // Dump the FULL Response to a file for use later
                    $fp = fopen("resources/psn/" . $endPoint . '_full.json', 'w');
                    fwrite($fp, json_encode($saleGames));
                    fclose($fp);

                    echo "Minimizing JSON...." . PHP_EOL;
                    $this->minimizeJSON($endPoint);
                }
            } else {
                echo "[WARNING] Skipping API Call" . PHP_EOL;
                echo "Minimizing JSON...." . PHP_EOL;
                $this->minimizeJSON($endPoint);
                $this->createCSV($endPoint);
            }
        }
        $this->call('psn:loadGamesTable');
    }

    /**
     * Build a Minimized JSON with just the needed information
     *
     * @param $jsonId
     */
    private function minimizeJSON($jsonId){
        $filePath = "resources/psn/" . $jsonId . "_full.json";
        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        echo "Creating Game JSONs" . PHP_EOL;
        $miniJson = [];
        foreach($myJson as $game){
            $newGame=[];
            if(!$game['attributes']['name']){
                echo "NONE" . PHP_EOL;
            }
            $newGame['id'] = $game['id'];
            $newGame['name'] = $game['attributes']['name'];

            if(isset($game['attributes']['primary-classification'])){
                $newGame['primary-classification'] = $game['attributes']['primary-classification'];
            }
            array_push($miniJson,$newGame);


            $fileName = "resources/psn/games/" . substr($game['id'],0,6) . "/" . $game['id'] . ".json";
            $dirname = dirname($fileName);
            if (!is_dir($dirname)) {
                mkdir($dirname, 0755, true);
            }
            # Create a Separate Game JSON for each game found
            $fp = fopen($fileName, 'w');
            fwrite($fp, json_encode($game));
            fclose($fp);
        }

        // Create a Separate Game JSON for each game found
        $fp = fopen("resources/psn/" . $jsonId . "_min.json", 'w');
        fwrite($fp, json_encode($miniJson));
        fclose($fp);

        echo "[COMPLETE] Minimized JSON" . PHP_EOL;
    }

    private function createCSV ($jsonId) {

        $filePath = "resources/psn/" . $jsonId . "_full.json";
        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        $games = [['name','platform','price','discount','normal','rating','total']];
        $newGame = [];
        //$platformList="";
        foreach($myJson as $game){
            $newGame['name'] = $game['attributes']['name'];
//            foreach($game['attributes']['platforms'] as $platform){
//                $platformList .= $platform . "|";
//            }

            //$newGame['platform'] = trim($platformList. "|");
            $newGame['platform'] = $game['attributes']['platforms'][0];
            $newGame['price'] = $game['attributes']['skus'][0]['prices']['plus-user']['actual-price']['display'];
            $newGame['discount'] = $game['attributes']['skus'][0]['prices']['plus-user']['discount-percentage'];
            $newGame['normal'] = $game['attributes']['skus'][0]['prices']['plus-user']['strikethrough-price']['display'];
            $newGame['rating'] = $game['attributes']['star-rating']['score'];
            $newGame['total'] = $game['attributes']['star-rating']['total'];

            array_push($games,$newGame);
        }

        $fp = fopen("resources/psn/" . $jsonId . ".csv", 'w');
        foreach ($games as $game) {
            fputcsv($fp, $game);
        }
        fclose($fp);
    }
}