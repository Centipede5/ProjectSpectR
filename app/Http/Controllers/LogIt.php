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
        if(is_array($data)) {
            LogItController::getInstance()->info( "[INFO] " . "Array Dump" );
            LogItController::getInstance()->dumpArrayToLog($data);
        } else {
            LogItController::getInstance()->info("[INFO] " . $data);
        }
    }

    /**
     * @param $data
     * Use debug() for temporary logging. If you see this in a
     *      log file years from now, it needs to be removed
     */
    public static function debug ($data) {
        $bt = debug_backtrace();   //Using debug_backtrace() to get info about who called this method
        $caller = array_shift($bt);

        if(is_array($data)) {
            LogItController::getInstance()->info(
                "[DEBUG] Array Dump" . " | " . basename($caller['file'] . ":" . $caller['line'])
            );
            LogItController::getInstance()->dumpArrayToLog($data);
        } else {
            // OUTPUT: [DEBUG] Message Here | FileName.php:373
            LogItController::getInstance()->info(
                "[DEBUG] " . $data . " | " . basename($caller['file'] . ":" . $caller['line'])
            );
        }
    }

    /**
     * @param $data
     * Use trace() for extensive logging. Leave in the code if
     *          you want for long term. Just turn on the
     *          Log Config with using the term, trace
     */
    public static function trace ($data) {
        if( config('app.log_level') === "trace"){
            if(is_array($data)) {
                LogItController::getInstance()->info( "[TRACE] " . "Array Dump" );
                LogItController::getInstance()->dumpArrayToLog($data);
            } else {
                LogItController::getInstance()->info("[TRACE] " . $data);
            }
        }
    }

    /**
     * @param $data
     * @param string $error_level
     * @param bool $logSessionInfo
     * Use error() for Error Logging. It will dump the $item into
     *      the error Log File as well as the info log file.
     */
    public static function error ($data, $error_level="WARN") {
        if(is_array($data)) {
            LogItController::getInstance()->error( "[" . $error_level . "] Array Dump");
            LogItController::getInstance()->dumpErrorArrayToLog($data);
        } else {
            LogItController::getInstance()->error("[" . $error_level . "] " . $data);
        }
    }

    /**
     * @param $data
     * Use userLog() to track specific movements from the user. This could
     *      be an entry for updating their profile or creating a new post.
     */
    public static function userLog ($data) {
        (Auth::user()) ? $userId = Auth::user()->id : $userId = null;

        if(is_array($data)) {
            LogItController::getInstance()->userLog("[USER] Array Dump ",$userId);
            LogItController::getInstance()->dumpUserArrayToLog($data, $userId);
        } else {
            LogItController::getInstance()->userLog($data,$userId);
        }
    }

    /**
     * @param $data
     * The utilLog() is mainly used for CLI process scripts
     */
    public static function utilLog ($data) {
        if(is_array($data)) {
            LogItController::getInstance()->utilLog("[UTIL] Array Dump");
            LogItController::getInstance()->dumpUtilArrayToLog($data);
        } else {
            LogItController::getInstance()->utilLog($data);
        }
    }
}
