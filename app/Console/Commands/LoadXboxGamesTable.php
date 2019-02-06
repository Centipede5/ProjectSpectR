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

        $xboxController = new XboxGamesController($myJson);

        ### Process JSON ###
        $xbox_id                        =   $myJson['ProductId'];
        $name                           =   $this->processString($myJson['LocalizedProperties'][0]['ProductTitle']);
        $release_date                   =   (isset($myJson['MarketProperties'][0]['OriginalReleaseDate'])) ? date("Y-m-d", strtotime($myJson['MarketProperties'][0]['OriginalReleaseDate'])) : null;
        $genres                         =   $xboxController->processCategory();
        $platforms                      =   $xboxController->processPlatforms();
        $provider_name                  =   $this->processString((isset($myJson['LocalizedProperties'][0]['PublisherName'])) ? $myJson['LocalizedProperties'][0]['PublisherName'] : null);
        $developer_name                 =   $this->processString((isset($myJson['LocalizedProperties'][0]['DeveloperName'])) ? $myJson['LocalizedProperties'][0]['DeveloperName'] : null);
        $content_descriptors            =   $xboxController->processContentDescriptors();
        $xbox_store_url                 =   "https://www.microsoft.com/en-us/p/" . $this->slugify($myJson['LocalizedProperties'][0]['ProductTitle']) . "/" . $xbox_id;
        $xboxImages                     =   $xboxController->processImages();
        $images                         =   $xboxImages[1];
        $thumbnail_url_base             =   $xboxImages[0];
        $videos                         =   $xboxController->processVideos();
        $star_rating_score              =   (isset($myJson['MarketProperties'][0]['UsageData'][2]['AverageRating'])) ? $myJson['MarketProperties'][0]['UsageData'][2]['AverageRating'] : null;
        $star_rating_count              =   (isset($myJson['MarketProperties'][0]['UsageData'][2]['RatingCount'])) ? $myJson['MarketProperties'][0]['UsageData'][2]['RatingCount'] : null;
        $game_content_type              =   (isset($myJson['ProductId'])) ? $myJson['ProductId'] : null;
        $actual_price_display           =   $xboxController->processPriceDisplay();
        $actual_price_value             =   ($actual_price_display!="FREE") ? str_replace(["$","."],"",$actual_price_display) : "0.00";
        $strikethrough_price_display    =   $xboxController->processBasePriceDisplay();
        $strikethrough_price_value      =   ($strikethrough_price_display!="FREE") ? str_replace(["$","."],"",$strikethrough_price_display) : "0.00";
        $discount_percentage            =   $this->getDiscount($strikethrough_price_value,$actual_price_value);
        $sale_start_date                =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['start-date'])) ? date("Y-m-d H:i:s", strtotime($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['start-date'])) : null;
        $sale_end_date                  =   (isset($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['end-date'])) ? date("Y-m-d H:i:s", strtotime($myJson['attributes']['skus'][0]['prices']['plus-user']['availability']['end-date'])) : null;

        return [
            'xbox_id'                       => $xbox_id,
            'name'                          => $name,
            'release_date'                  => $release_date,
            'genres'                        => $genres,
            'platforms'                     => $platforms,
            'provider_name'                 => $provider_name,
            'developer_name'                => $developer_name,
            'xbox_store_url'                => $xbox_store_url,
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

    private function getDiscount($msrp, $list)
    {
        if(is_numeric($msrp) && is_numeric($list)){
            if(($msrp - $list) != 0){
                $discount_percentage    =   round((($msrp - $list) / $msrp) * 100,0);
            } else {
                $discount_percentage    =   0;
            }
        } else {
            $discount_percentage        =   0;
        }

        return $discount_percentage;
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
