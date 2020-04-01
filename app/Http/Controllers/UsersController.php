<?php

namespace App\Http\Controllers;
use App\User;
use App\Team;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        // $this->middleware("login");
    }

    //Fungsi Index
    public function index(){
        return User::all();

    }

    public function addPanitia(Request $request){

        $email = $request->input('email');
        $event_id = $request->input('event_id');
        $name_team = $request->input('name_team');

        $user = User::where('email', $email)->first();

        if($user){
            $data = [
                'user_id' => $user->id,
                'event_id' => $event_id,
                'team_role' => "eo",
                'name_team' => $name_team
            ];

            Team::create($data);
            return "berhasil";

        }else{
            return "email tidak tersedia";
        }

        
    }
}
