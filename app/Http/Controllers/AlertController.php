<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alert;

class AlertController extends Controller
{
    public function addAlert($status=9,$severity=0, $send_email=0){
        $title = "Test Alert 3";
        $message = "This is a test message!";
        $data['status']=$status;
        $data['severity']=$severity;
        $data['title']=$title;
        $data['message']=$message;
        $data['send_email']=$send_email;
        Alert::create($data);
    }
}
