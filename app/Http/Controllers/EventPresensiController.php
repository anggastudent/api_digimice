<?php

namespace App\Http\Controllers;
use App\EventPresensi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class EventPresensiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        // $this->middleware('login');
    }

    //
    public function index(){

    }

    public function addPresensi(Request $request){

        $input = $request->all();
        EventPresensi::create($input);

        return response("berhasil absen");
    }
}
