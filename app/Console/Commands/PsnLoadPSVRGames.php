<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PsnLoadPSVRGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psn:loadPSVRGames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[DELETE] [DEPRECATED]';

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
        //
        $this->loadJson('psvr-games.json');
    }

    /**
     * Loads in the JSON file to be processed
     *
     * @param $file
     */
    private function loadJson ($file) {
        // Loop through and pull in each file
        // Decode File
        // Insert Contents into table
        $filePath = "resources/psn/". $file;
        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);
        $psvrGames = [];
        $psnSkus = [];

        foreach($myJson as $game){
            $arr = explode("_",$game['id']);
            if($game['type'] == "game" && !in_array($arr[0],$psnSkus)){
                array_push($psvrGames,$game['attributes']['name']);
            } else if ($game['type'] == "legacy-sku" && !in_array($arr[0],$psnSkus)) {
                array_push($psvrGames,$game['attributes']['entitlements'][0]['name']);
            } else if (!in_array($arr[0],$psnSkus)) {
                array_push($psvrGames,$game['attributes']['name']);
            } else {
                echo "ERROR" . PHP_EOL;
            }

            array_push($psnSkus,$arr[0]);
        }

        asort($psvrGames);

        $prevName="";
        $ctr=0;
        foreach($psvrGames as $game){
            if($prevName!=$game){
                echo $game . PHP_EOL;
                $ctr++;
            }
            $prevName = $game;
        }
        echo $ctr . " / " . count($psvrGames) . " games found!";

//        $data=[];
//        $ctr=0;
//        $totalCtr=1;
//        if ($myJson!=false){
//            foreach ($myJson['games'] as $game) {
//                if($totalCtr==count($myJson['games'])) {
//                    array_push($data, ['igdb_id' => $game,'platform_id' => $myJson['id']]);
//                    $this->massInsert($data);
//                    break;
//                } else if($ctr<100) {
//                    array_push($data, ['igdb_id' => $game,'platform_id' => $myJson['id']]);
//                    $ctr++;
//                } else {
//                    $this->massInsert($data);
//                    $ctr=0;
//                    $data=[];
//                }
//                $totalCtr++;
//            }
//
//            echo PHP_EOL;
//
//        } else {
//            echo " | FAILED".PHP_EOL;
//        }
    }
}
