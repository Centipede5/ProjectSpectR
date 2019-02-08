<?php

namespace App\Console\Commands;

use App\Http\Controllers\XboxGamesController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LogIt;

class LoadXboxGamesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xbox:loadGamesTable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears and Rebuilds the XboxGamesTable';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        LogIt::utilLog("STARTING loadGamesTable Command");
    }

    public function __destruct()
    {
        LogIt::utilLog("COMPLETED loadGamesTable Command");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('xbox_games')->delete();

        $subDirectoryList = [];
        $DocDirectory = "resources/xbox/games";   //Directory to be scanned

        $arrDocs = array_diff(scandir($DocDirectory), array('..', '.', '.db'));  //Scan the $DocDirectory and create an array list of all of the files and directories
        natcasesort($arrDocs);
        if( isset($arrDocs) && is_array($arrDocs) ) {
            foreach ($arrDocs as $a)   //For each document in the current document array
            {
                // Directory search and count
                if (is_dir($DocDirectory . "/" . $a))      //The "." and ".." are directories.  "." is the current and ".." is the parent
                {
                    array_push($subDirectoryList, $a);
                }
            }
        }
        echo "DIRECTORIES FOUND: " . count($subDirectoryList) . PHP_EOL;
        echo "SCANNING DIRECTORIES FOR FILES" . PHP_EOL;

        $subDirCtr=1;
        $fileCtr=0;
        $data=[];
        $ctr=1;
        foreach ($subDirectoryList as $dirName){
            $DocDirectory = "resources/xbox/games/" . $dirName;
            $arrDocs = array_diff(scandir($DocDirectory), array('..', '.', '.db'));
            natcasesort($arrDocs);

            if( isset($arrDocs) && is_array($arrDocs) )
            {
                $totalCtr=1;
                foreach( $arrDocs as $a ){
                    if( is_file($DocDirectory . "/" . $a)) {
                        $fileCtr++;
                        // 1) Insert for the last time
                        if($totalCtr==count($arrDocs) && $subDirCtr == count($subDirectoryList)) {
                            array_push($data, $this->loadJson($a));
                            $this->massInsert($data);
                            $output_str =  " Total: " . $fileCtr;
                            echo $output_str;
                            $line_size = strlen($output_str);
                            while($line_size >= 0){
                                echo "\010";
                                $line_size--;
                            }

                            break;
                        }
                        // if the loop count is less than 40, just add the data for later
                        else if ($ctr<5) {
                            array_push($data, $this->loadJson($a));
                            $ctr++;
                        }
                        // If the Counter hits 40, Inert
                        else {
                            array_push($data, $this->loadJson($a));
                            $this->massInsert($data);
                            $output_str =  "Total: " . $fileCtr;
                            echo $output_str;
                            $line_size = strlen($output_str);
                            while($line_size >= 0){
                                echo "\010";
                                $line_size--;
                            }

                            // Reset Counter and data
                            $ctr=0;
                            $data=[];
                        }

                        $totalCtr++;
                    }
                }
            }
            $subDirCtr++;
        }

        DB::table('xbox_games')->update(['created_at'=> \Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);

        echo PHP_EOL . "TOTAL FILES FOUND and ADDED: " . $fileCtr . PHP_EOL;
    }

    private function loadJson ($file)
    {
        // The XboxGamesController will take the "file" reference and
        // then actually pull in the json file and process it
        $gameController = new XboxGamesController($file);

        $gameId                         =   $gameController->getGameId();
        $gameTitle                      =   $this->processString($gameController->getGameTitle());
        $release_date                   =   $gameController->getReleaseDate();
        $genres                         =   $gameController->getGameGenre();
        $platforms                      =   $gameController->getAvailablePlatforms();
        $provider_name                  =   $this->processString($gameController->getProviderName());
        $developer_name                 =   $this->processString($gameController->getDeveloperName());
        $content_descriptors            =   $gameController->getContentDescriptors();
        $store_url                      =   $gameController->getStoreUrl();
        $images                         =   $gameController->getImages();
        $thumbnail_url_base             =   $gameController->getThumbnail();
        $videos                         =   $gameController->getVideos();
        $star_rating_score              =   $gameController->getStarRatingScore();
        $star_rating_count              =   $gameController->getStarRatingCount();
        $game_content_type              =   $gameController->getGameContentType();
        $actual_price_display           =   $gameController->getActualPriceDisplay();
        $actual_price_value             =   $gameController->getActualPriceValue();
        $strikethrough_price_display    =   $gameController->getStrikethroughPriceDisplay();
        $strikethrough_price_value      =   $gameController->getStrikethroughPriceValue();
        $discount_percentage            =   $gameController->getDiscountPercentage();
        $sale_start_date                =   $gameController->getSaleStartDate();
        $sale_end_date                  =   $gameController->getSaleEndDate();

        return [
            'xbox_id'                       => $gameId,
            'name'                          => $gameTitle,
            'release_date'                  => $release_date,
            'genres'                        => $genres,
            'platforms'                     => $platforms,
            'provider_name'                 => $provider_name,
            'developer_name'                => $developer_name,
            'xbox_store_url'                => $store_url,
            'content_descriptors'           => $content_descriptors,
            'thumbnail_url_base'            => $thumbnail_url_base,
            'images'                        => $images,
            'videos'                        => $videos,
            'star_rating_score'             => $star_rating_score,
            'star_rating_count'             => $star_rating_count,
            'game_content_type'             => $game_content_type,
            'actual_price_display'          => $actual_price_display,
            'actual_price_value'            => $actual_price_value,
            'strikethrough_price_display'   => $strikethrough_price_display,
            'strikethrough_price_value'     => $strikethrough_price_value,
            'discount_percentage'           => $discount_percentage,
            'sale_start_date'               => $sale_start_date,
            'sale_end_date'                 => $sale_end_date,
            'created_at'                    => \Carbon\Carbon::now(),
            'updated_at'                    => \Carbon\Carbon::now()
        ];
    }

    private function massInsert ($data)
    {
        echo PHP_EOL;
        DB::table('xbox_games')->insert($data);
    }

    private function processString($string)
    {
        // Strip special characters
        $string = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $string);

        // Replace apostrophe to standard style
        $string = str_replace("’","'",$string);

        return $string;
    }
}
