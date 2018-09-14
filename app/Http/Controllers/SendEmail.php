<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendEmail extends Controller
{
    //
    public static function general ($to, $subject, $data, $userId=0, $template="GENERAL", $scheduled="NOW") {
        EmailController::getInstance()->general($to, $subject, $data, $userId, $template, $scheduled);
    }
    public static function test () {
        EmailController::getInstance()->test();
    }
}
