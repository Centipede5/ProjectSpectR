<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utilities\SpectreUtilities;

/**
 * Class PsnGamesController
 *
 * @package App\Http\Controllers
 */
class PsnGamesController extends Controller
{

    /**
     * Table Column: vendor_games-> api
     *
     * @var
     */
    public $api = "psn";

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

    /**
     * Table Column: vendor_games-> psn_primary_classification
     *
     * @var
     */
    private $psn_primary_classification;

    /**
     * Table Column: vendor_games-> psn_secondary_classification
     *
     * @var
     */
    private $psn_secondary_classification;

    /**
     * Table Column: vendor_games-> psn_tertiary_classification
     *
     * @var
     */
    private $psn_tertiary_classification;

    /**
     * Table Column: vendor_games-> psn_ps_camera_compatibility
     *
     * @var
     */
    private $psn_ps_camera_compatibility;

    /**
     * Table Column: vendor_games-> psn_ps_move_compatibility
     *
     * @var
     */
    private $psn_ps_move_compatibility;

    /**
     * Table Column: vendor_games-> psn_ps_vr_compatibility
     *
     * @var
     */
    private $psn_ps_vr_compatibility;

    /**
     * @var mixed
     */
    private $gameJson;

    /**
     * @var string
     */
    private $jsonDir = "resources/psn/games";

    /**
     * @var
     */
    private $jsonSubDir;

    /**
     * PsnGamesController constructor.
     * Pass in the PSN Game ID to retrieve the JSON file Data
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
        $this->setPsnPrimaryClassification();
        $this->setPsnSecondaryClassification();
        $this->setPsnTertiaryClassification();
        $this->setPsnPsCameraCompatibility();
        $this->setPsnPsMoveCompatibility();
        $this->setPsnPsVrCompatibility();
    }

    /**
     * @return mixed
     */
    private function getJsonSubDir () {
        return $this->jsonSubDir;
    }

