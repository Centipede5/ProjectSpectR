<?php

namespace App\Http\Controllers;
use App\Http\Controllers\UserProfileController;
use App\PsnGames;
use Illuminate\Http\Request;
use Gate;
use App\Role;
use App\Game;
use App\User;
use DB;

class SuperAdminController extends Controller
{
    public function index () {
        // I'm just redirecting the traffic until I have a landing page established
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

    public function manageRoles () {
        $roles = Role::all();
        // Only allow access to
        if(Gate::allows('god-mode')) {
            return view('super-admin.manageRoles', compact('roles'));
        }
        return redirect('/access-denied');
    }

    public function manageUsers () {
        $users = User::orderBy('created_at', 'desc')
            ->take(100)
            ->get();
        // Only allow access to
        if(Gate::allows('god-mode')) {
            return view('super-admin.manageUsers', compact('users'));
        }
        return redirect('/access-denied');
    }

    public function updateGamesTable () {
        $games = Game::orderBy('created_at', 'desc')
            ->take(100)
            ->get();
        // Only allow access to
        if(Gate::allows('god-mode')) {
            return view('super-admin.updateGamesTable', compact('games'));
        }
        return redirect('/access-denied');
    }

    public function updateRoles (Request $data)
    {

        $roles = Role::all();

        foreach ($roles as $role){
            $permissions = [];
            $upPr = $role['slug'] . "-update-profile";
            $coPo = $role['slug'] . "-comment-on-post";
            $crPo = $role['slug'] . "-create-post";
            $upPo = $role['slug'] . "-update-post";
            $puPo = $role['slug'] . "-publish-post";
            $poUn = $role['slug'] . "-post-unlimited";
            $siMo = $role['slug'] . "-site-moderator";
            $siAd = $role['slug'] . "-site-admin";

            $permissions['update-profile'] = (isset($data[$upPr])) ? true : false;
            $permissions['comment-on-post'] = (isset($data[$coPo])) ? true : false;
            $permissions['create-post'] = (isset($data[$crPo])) ? true : false;
            $permissions['update-post'] = (isset($data[$upPo])) ? true : false;
            $permissions['publish-post'] = (isset($data[$puPo])) ? true : false;
            $permissions['post-unlimited'] = (isset($data[$poUn])) ? true : false;
            $permissions['site-moderator'] = (isset($data[$siMo])) ? true : false;
            $permissions['site-admin'] = (isset($data[$siAd])) ? true : false;
            $permissions['god-mode'] = ($role['slug']=="super") ? true : false;

            Role::where('slug', $role['slug'])
                ->update(['permissions' => json_encode($permissions)]);
        }

        $roles = Role::all();
        // Only allow access to
        if(Gate::allows('god-mode')) {
            return view('super-admin.manageRoles', compact('roles'));
        }
        return redirect('/access-denied');
    }


    public function searchUser (Request $data)
    {
        if(Gate::allows('god-mode')) {
            if ($data['searchBy'] == "searchByEmail") {
                $gameList = User::where('email', '=', $data['searchData'])->take(10)->get();

            } else if ($data['searchBy'] == "searchByDisplayName") {
                $gameList = User::where('display_name', '=', $data['searchData'])->take(10)->get();
            } else {
                echo "Not Found";
            }
            echo $gameList;
        } else {
            echo "ERROR";
        }
    }

    public function updateUser (Request $data)
    {
        $updatefield = explode("-",$data['updateField']);
        $destinationFile = database_path('mods/update-users.json');
        $jsonSaveInfo = '{"'.$data['updateUserId'].'": {"'.$updatefield[0].'": "'.$data['updateData'].'"}}';

        echo $data['updateUserId'] . " : " . $data['updateData'];

        // Decode the contents of the current JSON file
        $jsonComplete       = json_decode(file_get_contents($destinationFile),true);
        // Decode the JSON to be saved to determine where it goes
        $jsonSaveInfo       = json_decode($jsonSaveInfo,true);   // example message: {"1031": {"test_id": "234525"}}

        // For Each Record to Update
        foreach($jsonSaveInfo as $topKey => $fullVal){
            foreach($fullVal as $item => $val){
                $jsonComplete[$topKey][$item] = $val;
            }
        }

        // Sort the JSON in ascending order
        ksort($jsonComplete);
        // Update the file with the new information
        file_put_contents($destinationFile, json_encode($jsonComplete));

        UserProfileController::adminModifyUser($data['updateUserId'],$updatefield[0],$data['updateData']);
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
            return view('super-admin.gameSync', compact('gameList'));
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
