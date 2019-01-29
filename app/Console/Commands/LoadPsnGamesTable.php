<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LoadPsnGamesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'psn:loadGamesTable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears and Rebuilds the PsnGamesTable';

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
        DB::table('psn_games')->delete();

        $subDirectoryList = [];
        $DocDirectory = "resources/psn/games";   //Directory to be scanned

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
            $DocDirectory = "resources/psn/games/" . $dirName;
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
                            array_push($data, $this->loadJson($dirName,$a));
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
                            array_push($data, $this->loadJson($dirName,$a));
                            $ctr++;
                        }
                        // If the Counter hits 40, Inert
                        else {
                            array_push($data, $this->loadJson($dirName,$a));
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

        DB::table('psn_games')->update(['created_at'=> \Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);

        echo PHP_EOL . "TOTAL FILES FOUND and ADDED: " . $fileCtr . PHP_EOL;
    }

    private function loadJson ($dirName,$file) {
        // Loop through and pull in each file
        // Decode File
        // Insert Contents into table
        $filePath = "resources/psn/games/" . $dirName . "/" . $file;
        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        ### Process JSON ###
        $psn_id                         =   $myJson['id'];

        //
        $name                           =   $this->processString($myJson['attributes']['name']);
        $release_date                   =   date("Y-m-d", strtotime($myJson['attributes']['release-date']));
        $genres                         =   (isset($myJson['attributes']['genres']) && count($myJson['attributes']['genres'])>0) ? json_encode($myJson['attributes']['genres']) : null;

        $platforms=[];
        if (isset($myJson['attributes']['platforms']) && count($myJson['attributes']['platforms'])>0){
            foreach($myJson['attributes']['platforms'] as $platform){
                array_push($platforms,$platform);
            }
        } else {
            $platforms = null;
        }
        $platforms                      = json_encode($platforms);
        $provider_name                  =   $myJson['attributes']['provider-name'];

        $content_descriptors=[];
        if (isset($myJson['attributes']['content-rating']['content-descriptors']) && count($myJson['attributes']['content-rating']['content-descriptors'])>0){
            foreach($myJson['attributes']['content-rating']['content-descriptors'] as $content){
                array_push($content_descriptors,$content['name']);
            }
        } else {
            $content_descriptors = null;
        }
        $content_descriptors            =   json_encode($content_descriptors);
        $psn_store_url                  =   "https://store.playstation.com/en-us/product/".$psn_id;
        $thumbnail_url_base             =   $myJson['attributes']['thumbnail-url-base'];

        $images=[];
        if (isset($myJson['attributes']['media-list']) && count($myJson['attributes']['media-list'])>0){
            if (isset($myJson['attributes']['media-list']['promo']['images']) && count($myJson['attributes']['media-list']['promo']['images'])>0){
                foreach($myJson['attributes']['media-list']['promo']['images'] as $image){
                    array_push($images,$image['url']);
                }
            }
        } else {
            $images = null;
        }
        $images                         =   json_encode($images);

        $videos=[];
        if (isset($myJson['attributes']['media-list']) && count($myJson['attributes']['media-list'])>0){
            if (isset($myJson['attributes']['media-list']['promo']['videos']) && count($myJson['attributes']['media-list']['promo']['videos'])>0){
                foreach($myJson['attributes']['media-list']['promo']['videos'] as $video){
                    array_push($videos,$video['url']);
                }
            }
        } else {
            $videos = null;
        }
        $videos                         =   json_encode($videos);
        $star_rating_score              =   (isset($myJson['attributes']['star-rating']['score'])) ? $myJson['attributes']['star-rating']['score'] : null;
        $star_rating_count              =   (isset($myJson['attributes']['star-rating']['total'])) ? $myJson['attributes']['star-rating']['total'] : null;
        $primary_classification         =   (isset($myJson['attributes']['primary-classification'])) ? $myJson['attributes']['primary-classification'] : null;
        $secondary_classification       =   (isset($myJson['attributes']['secondary-classification'])) ? $myJson['attributes']['secondary-classification'] : null;
        $tertiary_classification        =   (isset($myJson['attributes']['tertiary-classification'])) ? $myJson['attributes']['tertiary-classification'] : null;
        $ps_camera_compatibility        =   (isset($myJson['attributes']['ps-camera-compatibility'])) ? $myJson['attributes']['ps-camera-compatibility'] : null;
        $ps_move_compatibility          =   (isset($myJson['attributes']['ps-move-compatibility'])) ? $myJson['attributes']['ps-move-compatibility'] : null;
        $ps_vr_compatibility            =   (isset($myJson['attributes']['ps-vr-compatibility'])) ? $myJson['attributes']['ps-vr-compatibility'] : null;
        $game_content_type              =   (isset($myJson['attributes']['game-content-type'])) ? $myJson['attributes']['game-content-type'] : null;
        $file_size                      =   (isset($myJson['attributes']['file-size']['value'])) ? $myJson['attributes']['file-size']['value'] . " " . $myJson['attributes']['file-size']['unit'] : null;
        $actual_price_display           =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['actual-price']['display']))  ? $myJson['attributes']['skus'][0]['prices']['plus-user']['actual-price']['display'] : null;
        $actual_price_value             =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['actual-price']['value'])) ? $myJson['attributes']['skus'][0]['prices']['plus-user']['actual-price']['value'] : null;
        $strikethrough_price_display    =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['strikethrough-price']['display'])) ? $myJson['attributes']['skus'][0]['prices']['plus-user']['strikethrough-price']['display'] : null;
        $strikethrough_price_value      =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['strikethrough-price']['value'])) ? $myJson['attributes']['skus'][0]['prices']['plus-user']['strikethrough-price']['value'] : null;
        $discount_percentage            =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['discount-percentage'])) ? $myJson['attributes']['skus'][0]['prices']['plus-user']['discount-percentage'] : null;
        $sale_start_date                =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['start-date'])) ? date("Y-m-d H:i:s", strtotime($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['start-date'])) : null;
        $sale_end_date                  =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['end-date'])) ? date("Y-m-d H:i:s", strtotime($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['end-date'])) : null;

        return [
            'psn_id'                        => $psn_id,
            'name'                          => $name,
            'release_date'                  => $release_date,
            'genres'                        => $genres,
            'platforms'                     => $platforms,
            'provider_name'                 => $provider_name,
            'psn_store_url'                 => $psn_store_url,
            'content_descriptors'           => $content_descriptors,
            'thumbnail_url_base'            => $thumbnail_url_base,
            'images'                        => $images,
            'videos'                        => $videos,
            'star_rating_score'             => $star_rating_score,
            'star_rating_count'             => $star_rating_count,
            'primary_classification'        => $primary_classification,
            'secondary_classification'      => $secondary_classification,
            'tertiary_classification'       => $tertiary_classification,
            'ps_camera_compatibility'       => $ps_camera_compatibility,
            'ps_move_compatibility'         => $ps_move_compatibility,
            'ps_vr_compatibility'           => $ps_vr_compatibility,
            'game_content_type'             => $game_content_type,
            'file_size'                     => $file_size,
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

    private function massInsert ($data) {
        echo PHP_EOL;
        DB::table('psn_games')->insert($data);
    }

    private function processString($string){

        // Strip special characters
        $string = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $string);

        // Replace apostrophe to standard style
        $string = str_replace("’","'",$string);

        // (PS3 Only)
        // (PS3/PSP/PS Vita)

        $string = str_replace(" (PS3 Only)","",$string);
        $string = str_replace(" (PS3/PSP/PS Vita)","",$string);
        $string = str_replace(" (PS3/PSP/PS VITA)","",$string);
        $string = str_replace("(PS3/PSP/PS Vita)","",$string);
        $string = str_replace(" (PS3/PSP)","",$string);

        return $string;
    }
}
