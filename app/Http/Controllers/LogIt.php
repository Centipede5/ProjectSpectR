<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LogIt extends Controller
{
    public static function info ($data) {
        LogItController::getInstance()->info($data);
    }

    public static function debug ($data) {
        $bt = debug_backtrace();   //Using debug_backtrace() to get info about who called this method
        $caller = array_shift($bt);
        $data = "[DEBUG] " . " " . $data . " | " . basename($caller['file'] . ":" . $caller['line']);
        LogItController::getInstance()->info($data);
    }

    public static function trace ($data) {
        if( config('app.log_level') === "trace"){
            $data = "[TRACE] " . $data;
        }
        LogItController::getInstance()->info($data);
    }

    public static function error ($item, $error_level="[WARN]", $logSessionInfo=FALSE) {
        LogItController::getInstance()->error($item, $error_level, $logSessionInfo);
    }

    public static function userLog ($data) {
        if(Auth::user()){
            $userId = Auth::user()->id;
        } else {
            $userId = null;
        }
        LogItController::getInstance()->userLog($data,$userId);
    }

    public static function utilLog ($data) {
        LogItController::getInstance()->utilLog($data);
    }

    public static function DumpArrayToLog ($data) {
        LogItController::getInstance()->DumpArrayToLog($data);
    }
}
