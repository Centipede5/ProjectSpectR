<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Messerli90\IGDB\IGDBServiceProvider;
use Illuminate\Support\Facades\DB;

class IgdbBuildPlatforms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:buildPlatforms';

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
        for($i=0;$i<50;$i++){
            echo "Checking ID: " . $i;

            $platform = \IGDB::getPlatform($i);
            if ($platform!=false){
                echo " | FOUND".PHP_EOL;
                $fp = fopen("resources/igdb/".$platform->slug.'.json', 'w');
                fwrite($fp, json_encode($platform));
                fclose($fp);

                DB::table('igdb_admin')->insert(
                    [
                        'igdb_id' => $i,
                        'endpoint' => 'platforms',
                        'slug' => $platform->slug,
                        'name' => $platform->name,
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
