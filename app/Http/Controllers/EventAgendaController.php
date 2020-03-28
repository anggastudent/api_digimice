<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\EventAgenda;
use App\EventSession;
class EventAgendaController extends Controller
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

    public function index(Request $request){
        $event_id = $request->input('event_id');
        $session = EventAgenda::where('event_session_event_id', $event_id)->get();

        $array = [];
       
        foreach ($session as $value) {
            $array[] = [
                'id' => $value->id,
                'name' => $value->name,
                'start' => $value->start,
                'end' => $value->end,
                'description' => $value->description,
                'session' => $value->session->name
                
            ];
        }
        return response()->json($array);
    }

    public function agenda(Request $request){
        $id_session = $request->input('id_event_session');
        $id_event = $request->input('id_event');
        $agenda = EventAgenda::where('event_session_id',$id_session)->where('event_session_event_id',$id_event)->get();

        return response()->json($agenda);
    }

    //
}
