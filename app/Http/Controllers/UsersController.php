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
    public function index($id){
        $user = User::where('id',$id)->first();

        $array [] = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'avatar' => $user->avatar
        ];
        return response($array);

    }

    public function addPanitia(Request $request){

        $email = $request->input('email');
        $event_id = $request->input('event_id');
        $name_team = $request->input('name_team');

        $user = User::where('email', $email)->first();
        

        if($user){

            $team = Team::where('user_id',$user->id)->where('event_id', $event_id)->first();
            if($user && $team){
                return "email sudah terdaftar";
                
            }else{
                $data = [
                    'user_id' => $user->id,
                    'event_id' => $event_id,
                    'team_role' => "eo",
                    'name_team' => $name_team
                ];

                Team::create($data);
                return "berhasil";
            }
            

        }else{
            return "email belum terdaftar";
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
            'regencies_id' => $regencies_id,
            'avatar' => "upload/images/blank.jpg"
        ];

        if($user = User::where('email',$email)->first()){
            return "Email sudah terdaftar";
        }else{

            $user = User::create($data);

            $data2 = [
                'user_id' => $user->id,
                'event_id' => $event_id
            ];

            Pemateri::create($data2);

            return "Berhasil ditambahkan";
        }

    }

    public function provinsi(){
        $provinsi = Provinsi::all();
        $array = [];
        foreach ($provinsi as $value) {
            $array [] = [
                'id' => $value->id,
                'name' => $value->name,
                'kabupaten' => $value->kabupaten
            ];
        }
        return response($array);
    }

    public function edit($id){
        $user = User::findOrFail($id);
        
        $array = [
            $user
        ];

        return response($array);
    }

    public function update(Request $request, $id){
        
        $user = User::findOrFail($id);
        
        $name = $request->input('name');
        $avatar = $request->input('avatar');
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');

        if(trim($avatar) == ''){

        }else{

            $target_dir = "upload/images";
        
            if(!file_exists($target_dir)){

                mkdir($target_dir, 0777, true);
            }
            if (!$user->avatar=="upload/images/blank.jpg") {
                unlink($user->avatar);
            }
            
            
            
            $file = $target_dir."/image".time().".jpeg";
            $ifp = fopen($file, "wb"); 

            $data2 = explode(',', $avatar);

            fwrite($ifp, base64_decode($data2[0])); 
            fclose($ifp); 

            $data = [

                'name' => $name,
                'avatar' => $file
                                    
            ];

            $user->update($data);

            return "berhasil";

            
        }

        if(trim($old_password) == '' && trim($new_password) == ''){

            $old_password = $request->except('old_password');
            $new_password = $request->except('new_password');

        }else{

            if(Hash::check($old_password, $user->password_hash)){

                $password = Hash::make($new_password);

                $data = [

                    'name' => $name,
                    'password_hash' => $password
                                        
                ];

                $user->update($data);

                return "berhasil";

            }else{

                return "Password Lama Tidak Cocok";
            }
        }

        $data = [

            'name' => $name
                         
        ];

        $user->update($data);
        return "berhasil";

    }

    public function gabungPemateri(Request $request){

        $user_id = $request->input('user_id');
        $event_id = $request->input('event_id');

        if($pemateri = Pemateri::where('user_id',$user_id)->where('event_id',$event_id)->first()){
            return "Pemateri sudah tergabung";
        }else{
            $data2 = [
                'user_id' => $user_id,
                'event_id' => $event_id
            ];

            Pemateri::create($data2);

            return "Pemateri berhasil bergabung";
        }

        

    }
}
