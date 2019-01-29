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
    protected $description = 'Builds a list of missing IGDB IDs and searches for them';

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
        # Get list of all Ids
        $allGameIds = DB::table('games')->select('igdb_id')->orderBy('igdb_id', 'asc')->get();
        // Count of known Game Id's

        $loadedGames = [];
        foreach ($allGameIds as $allGameId){
            array_push($loadedGames,$allGameId->igdb_id);
        }

        $gameCount = count($loadedGames);

        echo $gameCount . PHP_EOL;


        //Build Missing Games Array
        $missingGames = [];
        for ($i=1;$i<5000; $i++){
            if(!in_array($i,$loadedGames)){
                array_push($missingGames,$i);
            }
        }
        echo count($missingGames) . PHP_EOL;
//
        $reqApiCalls = count($missingGames) / 50 . PHP_EOL;
//
        echo "Old Game Count: " . $gameCount . " || New Game Count: " . count($missingGames) . PHP_EOL;
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
    }

    private function getGames($i){
        echo "Loading " . count(explode(',',$i)) . " records..." .PHP_EOL;
        $games = \IGDB::getGames($i);
        if ($games!=false){
            sleep(2);
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
