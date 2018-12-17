<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PsnGetPSVRGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psn:getPSVRGames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle() {

        $psvrGames = [];
        $games = \PSNAPI::getPSVRGames();
        if ($games != false) {
            echo "LOADING" . PHP_EOL;
            // Dump Response to file for use later
            $fp = fopen("resources/psn/" . 'psvr-games.json', 'w');
            fwrite($fp, json_encode($games->{'included'}));
            fclose($fp);

            $fp = fopen("resources/psn/" . 'psvr-games-complete.json', 'w');
            fwrite($fp, json_encode($games));
            fclose($fp);

            foreach($games->{'included'} as $game){
                if($game->{'type'} == "game"){
                    array_push($psvrGames,$game->{'attributes'}->{'name'});
                } else if ($game->{'type'} == "legacy-sku") {
                    array_push($psvrGames,$game->{'attributes'}->{'entitlements'}[0]->{'name'});
                }
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
        }
    }
}

