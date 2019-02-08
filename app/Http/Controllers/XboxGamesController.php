<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utilities\SpectreUtilities;

/**
 * Class XboxGamesController
 *
 * @package App\Http\Controllers
 */
class XboxGamesController extends Controller
{
    private $gameJson;

    private $gameId;
    private $gameTitle;
    private $release_date;
    private $provider_name;
    private $developer_name;
    private $content_descriptors;
    private $store_url;
    private $images;
    private $thumbnailUrl;
    private $videos;
    private $star_rating_score;
    private $star_rating_count;
    private $game_content_type;
    private $actual_price_display;
    private $actual_price_value;
    private $strikethrough_price_display;
    private $strikethrough_price_value;
    private $discount_percentage;
    private $sale_start_date;
    private $sale_end_date;

    /**
     * XboxGamesController constructor.
     * Pass in the Xbox Game ID to retrieve the JSON file Data
     *
     * @param $fileName
     */
    public function __construct ($fileName) {
        $filePath = "resources/xbox/games/" . substr($fileName,0,2) . "/" . $fileName;
        $jsonOutput = file_get_contents($filePath);
        $this->gameJson = json_decode($jsonOutput,true);

        $this->setGameId($this->gameJson['ProductId']);
        $this->setGameTitle($this->gameJson['LocalizedProperties'][0]['ProductTitle']);
        $this->setReleaseDate((isset($this->gameJson['MarketProperties'][0]['OriginalReleaseDate'])) ? date("Y-m-d", strtotime($this->gameJson['MarketProperties'][0]['OriginalReleaseDate'])) : null);
        $this->setProviderName((isset($this->gameJson['LocalizedProperties'][0]['PublisherName'])) ? $this->gameJson['LocalizedProperties'][0]['PublisherName'] : null);
        $this->setDeveloperName((isset($this->gameJson['LocalizedProperties'][0]['DeveloperName'])) ? $this->gameJson['LocalizedProperties'][0]['DeveloperName'] : null);
        $this->setStoreUrl($store_url = "https://www.microsoft.com/en-us/p/" . (new SpectreUtilities)->slugify($this->gameJson['LocalizedProperties'][0]['ProductTitle']) . "/" . $this->getGameId());
        $this->setContentDescriptors();
        $this->processImages();
        $this->processVideos();
        $this->setStarRatingCount();
        $this->setStarRatingScore();
        $this->setGameContentType();
        $this->setActualPriceDisplay();
        $this->setActualPriceValue();
        $this->setStrikethroughPriceDisplay();
        $this->setStrikethroughPriceValue();
        $this->setDiscountPercentage();
        $this->setSaleStartDate();
        $this->setSaleEndDate();
    }

    /**
     * This will return a JSON array of the Thumbnail and all the screenshots available
     *
     */
    public function processImages () {
        $gameJson = $this->gameJson;
        $images=[];
        $thumbnail_url_base="";
        if (isset($gameJson['LocalizedProperties'][0]['Images']) && count($gameJson['LocalizedProperties'][0]['Images'])>0){
            foreach($gameJson['LocalizedProperties'][0]['Images'] as $image){
                if($image['ImagePurpose'] == 'TitledHeroArt'){
                    if(strpos($image['Uri'],"http")===false){
                        $thumbnail_url_base = "https:".$image['Uri'];
                    } else {
                        $thumbnail_url_base = $image['Uri'];
                    }
                } else if ($image['ImagePurpose'] == 'Screenshot' || $image['ImagePurpose'] == "ImageGallery"){
                    if(strpos($image['Uri'],"https:")===false){
                        array_push($images,"https:".$image['Uri']);
                    } else {
                        array_push($images,$image['Uri']);
                    }
                }
            }
        } else {
            $images = null;
        }

        $images = json_encode($images);
        $this->setThumbnail($thumbnail_url_base);
        $this->setImages($images);
    }

