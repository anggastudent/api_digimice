<?php

namespace App\Http\Controllers;
use App\Event;
use App\Team;
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
        $array = [];
       
        foreach ($team as $value) {
            $array[] = [
                'id' => $value->event->id,
                'name' => $value->event->name,
                'start' => $value->event->start,
                'end' => $value->event->end
            ];
        }
        
        
        return response()->json($array);
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
            'event_ticket_price' => $event_ticket_price
        ];

        Event::create($data);

        return "Berhasil ditambahkan";

    }
}
