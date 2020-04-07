<?php

namespace App\Http\Controllers;
use App\Session;
class SessionController extends Controller
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

    public function index($id){
        $session = Session::where('event_id',$id)->get();

        foreach ($session as $value) {
            $array[] = [
                'id' => $value->id,
                'name' => $value->name,
                'agenda' => $value->agenda
            ];
        }
        
        return response($array);
    }
    //
}
