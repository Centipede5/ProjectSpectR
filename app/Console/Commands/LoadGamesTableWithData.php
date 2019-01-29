<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LoadGamesTableWithData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spectre:loadGamesTableWithData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'New Game Loader - Uses fragmented directory structures';

    /**
     * Stores all of the available Platforms that are in the platforms table
     *
     * @var
     */
    private $platformList;
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
        echo "-- GAMES TABLE -" .PHP_EOL;
        $this->platformList = DB::table('platforms')->select('igdb_id','slug')->get();

        # Clear the GAMES table
        DB::table('games')->delete();

        $subDirectoryList = [];
        $DocDirectory = "resources/igdb/games";   //Directory to be scanned

        $arrDocs = array_diff(scandir($DocDirectory), array('..', '.', '.db', '.DS_Store'));  //Scan the $DocDirectory and create an array list of all of the files and directories
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

        $subDirCtr    = 0;
        $totalFileCtr = 0;
        $jsonData     = [];
        $watchCtr     = 1;
        foreach ($subDirectoryList as $dirName){
            $subDirCtr++;
            $DocDirectory = "resources/igdb/games/" . $dirName;
            $arrDocs = array_diff(scandir($DocDirectory), array('..', '.', '.db', '.DS_Store'));
            natcasesort($arrDocs);

            if( isset($arrDocs) && is_array($arrDocs) ) {
                $subDirFileCtr=0;
                foreach( $arrDocs as $a ){
                    if( is_file($DocDirectory . "/" . $a)) {
                        $subDirFileCtr++;
                        $totalFileCtr++;

                        // 1) Insert for the last time
                        if($subDirFileCtr==count($arrDocs) && $subDirCtr == count($subDirectoryList)) {
                            array_push($jsonData, $this->loadJson($dirName,$a));
                            $this->massInsert($jsonData);
                            $output_str =  "Total: " . $subDirCtr . " / " . count($subDirectoryList);
                            echo $output_str;
                            $line_size = strlen($output_str);
                            while($line_size > 0){
                                echo "\010";
                                $line_size--;
                            }

                            break;
                        }
                        // if the loop count is less than 40, just add the data for later
                        else if ($watchCtr<30) {
                            array_push($jsonData, $this->loadJson($dirName,$a));
                            $watchCtr++;
                        }
                        // If the Counter hits 30, Insert
                        else {
                            array_push($jsonData, $this->loadJson($dirName,$a));
                            $this->massInsert($jsonData);

                            $output_str =  "Total: " . $subDirCtr . " / " . count($subDirectoryList);
                            echo $output_str;
                            $line_size = strlen($output_str);
                            while($line_size > 0){
                                echo "\010";
                                $line_size--;
                            }

                            // Reset Counter and data
                            $watchCtr=0;
                            $jsonData=[];
                        }
                    }
                }
            }
        }

        DB::table('games')->update(['created_at'=> \Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);

        echo PHP_EOL . "TOTAL FILES FOUND and ADDED: " . $totalFileCtr . PHP_EOL;
    }

    private function loadJson ($dirName,$file) {
        // Loop through and pull in each file
        // Decode File
        // Insert Contents into table
        $filePath = "resources/igdb/games/". $dirName . "/" . $file;
        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        ### Process JSON ###
        # igdb_id
        # The main IGDB Game ID
        $igdb_id = $myJson['id'];
        # name
        # The Name of the Game
        $name = $myJson['name'];
        # slug
        # The non-spaced slug should always be set, but if not, use an altered name
        $slug = (isset($myJson['slug'])) ? $myJson['slug'] : strtolower(str_replace(" ", "-",$myJson['name']));
        # url
        # created_at
        # updated_at
        # summary
        $summary =  (isset($myJson['summary'])) ? substr($myJson['summary'],0,250) : 'N/A';
        # storyline
        # collection
        # franchise
        # franchises->array
        # hypes
        # rating
        # popularity
        # aggregated_rating
        # aggregated_rating_count
        # total_rating
        # total_rating_count
        # rating_count
        # games->array
        # tags->array
        # developers->array
        $developer = (isset($myJson['developers'])) ? json_encode($myJson['developers']) : json_encode(['Unknown']);
        # publishers->array
        $publisher = (isset($myJson['publishers'])) ? json_encode($myJson['publishers']) : json_encode(['Unknown']);
        # game_engines->array
        # category
        # time_to_beat->[normally][completely][hastly]
        # player_perspectives->array
        # game_modes->array
        # keywords->array
        # themes->array
        # genres->array
        # dlcs->array
        # first_release_date
        //$first_release_date = $myJson['first_release_date'];
        if(isset($myJson['first_release_date'])){
            $first_release_date = (strlen($myJson['first_release_date']) == 12) ? date("Y-m-d", substr($myJson['first_release_date'],0,9)) : date("Y-m-d", substr($myJson['first_release_date'],0,10));
        } else {
            $first_release_date = null;
        }
        # pulse_count
        # platforms->array
        $platforms = [];
        if(isset($myJson['platforms'])){
            foreach($myJson['platforms'] as $platform){
                $platformList = json_decode($this->platformList);
                foreach($platformList as $x){
                    if($platform == $x->igdb_id)
                    {
                        switch($x->slug){
                            case "win":
                                $thePlatform = "pc";
                                break;
                            case "steam":
                                $thePlatform = "pc";
                                break;
                            case "mac":
                                $thePlatform = "pc";
                                break;
                            case "linux":
                                $thePlatform = "pc";
                                break;
                            case "nintendo-switch":
                                $thePlatform = "switch";
                                break;
                            case "ios":
                                $thePlatform = "mobile";
                                break;
                            case "android":
                                $thePlatform = "mobile";
                                break;
                            default:
                                $thePlatform = $x->slug;
                                break;
                        }

                        if (!in_array(strtoupper($thePlatform),$platforms)){
                            array_push($platforms,strtoupper($thePlatform));
                        }
                    }
                }
            }
        } else {
            array_push($platforms,"unknown");
        }
        $platforms = json_encode($platforms);
        # release_dates->array->[category][platform][date][region][human][y][m]
        # alternative_names->array[name][comment]
        # screenshots->array->[url][cloudinary_id][width][height]
        # videos->array->[name][video)id]
        # cover->[url][cloudinary_id][width][height]
        $image_portrait = (isset($myJson['cover']['cloudinary_id'])) ? "https://images.igdb.com/igdb/image/upload/t_720p/" . $myJson['cover']['cloudinary_id'] . ".jpg" : null;
        $image_landscape = (isset($myJson['screenshots'][0]['cloudinary_id'])) ? "https://images.igdb.com/igdb/image/upload/t_720p/" . $myJson['screenshots'][0]['cloudinary_id'] . ".jpg" : null;
        # esrb->[synopsis][rating]
        $synopsis = (isset($myJson['esrb']['synopsis'])) ? substr($myJson['esrb']['synopsis'],0,200) . '...' : 'N/A';
        if($synopsis=='N/A'){
            $synopsis = (isset($myJson['pegi']['synopsis'])) ? substr($myJson['pegi']['synopsis'],0,200) . '...' : 'N/A';
        }

        if($summary!='N/A' && $synopsis == 'N/A'){
            $synopsis = (strlen($summary)<200) ? $summary : substr($summary,0,200) . "...";
        }
        # pegi->[synopsis][rating]
        # websites->array->[category][url]
        # external[steam]
        # multiplayer_modes[platform][offlinecoop][onlinecoop][lancoop][campaigncoop][splitscreenonline][splitscreen][dropin][offlinecoopmax][onlinecoopmax][onlinemax][offlinemax]

        return [
            'slug'              => $slug,
            'title'             => $name,
            'publisher'         => $publisher,
            'developer'         => $developer,
            'platforms'         => $platforms,
            'synopsis'          => $synopsis,
            'summary'           => $summary,
            'image_portrait'    => $image_portrait,
            'image_landscape'   => $image_landscape,
            'release_date'      => $first_release_date,
            'igdb_id'           => $igdb_id,
            'created_at'        => \Carbon\Carbon::now(),
            'updated_at'        => \Carbon\Carbon::now()
        ];
    }

    private function massInsert ($jsonData) {
        DB::table('games')->insert($jsonData);
    }
}
