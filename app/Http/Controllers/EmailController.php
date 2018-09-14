<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\GeneralMail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;


class EmailController extends Controller
{
    // Hold the class instance
    private static $instance = null;

    public static function getInstance() {
        if (self::$instance == null){
            self::$instance = new EmailController();
        }
        return self::$instance;
    }
    public static function test(){
        echo "TEST";
    }

    public static function general ($to, $subject="subject", $data="data", $userId=0, $template="GENERAL", $scheduled="NOW") {
        Mail::to($to)->send(new GeneralMail($to, $subject, $data, $userId, $template, $scheduled));
    }
}
