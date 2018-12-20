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
    protected $signature = 'psn:customSale';

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
        $continue = true;
        $saleEndPoints =[];

        // Returns the Children under the STORE-MSF77008-SAVE item id
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
            echo "Getting Games... " . PHP_EOL;

            $saleGames = \PSNAPI::getCustomSaleGames($endPoint);

            echo "Total Games: " . count($saleGames) . PHP_EOL;

            if ($saleGames != false) {
                echo "LOADING JSON" . PHP_EOL;

                // Dump the FULL Response to a file for use later
                $fp = fopen("resources/psn/" . $endPoint . '_full.json', 'w');
                fwrite($fp, json_encode($saleGames));
                fclose($fp);

                $this->minimizeJSON($endPoint);
            }
        }
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

            # Create a Separate Game JSON for each game found
            $fp = fopen("resources/psn/games/" . $game['id'] . '.json', 'w');
            fwrite($fp, json_encode($game));
            fclose($fp);
        }

        // Create a Separate Game JSON for each game found
        $fp = fopen("resources/psn/" . $jsonId . "_min.json", 'w');
        fwrite($fp, json_encode($miniJson));
        fclose($fp);
    }
}
