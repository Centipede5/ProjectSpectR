<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
class SpectreAutoMatchIgdbId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spectre:matchIgdbIds';

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
    public function handle()
    {
        $subDirectoryList = [];
        $DocDirectory = "resources/psn/games";   //Directory to be scanned

        $arrDocs = array_diff(scandir($DocDirectory), array('..', '.', '.db'));  //Scan the $DocDirectory and create an array list of all of the files and directories
        natcasesort($arrDocs);
        if( isset($arrDocs) && is_array($arrDocs) ) {
            foreach ($arrDocs as $a)   //For each document in the current document array
            {
                // Directory search and count
                if (is_dir($DocDirectory . "/" . $a))      //The "." and ".." are directories.  "." is the current and ".." is the parent
                {
                    array_push($subDirectoryList, $a);
                }
            }
        }
        echo "DIRECTORIES FOUND: " . count($subDirectoryList) . PHP_EOL;
        echo "SCANNING DIRECTORIES FOR FILES" . PHP_EOL;

        $subDirCtr=1;
        $fileCtr=0;
        $gameCtr=0;
        foreach ($subDirectoryList as $dirName){
            $DocDirectory = "resources/psn/games/" . $dirName;
            $arrDocs = array_diff(scandir($DocDirectory), array('..', '.', '.db'));
            natcasesort($arrDocs);

            if( isset($arrDocs) && is_array($arrDocs) )
            {
                $totalCtr=1;
                foreach( $arrDocs as $a ){
                    if( is_file($DocDirectory . "/" . $a)) {
                        $fileCtr++;
                        if($this->loadJson($dirName,$a)){
                            $gameCtr++;
                        }

                        $totalCtr++;
                    }
                }
            }
            $subDirCtr++;
        }

        echo PHP_EOL . "Games Matched: " . $gameCtr . "/" . $fileCtr . PHP_EOL;
    }

    private function loadJson ($dirName,$file) {
        // Loop through and pull in each file
        // Decode File
        // Insert Contents into table
        $filePath = "resources/psn/games/" . $dirName . "/" . $file;
        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        ### Process JSON ###
        $psn_id                         =   $myJson['id'];
        $name                           =   $myJson['attributes']['name'];
        $release_date                   =   date("Y-m-d", strtotime($myJson['attributes']['release-date']));

        $gamesFound = DB::table('games')
            ->where('title', $name)
            ->whereDate('release_date', $release_date)
            ->get();

        if(count($gamesFound)>0){
            if(count($gamesFound)==1){
                foreach ($gamesFound as $game){
                    $this->updateRecords($game->igdb_id,$psn_id);
                }
                return true;
            }
            return false;
        } else {
            if (strlen($name) >= 6){
                $smName = substr($name,0,6);
            } elseif (strlen($name) < 6 && strlen($name) > 3) {
                $smName = substr($name,0,3);
            } else {
                $smName = $name;
            }
            $gamesFound = DB::table('games')
                ->where('title', 'like' , $smName)
                ->whereDate('release_date', $release_date)
                ->get();
            if(count($gamesFound)>0){
                if(count($gamesFound)==1){
                    foreach ($gamesFound as $game){
                        if($game->psn_id != $psn_id){
                            $this->updateRecords($game->igdb_id,$psn_id);
                            echo PHP_EOL . "[2nd ROUND] " . $game->title . PHP_EOL;
                        }
                    }
                } else {
                    echo PHP_EOL . "[MULTIPLE]" . PHP_EOL;
                }
                return true;
            } else {
                return false;
            }
        }
    }

    private function updateRecords($igdb_id,$psn_id){
        echo "+";
        DB::table('games')->where('igdb_id', $igdb_id)->update(['psn_id' => $psn_id]);
        DB::table('psn_games')->where('psn_id', $psn_id)->update(['igdb_id' => $igdb_id]);
    }
}
