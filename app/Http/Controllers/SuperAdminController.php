<?php

namespace App\Http\Controllers;

use App\PsnGames;
use Illuminate\Http\Request;
use Gate;
use App\Role;
use App\Game;
use DB;

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

    public function gameSync () {
        $gameList = Game::where('psn_id', '=', null)
            ->where('release_date', '<', date("Y-m-d", strtotime("+ 2 months")))
            ->where('platforms','like','%PS4%')
            ->orderBy('release_date', 'DESC')
            ->take(100)
            ->get();

        // Only allow access to
        if(Gate::allows('god-mode')) {
            return view('super-admin.game-sync', compact('gameList'));
        }
        return redirect('/access-denied');
    }

    public function gameGetSync (Request $data)
    {
        // Only allow access to
        if(Gate::allows('god-mode')) {

            if(isset($data['game'])){
                $game = substr($data['game'],0,5);
                $games = PsnGames::where('name', 'like', $game.'%')
                    ->orderBy('release_date', 'DESC')
                    ->take(50)
                    ->get();

                return $games;
            } else if (isset($data['idgb_id']) && isset($data['psn_id'])){
                DB::table('games')->where('igdb_id', $data['idgb_id'])->update(['psn_id' => $data['psn_id'], 'updated_at' => \Carbon\Carbon::now()]);
                DB::table('psn_games')->where('psn_id', $data['psn_id'])->update(['igdb_id' => $data['idgb_id'], 'updated_at' => \Carbon\Carbon::now()]);
                DB::table('game_id_sync')->insert(['psn_id' => $data['psn_id'], 'igdb_id' => $data['idgb_id'], 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]);
                return "Success!";
            }

            return "ERROR";
        }
        return redirect('/access-denied');
    }
}
