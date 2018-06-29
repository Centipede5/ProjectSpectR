<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;

class SuperAdminController extends Controller
{
    public function index () {
        // Only allow access to
        if(Gate::allows('god-mode')) {
            return view('super-admin.manage-roles');
        }
        return redirect('/access-denied');
    }
}
