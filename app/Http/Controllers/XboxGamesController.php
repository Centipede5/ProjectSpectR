<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class XboxGamesController
 *
 *
 *
 * @package App\Http\Controllers
 */
class XboxGamesController extends Controller
{
    private $gameJson;

    public function __construct ($gameJson) {
        $this->gameJson = $gameJson;
    }

    /**
     * This will return a JSON array of the Thumbnail and all the screenshots available
     *
     * @param $gameJson
     * @return array
     */
    public function processImages () {
        $gameJson = $this->gameJson;
        $images=[];
        $thumbnail_url_base="";
        if (isset($gameJson['LocalizedProperties'][0]['Images']) && count($gameJson['LocalizedProperties'][0]['Images'])>0){
            foreach($gameJson['LocalizedProperties'][0]['Images'] as $image){
                if($image['ImagePurpose'] == 'TitledHeroArt'){
                    if(strpos($image['Uri'],"http")!=0){
                        $thumbnail_url_base = $image['Uri'];
                    } else {
                        $thumbnail_url_base = "https:".$image['Uri'];
                    }
                } else if ($image['ImagePurpose'] == 'Screenshot' || $image['ImagePurpose'] == "ImageGallery"){
                    if(strpos($image['Uri'],"http")!=0){
                        array_push($images,$image['Uri']);
                    } else {
                        array_push($images,"https:".$image['Uri']);
                    }
                }
            }
        } else {
            $images = null;
        }

        $images = json_encode($images);

        return [$thumbnail_url_base,$images];
    }

    /**
     * This returns all of the Genres (categories) for each game
     *
     * @param $xboxGameProperties
     * @return array|false|null|string
     */
    public function processCategory () {
        $gameJson = $this->gameJson;
        if (isset($gameJson['Properties']['Categories']) && count($gameJson['Properties']['Categories'])>0){
            $genres = json_encode($gameJson['Properties']['Categories']);
        } else if (isset($gameJson['Properties']['Category']) && $gameJson['Properties']['Category']!=null){
            $genres=[];
            array_push($genres,$gameJson['Properties']['Category']);
            $genres = json_encode($genres);
        } else {
            $genres = null;
        }

        return $genres;
    }

    /**
     * This returns an Array of all the ESRB Ratings that are attached to the game
     *
     * @param $gameJson
     * @return false|string
     */
    public function processContentDescriptors ()
    {
        $gameJson = $this->gameJson;
        $content_descriptors=[];
        if (isset($gameJson['MarketProperties'][0]['ContentRatings']) && count($gameJson['MarketProperties'][0]['ContentRatings'])>0) {
            foreach($gameJson['MarketProperties'][0]['ContentRatings'] as $market){
                if($market['RatingSystem']=='ESRB'){
                    if (isset($market['RatingDescriptors']) && count($market['RatingDescriptors'])>0){
                        foreach($market['RatingDescriptors'] as $content){
                            $content = $this->processRatingSystem($content);
                            array_push($content_descriptors,$content);
                        }
                    } else {
                        $content_descriptors = null;
                    }
                }
            }
        }
        return json_encode($content_descriptors);
    }