    /**
     * @param mixed $fileName
     */
    private function setJsonSubDir ($fileName) {
        $this->jsonSubDir = substr($fileName,0,6);
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
        $this->genres = (isset($this->gameJson['attributes']['genres']) && count($this->gameJson['attributes']['genres'])>0) ? json_encode($this->gameJson['attributes']['genres']) : null;
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
        if (isset($this->gameJson['attributes']['content-rating']['content-descriptors']) && count($this->gameJson['attributes']['content-rating']['content-descriptors'])>0){
            foreach($this->gameJson['attributes']['content-rating']['content-descriptors'] as $content){
                array_push($content_descriptors,$content['name']);
            }
        } else {
            $content_descriptors = null;
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
        if (isset($this->gameJson['attributes']['platforms']) && count($this->gameJson['attributes']['platforms'])>0){
            foreach($this->gameJson['attributes']['platforms'] as $platform){
                array_push($platforms,$platform);
            }
        } else {
            $platforms = null;
        }

        $this->platforms =  json_encode($platforms);
    }

    /**
     * @param $cleanTitle
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
        $this->gameTitle = $this->gameJson['attributes']['name'];
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
        $this->release_date_na = (isset($this->gameJson['attributes']['release-date'])) ? date("Y-m-d", strtotime($this->gameJson['attributes']['release-date'])) : null;
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
        $this->gameId = $this->gameJson['id'];
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
        $this->publishers = (isset($this->gameJson['attributes']['provider-name'])) ? $this->gameJson['attributes']['provider-name'] : null;
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
        $this->developers = null;
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
        $this->store_url = $store_url = "https://store.playstation.com/en-us/product/".$this->getGameId();
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
        $this->star_rating_score = (isset($this->gameJson['attributes']['star-rating']['score'])) ? $this->gameJson['attributes']['star-rating']['score'] : null;
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
        $this->star_rating_count = (isset($this->gameJson['attributes']['star-rating']['total'])) ? $this->gameJson['attributes']['star-rating']['total'] : null;
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
        $this->game_content_type = (isset($this->gameJson['attributes']['game-content-type'])) ? $this->gameJson['attributes']['game-content-type'] : null;
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
        $actual_price_display = (isset($this->gameJson['attributes']['skus'][0]['prices']['plus-user']['actual-price']['display']))  ? $this->gameJson['attributes']['skus'][0]['prices']['plus-user']['actual-price']['display'] : null;
        $this->actual_price_display = ($actual_price_display == '0.00') ? "FREE" :  $actual_price_display;
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
        $this->actual_price_value = (isset($this->gameJson['attributes']['skus'][0]['prices']['plus-user']['actual-price']['value'])) ? $this->gameJson['attributes']['skus'][0]['prices']['plus-user']['actual-price']['value'] : null;
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
        $msrp_price_display = (isset($this->gameJson['attributes']['skus'][0]['prices']['plus-user']['strikethrough-price']['value'])) ? $this->gameJson['attributes']['skus'][0]['prices']['plus-user']['strikethrough-price']['value'] : null;
        if ($msrp_price_display == null){
            $msrp_price_display = $this->getActualPriceDisplay();
        }

        $this->msrp_price_display = ($msrp_price_display == 'Free') ? "FREE" : $msrp_price_display;
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
        $msrp_price_value = (isset($this->gameJson['attributes']['skus'][0]['prices']['plus-user']['strikethrough-price']['value'])) ? $this->gameJson['attributes']['skus'][0]['prices']['plus-user']['strikethrough-price']['value'] : null;
        if ($msrp_price_value == null){
            $msrp_price_value = $this->getActualPriceValue();
        }

        $this->msrp_price_value = $msrp_price_value;
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
        //$discount_percentage            =   (isset($this->gameJson['attributes']['skus'][0]['prices']['plus-user']['discount-percentage'])) ? $this->gameJson['attributes']['skus'][0]['prices']['plus-user']['discount-percentage'] : null;
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
        return $this->psn_primary_classification;
    }

    /**
     *
     */
    private function setPsnPrimaryClassification () {
        $this->psn_primary_classification = (isset($this->gameJson['attributes']['primary-classification'])) ? $this->gameJson['attributes']['primary-classification'] : null;
    }

    /**
     * @return mixed
     */
    public function getPsnSecondaryClassification () {
        return $this->psn_secondary_classification;
    }

    /**
     *
     */
    private function setPsnSecondaryClassification () {
        $this->psn_secondary_classification = (isset($this->gameJson['attributes']['secondary-classification'])) ? $this->gameJson['attributes']['secondary-classification'] : null;
    }

    /**
     * @return mixed
     */
    public function getPsnTertiaryClassification () {
        return $this->psn_tertiary_classification;
    }

    /**
     *
     */
    private function setPsnTertiaryClassification () {
        $this->psn_tertiary_classification = (isset($this->gameJson['attributes']['tertiary-classification'])) ? $this->gameJson['attributes']['tertiary-classification'] : null;
    }

    /**
     * @return mixed
     */
    public function getPsnPsCameraCompatibility () {
        return $this->psn_ps_camera_compatibility;
    }

    /**
     *
     */
    private function setPsnPsCameraCompatibility () {
        $this->psn_ps_camera_compatibility = (isset($this->gameJson['attributes']['ps-camera-compatibility'])) ? $this->gameJson['attributes']['ps-camera-compatibility'] : null;
    }

    /**
     * @return mixed
     */
    public function getPsnPsMoveCompatibility () {
        return $this->psn_ps_move_compatibility;
    }

    /**
     *
     */
    private function setPsnPsMoveCompatibility () {
        $this->psn_ps_move_compatibility = (isset($this->gameJson['attributes']['ps-move-compatibility'])) ? $this->gameJson['attributes']['ps-move-compatibility'] : null;;
    }

    /**
     * @return mixed
     */
    public function getPsnPsVrCompatibility () {
        return $this->psn_ps_vr_compatibility;
    }

    /**
     *
     */
    private function setPsnPsVrCompatibility () {
        $this->psn_ps_vr_compatibility = (isset($this->gameJson['attributes']['ps-vr-compatibility'])) ? $this->gameJson['attributes']['ps-vr-compatibility'] : null;
    }

    /**
     * This will return a JSON array of the Thumbnail and all the screenshots available
     *
     */
    private function processImages () {
        $images=[];
        if (isset($this->gameJson['attributes']['media-list']) && count($this->gameJson['attributes']['media-list'])>0){
            if (isset($this->gameJson['attributes']['media-list']['promo']['images']) && count($this->gameJson['attributes']['media-list']['promo']['images'])>0){
                foreach($this->gameJson['attributes']['media-list']['promo']['images'] as $image){
                    array_push($images,$image['url']);
                }
            } else if(isset($this->gameJson['attributes']['media-list']['screenshots']) && count($this->gameJson['attributes']['media-list']['screenshots'])>0) {
                foreach ($this->gameJson['attributes']['media-list']['screenshots'] as $image) {
                    array_push($images, $image['url']);
                }
            }
        } else {
            $images = null;
        }

        $this->setThumbnail($this->gameJson['attributes']['thumbnail-url-base']);
        $this->setImages(json_encode($images));
    }

    /**
     *
     */
    private function processVideos ()
    {
        $videos=[];
        if (isset($this->gameJson['attributes']['media-list']) && count($this->gameJson['attributes']['media-list'])>0){
            if (isset($this->gameJson['attributes']['media-list']['promo']['videos']) && count($this->gameJson['attributes']['media-list']['promo']['videos'])>0){
                foreach($this->gameJson['attributes']['media-list']['promo']['videos'] as $video){
                    array_push($videos,$video['url']);
                }
            } else if (isset($this->gameJson['attributes']['media-list']['preview']) && count($this->gameJson['attributes']['media-list']['preview'])>0){
                foreach($this->gameJson['attributes']['media-list']['preview'] as $video){
                    array_push($videos,$video['url']);
                }
            }
        } else {
            $videos = null;
        }

        $this->setVideos(json_encode($videos));
    }

    /**
     * @param $title
     * @return mixed|null|string|string[]
     */
    private function cleanTitle ($title)
    {
        // Strip special characters
        $title = preg_replace("/(™|®|©|&trade;|&reg;|&copy;|&#8482;|&#174;|&#169;)/", "", $title);

        // Replace apostrophe to standard style
        $title = str_replace("’","'",$title);

        $title = str_replace(" (PSOne Clasic)","",$title);
        $title = str_replace("  (PSONE CLASSIC)","",$title);
        $title = str_replace(" (PSone Classic)","",$title);
        $title = str_replace(" (PSOne Classic)","",$title);
        $title = str_replace(" (PSOne classic)","",$title);
        $title = str_replace(" (PS3 Only)","",$title);
        $title = str_replace(" (PS3/PSP/PS Vita)","",$title);
        $title = str_replace(" (PS3/PSP/PS VITA)","",$title);
        $title = str_replace("(PS3/PSP/PS Vita)","",$title);
        $title = str_replace(" (PS3/PSP)","",$title);

        return $title;
    }

    public function createAlert ($title)
    {
        (new AlertController)->addAlert($title, $this->getGameId() . " - " . $this->getGameTitle());
    }
}
