<?php

namespace App\Http\Controllers;
use App\EventPresensi;
use App\Participant;
use App\Kabupaten;
use App\Session;
use App\User;
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

    public function addParticipant(Request $request){

        $event_id = $request->input('event_id');
        $user_id = $request->input('user_id');
        $payment = $request->input('payment');
        $participant_group_id = $request->input('participant_group_id');
        $session_id = $request->input('session_id');

        $session = Session::where('event_id',$event_id)->get('id');

        $data = [
            'event_id' => $event_id,
            'user_id' => $user_id,
            'kit' => "Belum",
            'register' => "Belum",
            'payment' => $payment,
            'payment_status' => "Belum Lunas",
            'participant_group_id' => $participant_group_id
        ];

        $participant = Participant::create($data);

        $barcode = $this->getRandomString(8)."-MOB-";
        foreach($session as $value){

            $data2 = [
                'barcode' => $barcode,
                'status' => "Belum Hadir",
                'participant_user_id' => $user_id,
                'event_agenda_event_session_id' => $value->id,
                'event_agenda_event_session_event_id' => $event_id,
                'event_agenda_event_session_event_event_type_id' => "3"
            ];
            EventPresensi::create($data2);
            
        }

        return "berhasil tambah participant";
    }

    public function setQrCode(Request $request){
        $email = $request->input('email');
        $kode_qr = $request->input('kode_qr');
        $event_id = $request->input('event_id');

        $session = Session::where('event_id',$event_id)->get('id');

        $user = User::where('email',$email)->first();

        if($user){

            $user_id = $user->id;
            foreach ($session as $value) {
                $presensi = EventPresensi::where('participant_user_id', $user_id)->where('event_agenda_event_session_id',$value->id)->first();

                $data = [
                    'barcode' => $kode_qr
                ];

                $presensi->update($data);
            }
            

            return "berhasil";
        }
        else{
            return "email belum terdaftar";
        }
        

    }

    public function scanQrCode(Request $request){
        $qr_code = $request->input('qr_code');
        $session_id = $request->input('session_id');
        $event_id = $request->input('event_id');
        
        if($presensi = EventPresensi::where('barcode', $qr_code)->where('event_agenda_event_session_id',$session_id)->first()){
            $data = [
                'status' => "Hadir" 
            ];

           $presensi->update($data);

            $participant = Participant::where('user_id',$presensi->participant_user_id)->where('event_id',$event_id)->first();

            $data2 = [
                'kit' => "Sudah",
                'register' => "Sudah"
            ];

            $participant->update($data2);
            //return $presensi;
            return "Berhasil Absen";
        }else{
            return "QR Code salah";
        }

        
    }

    public function rekapitulasi(Request $request){
        $event_id = $request->input('event_id');
        $session_id = $request->input('session_id');

        $presensi = EventPresensi::where('event_agenda_event_session_id',$session_id)->where('event_agenda_event_session_event_id',$event_id)->get();
        
        foreach ($presensi as $value) {
            $kabupaten = Kabupaten::findOrFail($value->user->regencies_id);

            $array[] = [
                'name' => $value->user->name,
                'email' => $value->user->email,
                'phone' => $value->user->phone,
                'rekap' => $value->status,
                'payment_status' => $value->participant->payment_status,
                'provinsi' => $kabupaten->provinsi->name
            ];
        }
        return $array;
    }

    //Fungsi Random String
    public function getRandomString($panjang = 32){
        $karakter = '012345678dssd9abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $panjang_karakter = strlen($karakter);
        $randomString = '';
        for ($i = 0; $i < $panjang; $i++) {
            $randomString .= $karakter[rand(0, $panjang_karakter - 1)];
        }
        return $randomString;
    }
}
