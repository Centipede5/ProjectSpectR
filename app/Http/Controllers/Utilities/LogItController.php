<?php

namespace App\Http\Controllers;

// The following Log paths can be set to Absolute Paths so you can set the path outside of the Site for security
define("LOG_PATH",          config('app.log_dir'));        // General Log directory
define("LOG_LEVEL",         config('app.log_level'));
define("USER_LOG_PATH",     LOG_PATH ."/users");	            // Usertrack_Log() creates a daily log for each user
define("Util_Log_Path",     LOG_PATH);					        // utilLog() gives the logging ability for Commandline Utility Scripts/Programs; Not meant to be used from the Browser
define("Sql_Log_Path",      LOG_PATH);					        // This is just for the separate log file for SQL transactions. Normally this is for INSERTS and UPDATES

// TODO: I need to decide what to do with this client side logging. I may just stick with the mrplentl/form-logger-plus feature
define("JS_DIR_Path",       __DIR__ . "/../../../public/js");  // Path to the webserver javascript folder

// User tracks are for logging specific users. When set to TRUE, users will have their own log file along with the info log.
define("USER_LOG",   FALSE);	          //FALSE: Usertrack log deactivated; TRUE: Usertrack log activated

class LogItController extends Controller
{
    // Hold the class instance
    private static $instance = null;

    function __construct() {
        // Make Log Directory
        if (file_exists(LOG_PATH) == FALSE) {
            mkdir(LOG_PATH, 0700, TRUE);   // LOG_PATH defined above from within config/app.php
        }

        // Make Util Log Directory
        if (file_exists(Util_Log_Path) == FALSE) {
            mkdir(Util_Log_Path, 0700, TRUE);
        }

        // Make User Log Directory
        if (file_exists(USER_LOG_PATH) == FALSE) {
            mkdir(USER_LOG_PATH, 0700, TRUE);
        }

        // Make SQL Log Directory
        if (file_exists(Sql_Log_Path) == FALSE) {
            mkdir(Sql_Log_Path, 0700, TRUE);
        }
    }

    public static function getInstance() {
        if (self::$instance == null){
            self::$instance = new LogItController();
        }
        return self::$instance;
    }

    ### info() is the actual call to write to the daily log
    ###           Use this for High Level tracking
    public function info( $item ) {
            // General Log
            // The Collect All info log. Every log call will be written to this file
            $filePathGen  = sprintf("%s/DailyLog_%s.txt", LOG_PATH, date("ymd") );   // LOG_PATH defined in log2file_config.php
            $file_res = fopen($filePathGen, "a");

        // In the case that you might be running localhost, REMOTE_ADDR returns ::1 and causes issues
        $ip_address = (!isset($_SERVER['REMOTE_ADDR']) || $_SERVER['REMOTE_ADDR'] == '::1') ? "127.0.0.1" : $_SERVER['REMOTE_ADDR'];

        fwrite($file_res, sprintf("%s [%s] %s\r\n", date("H:i:s"), $ip_address, $item));
        fclose($file_res);

        // If available, add the info note item to the UserLog as well
        if(USER_LOG===TRUE) {
            $this->userLog( $item, $userId=null );
        }
    }

    ### error() writes to a separate log file labeled error; All errors also write to the main info Log
    public function error( $item ){

        $filePathGen  = sprintf("%s/ErrorLog_%s.txt", LOG_PATH, date("Y") . "-" . date("W"));   // This is currently a WEEKLY Log file
        $file_res = fopen($filePathGen, "a");

        // In the case that you might be running localhost, REMOTE_ADDR returns ::1 and causes issues
        $ip_address = (!isset($_SERVER['REMOTE_ADDR']) || $_SERVER['REMOTE_ADDR'] == '::1') ? "127.0.0.1" : $_SERVER['REMOTE_ADDR'];

        fwrite($file_res, sprintf("%s [%s] %s\r\n", date("D d H:i:s"), $ip_address, $item));
        fclose($file_res);
    }

    ### utilLog() gives the logging ability for Commandline Utility Scripts/Programs; Not meant to be used from the Browser
    public function utilLog( $item ) {
        // $altUser is used when using the console; This DOES NOT work from a browser. This only works from the system console
        //$altUser = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] :  $_SERVER['USERNAME'] . "_on_" . $_SERVER['COMPUTERNAME'];   //$_SERVER['USERNAME'] and $_SERVER['COMPUTERNAME'] only work from the system console
        //$Username = isset($_SESSION['Username']) && strlen($_SESSION['Username']) > 0 ?  $_SESSION['Username'] : $altUser;
        $Username = "APP";

        // The Collect All Utility log. Every Utility log call will be written to this file
        $filePathGen  = sprintf("%s/UtilityLog_%s.txt", Util_Log_Path, date("ymd") );
        $file_res = fopen($filePathGen, "a");
        $ID = strlen($Username) > 0 ? $Username : "_Unknown";
        fwrite($file_res, sprintf("%s [%s] %s\r\n", date("H:i:s"), $ID, $item));
        fclose($file_res);
    }

