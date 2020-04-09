<?php

namespace App\Http\Controllers;
use App\Session;
use Illuminate\Http\Request;
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

    public function create(Request $request){

        $input = $request->all();

        Session::create($input);

        return "berhasil";
    }

    public function edit(Request $request, $id){
        $session = Session::findOrFail($id);
        $input = $request->all();
        $session->update($input);

        return "berhasil";
    }

    public function show($id){

        $session = Session::findOrFail($id);
        $array = [
            $session
        ];
        return $array;
    }
    //
}
