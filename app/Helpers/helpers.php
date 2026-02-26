<?php
use App\Models\User;
use App\Models\Notification;
use App\Http\Controllers\Twilio\TwilioController;


function sendNotifcation($user_id, $title, $content, $link=""){

    if(empty($user_id) || empty($title)){
        return false;
    }

    $notification= Notification::create([
        "notification_title"=> $title,
        "notification_content"=> $content,
        "user_id"=>$user_id,
        "link"=> $link
    ]);


    if(is_connected()){
        $user_phone= User::find($user_id); 
        TwilioController::sendWhatsAppNotification($user_phone->phone, "*$title* \n\n". $content);

       
    }
   

    return $notification;
}





function is_connected()
{

    ini_set('max_execution_time',0);
    
    ob_start();
    $connected =system("ping -c 1 google.com", $response);
    ob_get_contents();
    ob_clean();

    if($connected!="")
    {
        return true;
    } else {
        return false;
    }
} 