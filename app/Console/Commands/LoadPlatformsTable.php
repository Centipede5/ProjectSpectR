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
    protected $description = 'Load in the platform data from the igdb/platforms directory into the platforms table.';

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
        DB::table('platforms')->delete();

        //scan JSON directory
        $DocDirectory = "resources/igdb/platforms";   //Directory to be scanned

        $arrDocs = array_diff(scandir($DocDirectory), array('..', '.'));  //Scan the $DocDirectory and create an array list of all of the files and directories
        natcasesort($arrDocs);
        if( isset($arrDocs) && is_array($arrDocs) )
        {
            foreach( $arrDocs as $a )   //For each document in the current document array
            {
                // Directory search and count
                if( is_file($DocDirectory . "/" . $a) && $a != "." && $a != ".." && substr($a,strlen($a)-3,3) != ".db" )      //The "." and ".." are directories.  "." is the current and ".." is the parent
                {
                    $this->loadJson($a);
                }
            }
        }
    }

    public function loadJson ($file) {
        // Loop through and pull in each file
        // Decode File
        // Insert Contents into table
        $filePath = "resources/igdb/platforms/". $file;

        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        echo $myJson['name'] . " - ID: " . $myJson['id'] . PHP_EOL;

        $myJson['id'] = (!isset($myJson['id'])) ? "unknown" : $myJson['id'];
        $myJson['name'] = (!isset($myJson['name'])) ? "unknown" : $myJson['name'];
        $myJson['slug'] = (!isset($myJson['slug'])) ? "unknown" : $myJson['slug'];
        $myJson['logo']['url'] = (!isset($myJson['logo']['url'])) ? "unknown" : $myJson['logo']['url'];
        $myJson['website'] = (!isset($myJson['website'])) ? "unknown" : $myJson['website'];

        if(isset($myJson['summary'])){
            $myJson['versions'][0]['summary'] = $myJson['summary'];
        } else {
            $myJson['versions'][0]['summary'] = (!isset($myJson['versions'][0]['summary'])) ? "unknown" : $myJson['versions'][0]['summary'];
        }

        $myJson['generation'] = (!isset($myJson['generation'])) ? "unknown" : $myJson['generation'];
        $myJson['alternative_name'] = (!isset($myJson['alternative_name'])) ? "none" : $myJson['alternative_name'];

        DB::table('platforms')->insert(
            [
                'igdb_id'           => $myJson['id'],
                'name'              => $myJson['name'],
                'slug'              => $myJson['slug'],
                'logo'              => $myJson['logo']['url'],
                'website'           => $myJson['website'],
                'summary'           => $myJson['versions'][0]['summary'],
                'alternative_name'  => $myJson['alternative_name'],
                'generation'        => $myJson['generation']
            ]
        );
    }
}
