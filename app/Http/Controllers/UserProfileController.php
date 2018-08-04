<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserProfileController extends Controller
{
    //
    public function index ($uniqid) {
        $user = $this->getUserByUniqid($uniqid);
        return view('user.profile' , compact('user'));
    }

    public function getUserByUniqid ($uniqid) {
        return User::where('uniqid', $uniqid)->first();
    }
}
