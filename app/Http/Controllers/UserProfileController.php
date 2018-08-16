<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    private $img_sm  = "-90x90";
    private $img_md  = "-126x126";
    private $img_lg  = "-400x400";

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

        $user->profile_image_full = $user->profile_image;
        $imageName = substr($user->profile_image,0,-4);
        $imageExt = substr($user->profile_image,-4);

        $user->profile_image_small = $imageName . $this->img_sm . $imageExt;
        $user->profile_image_medium = $imageName . $this->img_md . $imageExt;
        $user->profile_image_large = $imageName . $this->img_lg . $imageExt;

        return view('user.profile' , compact('user','user_info'));
    }

    public function getUser ($user, $searchWith) {
        $user = User::where($searchWith, $user)->first();

        return $user;
    }

    private function getUserInfo ($userid) {
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

    /**
     * When a user has been marked for termination, their profile and all posts will be deleted.
     * Given the severity, it's possible that the users contributions may remain under a new alias,
     * but if they are a SPAM user, they will be completely erased.
     */
    public function terminateUser(){
        // 1) Remove User Records from all tables
        //   - users,user_infos,user_meta,subscribe_to_user,subscribe_to_game,
        //     role_users, posts,post_likes,post_comments, password_resets
    }
}
