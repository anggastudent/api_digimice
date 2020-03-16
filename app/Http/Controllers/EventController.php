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
}