    /**
     * Some games are available on Desktop or Mobile, so I thought it would be nice to have that distinguised
     *
     * @param $gameJson
     * @return array|false|null|string
     */
    public function processPlatforms ()
    {
        $gameJson = $this->gameJson;
        $platforms=[];
        if(isset($gameJson['Properties']['Attributes'])){
            foreach($gameJson['Properties']['Attributes'] as $attribute){
                if(isset($attribute['Name'])){
                    if(isset($attribute['ApplicablePlatforms']) && $attribute['ApplicablePlatforms']!=null){
                        foreach($attribute['ApplicablePlatforms'] as $appPlatforms){
                            array_push($platforms,$appPlatforms);
                        }
                    }
                }
            }
        }
        $platforms = (count($platforms)>0) ? json_encode(array_values(array_unique($platforms,SORT_REGULAR))) : null;

        if($platforms==null){
            $platforms =[];
            if(isset($gameJson['DisplaySkuAvailabilities'][0]['Sku']['Properties']['Packages'])){
                foreach($gameJson['DisplaySkuAvailabilities'][0]['Sku']['Properties']['Packages'] as $attribute){
                    if(isset($attribute['PlatformDependencies'])){
                        if(isset($attribute['PlatformDependencies'][0]['PlatformName']) && $attribute['PlatformDependencies'][0]['PlatformName']!=null){
                            $thePlatform = explode(".",$attribute['PlatformDependencies'][0]['PlatformName']);
                            array_push($platforms,$thePlatform[1]);
                        }
                    }
                }
            }
            $platforms = (count($platforms)>0) ? json_encode(array_values(array_unique($platforms,SORT_REGULAR))) : null;
        }

        if($platforms==null){
            $platforms =[];
            if(isset($gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['Conditions']['ClientConditions']['AllowedPlatforms'][0]['PlatformName'])){
                $thePlatform = explode(".",$gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['Conditions']['ClientConditions']['AllowedPlatforms'][0]['PlatformName']);
                array_push($platforms,$thePlatform[1]);
            }
            $platforms = (count($platforms)>0) ? json_encode(array_values(array_unique($platforms,SORT_REGULAR))) : null;
        }

        return $platforms;
    }

    /**
     * This is just the typical output display for the actual Listed price
     *
     * @param $gameJson
     * @return string
     */
    public function processPriceDisplay ()
    {
        $gameJson = $this->gameJson;
        $actual_price_display           =   (isset($gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['ListPrice']))  ? $gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['ListPrice'] : null;
        if(strpos($actual_price_display,".")===false){
            $actual_price_display       = $actual_price_display . ".00";
        }

        if($actual_price_display == ".00"){
            $actual_price_display = "0.00";
        }
        $cents = explode(".",$actual_price_display);
        if(strlen($cents[1]) == 1){
            $actual_price_display = $actual_price_display . "0";
        }

        return ($actual_price_display == '0.00') ? "FREE" : "$" . $actual_price_display;
    }

    /**
     * Under Construction
     * TODO: The way that the current JSON is setup, video links are a bit cryptic and I need to figure out how to make them work
     * @param $gameJson
     * @return array|false|string
     */
    public function processVideos ()
    {
        $gameJson = $this->gameJson;
        $videos = [];
        $videos = json_encode($videos);
        return $videos;
    }

    /**
     * This is just the typical output display for the base MSRP price
     *
     * @param $gameJson
     * @return string
     */
    public function processBasePriceDisplay ()
    {
        $gameJson = $this->gameJson;
        $strikethrough_price_display           =   (isset($gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['ListPrice']))  ? $gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['MSRP'] : null;
        if(strpos($strikethrough_price_display,".")===false){
            $strikethrough_price_display       = $strikethrough_price_display . ".00";
        }

        if($strikethrough_price_display == ".00"){
            $strikethrough_price_display = "0.00";
        }
        $cents = explode(".",$strikethrough_price_display);
        if(strlen($cents[1]) == 1){
            $strikethrough_price_display = $strikethrough_price_display . "0";
        }

        return ($strikethrough_price_display == '0.00') ? "FREE" : "$" . $strikethrough_price_display;
    }

