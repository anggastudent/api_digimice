<?php

namespace App\Http\Controllers;
use App\User;
use App\Team;
use App\Provinsi;
use App\Pemateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function addPemateri(Request $request){

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $no_telp = $request->input('no_telp');
        $regencies_id = $request->input('regencies_id');
        $event_id = $request->input('event_id');
        $password_hash = Hash::make($password);

        $data = [
            'name' => $name,
            'email' => $email,
            'password_hash' => $password_hash,
            'phone' => $no_telp,
            'role' => "speaker",
            'regencies_id' => $regencies_id
        ];

        $user = User::create($data);

        $data2 = [
            'user_id' => $user->id,
            'event_id' => $event_id
        ];

        Pemateri::create($data2);

        return "berhasil";

        
    }

    public function provinsi(){
        $provinsi = Provinsi::all();

        foreach ($provinsi as $value) {
            $array [] = [
                'id' => $value->id,
                'name' => $value->name,
                'kabupaten' => $value->kabupaten
            ];
        }
        return response($array);
    }
}
