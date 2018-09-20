<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class IgdbGetPlatformGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:getPlatformGames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Connect to the IGDB API to get List of Game Ids that are on each platform';

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
        $platformArray = [48,49,130];
        foreach($platformArray as $i){
            echo "Checking ID: " . $i;

            $games = \IGDB::getPlatformGames($i);
            if ($games!=false){
                echo " | Building " . PHP_EOL;

                echo "Adding " . PHP_EOL;

                foreach ($games->games as $game){
                    echo $game . PHP_EOL;
                    DB::table('igdb_game_ids')->insert(
                        [
                            'igdb_id' => $game,
                            'platform_id' => $i
                        ]
                    );
                }
            } else {
                echo " | FAILED".PHP_EOL;
            }
            sleep(1);
        }
    }
}
