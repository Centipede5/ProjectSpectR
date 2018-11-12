<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class LoadIgdbGameIdsTable
 * @package App\Console\Commands
 */
class LoadIgdbGameIdsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:loadIgdbGameIdsTable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load in the Igdb Game Ids for each platform that has a platform_games JSON.';

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
        echo "-- GAME IDS TABLE -" . PHP_EOL;
        echo "[CLEARING TABLE]" . PHP_EOL;
        DB::table('igdb_game_ids')->delete();

        //scan JSON directory
        $DocDirectory = "resources/igdb/platform_games";   //Directory to be scanned
        $arrDocs = array_diff(scandir($DocDirectory), array('..', '.','.DS_Store'));  //Scan the $DocDirectory and create an array list of all of the files and directories
        natcasesort($arrDocs);

        echo "[SCANNING]" . PHP_EOL;
        if( isset($arrDocs) && is_array($arrDocs) )
        {
            foreach( $arrDocs as $a )   //For each document in the current document array
            {
                // Directory search and count
                if( is_file($DocDirectory . "/" . $a) && $a != "." && $a != ".." && $a != ".DS_Store" && substr($a,strlen($a)-3,3) != ".db" )      //The "." and ".." are directories.  "." is the current and ".." is the parent
                {
                    $this->loadJson($a);
                }
            }
        }
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
        $filePath = "resources/igdb/platform_games/". $file;
        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        echo "Loading Platform ID [" . $myJson['id'] . "] ";
        $data=[];
        $ctr=0;
        $totalCtr=1;
        if ($myJson!=false){
            foreach ($myJson['games'] as $game) {
                if($totalCtr==count($myJson['games'])) {
                    array_push($data, ['igdb_id' => $game,'platform_id' => $myJson['id']]);
                    $this->massInsert($data);
                    break;
                } else if($ctr<100) {
                    array_push($data, ['igdb_id' => $game,'platform_id' => $myJson['id']]);
                    $ctr++;
                } else {
                    $this->massInsert($data);
                    $ctr=0;
                    $data=[];
                }
                $totalCtr++;
            }

            echo PHP_EOL;

        } else {
            echo " | FAILED".PHP_EOL;
        }
    }

    /**
     * Takes an Array of Data to be inserted
     * @param $data
     */
    private function massInsert ($data) {
        echo ".";
        DB::table('igdb_game_ids')->insert($data);
    }
}
