<?php

namespace App\Http\Controllers\CustomTraits;
use App\PushToken;
use Illuminate\Support\Facades\Log;
trait PushNotificationTrait{
    public function CreatePushNotification($PushTitle,$PushMsg){
        $title = $PushTitle;
        $msg = $PushMsg;
        $device_token=PushToken::lists('push_token')->toArray();
        $newToken = array();
        foreach($device_token as $token){
            array_push($newToken,$token);
        }
        Log::info($newToken);
        $url = 'https://push.ionic.io/api/v1/push';
        $data = array(
            'tokens' => $newToken,
            'notification' => array('title' => ''.$title.': '.$msg,
                                    'message' =>$msg),
        );
        Log::info($data);
        $content = json_encode($data);
        Log::info($content);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_USERPWD, "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJlMzdhZWRhNS00Y2IwLTQwMzYtOTVhMS1mZDdiNTI0NWRjZDgifQ.6c_-v7vrjshE8IIpYP5zfGyy1aWjQm5aKCgEzrNyjpE" . ":");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-Ionic-Application-Id:39687151'
        ));
        Log::info($ch);
        $result = curl_exec($ch);
        Log::info($result);
        curl_close($ch);
    }
}