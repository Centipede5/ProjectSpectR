<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    public function index ($user) {
        if (substr($user,0,2)=="..") {
            $searchWith = "uniqid";
        } else {
            $searchWith = "display_name";
        }

        $user = $this->getUser($user, $searchWith);

        if(!is_object($user)){
            return view('errors.404');
        }

        $user_info = $this->getUserInfo($user->id);
        $user->created_date = date("M Y", mktime($user->created_date));

        return view('user.profile' , compact('user','user_info'));
    }

    public function getUser ($user, $searchWith) {
        $user = User::where($searchWith, $user)->first();

        return $user;
    }

    public function getUserInfo ($userid) {
        $user_info = DB::table('user_infos')->where('id',$userid)->first();
        // If the query returns a record, run JSON decode on the social meta
        if ($user_info != null){
            $user_info->social_meta = json_decode($user_info->social_meta);

            // When a website is larger than 34 characters, it wraps.
            // I am going to just display the domain name in those cases.
            if (isset($user_info->social_meta->website) && strlen($user_info->social_meta->website) > 34){
                $user_info->social_meta->website_display = parse_url($user_info->social_meta->website, PHP_URL_HOST) . "/...";
            } else {
                $user_info->social_meta->website_display = $user_info->social_meta->website;
            }
        }
        return $user_info;
    }

    /**
     * When using Route model binding, the variable name must match the DB field name.
     * I have to reset the variable name to match what the view expects
     * @param User $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit (User $id) {
        $user = $id;
        $user_info = $this->getUserInfo($user->id);
        return view('user.profile-edit' , compact('user','user_info'));
    }
}