    /**
     * I am only using the ESRB rating system at this time
     *
     * @param $xboxRating
     * @return string
     */
    private function processRatingSystem($xboxRating)
    {
        if(substr($xboxRating,0,3)=='SRB'){
            $xboxRating = "ESRB:" . substr($xboxRating,3);
        }

        switch($xboxRating){
            case "ESRB:AlcRef":
                $cleanedRating = "Alcohol Reference";
                break;
            case "ESRB:AlcAndTobRef":
                $cleanedRating = "Alcohol and Tobacco Reference";
                break;
            case "ESRB:AniBlo":
                $cleanedRating = "Animated Blood";
                break;
            case "ESRB:Blo":
                $cleanedRating = "Blood";
                break;
            case "ESRB:BloGor":
                $cleanedRating = "Blood and Gore";
                break;
            case "ESRB:CarVio":
                $cleanedRating = "Cartoon Violence";
                break;
            case "ESRB:ComMis":
                $cleanedRating = "Comic Mischief";
                break;
            case "ESRB:CruHum":
                $cleanedRating = "Crude Humor";
                break;
            case "ESRB:DruRef":
                $cleanedRating = "Drug Reference";
                break;
            case "ESRB:FanVio":
                $cleanedRating = "Fantasy Violence";
                break;
            case "ESRB:IntVio":
                $cleanedRating = "Intense Violence";
                break;
            case "ESRB:Lan":
                $cleanedRating = "Language";
                break;
            case "ESRB:Lyr":
                $cleanedRating = "Lyrics";
                break;
            case "ESRB:MatHum":
                $cleanedRating ="Mature Humor";
                break;
            case "ESRB:MilBlo":
                $cleanedRating ="Mild Blood";
                break;
            case "ESRB:MilCarVio":
                $cleanedRating ="Mild Cartoon Violence";
                break;
            case "ESRB:MilFanVio":
                $cleanedRating ="Mild Fantasy Violence";
                break;
            case "ESRB:MilLan":
                $cleanedRating ="Mild Language";
                break;
            case "ESRB:MilLyr":
                $cleanedRating ="Mild Lyrics";
                break;
            case "ESRB:MilSexThe":
                $cleanedRating ="Mild Sexual Themes";
                break;
            case "ESRB:MilSugThe":
                $cleanedRating ="Mild Suggestive Themes";
                break;
            case "ESRB:MilVio":
                $cleanedRating ="Mild Violence";
                break;
            case "ESRB:MilVio1":
                $cleanedRating ="Mild Violence";
                break;
            case "ESRB:MilVio3":
                $cleanedRating ="Mild Violence";
                break;
            case "ESRB:MilVio5":
                $cleanedRating ="Mild Violence";
                break;
            case "ESRB:MilVio7":
                $cleanedRating ="Mild Violence";
                break;
            case "ESRB:MilVio9":
                $cleanedRating ="Mild Violence";
                break;
            case "ESRB:Nud":
                $cleanedRating ="Nudity";
                break;
            case "ESRB:ParNud":
                $cleanedRating ="Partial Nudity";
                break;
            case "ESRB:ReaGam":
                $cleanedRating ="Real Gambling";
                break;
            case "ESRB:SexCon":
                $cleanedRating ="Sexual Content";
                break;
            case "ESRB:SexThe":
                $cleanedRating ="Sexual Themes";
                break;
            case "ESRB:SexVio":
                $cleanedRating ="Sexual Violence";
                break;
            case "ESRB:SimGam":
                $cleanedRating ="Simulated Gambling";
                break;
            case "ESRB:StrLan":
                $cleanedRating ="Strong Language";
                break;
            case "ESRB:StrLyr":
                $cleanedRating ="Strong Lyrics";
                break;
            case "ESRB:StrSexCon":
                $cleanedRating ="Strong Sexual Content";
                break;
            case "ESRB:SugThe":
                $cleanedRating ="Suggestive Themes";
                break;
            case "ESRB:TobRef":
                $cleanedRating ="Tobacco Reference";
                break;
            case "ESRB:UseOfAlcAndTob":
                $cleanedRating ="Use of Alcohol and Tobacco";
                break;
            case "ESRB:UseAlc":
                $cleanedRating ="Use of Alcohol";
                break;
            case "ESRB:UseDru":
                $cleanedRating ="Use of Drugs";
                break;
            case "ESRB:UseTob":
                $cleanedRating ="Use of Tobacco";
                break;
            case "ESRB:Vio":
                $cleanedRating ="Violence";
                break;
            case "ESRB:VioRef":
                $cleanedRating ="Violent References";
                break;
            default:
                $cleanedRating = $xboxRating;
                break;
        }

        return $cleanedRating;
    }
}
