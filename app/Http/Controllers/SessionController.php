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

    public function index(){
        $session = Session::all();
        return response($session);
    }
    //
}