    /**
     * This returns all of the Genres (categories) for each game
     * @return array|false|null|string
     */
    public function getGameGenre () {
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
     * @return mixed
     */
    public function getContentDescriptors () {
        return $this->content_descriptors;
    }

    /**
     * This returns an Array of all the ESRB Ratings that are attached to the game
     *
     */
    public function setContentDescriptors ()
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
                        if(isset($market['RatingId'])){
                            $content = $this->processRatingSystem($market['RatingId']);
                            array_push($content_descriptors,$content);
                        } else {
                            $content_descriptors = null;
                        }
                    }
                }
            }
        }
        $this->content_descriptors = json_encode($content_descriptors);
    }

    /**
     * Some games are available on Desktop or Mobile, so I thought it would be nice to have that distinguished
     *
     * @return array|false|null|string
     */
    public function getAvailablePlatforms ()
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
     * processVideos is not configured yet
     *
     * TODO: The way that the current JSON is setup, video links are a bit cryptic and I need to figure out how to make them work
     *
     */
    public function processVideos ()
    {
        //$gameJson = $this->gameJson;
        $videos = [];
        $videos = json_encode($videos);
        $this->setVideos($videos);
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
            case "ESRB:E":
                $cleanedRating = "Everyone";
                break;
            case "ESRB:E10":
                $cleanedRating = "Everyone";
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
            case "ESRB:RPEveryone":
                $cleanedRating = "Everyone";
                break;
            case "ESRB:RPTeen":
                $cleanedRating = "Everyone";
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
            case "ESRB:T":
                $cleanedRating = "Everyone";
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

    /**
     * @return mixed
     */
    public function getGameTitle () {
        return $this->gameTitle;
    }

    /**
     * @param mixed $gameTitle
     */
    public function setGameTitle ($gameTitle) {
        $this->gameTitle = $gameTitle;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate () {
        return $this->release_date;
    }

    /**
     * @param mixed $release_date
     */
    public function setReleaseDate ($release_date) {
        $this->release_date = $release_date;
    }

    /**
     * @return mixed
     */
    public function getGameId () {
        return $this->gameId;
    }

    /**
     * @param mixed $gameId
     */
    public function setGameId ($gameId) {
        $this->gameId = $gameId;
    }


    /**
     * @return mixed
     */
    public function getProviderName () {
        return $this->provider_name;
    }

    /**
     * @param mixed $provider_name
     */
    public function setProviderName ($provider_name) {
        $this->provider_name = $provider_name;
    }

    /**
     * @return mixed
     */
    public function getDeveloperName () {
        return $this->developer_name;
    }

    /**
     * @param mixed $developer_name
     */
    public function setDeveloperName ($developer_name) {
        $this->developer_name = $developer_name;
    }

    /**
     * @return mixed
     */
    public function getStoreUrl () {
        return $this->store_url;
    }

    /**
     * @param mixed $store_url
     */
    public function setStoreUrl ($store_url) {
        $this->store_url = $store_url;
    }

    /**
     * @return mixed
     */
    public function getImages () {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages ($images) {
        $this->images = $images;
    }

    /**
     * @return mixed
     */
    public function getThumbnail () {
        return $this->thumbnailUrl;
    }

    /**
     * @param mixed $thumbnailUrl
     */
    public function setThumbnail ($thumbnailUrl) {
        $this->thumbnailUrl = $thumbnailUrl;
    }

    /**
     * @return mixed
     */
    public function getVideos () {
        return $this->videos;
    }

    /**
     * @param mixed $videos
     */
    public function setVideos ($videos) {
        $this->videos = $videos;
    }

    /**
     * @return mixed
     */
    public function getStarRatingScore () {
        return $this->star_rating_score;
    }

    /**
     *
     */
    public function setStarRatingScore ()
    {
        $gameJson = $this->gameJson;
        $this->star_rating_score = (isset($gameJson['MarketProperties'][0]['UsageData'][2]['AverageRating'])) ? $gameJson['MarketProperties'][0]['UsageData'][2]['AverageRating'] : null;
    }

    /**
     * @return mixed
     */
    public function getStarRatingCount () {
        return $this->star_rating_count;
    }

    /**
     *
     */
    public function setStarRatingCount ()
    {
        $gameJson = $this->gameJson;
        $this->star_rating_count = (isset($gameJson['MarketProperties'][0]['UsageData'][2]['RatingCount'])) ? $gameJson['MarketProperties'][0]['UsageData'][2]['RatingCount'] : null;
    }

    /**
     * @return mixed
     */
    public function getGameContentType () {
        return $this->game_content_type;
    }

    /**
     *
     */
    private function setGameContentType ()
    {
        $gameJson = $this->gameJson;
        $this->game_content_type = (isset($gameJson['ProductId'])) ? $gameJson['ProductId'] : null;;
    }

    /**
     * @return mixed
     */
    public function getActualPriceDisplay () {
        return $this->actual_price_display;
    }

    /**
     *
     */
    public function setActualPriceDisplay () {
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

        $this->actual_price_display = ($actual_price_display == '0.00') ? "FREE" : "$" . $actual_price_display;
    }

    /**
     * @return mixed
     */
    public function getActualPriceValue () {
        return $this->actual_price_value;
    }

    /**
     *
     */
    public function setActualPriceValue () {
        $this->actual_price_value = ($this->actual_price_display!="FREE") ? str_replace(["$","."],"",$this->actual_price_display) : "0.00";
    }

    /**
     * @return mixed
     */
    public function getStrikethroughPriceDisplay () {

        return $this->strikethrough_price_display;
    }

    /**
     *
     */
    public function setStrikethroughPriceDisplay () {
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

        $this->strikethrough_price_display = ($strikethrough_price_display == '0.00') ? "FREE" : "$" . $strikethrough_price_display;
    }

    /**
     * @return mixed
     */
    public function getStrikethroughPriceValue () {
        return $this->strikethrough_price_value;
    }

    /**
     *
     */
    public function setStrikethroughPriceValue () {
        $this->strikethrough_price_value = ($this->strikethrough_price_display!="FREE") ? str_replace(["$","."],"",$this->strikethrough_price_display) : "0.00";
    }

    /**
     * @return mixed
     */
    public function getDiscountPercentage () {
        return $this->discount_percentage;
    }

    /**
     *
     */
    public function setDiscountPercentage ()
    {
        $msrp = $this->strikethrough_price_value;
        $list = $this->actual_price_value;

        if(is_numeric($msrp) && is_numeric($list)){
            if(($msrp - $list) != 0){
                $discount_percentage    =   round((($msrp - $list) / $msrp) * 100,0);
            } else {
                $discount_percentage    =   0;
            }
        } else {
            $discount_percentage        =   0;
        }
        $this->discount_percentage = $discount_percentage;
    }

    /**
     * @return mixed
     */
    public function getSaleStartDate () {
        return $this->sale_start_date;
    }

    /**
     *
     */
    public function setSaleStartDate () {
        $this->sale_start_date = null;
    }

    /**
     * @return mixed
     */
    public function getSaleEndDate () {
        return $this->sale_end_date;
    }

    /**
     *
     */
    public function setSaleEndDate () {
        $this->sale_end_date = null;
    }
}
