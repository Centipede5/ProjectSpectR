<?php

namespace App\Console\Commands;

use App\Http\Controllers\XboxGamesController;
use App\Http\Controllers\PsnGamesController;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\LogIt;

class LoadVendorGamesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spectre:loadVendorGamesTable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears and Rebuilds the Vendor Games table';

    private $vendor;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        LogIt::utilLog("STARTING loadVendorGamesTable Command");
    }

    public function __destruct()
    {
        LogIt::utilLog("COMPLETED loadVendorGamesTable Command");
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbTable = "vendor_games";
        DB::table($dbTable)->delete();

        $vendors = ['psn','xbox'];
        foreach ($vendors as $vendor) {
            echo "Processing: " . $vendor . PHP_EOL;
            $this->setVendor($vendor);
            $gamesDir = "resources/".$vendor."/games";   //Directory to be scanned

            $subDirectoryList = [];
            $arrDocs = array_diff(scandir($gamesDir), array('..', '.', '.db'));  //Scan the $gamesDir and create an array list of all of the files and directories
            natcasesort($arrDocs);
            if( isset($arrDocs) && is_array($arrDocs) ) {
                foreach ($arrDocs as $a)   //For each document in the current document array
                {
                    // Directory search and count
                    if (is_dir($gamesDir . "/" . $a))      //The "." and ".." are directories.  "." is the current and ".." is the parent
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
                $DocDirectory = $gamesDir . "/" . $dirName;
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
                                DB::table($dbTable)->insert($data);
                                echo PHP_EOL;
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
                            // If the Counter hits 40, Insert
                            else {
                                array_push($data, $this->loadJson($a));
                                DB::table($dbTable)->insert($data);
                                echo PHP_EOL;
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

            DB::table($dbTable)->update(['created_at'=> \Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);

            echo PHP_EOL . "TOTAL FILES FOUND and ADDED: " . $fileCtr . PHP_EOL;
        }
    }

    private function loadJson ($file)
    {
        // The XboxGamesController will take the "file" reference and
        // then actually pull in the json file and process it
        if($this->getVendor()=="psn") {
            $gameController = new PsnGamesController($file);
        } else if($this->getVendor()=="xbox") {
            $gameController = new XboxGamesController($file);
        }

        $api                            =   $gameController->api;
        $gameId                         =   $gameController->getGameId();
        $gameTitle                      =   $gameController->getGameTitle();
        $release_date                   =   $gameController->getReleaseDate();
        $genres                         =   $gameController->getGameGenre();
        $platforms                      =   $gameController->getPlatforms();
        $provider_name                  =   $this->cleanString($gameController->getPublisherName());
        $developer_name                 =   $this->cleanString($gameController->getDeveloperName());
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
        $msrp_price_display             =   $gameController->getMsrpPriceDisplay();
        $msrp_price_value               =   $gameController->getMsrpPriceValue();
        $discount_percentage            =   $gameController->getDiscountPercentage();
        $psn_primary_classification     =   $gameController->getPsnPrimaryClassification();
        $psn_secondary_classification   =   $gameController->getPsnSecondaryClassification();
        $psn_tertiary_classification    =   $gameController->getPsnTertiaryClassification();
        $psn_ps_camera_compatibility    =   $gameController->getPsnPsCameraCompatibility();
        $psn_ps_move_compatibility      =   $gameController->getPsnPsMoveCompatibility();
        $psn_ps_vr_compatibility        =   $gameController->getPsnPsVrCompatibility();

        return [
            'api'                           => $api,
            'game_id'                       => $gameId,
            'title'                         => $gameTitle,
            'release_date_na'               => $release_date,
            'genres'                        => $genres,
            'platforms'                     => $platforms,
            'publishers'                    => $provider_name,
            'developers'                    => $developer_name,
            'content_descriptors'           => $content_descriptors,
            'store_url'                     => $store_url,
            'thumbnail_url'                 => $thumbnail_url_base,
            'images'                        => $images,
            'videos'                        => $videos,
            'star_rating_score'             => $star_rating_score,
            'star_rating_count'             => $star_rating_count,
            'game_content_type'             => $game_content_type,
            'actual_price_display'          => $actual_price_display,
            'actual_price_value'            => $actual_price_value,
            'msrp_price_display'            => $msrp_price_display,
            'msrp_price_value'              => $msrp_price_value,
            'discount_percentage'           => $discount_percentage,
            'psn_primary_classification'    => $psn_primary_classification,
            'psn_secondary_classification'  => $psn_secondary_classification,
            'psn_tertiary_classification'   => $psn_tertiary_classification,
            'psn_ps_camera_compatibility'   => $psn_ps_camera_compatibility,
            'psn_ps_move_compatibility'     => $psn_ps_move_compatibility,
            'psn_ps_vr_compatibility'       => $psn_ps_vr_compatibility,
            'created_at'                    => \Carbon\Carbon::now(),
            'updated_at'                    => \Carbon\Carbon::now()
        ];
    }

    private function cleanString($string)
    {
        // Strip special characters
        $string = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $string);

        // Replace apostrophe to standard style
        $string = str_replace("’","'",$string);

        return $string;
    }

    /**
     * @return mixed
     */
    public function getVendor () {
        return $this->vendor;
    }

    /**
     * @param mixed $vendor
     */
    public function setVendor ($vendor) {
        $this->vendor = $vendor;
    }
}
