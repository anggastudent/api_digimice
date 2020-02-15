<?php

namespace App\Http\Controllers;
require '../vendor/autoload.php';

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
      
        
    }

    public function createInvoice(){

      $options['secret_api_key'] = 'xnd_development_rpOvltDUNxwYd4DbJ8czoEJiPKU3AwgeMQsfW6KxNLuJYJvTDmiiJBCeKNaZ0';
      $xenditPHPClient = new \XenditClient\XenditPHPClient($options);

      $external_id = 'tes_api_1';
      $amount = 5000000;
      $payer_email = 'tes@api.com';
      $description = 'Tes bayar';

      $response = $xenditPHPClient->createInvoice($external_id, $amount, $payer_email, $description);
      print_r($response);
 
    }

    public function getInvoice(){
      $options['secret_api_key'] = 'xnd_development_rpOvltDUNxwYd4DbJ8czoEJiPKU3AwgeMQsfW6KxNLuJYJvTDmiiJBCeKNaZ0';
      $xenditPHPClient = new \XenditClient\XenditPHPClient($options);

        $invoice_id = '5e3fffc59138ca030f53107b';

        $response = $xenditPHPClient->getInvoice($invoice_id);
        print_r($response);
    }

    public function createDisbursement(){
      $options['secret_api_key'] = 'xnd_development_rpOvltDUNxwYd4DbJ8czoEJiPKU3AwgeMQsfW6KxNLuJYJvTDmiiJBCeKNaZ0';
      $xenditPHPClient = new \XenditClient\XenditPHPClient($options);

      $external_id = 'demo_1475459775872';
      $amount = 17000;
      $bank_code = 'BCA';
      $account_holder_name = 'Angga Jones';
      $account_number = '1231241231';
      $disbursement_options['description'] = 'tess api';

      $response = $xenditPHPClient->createDisbursement($external_id, $amount, $bank_code, $account_holder_name, $account_number, $disbursement_options);
      print_r($response);
    }

    public function getDisbursement(){
      $options['secret_api_key'] = 'xnd_development_rpOvltDUNxwYd4DbJ8czoEJiPKU3AwgeMQsfW6KxNLuJYJvTDmiiJBCeKNaZ0';
      $xenditPHPClient = new \XenditClient\XenditPHPClient($options);
      
      $disbursement_id = '5e4009b1b1be6b0020c63e9e';

      $response = $xenditPHPClient->getDisbursement($disbursement_id);
      print_r($response);
    }

    //
}
