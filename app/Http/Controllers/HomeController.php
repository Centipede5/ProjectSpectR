<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Remove this when the site goes LIVE
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $slides = new SliderController();
       $slides = $slides->getSlider('home-page');

       $games = new GameController();
       $games = $games->getGames('home-recent', 'console-only');
       return view('index', compact('slides','games'));
    }

    public function future()
    {
        $slides = new SliderController();
        $slides = $slides->getSlider('home-page');

        return view('home-new', compact('slides'));
    }


    public function ajaxTest ($data) {
        $response = [
            'name'=> 'Brandon',
            'id'=> 6
        ];

        return json_encode($response);
    }
}
