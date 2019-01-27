<?php

namespace App\Http\Controllers;

use App\PsnGames;
use Illuminate\Http\Request;
use Gate;
use App\Role;
use App\Game;


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

    private function gameSync () {
        $gameList = Game::where('psn_id', '=', null)
            ->where('release_date', '<', date("Y-m-d", strtotime("+ 2 months")))
            ->orderBy('release_date', 'DESC')
            ->take(100)
            ->get();

        // Only allow access to
        if(Gate::allows('god-mode')) {
            return view('super-admin.game-sync', compact('gameList'));
        }
        return redirect('/access-denied');
    }

    public function gameGetSync (Request $data) {

        $game = substr($data['game'],0,5);
        $games = PsnGames::where('name', 'like', $game.'%')
            ->orderBy('release_date', 'DESC')
            ->take(50)
            ->get();

        // Only allow access to
        if(Gate::allows('god-mode')) {
            return $games;
        }
        return redirect('/access-denied');
    }
}
