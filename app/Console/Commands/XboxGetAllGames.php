<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class XboxGetAllGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xbox:getAllGames {--excludeApiCall}';

    /**
     * Loop through a given list of Endpoints within the command set at the top of the command execution
     *
     * @var string
     */
    protected $description = '[MAIN] Retrieve and build Xbox Games based on a delivered list of Games';

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
        ini_set('memory_limit','800M');

        // Returns the Children under the STORE-MSF77008-SAVE item id
        echo "Retrieving Game Items..." . PHP_EOL;

        $xboxGameIds = \XBOXAPI::getAllGameIds();
        $xboxGames = \XBOXAPI::getGamesByEndpoint($xboxGameIds);

        echo "Total Games: " . count($xboxGames) . PHP_EOL;
        if ($xboxGames != false) {
            echo "LOADING JSON" . PHP_EOL;

            // Dump the FULL Response to a file for use later
            $fp = fopen("resources/xbox/xbox-games_full.json", 'w');
            fwrite($fp, json_encode($xboxGames));
            fclose($fp);

            echo "Minimizing JSON...." . PHP_EOL;
            $this->minimizeJSON();
        }

//        echo "REBUILDING xbox_game TABLE" . PHP_EOL;
//        $this->call('xbox:loadGamesTable');
    }

    /**
     * Build a Minimized JSON with just the needed information
     *
     * @param $jsonId
     */
    private function minimizeJSON(){
        $filePath = "resources/xbox/xbox-games_full.json";
        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        echo "Creating Game JSONs" . PHP_EOL;
        $miniJson = [];
        foreach($myJson as $game){
            $newGame=[];
            if(!$game['LocalizedProperties'][0]['ProductTitle']){
                echo "NONE" . PHP_EOL;
            }
            $newGame['ProductId'] = $game['ProductId'];
            $newGame['ProductTitle'] = $game['LocalizedProperties'][0]['ProductTitle'];

            array_push($miniJson,$newGame);

            $fileName = "resources/xbox/games/" . substr($game['ProductId'],0,2) . "/" . $game['ProductId'] . ".json";
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
        $fp = fopen("resources/xbox/xbox-games_min.json", 'w');
        fwrite($fp, json_encode($miniJson));
        fclose($fp);

        echo "[COMPLETE] Minimized JSON" . PHP_EOL;
    }
}
