<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use DB;
class GameController extends Controller
{

    /**
     * @param string $filter
     * @param int $limit
     * @return Game[]|\Illuminate\Database\Eloquent\Collection
     *
     *  Currently release_date_na has an accessor defined, but can be overrode.
     *  in the view, use {{$game->getOriginal('release_date_na')}}
     *  This will display the stored DB value
     */
    public function getGames($filter='all', $platforms='all' , $limit=100) {

        $currentDate = date('Y-m-d');

        if ($filter=='home-recent'){
            $games = Game::where('release_date', '>=', $currentDate)
                ->orderBy('release_date')
                ->take(50)
                ->get();
        } else {
            $games = Game::all();
        }

        if($platforms == "console-only"){
            $platformArray = ['PS4','SWITCH','XBOXONE'];
            $gameLimit=1;  // How many games to load on the home page
            foreach ($games as $key => $game) {
                $pos=0;
                if($gameLimit<=9){
                    foreach ($platformArray as $platform){
                        $pos = $pos + strpos($game->platforms,$platform);
                    }

                    if($game->synopsis == "N/A"){
                        $game->synopsis = $game->summary;
                    }

                    if($game->image_landscape == null || $pos == 0){
                        $gameLimit=$gameLimit-1;
                        unset($games[$key]);
                    }
                } else {
                    unset($games[$key]);
                }

                $gameLimit++;
            }
        }

        return $games;
    }

    public function getGame($slug) {

        $game = Game::where('slug', $slug)->first();
        $jsonFile = resource_path('igdb/games/'.$game->igdb_id . "_" . $game->slug . ".json");

        $jsonOutput = file_get_contents($jsonFile);
        $gameInfo     = json_decode($jsonOutput,true);

        # Release Date
        if(isset($myJson['first_release_date'])){
            $gameInfo['first_release_date'] = (strlen($gameInfo['first_release_date']) == 12) ? date("Y-m-d", substr($gameInfo['first_release_date'],0,9)) : date("Y-m-d", substr($gameInfo['first_release_date'],0,10));
        } else {
            $gameInfo['first_release_date'] = null;
        }

        # Platforms
        $gameInfo['platforms'] = $this->setPlatformNames($gameInfo['platforms']);

        # Developers
        //$gameInfo['developers'] = (isset($gameInfo['developers'])) ? json_encode($gameInfo['developers']) : ['Unknown'];
        //$gameInfo['developers'] = $this->setPlatformNames($gameInfo['platforms']);

        # Publishers
        //$gameInfo['publishers'] = $this->setPlatformNames($gameInfo['platforms']);
        $gameInfo['image_hero'] = "https://images.igdb.com/igdb/image/upload/t_screenshot_huge/" . $gameInfo['cover']['cloudinary_id'] . ".jpg";
        $gameInfo['image_widget'] = "https://images.igdb.com/igdb/image/upload/t_720p/" . $gameInfo['cover']['cloudinary_id'] . ".jpg";

        return view('game.index', compact('gameInfo'));
    }

    private function setPlatformNames($platforms)
    {
        $platformLabels=[];
        if(isset($platforms)){
            foreach($platforms as $platform){
                $platformList = json_decode(DB::table('platforms')->select('igdb_id','slug')->get());
                foreach($platformList as $x){
                    if($platform == $x->igdb_id)
                    {
                        switch($x->slug){
                            case "win":
                                $thePlatform = "pc";
                                break;
                            case "steam":
                                $thePlatform = "pc";
                                break;
                            case "mac":
                                $thePlatform = "pc";
                                break;
                            case "linux":
                                $thePlatform = "pc";
                                break;
                            case "nintendo-switch":
                                $thePlatform = "switch";
                                break;
                            default:
                                $thePlatform = $x->slug;
                                break;
                        }

                        if (!in_array(strtoupper($thePlatform),$platformLabels)){
                            array_push($platformLabels,strtoupper($thePlatform));
                        }
                    }
                }
            }
        } else {
            array_push($platformLabels,"unknown");
        }

        return $platformLabels;
    }
}
