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

    /**
     * Table Column: vendor_games-> api
     *
     * @var
     */
    public $api = "xbox";

    /**
     * Table Column: vendor_games-> game_id
     *
     * @var
     */
    private $gameId;

    # Unused Table field
    // vendor_games-> igdb_id

    /**
     * Table Column: vendor_games-> title
     *
     * @var
     */
    private $gameTitle;

    /**
     * Table Column: vendor_games-> release_date_na
     *
     * @var
     */
    private $release_date_na;

    /**
     * Table Column: vendor_games-> genres
     *
     * @var
     */
    private $genres;

    /**
     * Table Column: vendor_games-> platforms
     *
     * @var
     */
    private $platforms;

    /**
     * Table Column: vendor_games-> publishers
     *
     * @var
     */
    private $publishers;

    /**
     * Table Column: vendor_games-> developers
     *
     * @var
     */
    private $developers;

    /**
     * Table Column: vendor_games-> content_descriptors
     *
     * @var
     */
    private $content_descriptors;

    /**
     * Table Column: vendor_games-> store_url
     *
     * @var
     */
    private $store_url;

    /**
     * Table Column: vendor_games-> thumbnail_url
     *
     * @var
     */
    private $thumbnailUrl;

    /**
     * Table Column: vendor_games-> images
     *
     * @var
     */
    private $images;

    /**
     * Table Column: vendor_games-> videos
     *
     * @var
     */
    private $videos;
