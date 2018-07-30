<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;

class RegisterEmailController extends Controller
{
        public function validateEmail ($email,$uniqid) {

        // Check the users table for a user record that matches the email and uniqid
        $findUser = User::where('email', $email)->where('uniqid',$uniqid)->count();
        if( $findUser==1 ){
            $user = User::where('email', $email)->where('uniqid',$uniqid)->first();

            if($user->roles[0]->pivot->role_id == 1){
                $user->roles()->detach(1);
                $user->roles()->attach(2);
                $msg = "Your Email has been Verified!";
            } else {
                $msg = "This email has already been verified!";
            }
            //Update User Role to Basic
        } else {
            $findUser = User::where('email', $email)->count();
            if( $findUser==0 ) {
                $msg = "It looks like we can't find an account that matches your email (".$email."). 
                        It's possible that your account was deleted due to your email not being verified within the given time.
                        Please re-register and verify your email again.";
            } else {
                $msg = "Your email was found in the system, but the unique registration key you sent over doesn't match the account.
                        Try clicking the Verify Email button from your email again.
                        If that still doesn't work, try resending the email confirmation link in the dashboard.
                        If you are still having trouble, please reach out to support.";
            }
        }
        return view('notifications.basic', ['msg' => $msg]);
    }
}
