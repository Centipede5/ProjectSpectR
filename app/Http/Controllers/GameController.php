<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;

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
    public function getGames($filter='all', $limit=100) {

        $currentDate = date('Y-m-d');

        if ($filter=='home-recent'){
            $games = Game::where('release_date', '>=', $currentDate)
                ->orderBy('release_date')
                ->take(6)
                ->get();
        } else {
            $games = Game::all();
        }

        return $games;
    }
}
