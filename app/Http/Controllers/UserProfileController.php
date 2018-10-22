<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\User;

use Illuminate\Support\Facades\DB;

class UserProfileController extends Controller
{
    private $img_sm  = "-90x90";
    private $img_md  = "-126x126";
    private $img_lg  = "-400x400";

    public function index ($userName, $editMode=false)
    {
        // If the user string starts with 2 dots, it is th uniqid
        if (substr($userName,0,2)==".." && !$editMode) {
            $searchWith = "uniqid";
        } else if($editMode) {
            $searchWith = "id";
        } else {
            $searchWith = "display_name";
        }

        // Get the user object with either uniqid or display_name
        $user = $this->getUser($userName, $searchWith);

        // If the user is not found, show the 404 page
        if(!is_object($user)){
            return view('errors.404');
        }

        // Get all of the needed user profile information
        $user_info = $this->getUserInfo($user->id);

        $this->getExtendedUserInfo($user);
        // Override the Created date to just month and year
//        $user->created_date = date("M Y", mktime($user->created_date));
//
//        // Main Profile Canopy Image
//        $user->background_image = env('APP_USR_IMG_LOC') . "/" . $user->background_image;
//        // Original uploaded profile image
//        $user->profile_image_full = env('APP_USR_IMG_LOC') . "/" . $user->profile_image;
//
//        $imageName = substr($user->profile_image,0,-4);  // Base Image name
//        $imageExt = substr($user->profile_image,-4);            // Image Extension
//
//        // Available image sizes
//        $user->profile_image_small = env('APP_USR_IMG_LOC') . "/" . $imageName . $this->img_sm . $imageExt;
//        $user->profile_image_medium =  env('APP_USR_IMG_LOC') . "/" . $imageName . $this->img_md . $imageExt;
//        $user->profile_image_large =  env('APP_USR_IMG_LOC') . "/" . $imageName . $this->img_lg . $imageExt;

        return view('user.profile' , compact('user','user_info'));
    }

    private function getExtendedUserInfo ($user)
    {
        // Override the Created date to just month and year
        $user->created_date = date("M Y", mktime($user->created_date));

        // Main Profile Canopy Image
        $user->background_image = env('APP_USR_IMG_LOC') . "/" . $user->background_image;
        // Original uploaded profile image
        $user->profile_image_full = env('APP_USR_IMG_LOC') . "/" . $user->profile_image;

        $imageName = substr($user->profile_image,0,-4);  // Base Image name
        $imageExt  = substr($user->profile_image,-4);            // Image Extension

        // Available image sizes
        $user->profile_image_small  = env('APP_USR_IMG_LOC') . "/" . $imageName . $this->img_sm . $imageExt;
        $user->profile_image_medium = env('APP_USR_IMG_LOC') . "/" . $imageName . $this->img_md . $imageExt;
        $user->profile_image_large  = env('APP_USR_IMG_LOC') . "/" . $imageName . $this->img_lg . $imageExt;
    }

    public function getUser ($user, $searchWith)
    {
        return User::where($searchWith, 'like', '%' . $user . '%')->first();
    }

    private function getUserInfo ($userid)
    {
        $user_info = DB::table('user_infos')->where('id',$userid)->first();
        // If the query returns a record, run JSON decode on the social meta
        if ($user_info != null){
            $user_info->social_meta = json_decode($user_info->social_meta);

            // When a user website is larger than 34 characters, it wraps.
            // I am going to just display the domain name in those cases.
            if (isset($user_info->social_meta->website) && strlen($user_info->social_meta->website) > 34){
                $user_info->social_meta->website_display = parse_url($user_info->social_meta->website, PHP_URL_HOST) . "/...";
            } else if (isset($user_info->social_meta->website)){
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
    public function edit (User $id)
    {
        LogIt::userLog("Editing Profile");
        $user = $id;
        $user_info = $this->getUserInfo($user->id);
        $this->getExtendedUserInfo($user);

        return view('user.profile-edit' , compact('user','user_info'));
    }

    public function update (Request $request,User $id)
    {
        LogIt::userLog("Updating Profile");
        $user = $id;

        /**
         * Verify that the Display Name is not taken if a change is requested
         **/
        if($user->display_name != $request->input('user_info_display_name'))
        {
            // SQL SELECT: Check `users` table for the requested new name.
            $count = User::where('display_name', $request->input('user_info_display_name'))->count();
            if($count==0){
                // If no records are found, the display name can be updated
                LogIt::userLog("Updating Display Name to: " . $request->input('user_info_display_name'));

                // Updating the local scoped value to the new Display Name
                $user->display_name = $request->input('user_info_display_name');

                // SQL UPDATE: Update `users` table with the new display name
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'display_name'  =>  $request->input('user_info_display_name'),
                        'updated_at'    =>  \Carbon\Carbon::now()
                    ]);

            } else {
                //TODO: Display Name Updates should be verified on the form View. If they still made it this far, I need to send the user an error notification
                LogIt::userLog("Display Name [ " . $request->input('user_info_display_name') . " ] already taken");
            }
        }

        /**
         * Verify that the email is not taken if a change is requested
         **/
        if($user->email != $request->input('user_info_email'))
        {
            // SQL SELECT: Check `users` table for the requested email.
            $count = User::where('email', $request->input('user_info_email'))->count();
            if($count==0){
                // If no records are found, the email can be updated
                LogIt::userLog("No Email conflicts. Updating Email to: " . $request->input('user_info_email'));

                // SQL UPDATE: Update `users` table with the new email
                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'email'      => $request->input('user_info_email'),
                        'updated_at' => \Carbon\Carbon::now()
                    ]);
            } else {
                //TODO: Email Updates should be verified on the form View. If they still made it this far, I need to send the user an error notification
                LogIt::userLog("Email [ " . $request->input('user_info_email') . " ] already taken");
            }
        }

        $social_meta = [
            'website'  => $request->input('user_info_website'),
            'youtube'  => $request->input('user_info_youtube'),
            'twitter'  => $request->input('user_info_twitter'),
            'facebook' => $request->input('user_info_facebook')
        ];

        /**
         * Updating the `user_infos` table
         **/
        DB::table('user_infos')
            ->where('id', $user->id)
            ->update([
                'bio'         => $request->input('user_info_bio'),
                'social_meta' => json_encode($social_meta),
                'ip_address'  => $request->ip(),
                'updated_at'  => \Carbon\Carbon::now()
            ]);

        return redirect()->route('user-profile', ['user' => $user->display_name]);
    }

    /**
     * When a user has been marked for termination, their profile and all posts will be deleted.
     * Given the severity, it's possible that the users contributions may remain under a new alias,
     * but if they are a SPAM user, they will be completely erased.
     */
    public function terminateUser()
    {
        // 1) Remove User Records from all tables
        //   - users,user_infos,user_meta,subscribe_to_user,subscribe_to_game,
        //     role_users, posts,post_likes,post_comments, password_resets
    }
}
