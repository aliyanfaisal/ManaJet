<?php

namespace App\Http\Controllers\Twilio;

use Exception;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\Models\Option;

class TwilioController extends Controller
{
  //


  static function sendWhatsAppNotification($send_to, $message)
  {

        $enable_twilio= Option::where("option_key","enable_twilio")->first();
        $sid= Option::where("option_key","twilio_sid")->first();
        $token= Option::where("option_key","twilio_key")->first();

        if($enable_twilio == null ||  $enable_twilio->option_value=="disable" ||  $sid == null  ||  $token == null ){
            return false;
        }
        

    $sid = $sid->option_value != "" ? $sid->option_value : $_ENV['TWILIO_SID'] ;
    $token = $token->option_value != "" ? $token->option_value : $_ENV['TWILIO_AUTH_KEY'] ;


    if (substr($send_to, 0, 1) === "0") {
      // Remove the leading 0 and add "92" to the beginning of the string
      $send_to = "+92" . substr($send_to, 1);
    }

    if($sid!="" && $token != ""){
            return false;
    }

    
      $twilio = new Client($sid, $token);
 
      $message = $twilio->messages
        ->create(
          "whatsapp:$send_to",
          // to
          array(
            "from" => "whatsapp:+14155238886",
            "body" => $message
          )
        );
 



    return response()->json($message);
  }
}
