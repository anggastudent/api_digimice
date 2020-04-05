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

    public function upload(Request $request){

        $pdf = $request->input('pdf');       
        $name = $request->input('name');
        $event_id = $request->input('event_id');
        $event_agenda_id = $request->input('event_agenda_id');
        $event_event_type_id = $request->input('event_event_type_id');

        $target_dir = "upload/pdf";
        if(!file_exists($target_dir)){
            mkdir($target_dir, 0777, true);
        }

        $file = $target_dir."/".$name.time().".pdf";

        $fopen = fopen($file, "wb");
        $data_pdf = explode(',', $pdf);
        fwrite($fopen, base64_decode($data_pdf[0]));
        fclose($fopen);

        $data = [
            'name' => $name,
            'url' => $file,
            'event_id' => $event_id,
            'event_agenda_id' => $event_agenda_id,
            'event_event_type_id' => $event_event_type_id
        ];

        Materi::create($data);

        

        return "berhasil";
    }

    //
}
