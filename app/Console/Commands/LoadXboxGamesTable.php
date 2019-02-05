<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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

        DB::table('xbox_games')->update(['created_at'=> \Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);

        echo PHP_EOL . "TOTAL FILES FOUND and ADDED: " . $fileCtr . PHP_EOL;
    }

    private function loadJson ($dirName,$file) {
        // Loop through and pull in each file
        // Decode File
        // Insert Contents into table
        $filePath = "resources/xbox/games/" . $dirName . "/" . $file;
        $jsonOutput = file_get_contents($filePath);
        $myJson     = json_decode($jsonOutput,true);

        ### Process JSON ###
        $xbox_id                        =   $myJson['ProductId'];
        $name                           =   $this->processString($myJson['LocalizedProperties'][0]['ProductTitle']);
        $release_date=null;
        if(isset($myJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['Properties']['OriginalReleaseDate'])){
            $release_date               =   date("Y-m-d", strtotime($myJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['Properties']['OriginalReleaseDate']));
        }
        $genres                         =   (isset($myJson['Properties']['Categories']) && count($myJson['Properties']['Categories'])>0) ? json_encode($myJson['Properties']['Categories']) : null;

        $platforms=[];
        if (isset($myJson['Properties']['Attributes'][0]['ApplicablePlatforms']) && count($myJson['Properties']['Attributes'][0]['ApplicablePlatforms'])>0){
            foreach($myJson['Properties']['Attributes'][0]['ApplicablePlatforms'] as $platform){
                array_push($platforms,$platform);
            }
        } else {
            $platforms = null;
        }
        $platforms                      =   json_encode($platforms);
        $provider_name = null;
        if(isset($myJson['LocalizedProperties'][0]['PublisherName'])){
            $provider_name                  =   $myJson['LocalizedProperties'][0]['PublisherName'];
        }

        $content_descriptors=[];
        if (isset($myJson['MarketProperties'][0]['ContentRatings']) && count($myJson['MarketProperties'][0]['ContentRatings'])>0) {
            foreach($myJson['MarketProperties'][0]['ContentRatings'] as $market){
                if($market['RatingSystem']=='ESRB'){
                    if (isset($market['RatingDescriptors']) && count($market['RatingDescriptors'])>0){
                        foreach($market['RatingDescriptors'] as $content){
                            array_push($content_descriptors,$content);
                        }
                    } else {
                        $content_descriptors = null;
                    }
                }
            }
        }
        $content_descriptors             =   json_encode($content_descriptors);

        $xbox_store_url                  =   "https://www.microsoft.com/en-us/p/" . $this->slugify($myJson['LocalizedProperties'][0]['ProductTitle']) . "/" . $xbox_id;

        $images=[];
        $thumbnail_url_base="";
        if (isset($myJson['LocalizedProperties'][0]['Images']) && count($myJson['LocalizedProperties'][0]['Images'])>0){
            foreach($myJson['LocalizedProperties'][0]['Images'] as $image){
                if($image['ImagePurpose'] == 'TitledHeroArt'){
                    $thumbnail_url_base = $image['Uri'];
                } else if ($image['ImagePurpose'] == 'Screenshot'){
                    array_push($images,$image['Uri']);
                }
            }
        } else {
            $images = null;
        }
        $images = json_encode($images);

        $videos=[];
//        if (isset($myJson['attributes']['media-list']) && count($myJson['attributes']['media-list'])>0){
//            if (isset($myJson['attributes']['media-list']['promo']['videos']) && count($myJson['attributes']['media-list']['promo']['videos'])>0){
//                foreach($myJson['attributes']['media-list']['promo']['videos'] as $video){
//                    array_push($videos,$video['url']);
//                }
//            }
//        } else {
//            $videos = null;
//        }
        $videos                         =   json_encode($videos);

        $star_rating_score              =   (isset($myJson['MarketProperties'][0]['UsageData'][2]['AverageRating'])) ? $myJson['MarketProperties'][0]['UsageData'][2]['AverageRating'] : null;
        $star_rating_count              =   (isset($myJson['MarketProperties'][0]['UsageData'][2]['RatingCount'])) ? $myJson['MarketProperties'][0]['UsageData'][2]['RatingCount'] : null;

//        $ps_camera_compatibility        =   (isset($myJson['attributes']['ps-camera-compatibility'])) ? $myJson['attributes']['ps-camera-compatibility'] : null;
//        $ps_move_compatibility          =   (isset($myJson['attributes']['ps-move-compatibility'])) ? $myJson['attributes']['ps-move-compatibility'] : null;
//        $ps_vr_compatibility            =   (isset($myJson['attributes']['ps-vr-compatibility'])) ? $myJson['attributes']['ps-vr-compatibility'] : null;
        $game_content_type              =   (isset($myJson['ProductId'])) ? $myJson['ProductId'] : null;
//        $file_size                      =   (isset($myJson['attributes']['file-size']['value'])) ? $myJson['attributes']['file-size']['value'] . " " . $myJson['attributes']['file-size']['unit'] : null;
        $actual_price_display           =   (isset($myJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['ListPrice']))  ? $myJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['ListPrice'] : null;
//        $actual_price_value             =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['actual-price']['value'])) ? $myJson['attributes']['skus'][0]['prices']['plus-user']['actual-price']['value'] : null;
        $strikethrough_price_display    =   (isset($myJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['MSRP'])) ? $myJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['MSRP'] : null;
//        $strikethrough_price_value      =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['strikethrough-price']['value'])) ? $myJson['attributes']['skus'][0]['prices']['plus-user']['strikethrough-price']['value'] : null;
//        $discount_percentage            =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['discount-percentage'])) ? $myJson['attributes']['skus'][0]['prices']['plus-user']['discount-percentage'] : null;
        $sale_start_date                =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['start-date'])) ? date("Y-m-d H:i:s", strtotime($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['start-date'])) : null;
        $sale_end_date                  =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['end-date'])) ? date("Y-m-d H:i:s", strtotime($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['end-date'])) : null;

        return [
            'xbox_id'                       => $xbox_id,
            'name'                          => $name,
            'release_date'                  => $release_date,
            'genres'                        => $genres,
            'platforms'                     => $platforms,
            'provider_name'                 => $provider_name,
            'xbox_store_url'                => $xbox_store_url,
            'content_descriptors'           => $content_descriptors,
            'thumbnail_url_base'            => $thumbnail_url_base,
            'images'                        => $images,
            'videos'                        => $videos,
            'star_rating_score'             => $star_rating_score,
            'star_rating_count'             => $star_rating_count,
            'game_content_type'             => $game_content_type,
            //'file_size'                     => $file_size,
            'actual_price_display'          => $actual_price_display,
            'actual_price_value'            => str_replace(".","",$actual_price_display),
            'strikethrough_price_display'   => $strikethrough_price_display,
            'strikethrough_price_value'     => str_replace(".","",$strikethrough_price_display),
            //'discount_percentage'           => $discount_percentage,
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

    private function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//IGNORE', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
