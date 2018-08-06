<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only allows Guests (non-logged in users) to Load the
        // Registration page, They need to logout first to see it
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'display_name'  => 'required|string|max:50',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:7|confirmed',
            'code'          => 'required|in:xlr8'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'display_name'  => $data['display_name'],
            'email'         => $data['email'],
            'password'      => bcrypt($data['password']),
            'uniqid'         => uniqid(),
        ]);

        $user->roles()->attach(1);

        Mail::to($data['email'])->send(new WelcomeMail($user));
        
        return $user;
    }

    public function showRegistrationForm()
    {
        $roles = Role::orderBy('name')->pluck('name', 'id');
        return view('auth.register', compact('roles'));
    }
}
