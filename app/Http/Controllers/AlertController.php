<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alert;

class AlertController extends Controller
{
    public function addAlert($title, $message, $status=0, $severity=0, $send_email=0){
        $data['title'] = $title;
        $data['message'] = $message;
        $data['status'] = $status;
        $data['severity'] = $severity;
        $data['send_email'] = $send_email;

        Alert::create($data);
    }
}
