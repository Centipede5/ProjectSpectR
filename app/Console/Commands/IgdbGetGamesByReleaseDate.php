<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IgdbGetGamesByReleaseDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:getGamesByReleaseDate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compares the Available JSONs with the GameIDs table. If a JSON is missing, an API call will be made to get it.';

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
        # Get list of currently available Game Ids from JSON files
        $currentIds = $this->scanJsonDir();

        $foundGamesList = [];
        for($i=0;$i<90;$i++) {
            $startTime = strtotime("Today + $i days") . "000";

            echo "------- API CALL => " . date("m-d-Y", strtotime("Today + $i days")) . " -------" . PHP_EOL;
            $games = \IGDB::getGamesByReleaseDate($startTime,['game']);
            if ($games != false) {
                foreach ($games as $game) {
                    if (!in_array($game->game, $currentIds) && !in_array($game->game, $foundGamesList)) {
                        array_push($foundGamesList,$game->game);
                    }
                }
            } else {
                echo "FAILED" . PHP_EOL;
            }
            if(count($foundGamesList) > 30){
                echo "Processing: " . count($foundGamesList) . PHP_EOL;
                sleep(1);
                $this->getGames($foundGamesList);
                echo "Continuing..." . PHP_EOL;
                sleep(3);
                $foundGamesList = [];
//                echo "API limit approaching. Breaking loop!" . PHP_EOL;
//                break;
            }
        }

//        if (count($foundGamesList) > 0) {
//            echo "FOUND: " . count($foundGamesList) . PHP_EOL . PHP_EOL;
//            $this->getGames($foundGamesList);
//        } else {
//            echo "Up to Date: No New Release Dates!". PHP_EOL;
//        }
        # Get list of all Ids
        //$allGameIds = DB::table('igdb_game_ids')->select('igdb_id')->groupBy('igdb_id')->get();

        // Count of known Game Id's
        //$gameCount = count($allGameIds);

        //Build Missing Games Array
//        $missingGames = [];
//        foreach ($allGameIds as $allGameId){
//            if(!in_array($allGameId->igdb_id, $currentIds)){
//                array_push($missingGames,$allGameId->igdb_id);
//            }
//        }
//
//        $reqApiCalls = count($missingGames) / 50 . PHP_EOL;
//
//        echo "Old Game Count: " . $gameCount . " || New Game Count: " . count($missingGames) . PHP_EOL;
//        echo "Required API Calls: " . ceil($reqApiCalls) . PHP_EOL;
//
//        $grpCtr=1;
//        $gameGroups=[];
//        $gameGroupId=0;
//        $gameList="";
//        $ctr=1;
//        foreach($missingGames as $game){
//            if($ctr==count($missingGames)){
//                $gameList .= $game .",";
//                $gameGroups[$gameGroupId] = rtrim($gameList, ",");
//            } else if($grpCtr<50){
//                $gameList .= $game .",";
//                $grpCtr++;
//            } else {
//                $gameList .= $game .",";
//                $gameGroups[$gameGroupId] = rtrim($gameList, ",");
//                $gameList="";
//                $grpCtr=1;
//                $gameGroupId++;
//            }
//            $ctr++;
//        }
//
//        foreach ($gameGroups as $games){
//            $this->getGames($games);
//        }
    }

    private function getGames($i){
        echo "Loading " . count($i) . " records..." .PHP_EOL;
        $games = \IGDB::getGames(implode(',', $i));
        if ($games!=false){
            foreach ($games as $game){
                echo $game->id . "_" . $game->slug .PHP_EOL;
                $fp = fopen("resources/igdb/games/" . $game->id . "_" . $game->slug .'.json', 'w');
                fwrite($fp, json_encode($game));
                fclose($fp);
            }
        } else {
            echo "FAILED".PHP_EOL;
        }
    }

    private function scanJsonDir(){
        //scan JSON directory
        $DocDirectory = "resources/igdb/games";   //Directory to be scanned

        $arrDocs = array_diff(scandir($DocDirectory), array('..', '.','.DS_Store'));  //Scan the $DocDirectory and create an array list of all of the files and directories
        natcasesort($arrDocs);

        if( isset($arrDocs) && is_array($arrDocs) )
        {
            $games = [];
            foreach( $arrDocs as $a )   //For each document in the current document array
            {
                // Directory search and count
                if( is_file($DocDirectory . "/" . $a) && $a != "." && $a != ".." && $a != ".DS_Store" && substr($a,strlen($a)-3,3) != ".db" )      //The "." and ".." are directories.  "." is the current and ".." is the parent
                {
                    $game = explode("_",$a);
                    array_push($games,$game[0]);
                }
            }
        }
        return $games;
    }
}
