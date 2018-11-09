<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Platform;

class LoadGamesTableFromScratch extends Command
{
    private $regions = [
        '1' => "Europe (EU)",
        '2' => "North America (NA)",
        '3' => "Australia (AU)",
        '4' => "New Zealand (NZ)",
        '5' => "Japan (JP)",
        '6' => "China (CH)",
        '7' => "Asia (AS)",
        '8' => "Worldwide",
        '9' => "Hong Kong (HK)",
        '10' => "South Korea (KR)"
    ];

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
    protected $description = 'Load in the game data from the igdb/games directory into the platforms table.';

    private $platformList;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->platformList = DB::table('platforms')->select('igdb_id','slug')->get();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
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

            echo "Scanning..." . PHP_EOL;
            foreach( $arrDocs as $a )   //For each document in the current document array
            {
                // Directory search and count
                if( is_file($DocDirectory . "/" . $a) && $a != "." && $a != ".." && $a != ".DS_Store" && substr($a,strlen($a)-3,3) != ".db" )      //The "." and ".." are directories.  "." is the current and ".." is the parent
                {
                    if($totalCtr==count($arrDocs)) {
                        array_push($data, $this->loadJson($a));
                        $this->massInsert($data);
                        break;
                    } else if ($ctr<50) {
                        array_push($data, $this->loadJson($a));
                        $ctr++;
                    } else {
                        array_push($data, $this->loadJson($a));
                        $this->massInsert($data);
                        $ctr=0;
                        $data=[];
                    }

                    $totalCtr++;
                }
            }
            echo PHP_EOL . "Total Inserted: " . $totalCtr . PHP_EOL . PHP_EOL;
            $this->customFixes();
        }
    }

    private function loadJsonDemo ($file) {

        $filePath = "resources/igdb/games/". $file;

        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        echo $myJson['slug'].PHP_EOL;
        $this->getReleaseDate($myJson['release_dates']);
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
        $summary =  (isset($myJson['summary'])) ? $myJson['summary'] : null;
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
        $developer = (isset($myJson['developers'])) ? json_encode($myJson['developers']) : null;
        # publishers->array
        $publisher = (isset($myJson['publishers'])) ? json_encode($myJson['publishers']) : null;
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
        $first_release_date = date("Y-m-d", substr($myJson['first_release_date'], 0, 10));
        # pulse_count
        # platforms->array
        $platforms = [];
        foreach($myJson['platforms'] as $platform){
            $platformList = json_decode($this->platformList);
            foreach($platformList as $x){
                if($platform == $x->igdb_id)
                {
                    array_push($platforms,$x->slug);
                }
            }
        }
        $platforms = json_encode($platforms);
        # release_dates->array->[category][platform][date][region][human][y][m]
        # alternative_names->array[name][comment]
        # screenshots->array->[url][cloudinary_id][width][height]
        # videos->array->[name][video)id]
        # cover->[url][cloudinary_id][width][height]
        # esrb->[synopsis][rating]
        $synopsis = (isset($myJson['esrb']['synopsis'])) ? $myJson['esrb']['synopsis'] : null;
        if(!isset($synopsis) || $synopsis==""){
            $synopsis = (isset($myJson['pegi']['synopsis'])) ? $myJson['pegi']['synopsis'] : null;
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
//            'image_portrait'    => $myJson[''],
//            'image_landscape'   => $myJson[''],
            'release_date_na'   => $first_release_date,
            'release_date_jp'   => $first_release_date,
            'release_date_eu'   => $first_release_date,
            'igdb_id'           => $igdb_id,
            'created_at'        => \Carbon\Carbon::now(),
            'updated_at'        => \Carbon\Carbon::now()
        ];
    }

    private function getReleaseDate($releaseDates){
        $regions = [
            "EU" => null,
            "NA" => null,
            "JP" => null,
        ];
        $hasRegion=0;
        foreach ($releaseDates as $date){
            if(isset($date["region"])){
                switch ($date["region"]){
                    case 1:
                        $regions["EU"] = "EU";
                        break;
                    case 2:
                        $regions["NA"] = "NA";
                        break;
                    case 5:
                        $regions["JP"] = "JP";
                        break;
                    default:
                        break;
                }
                $hasRegion++;
            } else {
                echo "No Region - " . date("Y-m-d", substr($date["date"], 0, 10)) . PHP_EOL;
            }
        }
        echo $hasRegion . PHP_EOL;

        foreach($regions as $region => $val){
            echo $region . PHP_EOL;
        }
    }


    private function massInsert ($data) {
        echo PHP_EOL ."Inserting " . count($data) . " records" . PHP_EOL;
        DB::table('games')->insert($data);
    }

    private function customFixes (){
        DB::table('games')->where('igdb_id', 517)->update(['slug' => 'fear']);
        DB::table('games')->where('igdb_id', 514)->update(['slug' => 'fear-3']);
        DB::table('games')->where('igdb_id', 520)->update(['slug' => 'fear-2-project-origin']);
    }
}
