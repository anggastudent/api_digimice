<?php

namespace App\Http\Controllers;

require '../vendor/autoload.php';
use Xendit\Xendit;
use App\EventOrderHistory;
use App\Participant;
use App\Event;
use App\Team;
use App\User;
use Illuminate\Http\Request;


class XenditController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        Xendit::setApiKey(getenv('SECRET_API_KEY'));
    }

    public function createInvoice(){

      $params = [
          'external_id' => 'tes_api_8',
          'payer_email' => 'a123aku@gmail.com',
          'description' => 'Nyoba aja',
          'amount' => 10000
      ];

      $createInvoice = \Xendit\Invoice::create($params);

      // if($createInvoice){
      //   $data = [
      //       'status' => "PENDING",
      //       'participant_event_id' => "1",
      //       'participant_user_id' => "1280",
      //       'id_invoice' => $createInvoice['id']

      //   ];

      //   OrderHistory::create($data);
      // }

      return $array = [$createInvoice];

      // $options['secret_api_key'] = 'xnd_development_rpOvltDUNxwYd4DbJ8czoEJiPKU3AwgeMQsfW6KxNLuJYJvTDmiiJBCeKNaZ0';
      // $xenditPHPClient = new \XenditClient\XenditPHPClient($options);

      // $external_id = 'tes_api_5';
      // $amount = 50000;
      // $payer_email = 'a123aku@gmail.com';
      // $description = 'Tes membayar';

      // $response = $xenditPHPClient->createInvoice($external_id, $amount, $payer_email, $description);
      // $array = [
      //     $response
      // ];
      // return $array;
 
    }

    public function getInvoice(){
      
      $id = "5eaece0c1c9cf11118cc354b";
      $getInvoice = \Xendit\Invoice::retrieve($id);
      return $array = [$getInvoice];

      // $options['secret_api_key'] = 'xnd_development_rpOvltDUNxwYd4DbJ8czoEJiPKU3AwgeMQsfW6KxNLuJYJvTDmiiJBCeKNaZ0';
      // $xenditPHPClient = new \XenditClient\XenditPHPClient($options);

      //   $invoice_id = '5ea41a101c9cf11118cbf0dd';

      //   $response = $xenditPHPClient->getInvoice($invoice_id);
        
      //   $array = [
      //     $response
      //   ];
      // return $array;
    }

    public function expiredInvoice(){
      $id = "5ea455591c9cf11118cbf228";
      $expireInvoice = \Xendit\Invoice::expireInvoice($id);
      return $expireInvoice;
    }

    public function createDisbursement(){

      $params = [
          'external_id' => 'disb-12345678',
          'amount' => 15000,
          'bank_code' => 'BCA',
          'account_holder_name' => 'Joe',
          'account_number' => '1234567890',
          'description' => 'Disbursement from Example',
          'X-IDEMPOTENCY-KEY'
      ];
      $createDisbursements = \Xendit\Disbursements::create($params);


      return $createDisbursements;
      // $options['secret_api_key'] = 'xnd_development_rpOvltDUNxwYd4DbJ8czoEJiPKU3AwgeMQsfW6KxNLuJYJvTDmiiJBCeKNaZ0';
      // $xenditPHPClient = new \XenditClient\XenditPHPClient($options);

      // $external_id = 'demo_14754597758172';
      // $amount = 800000;
      // $bank_code = 'BCA';
      // $account_holder_name = 'Angga Dwi';
      // $account_number = '1231241231';
      // $disbursement_options['description'] = 'tess api';

      // $response = $xenditPHPClient->createDisbursement($external_id, $amount, $bank_code, $account_holder_name, $account_number, $disbursement_options);
      
      // $array = [
      //     $response
      // ];
      // return $array;
    }

    public function getDisbursement(){
      $id = "5ea459c379037e0016e7e535";
      $getDisbursements = \Xendit\Disbursements::retrieve($id);
      return $getDisbursements;
      
      // $options['secret_api_key'] = 'xnd_development_rpOvltDUNxwYd4DbJ8czoEJiPKU3AwgeMQsfW6KxNLuJYJvTDmiiJBCeKNaZ0';
      // $xenditPHPClient = new \XenditClient\XenditPHPClient($options);
      
      // $disbursement_id = '5e4009b1b1be6b0020c63e9e';

      // $response = $xenditPHPClient->getDisbursement($disbursement_id);
      
      // $array = [
      //     $response
      // ];
      // return $array;
    }

    public function callbackInvoice($id){
       if ($_SERVER["REQUEST_METHOD"] === "POST" && "d03c8015b391f898985d59818b68971f3d3d8b7eb8a15cd7ba3715e17e6ce52b" == $id) 
       {
           
          $data = file_get_contents("php://input");
          $parse = json_decode($data); 
          $invoice_id = $parse->id;
          $status = $parse->status;

          if($event_order_history = EventOrderHistory::where('id_invoice',$invoice_id)->first()){
            
            $event_order_history->update(['status' => $status]);
            $event = Event::where('id',$event_order_history->event_id)->first();
            
            if($status == "PAID"){
              $event->update(['event_status' => "true"]);
            }

          }
          
      } else {
          return "Akses ditolak";
      }

    }

     public function callbackDisbursement($id){
       if ($_SERVER["REQUEST_METHOD"] === "POST" && "d03c8015b391f898985d59818b68971f3d3d8b7eb8a15cd7ba3715e17e6ce52b" == $id) {
          $data = file_get_contents("php://input");
          $parse = json_decode($data); 
          

      } else {
          return "Akses ditolak";
      }

    }

    //
}