    ### userLog() creates a daily log for each user
    public function userLog( $item, $user ) {
        if($user != null){
            $userLogDir = USER_LOG_PATH."/".$user;
        } else {
            $userLogDir = USER_LOG_PATH;
        }

        // Make Log Directory
        if ($user != null && file_exists(USER_LOG_PATH."/".$user) == FALSE) {
            mkdir(USER_LOG_PATH."/".$user, 0700, TRUE);
        }

        // In the case that you might be running localhost, REMOTE_ADDR returns ::1 and causes issues
        $ip_address = (!isset($_SERVER['REMOTE_ADDR']) || $_SERVER['REMOTE_ADDR'] == '::1') ? "127.0.0.1" : $_SERVER['REMOTE_ADDR'];

        // The Collect All history log. Every log call will be written to this file
        $filePathGen  = sprintf("%s/%s_%s.txt", $userLogDir, date("ymd"), $ip_address );   // File Name Example: 127.0.0.1_140919.txt

        $file_res = fopen($filePathGen, "a");
        fwrite($file_res, sprintf("%s %s\r\n", date("H:i:s"), $item));   // 11:42:34 This is an item to log
        fclose($file_res);
    }

    ### dumpArrayToLog() will do just as it says. It will print out the array keys and values to a log. Just call the method with the array submitted
    public function dumpArrayToLog( $dump_array ) {
        foreach ( $dump_array as $key => $value ) {
            $this->info( "   " . $key . " " . "=" . " " . $value );
        }
    }

    ### dumpArrayToLog() will do just as it says. It will print out the array keys and values to a log. Just call the method with the array submitted
    public function dumpErrorArrayToLog( $dump_array ) {
        foreach ( $dump_array as $key => $value ) {
            $this->error( "   " . $key . " " . "=" . " " . $value );
        }
    }

    ### dumpArrayToLog() will do just as it says. It will print out the array keys and values to a log. Just call the method with the array submitted
    public function dumpUserArrayToLog( $dump_array, $user ) {
        foreach ( $dump_array as $key => $value ) {
            $this->userLog( "   " . $key . " " . "=" . " " . $value, $user );
        }
    }

    ### dumpArrayToLog() will do just as it says. It will print out the array keys and values to a log. Just call the method with the array submitted
    public function dumpUtilArrayToLog( $dump_array ) {
        foreach ( $dump_array as $key => $value ) {
            $this->utilLog( "   " . $key . " " . "=" . " " . $value );
        }
    }

