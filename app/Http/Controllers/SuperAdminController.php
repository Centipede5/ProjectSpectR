<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\Role;


class SuperAdminController extends Controller
{
    public function index () {
        $roles = Role::all();
        // Only allow access to
        if(Gate::allows('god-mode')) {
            return view('super-admin.manage-roles', compact('roles'));
        }
        return redirect('/access-denied');
    }
}
