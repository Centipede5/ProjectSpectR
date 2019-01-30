<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IgdbGetMissingGamesDeepScan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:getMissingGamesDeepScan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Builds a list of missing IGDB IDs from the GAMES table and searches for them.';

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
        echo "==== GetMissingGamesDeepScan ===" . PHP_EOL;
        # Get list of all Ids
        $allGameIds = DB::table('games')->select('igdb_id')->orderBy('igdb_id', 'asc')->get();
        // Count of known Game Id's

        $loadedGames = [];
        foreach ($allGameIds as $allGameId){
            array_push($loadedGames,$allGameId->igdb_id);
        }

        $gameCount = count($loadedGames);

        echo "Current Games Loaded: " . $gameCount . PHP_EOL;

        echo "Building Missing Games Array" . PHP_EOL;
        //Build Missing Games Array
        $missingGames = [];
        for ($i=1;$i<116000; $i++){
            if(!in_array($i,$loadedGames)){
                if($i%10==0){
                    echo ".";
                }
                array_push($missingGames,$i);
            }
        }
        echo PHP_EOL . "Missing Games: " . count($missingGames) . PHP_EOL;

        $reqApiCalls = count($missingGames) / 50 . PHP_EOL;

        echo "New Games to Locate: " . count($missingGames) . PHP_EOL;
        echo "Required API Calls: " . ceil($reqApiCalls) . PHP_EOL;

        $grpCtr=1;
        $gameGroups=[];
        $gameGroupId=0;
        $gameList="";
        $ctr=1;
        foreach($missingGames as $game){
            if($ctr==count($missingGames)){
                $gameList .= $game .",";
                $gameGroups[$gameGroupId] = rtrim($gameList, ",");
            } else if($grpCtr<50){
                $gameList .= $game .",";
                $grpCtr++;
            } else {
                $gameList .= $game .",";
                $gameGroups[$gameGroupId] = rtrim($gameList, ",");
                $gameList="";
                $grpCtr=1;
                $gameGroupId++;
            }
            $ctr++;
        }

        $ctr=1;
        foreach ($gameGroups as $games){
            echo $ctr . "/" . ceil($reqApiCalls) . PHP_EOL;
            $this->getGames($games);
            $ctr++;
        }

        $this->call('spectre:loadGamesTableWithData');
    }

    private function getGames($i){
        echo "Loading " . count(explode(',',$i)) . " records..." .PHP_EOL;
        $games = \IGDB::getGames($i);
        if ($games!=false){
            sleep(2);
            foreach ($games as $game){
                if(strlen($game->id)>1){
                    $newDir = substr($game->id,-2);
                } else{
                    $newDir = "0" . $game->id;
                }

                echo $game->id . "_" . $game->slug .PHP_EOL;
                $fp = fopen("resources/igdb/games/" . $newDir . "/" . $game->id . "_" . $game->slug .'.json', 'w');
                fwrite($fp, json_encode($game));
                fclose($fp);
            }
        } else {
            echo "FAILED".PHP_EOL;
        }
    }
}
