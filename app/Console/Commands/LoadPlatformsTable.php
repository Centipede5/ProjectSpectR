<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LoadPlatformsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:loadPlatformsTable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load Platform JSON data into the platforms table.';

    public $slugUpdates = [
        "ps4--1" => "ps4",
        "turbografx16--1" => "turbografx16",
        "snes--1" => "snes",
        "odyssey--1" => "odyssey",
        "steam--1" => "steam",
        "pdp-8--1" => "pdp-8",
        "edsac--1" => "edsac",
        "pdp-7--1" => "pdp-7",
        "plato--1" => "plato",
        "microvision--1" => "microvision",
        "microcomputer--1" => "microcomputer",
    ];
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
        echo "-- PLATFORMS TABLE --" . PHP_EOL;
        echo "[CLEARING TABLE]" . PHP_EOL;
        DB::table('platforms')->delete();

        //scan JSON directory
        $DocDirectory = "resources/igdb/platforms";   //Directory to be scanned
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

                    //echo ".";
                    $totalCtr++;
                }
            }
            echo "[COMPLETED] Total Records Inserted: " . $totalCtr . PHP_EOL . PHP_EOL;
        }
    }

    private function loadJson ($file) {
        // Loop through and pull in each file
        // Decode File
        // Insert Contents into table
        $filePath = "resources/igdb/platforms/". $file;

        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        //echo $myJson['name'] . " - ID: " . $myJson['id'] . PHP_EOL;

        $myJson['id'] = (!isset($myJson['id'])) ? "unknown" : $myJson['id'];
        $myJson['name'] = (!isset($myJson['name'])) ? "unknown" : $myJson['name'];
        $myJson['slug'] = (!isset($myJson['slug'])) ? "unknown" : $myJson['slug'];

        $slug = $myJson['slug'];
        if(array_key_exists($slug,$this->slugUpdates)){$myJson['slug'] = $this->slugUpdates[$slug];}

        $myJson['logo']['url'] = (!isset($myJson['logo']['url'])) ? "unknown" : $myJson['logo']['url'];
        $myJson['website'] = (!isset($myJson['website'])) ? "unknown" : $myJson['website'];

        if(isset($myJson['summary'])){
            $myJson['versions'][0]['summary'] = $myJson['summary'];
        } else {
            $myJson['versions'][0]['summary'] = (!isset($myJson['versions'][0]['summary'])) ? "unknown" : $myJson['versions'][0]['summary'];
        }

        $myJson['generation'] = (!isset($myJson['generation'])) ? "unknown" : $myJson['generation'];
        $myJson['alternative_name'] = (!isset($myJson['alternative_name'])) ? "none" : $myJson['alternative_name'];

        return [
            'igdb_id'           => $myJson['id'],
            'name'              => $myJson['name'],
            'slug'              => $myJson['slug'],
            'logo'              => $myJson['logo']['url'],
            'website'           => $myJson['website'],
            'summary'           => $myJson['versions'][0]['summary'],
            'alternative_name'  => $myJson['alternative_name'],
            'generation'        => $myJson['generation'],
            'created_at'        => \Carbon\Carbon::now(),
            'updated_at'        => \Carbon\Carbon::now()
        ];
    }

    private function massInsert ($data) {
        echo PHP_EOL . "[INSERT]" . PHP_EOL;
        DB::table('platforms')->insert($data);
    }
}
