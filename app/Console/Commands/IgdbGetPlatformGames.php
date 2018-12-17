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
    protected $description = '[MANUALLY CONFIGURED] Connects to the IGDB API to get List of Game Ids that are on each platform.';

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
        // Currently searching PS3,PS4,Xbox360,XboxOne, and Switch
        $platformArray = [165];

        // There are currently 154 Platforms.
        // I don't have all there IDs so I start at zero and go to 169
        foreach($platformArray as $i){
            echo "Checking ID: " . $i;
            $games = \IGDB::getPlatformGames($i);

            if ($games!=false){
                echo " | FOUND -> " . $games->id .PHP_EOL;
                // Dump Response to file for use later
                $fp = fopen("resources/igdb/platform_games/".$i.'.json', 'w');
                fwrite($fp, json_encode($games));
                fclose($fp);
            } else {
                echo " | FAILED".PHP_EOL;
            }
            sleep(1);
        }
    }
}
