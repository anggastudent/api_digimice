<?php

namespace App\Http\Controllers;
use App\Event;
use App\Team;
use App\Session;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    //

    public function index(Request $request){
        $user_id = $request->input('user_id');
        $team = Team::where('user_id', $user_id)->get();
       
        foreach ($team as $value) {
            $array[] = [
                'id' => $value->event->id,
                'name' => $value->event->name,
                'start' => $value->event->start,
                'end' => $value->event->end,
                'place' => $value->event->place,
                'address' => $value->event->address,
                'banner' => $value->event->banner,
                'presence_type' => $value->event->presence_type
                
            ];
        }
        
        
        return  response()->json($array);
    }

    public function create(Request $request){

        $name = $request->input('name');
        $start = $request->input('start');
        $end = $request->input('end');
        $event_type_id = $request->input('event_type_id');
        $banner = $request->input('banner');
        $description = $request->input('description');
        $place = $request->input('place');
        $address = $request->input('address');
        $event_status = $request->input('event_status');
        $event_paket_id = $request->input('event_paket_id');
        $presence_type = $request->input('presence_type');
        $event_ticket_price = $request->input('event_ticket_price');
        $name_session = $request->input('name_session');
        
        $user_id = $request->input('user_id');
        $team_role = $request->input('team_role');
        $name_team = $request->input('name_team');

        $target_dir = "upload/images";
        if(!file_exists($target_dir)){
            mkdir($target_dir, 0777, true);
        }
        
        $file = $target_dir."/image".time().".jpeg";
        $ifp = fopen($file, "wb"); 

        $data2 = explode(',', $banner);

        fwrite($ifp, base64_decode($data2[0])); 
        fclose($ifp); 

        $data = [

            'name' => $name,
            'start' => $start,
            'end' => $end,
            'event_type_id' => $event_type_id,
            'banner' => $file,
            'description' => $description,
            'place' => $place,
            'address' => $address,
            'event_status' => $event_status,
            'event_paket_id' => $event_paket_id,
            'presence_type' => $presence_type,
            'event_ticket_price' => $event_ticket_price,

        ];

        $event = Event::create($data);

        $team = Team::where('event_id',$event->id)->first();

        $edit = [
            'user_id' => $user_id,
            'team_role' => $team_role,
            'name_team' => $name_team
        ];

        $team->update($edit);
        
        Session::create([
            'name' => $name_session,
            'event_event_type_id' => $event_type_id,
            'event_id' => $event->id
        ]);
        return "Berhasil ditambahkan";

    }

    public function edit($id){
        $event = Event::findOrFail($id);
        

       
        $array[] = [
            'name' => $event->name,
            'description' => $event->description,
            'place' => $event->place,
            'address' => $event->address,
            'start' => $event->start,
            'banner' => $event->banner,
            'end' => $event->end,
            'price' => $event->paket->price
            
        ];
        
        
        return response()->json($array);
    }

    public function update(Request $request, $id){

        $event = Event::findOrFail($id);

        $name = $request->input('name');
        $description = $request->input('description');
        $place = $request->input('place');
        $address = $request->input('address');
        $start = $request->input('start');
        $end = $request->input('end');
        $banner = $request->input('banner');
        $event_ticket_price = $request->input('event_ticket_price');

        
        if(trim($banner == '')){
            $banner = $request->except('banner');
        }else{
            $target_dir = "upload/images";
        
            if(!file_exists($target_dir)){
                mkdir($target_dir, 0777, true);
            }
            
            unlink($event->banner);
            
            $file = $target_dir."/image".time().".jpeg";
            $ifp = fopen($file, "wb"); 

            $data2 = explode(',', $banner);

            fwrite($ifp, base64_decode($data2[0])); 
            fclose($ifp); 

            $data = [
                'name' => $name,
                'description' => $description,
                'place' => $place,
                'address' => $address,
                'start' => $start,
                'end' => $end,
                'banner' => $file,
                'event_ticket_price' => $event_ticket_price

            ];

            $event->update($data);
        }
        



        return "sukses";
    }
}
