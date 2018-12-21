<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\Role;


class SuperAdminController extends Controller
{
    public function index () {
        // I'm just redirecting the traffic untill I have a landing page established
        return redirect('/oniadmin/manageRoles');
    }

    public function pages ($thePage) {
        if(method_exists($this,$thePage)){
            return $this->{$thePage}();
        } else {
            return $this->controllerNotFound($thePage);
        }
    }

    private function controllerNotFound($thePage){
        dd("Error: Method Not Found | " . __CLASS__ . ":" . $thePage . "()");
    }


    private function manageRoles () {
        $roles = Role::all();
        // Only allow access to
        if(Gate::allows('god-mode')) {
            return view('super-admin.manage-roles', compact('roles'));
        }
        return redirect('/access-denied');
    }
}
