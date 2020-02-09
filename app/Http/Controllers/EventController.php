<?php

namespace App\Http\Controllers;
use App\Event;

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

    public function index(){
        $event = Event::all();
        return response($event);
    }
}
