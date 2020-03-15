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
        $team = Team::where('user_id', $user_id)->first();

        $result = [
            'result' => [
                'event_id' => $team->event->id ?? 'nul',
                'name' => $team->event->name,
                'start' => $team->event->start
            ]


        ];
        return response($result);
    }
}
