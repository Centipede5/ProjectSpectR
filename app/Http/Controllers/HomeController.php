<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Log;

use FormLoggerPlus\Log2File;
use App\Http\Controllers\SliderController;

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

       return view('index', compact('slides'));
    }

    public function future()
    {
        $slides = new SliderController();
        $slides = $slides->getSlider('home-page');

        return view('future', compact('slides'));
    }


    public function ajaxTest ($data) {
        $response = [
            'name'=> 'Brandon',
            'id'=> 6
        ];

        return json_encode($response);
    }
}