//    vendor_games-> file_size

    /**
     * Table Column: vendor_games-> star_rating_score
     *
     * @var
     */
    private $star_rating_score;

    /**
     * Table Column: vendor_games-> star_rating_count
     *
     * @var
     */
    private $star_rating_count;

    /**
     * Table Column: vendor_games-> game_content_type
     *
     * @var
     */
    private $game_content_type;

    /**
     * Table Column: vendor_games-> actual_price_display
     *
     * @var
     */
    private $actual_price_display;

    /**
     * Table Column: vendor_games-> actual_price_value
     *
     * @var
     */
    private $actual_price_value;

    /**
     * Table Column: vendor_games-> msrp_price_display
     *
     * @var
     */
    private $msrp_price_display;

    /**
     * Table Column: vendor_games-> msrp_price_value
     *
     * @var
     */
    private $msrp_price_value;

    /**
     * Table Column: vendor_games-> discount_percentage
     *
     * @var
     */
    private $discount_percentage;

    # Unused Table fields
    //    vendor_games-> best_value_price
    //    vendor_games-> best_value_date
    //    vendor_games-> psn_primary_classification
    //    vendor_games-> psn_secondary_classification
    //    vendor_games-> psn_tertiary_classification
    //    vendor_games-> psn_ps_camera_compatibility
    //    vendor_games-> psn_ps_move_compatibility
    //    vendor_games-> psn_ps_vr_compatibility

    /**
     * @var mixed
     */
    private $gameJson;

    /**
     * @var string
     */
    private $jsonDir = "resources/xbox/games";

    /**
     * @var
     */
    private $jsonSubDir;

    /**
     * XboxGamesController constructor.
     * Pass in the Xbox Game ID to retrieve the JSON file Data
     *
     * @param $fileName
     */
    public function __construct ($fileName)
    {
        $this->setJsonSubDir($fileName);
        $filePath = $this->jsonDir . "/" . $this->getJsonSubDir() . "/" . $fileName;
        $jsonOutput = file_get_contents($filePath);
        $this->gameJson = json_decode($jsonOutput,true);

        $this->setGameId();
        $this->setGameTitle();
        $this->setReleaseDate();
        $this->setPublisherName();
        $this->setDeveloperName();
        $this->setPlatforms();
        $this->setGameGenre();
        $this->setStoreUrl();
        $this->setContentDescriptors();
        $this->processImages();
        $this->processVideos();
        $this->setStarRatingCount();
        $this->setStarRatingScore();
        $this->setGameContentType();
        $this->setActualPriceDisplay();
        $this->setActualPriceValue();
        $this->setMsrpPriceDisplay();
        $this->setMsrpPriceValue();
        $this->setDiscountPercentage();
    }

    /**
     * @return mixed
     */
    public function getJsonSubDir () {
        return $this->jsonSubDir;
    }

    /**
     * @param mixed $fileName
     */
    private function setJsonSubDir ($fileName) {
        $this->jsonSubDir = substr($fileName,0,2);
    }

    /**
     * @return mixed
     */
    public function getGameGenre ()
    {
        return $this->genres;
    }

    /**
     *
     */
    private function setGameGenre()
    {
        if (isset($this->gameJson['Properties']['Categories']) && count($this->gameJson['Properties']['Categories'])>0){
            $genres = json_encode($this->gameJson['Properties']['Categories']);
        } else if (isset($this->gameJson['Properties']['Category']) && $this->gameJson['Properties']['Category']!=null){
            $genres=[];
            array_push($genres,$this->gameJson['Properties']['Category']);
            $genres = json_encode($genres);
        } else {
            $genres = null;
        }

        $this->genres = $genres;
    }

    /**
     * @return mixed
     */
    public function getContentDescriptors ()
    {
        return $this->content_descriptors;
    }

    /**
     * This returns an Array of all the ESRB Ratings that are attached to the game
     */
    private function setContentDescriptors ()
    {
        $content_descriptors=[];
        if (isset($this->gameJson['MarketProperties'][0]['ContentRatings']) && count($this->gameJson['MarketProperties'][0]['ContentRatings'])>0) {
            foreach($this->gameJson['MarketProperties'][0]['ContentRatings'] as $market){
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
     * @return mixed
     */
    public function getPlatforms ()
    {
        return $this->platforms;
    }

    /**
     * Some games are available on Desktop or Mobile, so I thought it would be nice to have that distinguished
     *
     */
    private function setPlatforms ()
    {
        $platforms=[];
        if(isset($this->gameJson['Properties']['Attributes'])){
            foreach($this->gameJson['Properties']['Attributes'] as $attribute){
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
            if(isset($this->gameJson['DisplaySkuAvailabilities'][0]['Sku']['Properties']['Packages'])){
                foreach($this->gameJson['DisplaySkuAvailabilities'][0]['Sku']['Properties']['Packages'] as $attribute){
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
            if(isset($this->gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['Conditions']['ClientConditions']['AllowedPlatforms'][0]['PlatformName'])){
                $thePlatform = explode(".",$this->gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['Conditions']['ClientConditions']['AllowedPlatforms'][0]['PlatformName']);
                array_push($platforms,$thePlatform[1]);
            }
            $platforms = (count($platforms)>0) ? json_encode(array_values(array_unique($platforms,SORT_REGULAR))) : null;
        }

        $this->platforms =  $platforms;
    }

    /**
     * @return mixed
     */
    public function getGameTitle ($cleanTitle = true)
    {
        if ($cleanTitle){
            return $this->cleanTitle($this->gameTitle);
        }
        return $this->gameTitle;
    }


    /**
     *
     */
    private function setGameTitle ()
    {
        $this->gameTitle = $this->gameJson['LocalizedProperties'][0]['ProductTitle'];
    }

    /**
     * @return mixed
     */
    public function getReleaseDate ()
    {
        return $this->release_date_na;
    }

    /**
     *
     */
    private function setReleaseDate ()
    {
        $this->release_date_na = (isset($this->gameJson['MarketProperties'][0]['OriginalReleaseDate'])) ? date("Y-m-d", strtotime($this->gameJson['MarketProperties'][0]['OriginalReleaseDate'])) : null;
    }

    /**
     * @return mixed
     */
    public function getGameId ()
    {
        return $this->gameId;
    }

    /**
     *
     */
    private function setGameId ()
    {
        $this->gameId = $this->gameJson['ProductId'];
    }

    /**
     * @return mixed
     */
    public function getPublisherName ()
    {
        return $this->publishers;
    }

    /**
     *
     */
    private function setPublisherName ()
    {
        $this->publishers = (isset($this->gameJson['LocalizedProperties'][0]['PublisherName'])) ? $this->gameJson['LocalizedProperties'][0]['PublisherName'] : null;
    }

    /**
     * @return mixed
     */
    public function getDeveloperName ()
    {
        return $this->developers;
    }

    /**
     *
     */
    private function setDeveloperName ()
    {
        $this->developers = (isset($this->gameJson['LocalizedProperties'][0]['DeveloperName'])) ? $this->gameJson['LocalizedProperties'][0]['DeveloperName'] : null;
    }

    /**
     * @return mixed
     */
    public function getStoreUrl ()
    {
        return $this->store_url;
    }

    /**
     *
     */
    private function setStoreUrl ()
    {
        $this->store_url = $store_url = "https://www.microsoft.com/en-us/p/" . (new SpectreUtilities)->slugify($this->gameJson['LocalizedProperties'][0]['ProductTitle']) . "/" . $this->getGameId();
    }

    /**
     * @return mixed
     */
    public function getImages ()
    {
        return $this->images;
    }

    /**
     * @param $images
     */
    private function setImages ($images)
    {
        $this->images = $images;
    }

    /**
     * @return mixed
     */
    public function getThumbnail ()
    {
        return $this->thumbnailUrl;
    }

    /**
     * @param $thumbnailUrl
     */
    private function setThumbnail ($thumbnailUrl)
    {
        $this->thumbnailUrl = $thumbnailUrl;
    }

    /**
     * @return mixed
     */
    public function getVideos ()
    {
        return $this->videos;
    }

    /**
     * @param $videos
     */
    private function setVideos ($videos)
    {
        $this->videos = $videos;
    }

    /**
     * @return mixed
     */
    public function getStarRatingScore ()
    {
        return $this->star_rating_score;
    }

    /**
     *
     */
    private function setStarRatingScore ()
    {
        $gameJson = $this->gameJson;
        $this->star_rating_score = (isset($gameJson['MarketProperties'][0]['UsageData'][2]['AverageRating'])) ? $gameJson['MarketProperties'][0]['UsageData'][2]['AverageRating'] : null;
    }

    /**
     * @return mixed
     */
    public function getStarRatingCount ()
    {
        return $this->star_rating_count;
    }

    /**
     *
     */
    private function setStarRatingCount ()
    {
        $this->star_rating_count = (isset($this->gameJson['MarketProperties'][0]['UsageData'][2]['RatingCount'])) ? $this->gameJson['MarketProperties'][0]['UsageData'][2]['RatingCount'] : null;
    }

    /**
     * @return mixed
     */
    public function getGameContentType ()
    {
        return $this->game_content_type;
    }

    /**
     *
     */
    private function setGameContentType ()
    {
        $this->game_content_type = (isset($this->gameJson['ProductKind'])) ? $this->gameJson['ProductKind'] : null;
    }

    /**
     * @return mixed
     */
    public function getActualPriceDisplay ()
    {
        return $this->actual_price_display;
    }

    /**
     *
     */
    private function setActualPriceDisplay ()
    {
        $actual_price_display           =   (isset($this->gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['ListPrice']))  ? $this->gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['ListPrice'] : null;
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
    private function setActualPriceValue () {
        $this->actual_price_value = ($this->actual_price_display!="FREE") ? str_replace(["$","."],"",$this->actual_price_display) : "0.00";
    }

    /**
     * @return mixed
     */
    public function getMsrpPriceDisplay () {

        return $this->msrp_price_display;
    }

    /**
     *
     */
    private function setMsrpPriceDisplay ()
    {
        $msrp_price_display           =   (isset($this->gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['ListPrice']))  ? $this->gameJson['DisplaySkuAvailabilities'][0]['Availabilities'][0]['OrderManagementData']['Price']['MSRP'] : null;
        if(strpos($msrp_price_display,".")===false){
            $msrp_price_display       = $msrp_price_display . ".00";
        }

        if($msrp_price_display == ".00"){
            $msrp_price_display = "0.00";
        }
        $cents = explode(".",$msrp_price_display);
        if(strlen($cents[1]) == 1){
            $msrp_price_display = $msrp_price_display . "0";
        }

        $this->msrp_price_display = ($msrp_price_display == '0.00') ? "FREE" : "$" . $msrp_price_display;
    }

    /**
     * @return mixed
     */
    public function getMsrpPriceValue () {
        return $this->msrp_price_value;
    }

    /**
     *
     */
    private function setMsrpPriceValue () {
        $this->msrp_price_value = ($this->msrp_price_display!="FREE") ? str_replace(["$","."],"",$this->msrp_price_display) : "0.00";
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
    private function setDiscountPercentage ()
    {
        $msrp = $this->msrp_price_value;
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
    public function getPsnPrimaryClassification () {
        return null;
    }

    /**
     * @return mixed
     */
    public function getPsnSecondaryClassification () {
        return null;
    }

    /**
     * @return mixed
     */
    public function getPsnTertiaryClassification () {
        return null;
    }

    /**
     * @return mixed
     */
    public function getPsnPsCameraCompatibility () {
        return null;
    }

    /**
     * @return mixed
     */
    public function getPsnPsMoveCompatibility () {
        return null;
    }

    /**
     * @return mixed
     */
    public function getPsnPsVrCompatibility () {
        return null;
    }

    /**
     * This will return a JSON array of the Thumbnail and all the screenshots available
     *
     */
    public function processImages () {
        $images=[];
        $thumbnail_url_base="";
        if (isset($this->gameJson['LocalizedProperties'][0]['Images']) && count($this->gameJson['LocalizedProperties'][0]['Images'])>0){
            foreach($this->gameJson['LocalizedProperties'][0]['Images'] as $image){
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
     * processVideos is not configured yet
     *
     * TODO: The way that the current JSON is setup, video links are a bit cryptic and I need to figure out how to make them work
     *
     */
    public function processVideos ()
    {
        $videos = [];
        $videos = json_encode($videos);
        $this->setVideos($videos);
    }

    /**
     * I am only using the ESRB rating system at this time
     *
     * @param $gameRating
     * @return string
     */
    private function processRatingSystem($gameRating)
    {
        if(substr($gameRating,0,3)=='SRB'){
            $gameRating = "ESRB:" . substr($gameRating,3);
        }

        switch($gameRating){
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
                $cleanedRating = $gameRating;
                break;
        }

        return $cleanedRating;
    }

    private function cleanTitle ($title)
    {
        // Strip special characters
        $title = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $title);

        // Replace apostrophe to standard style
        $title = str_replace("’","'",$title);

        return $title;
    }
}
