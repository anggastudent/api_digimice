<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Materi;
use App\EventAgenda;

class MateriController extends Controller
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
        $materi = Materi::where('event_agenda_id', $id)->get();
        return $materi;
    }

    public function upload(Request $request, $id){

        $agenda = EventAgenda::findOrFail($id);
        
        $path = "upload/pdf";

        $file = $request->file('name');
        $name = time() . $file->getClientOriginalName();
        $file->move($path, $name);

        $data = [
            'name' => $name,
            'event_id' => $agenda->event_session_event_id
            
        ];

        $materi = Materi::create($data);
        
        $edit = [
            'event_material_id' => $materi->id
        ];

        $agenda->update($edit);

        return "berhasil";
    }

    //
}
