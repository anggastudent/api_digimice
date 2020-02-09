<?php

namespace App\Http\Controllers;
use App\EventPresensi;
use App\User;
use App\EventAgenda;
use App\Participant;
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

        $token = $request->input('token');
        $user = User::where('remember_token',$token)->first();
        $userId = $user->id;

        $participan = Participant::where('user_id',$userId)->first();
        $participanEventId = $participan->event_id;

        $agenda = EventAgenda::where('event_id',$participanEventId)->first();
        $agendaId = $agenda->id;

        $presensi = new EventPresensi();
        $presensi->participant_event_id = $userId;
        $presensi->event_agenda_id = $agendaId;
        $presensi->barcode = $request->input('barcode');
        $presensi->status = "Hadir";
        $presensi->save();

        return response("berhasil absen");
    }
}
