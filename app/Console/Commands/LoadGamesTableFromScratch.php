<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LoadGamesTableFromScratch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:loadGamesTableFromScratch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuilds the GAMES table with available JSONs';

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
        DB::table('games')->delete();

        //scan JSON directory
        $DocDirectory = "resources/igdb/games";   //Directory to be scanned

        $arrDocs = array_diff(scandir($DocDirectory), array('..', '.','.DS_Store'));  //Scan the $DocDirectory and create an array list of all of the files and directories
        natcasesort($arrDocs);

        if( isset($arrDocs) && is_array($arrDocs) )
        {
            $data=[];
            $ctr=1;
            $totalCtr=1;

            echo "[SCANNING]" . PHP_EOL;
            foreach( $arrDocs as $a )   //For each document in the current document array
            {
                // Directory search and count
                if( is_file($DocDirectory . "/" . $a) && $a != "." && $a != ".." && $a != ".DS_Store" && substr($a,strlen($a)-3,3) != ".db" )      //The "." and ".." are directories.  "." is the current and ".." is the parent
                {
                    if($totalCtr==count($arrDocs)) {
                        array_push($data, $this->loadJson($a));
                        $this->massInsert($data);
                        $output_str =  "Total: " . $totalCtr . " / " . count($arrDocs);
                        echo $output_str;
                        $line_size = strlen($output_str);
                        while($line_size >= 0){
                            echo "\010";
                            $line_size--;
                        }

                        break;
                    } else if ($ctr<40) {
                        array_push($data, $this->loadJson($a));
                        $ctr++;
                    } else {
                        array_push($data, $this->loadJson($a));
                        $this->massInsert($data);
                        $output_str =  "Total: " . $totalCtr . " / " . count($arrDocs);
                        echo $output_str;
                        $line_size = strlen($output_str);
                        while($line_size >= 0){
                            echo "\010";
                            $line_size--;
                        }

                        $ctr=0;
                        $data=[];
                    }

                    $totalCtr++;
                }
            }
            echo PHP_EOL . "Total Inserted: " . $totalCtr . PHP_EOL . PHP_EOL;
        }
    }

    private function loadJson ($file) {
        // Loop through and pull in each file
        // Decode File
        // Insert Contents into table
        $filePath = "resources/igdb/games/". $file;
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
        $summary =  (isset($myJson['summary'])) ? substr($myJson['summary'],0,100) : 'N/A';
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
        $synopsis = (isset($myJson['esrb']['synopsis'])) ? substr($myJson['esrb']['synopsis'],0,100) : 'N/A';
        if(!isset($synopsis) || $synopsis==""){
            $synopsis = (isset($myJson['pegi']['synopsis'])) ? substr($myJson['pegi']['synopsis'],0,100) : 'N/A';
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

    private function massInsert ($data) {
        echo PHP_EOL;
        DB::table('games')->insert($data);
    }
}
