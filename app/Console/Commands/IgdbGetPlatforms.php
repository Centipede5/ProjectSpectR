<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IgdbGetPlatforms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:getPlatforms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete Platform Information is pulled in when it connects and save response to JSON.';

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

        // There are currently 154 Platforms.
        // I don't have all there IDs so I start at zero and go to 169
        for($i=0;$i<170;$i++){
            echo "Checking ID: " . $i;

            $platform = \IGDB::getPlatform($i);
            if ($platform!=false){
                echo " | FOUND -> " . $platform->name .PHP_EOL;
                // Dump Response to file for use later
                $fp = fopen("resources/igdb/platforms/".$platform->slug.'.json', 'w');
                fwrite($fp, json_encode($platform));
                fclose($fp);

                DB::table('igdb_admin')->insert(
                    [
                        'igdb_id' => $i,
                        'endpoint' => 'platforms',
                        'slug' => $platform->slug,
                        'status' => 0
                    ]
                );

            } else {
                echo " | FAILED".PHP_EOL;
            }
            sleep(1);
        }
    }
}
