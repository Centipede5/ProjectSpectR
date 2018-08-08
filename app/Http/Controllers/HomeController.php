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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       /* (new Log2File)->History("Let's Start Logging!");

        Log::info('This is some useful information.');
// Create the logger
        $logger = new Logger('my_logger');
// Now add some handlers
        $logger->pushHandler(new StreamHandler(__DIR__.'/my_app.log', Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());

// You can now use your logger
        $logger->addInfo('My logger is now ready');
        $logger->addInfo('Adding a new user', array('username' => 'Seldaek'));
        $logger->addCritical('FAILURE'); */

       $slides = new SliderController();
       $slides = $slides->getSlider('home-page');

       return view('index', compact('slides'));
    }

    public function ajaxTest ($data) {
        $response = [
            'name'=> 'Brandon',
            'id'=> 6
        ];

        return json_encode($response);
    }
}
