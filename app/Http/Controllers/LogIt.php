<?php

namespace App\Http\Controllers;

use Auth;

class LogIt extends Controller
{
    /**
     * @param $data
     * Use info() for all general, permanent logging.
     */
    public static function info ($data) {
        LogItController::getInstance()->info($data);
    }

    /**
     * @param $data
     * Use debug() for temporary logging. If you see this in a
     *      log file years from now, it needs to be removed
     */
    public static function debug ($data) {
        $bt = debug_backtrace();   //Using debug_backtrace() to get info about who called this method
        $caller = array_shift($bt);
        // OUTPUT: [DEBUG] Message Here | FileName.php:373
        $data = "[DEBUG] " . $data . " | " . basename($caller['file'] . ":" . $caller['line']);
        LogItController::getInstance()->info($data);
    }

    /**
     * @param $data
     * Use trace() for extensive logging. Leave in the code if
     *          you want for long term. Just turn on the
     *          Log Config with using the term, trace
     */
    public static function trace ($data) {
        if( config('app.log_level') === "trace"){
            $data = "[TRACE] " . $data;
            LogItController::getInstance()->info($data);
        }
    }

    /**
     * @param $item
     * @param string $error_level
     * @param bool $logSessionInfo
     * Use error() for Error Logging. It will dump the $item into
     *      the error Log File as well as the info log file.
     */
    public static function error ($item, $error_level="[WARN]", $logSessionInfo=FALSE) {
        LogItController::getInstance()->error($item, $error_level, $logSessionInfo);
    }

    /**
     * @param $data
     * Use userLog() to track specific movements from the user. This could
     *      be an entry for updating their profile or creating a new post.
     */
    public static function userLog ($data) {
        if(Auth::user()){
            $userId = Auth::user()->id;
        } else {
            $userId = null;
        }
        LogItController::getInstance()->userLog($data,$userId);
    }

    /**
     * @param $data
     * The utilLog() is mainly used for CLI process scripts
     */
    public static function utilLog ($data) {
        LogItController::getInstance()->utilLog($data);
    }

    /**
     * @param $data
     * DumpArrayToLog() is for logging arrays
     */
    public static function DumpArrayToLog ($data) {
        LogItController::getInstance()->DumpArrayToLog($data);
    }
}
