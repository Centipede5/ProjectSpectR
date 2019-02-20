<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\XboxGamesController;
use App\Http\Controllers\PsnGamesController;
use App\Http\Controllers\NinGamesController;

class SpectreLoadGameJsonUtility extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spectre:loadGameJsonTest {--usePsn}{--useXbox}';

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
     */
    public function handle()
    {
        if($this->option('usePsn')) {
            $file = "UP2613-CUSA09143_00-USSUPERHOTVRGAME.json";
        } else if($this->option('useXbox')){
            $file = "BV6BRSLFJW3W.json";
        } else {
            $file = "yAKJO3LB7zlPsJlbQIMpmmN7o2ffLTB6.json";
        }
        $myGameJson = $this->loadJson($file);
        dd($myGameJson);
        echo PHP_EOL;
    }

    private function loadJson ($file)
    {
        // The XboxGamesController will take the "file" reference and
        // then actually pull in the json file and process it
        if($this->option('usePsn')) {
            echo "PSN";
            $gameController = new PsnGamesController($file);
        } else if($this->option('useXbox')) {
            echo "XBOX";
            $gameController = new XboxGamesController($file);
        } else {
            echo "NIN";
            $gameController = new NinGamesController($file);
        }
        echo PHP_EOL;

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
            'psn_primary_classification'   => $psn_primary_classification,
            'psn_secondary_classification' => $psn_secondary_classification,
            'psn_tertiary_classification'  => $psn_tertiary_classification,
            'psn_ps_camera_compatibility'  => $psn_ps_camera_compatibility,
            'psn_ps_move_compatibility'    => $psn_ps_move_compatibility,
            'psn_ps_vr_compatibility'      => $psn_ps_vr_compatibility,
            'created_at'                    => \Carbon\Carbon::now(),
            'updated_at'                    => \Carbon\Carbon::now()
        ];
    }

    private function cleanString($string)
    {
        if($string!=null){
            // Strip special characters
            $string = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $string);

            // Replace apostrophe to standard style
            $string = str_replace("’","'",$string);
        }
        return $string;
    }
}