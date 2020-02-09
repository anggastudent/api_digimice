<?php

namespace App\Http\Controllers;
use App\User;

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
}
