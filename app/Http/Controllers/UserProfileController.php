<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    public function index ($uniqid) {
        $user = $this->getUserByUniqid($uniqid);

        if(!is_object($user)){
            return view('errors.404');
        }

        $user_info = $this->getUserInfo($user->id);
        $user->created_date = date("M Y", mktime($user->created_date));

        return view('user.profile' , compact('user','user_info'));
    }

    public function getUserByUniqid ($uniqid) {
        $user = User::where('uniqid', $uniqid)->first();

        return $user;
    }

    public function getUserInfo ($userid) {
        $user_info = DB::table('user_info')->where('id',$userid)->first();
        $user_info->social_meta = json_decode($user_info->social_meta);

        return $user_info;
    }
}
