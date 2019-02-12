<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class NinGetAllGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nin:getAllGames {--excludeApiCall}';

    /**
     * Loop through a given list of Endpoints within the command set at the top of the command execution
     *
     * @var string
     */
    protected $description = '[MAIN] Retrieve and build Nintendo Games based on a delivered list of Games';

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
     *
     */
    public function handle()
    {
        ini_set('memory_limit','800M');

        // Returns the Children under the STORE-MSF77008-SAVE item id
        echo "Retrieving Game Items..." . PHP_EOL;

        if(!$this->option('excludeApiCall')) {
            $ninGames = \NINAPI::getGamesByEndpoint();
            echo "Total Games: " . count($ninGames) . PHP_EOL;

            if ($ninGames != false) {
                echo "LOADING JSON" . PHP_EOL;

                // Dump the FULL Response to a file for use later
                $fp = fopen("resources/nin/nin-games_full.json", 'w');
                fwrite($fp, json_encode($ninGames));
                fclose($fp);
            }
        }

        echo "Minimizing JSON...." . PHP_EOL;
        $this->minimizeJSON();
        //echo "REBUILDING nin_games TABLE" . PHP_EOL;
        //$this->call('nin:loadGamesTable');
    }

    /**
     * Build a Minimized JSON with just the needed information
     *
     * @param $jsonId
     */
    private function minimizeJSON(){
        $filePath = "resources/nin/nin-games_full.json";
        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        echo "Creating Game JSONs" . PHP_EOL;
        $miniJson = [];
        foreach($myJson as $game){
            $newGame=[];
            if(!$game['title']){
                echo "NONE" . PHP_EOL;
            }
            $newGame['id'] = $game['id'];
            $newGame['title'] = $game['title'];

            array_push($miniJson,$newGame);

            $fileName = "resources/nin/games/" . substr($game['id'],0,1) . "/" . $game['id'] . ".json";
            $dirname = dirname($fileName);
            if (!is_dir($dirname)) {
                mkdir($dirname, 0755, true);
            }
            # Create a Separate Game JSON for each game found
            $fp = fopen($fileName, 'w');
            fwrite($fp, json_encode($game));
            fclose($fp);
        }

        // Create a Separate Game JSON for each game found
        $fp = fopen("resources/nin/nin-games_min.json", 'w');
        fwrite($fp, json_encode($miniJson));
        fclose($fp);

        echo "[COMPLETE] Minimized JSON" . PHP_EOL;
    }
}