    ### LogInput() will dump any and all $_POST and/or $_GET values; there are a few custom checks in here, for instance, fields with CCnum will expert a credit card number and only print the last 4 digits
    public function LogInput() {
        // This will log all of the POST and GET values out to a file
        // Takes the App Name and adds it to the Log File
        /* Example Output:
        14:31:14 [_brandon] [Sysmon] -------- hardware.php --------------
        14:31:14 [_brandon] POST Values:
        14:31:14 [_brandon]    SupportLevel = Not Installed
        14:31:14 [_brandon]    level =
        14:31:14 [_brandon]    StartDate = 2006-09-05
        14:31:14 [_brandon] GET Values:
        14:31:14 [_brandon]    customerAbbr = IFP
        */

        if ( !$_POST && !$_GET ){
            $this->info("No input submitted");
        }

        if ( $_POST ) {
            $this->info("POST Values:");
            foreach ($_POST as $key => $value) {
                //  Fields that have the name 'CCnum' or AcctN will only print the last 4 characters and prepend 4 stars to its value; Meant for credit card numbers
                if (substr($key, 0, 5) == "CCnum" || substr($key, 0, 5) == "AcctN") {
                    $this->info("   " . $key . " " . "=" . " " . "****" . substr($value, -4, 4));
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            $this->info("       " . $k . " " . "=" . " " . $v);
                        }
                    }
                } //  Fields that have a name that starts with 'X_' will not print any of their value to the log; instead each character will be replaced with '*'
                else if (substr($key, 0, 2) == "X_") {
                    $temp = "";
                    if (strlen($value) > 10) {
                        for ($i = 0; $i < (strlen($value) - 4); $i++) {
                            $temp .= "*";
                        }
                        $temp .= substr($value, strlen($value) - 4, 4);
                        $this->info("   " . $key . " " . "=" . " " . $temp);
                    } else {
                        for ($i = 0; $i < strlen($value); $i++) {
                            $temp .= "*";
                        }
                        $this->info("   " . $key . " " . "=" . " " . $temp);
                    }
                } // The default print to info log entry
                else {
                    $this->info("   " . $key . " " . "=" . " " . $value);
                    if (is_array($value)) {
                        foreach ($value as $k => $v) {
                            $this->info("       " . $k . " " . "=" . " " . $v);
                        }
                    }
                }
            }
        }

        if ( $_GET ) {
            // If it's in the URL when the page submits, it will be in the log... no exceptions
            $this->info("GET Values:");
            foreach ($_GET as $key => $value) {
                $this->info("   " . $key . " " . "=" . " " . $value);
            }
        }
    }

    ### LogSession() - You generally don't want to print out SESSION information, so this should only be used for testing and debugging. This is pretty identical to the LogInput() $_POST section.
    public function LogSession() {
        $this->info("###############  WARNING: THIS SHOULD BE USED FOR TESTING ONLY  ########################");
        $this->info( "SESSION Values:" );
        foreach ( $_SESSION as $key => $value ){
            if( substr($key,0,5) == "CCnum" || substr($key,0,5) == "AcctN" ) {
                $this->info( "   " . $key . " " . "=" . " " . "****" . substr($value,-4,4) );
                if( is_array( $value )){
                    foreach( $value as $k => $v ){
                        $this->info( "       " . $k . " " . "=" . " " . $v );
                    }
                }
            } else if( substr($key,0,2) != "X_" ) {
                $temp = "";
                if( strlen( $value ) > 10 ){
                    for( $i=0; $i<(strlen($value)-4);$i++ ){
                        $temp .= "*";
                    }
                    $temp .= substr($value,strlen($value)-4,4);
                    $this->info( "   " . $key . " " . "=" . " " . $temp );
                } else {
                    for( $i=0; $i<strlen($value);$i++ ){
                        $temp .= "*";
                    }
                    $this->info( "   " . $key . " " . "=" . " " . $temp );
                }
            } else {
                $this->info( "   " . $key . " " . "=" . " " . $value );
                if( is_array( $value )){
                    foreach( $value as $k => $v ){
                        $this->info( "       " . $k . " " . "=" . " " . $v );
                    }
                }
            }
        }
    }

    ## This is just a separate log file for SQL transactions. Normally this is for INSERTS and UPDATES
    public function SQLHistoryLog( $SqlScript ) {
        $filePathGen   = sprintf("%s/SQLLog_%s.txt", Sql_Log_Path, date("ymd") );
        $file_res = fopen($filePathGen, "a");
        fwrite($file_res, sprintf("%s\r\n", $SqlScript ) );
        fclose($file_res);

        $this->info("[SQL Action] Check SQL Logs");
    }

    ### errorSessionLog() is pretty much identical to the LogInput() method except it dumps to the Error log instead. Meant for when errors occur.
    public function errorSessionLog() {
        $this->error( "SESSION Values:" );
        foreach ( $_SESSION as $key => $value ){
            if( substr($key,0,5) == "CCnum" || substr($key,0,5) == "AcctN" ){
                $this->error( "   " . $key . " " . "=" . " " . "****" . substr($value,-4,4) );
                if( is_array( $value )){
                    foreach( $value as $k => $v ){
                        $this->error( "       " . $k . " " . "=" . " " . $v, 1 );
                    }
                }
            }else if( substr($key,0,2) != "X_" ){
                $this->error( "   " . $key . " " . "=" . " " . $value );
                if( is_array( $value )){
                    foreach( $value as $k => $v ){
                        $this->error( "       " . $k . " " . "=" . " " . $v, 1 );
                    }
                }
            }else{
                $temp = "";
                if( strlen( $value ) > 10 ){
                    for( $i=0; $i<(strlen($value)-4);$i++ ){
                        $temp .= "*";
                    }
                    $temp .= substr($value,strlen($value)-4,4);
                    $this->error( "   " . $key . " " . "=" . " " . $temp );
                } else {
                    for( $i=0; $i<strlen($value);$i++ ){
                        $temp .= "*";
                    }
                    $this->error( "   " . $key . " " . "=" . " " . $temp );
                }
            }
        }
    }

    ### LogUserAgent() uses a third party to detect information about the user from the the User Agent string
    public function LogUserAgent() {
        $UserAgentURL = "useragentstring.com";   // This is the URL to the free service at useragentstring.com that reads in the User Agent Sting and parses the information; I currently only request the following: agent_name-agent_version-os_type-os_name
        // Check Connection, but move on after 2 seconds
        if( !fsockopen( $UserAgentURL, 80,$error_num,$error_str,2 ) ) {
            $this->error("User Agent Values:  Unable to Log User Agent Information due to a connection error with " . $UserAgentURL . ". Error while executing: " . __METHOD__ ."() " . $error_num . " - " . $error_str, "[ERROR]");
        } else {
            $url = "http://" . $UserAgentURL . "/?uas=" . $_SERVER['HTTP_USER_AGENT'] . "&getJSON=agent_name-agent_version-os_type-os_name";
            $url = str_replace(" ", "%20", $url);   // Example: http://useragentstring.com/?uas=Mozilla/5.0%20(Windows%20NT%206.1;%20WOW64)%20AppleWebKit/537.36%20(KHTML,%20like%20Gecko)%20Chrome/37.0.2062.120%20Safari/537.36&getJSON=agent_name-agent_version-os_type-os_name

            $contents = file_get_contents($url);
            $contents = utf8_encode($contents);
            $results = json_decode($contents, true);

            // EXAMPLE RETURN
            //      {
            //         "agent_name": "Chrome",
            //         "agent_version": "37.0.2062.120",
            //         "os_type": "Windows",
            //         "os_name": "Windows 7"
            //      }

            // Loop through and print out info
            $this->info("User Agent Values:");
            foreach ( $results as $key => $value ) {
                $this->info("   " . $key . " " . "=" . " " . $value);
            }
        }
    }
}
