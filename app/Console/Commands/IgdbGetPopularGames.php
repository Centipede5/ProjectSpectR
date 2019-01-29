<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IgdbGetPopularGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:getPopularGames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[DELETE] [UNNECESSARY] Originally used to pull in a handful of games to launch with.';

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
        //scan JSON directory
        $DocDirectory = "resources/igdb/popular_games";   //Directory to be scanned

        $arrDocs = array_diff(scandir($DocDirectory), array('..', '.','.DS_Store'));  //Scan the $DocDirectory and create an array list of all of the files and directories
        natcasesort($arrDocs);

        if( isset($arrDocs) && is_array($arrDocs) )
        {
            foreach( $arrDocs as $a )   //For each document in the current document array
            {
                // Directory search and count
                if( is_file($DocDirectory . "/" . $a) && $a != "." && $a != ".." && $a != ".DS_Store" && substr($a,strlen($a)-3,3) != ".db" )      //The "." and ".." are directories.  "." is the current and ".." is the parent
                {
                    $this->createJsonFiles($a);
                }
            }
        }
    }

    private function createJsonFiles ($file) {
        // Loop through and pull in each file
        // Decode File
        // Insert Contents into table
        $filePath = "resources/igdb/popular_games/". $file;

        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        echo "LOADING: " . $file . PHP_EOL;
        sleep(3);
        foreach($myJson as $game){
            echo $game['name'] . " - ID: " . $game['id'] . PHP_EOL;
            $fileName = "resources/igdb/games/".$game['id'] . "_" . $game['slug'] . ".json";
            if(!is_file($fileName)){
                $fp = fopen($fileName, 'w');
                fwrite($fp, json_encode($game));
                fclose($fp);
            }
        }
    }

    private function customFixes (){

    }
}
