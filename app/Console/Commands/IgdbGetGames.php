<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IgdbGetGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:getGames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[WARNING] DO NOT USE THIS! Cycles through manually set Game Ids one at a time and caches the Game JSONs';

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
        for($i=9630;$i<9631;$i++){
            echo "Checking ID: " . $i;

            $game = \IGDB::getGame($i);
            if ($game!=false){
                echo " | FOUND -> " . $game->name .PHP_EOL;
                // Dump Response to file for use later
                $fp = fopen("resources/igdb/games/".$game->slug.'.json', 'w');
                fwrite($fp, json_encode($game));
                fclose($fp);

                DB::table('igdb_admin')->insert(
                    [
                        'igdb_id' => $i,
                        'endpoint' => 'games',
                        'slug' => $game->slug,
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
