<?php

namespace App\Http\Controllers\CustomTraits;

use App\PushToken;
use Illuminate\Support\Facades\Log;

trait PushNotificationTrait{

    public function CreatePushNotification($PushTitle,$PushMsg){
        $title = $PushTitle;
        $msg = $PushMsg;
        $device_token=PushToken::lists('push_token');
        $url = 'https://push.ionic.io/api/v1/push';
        $data = array(
            'tokens' => array($device_token),
            'notification' => array('title' => ''.$title.': '.$msg,
                                    'message' =>$msg),
        );
        $content = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_USERPWD, "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJlMzdhZWRhNS00Y2IwLTQwMzYtOTVhMS1mZDdiNTI0NWRjZDgifQ.6c_-v7vrjshE8IIpYP5zfGyy1aWjQm5aKCgEzrNyjpE" . ":" );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-Ionic-Application-Id:39687151'
        ));
        $result = curl_exec($ch);
        curl_close($ch);
    }
}