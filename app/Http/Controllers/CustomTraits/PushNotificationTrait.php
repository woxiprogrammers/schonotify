<?php
namespace App\Http\Controllers\CustomTraits;
use App\PushToken;
use Illuminate\Support\Facades\Log;
trait PushNotificationTrait{

    public function CreatePushNotification($PushTitle,$PushMsg,$allUser,$push_users){
        $title = $PushTitle;
        $msg = $PushMsg;
        if($allUser == 1){
            $device_token=PushToken::lists('push_token')->toArray();
         }
        else{
            $device_token=$push_users;
        }
        $url = env('PushDomain');
        $data = array(
            'tokens' => $device_token,
            'notification' => array('title' => ''.$title,
                                    'message' =>$msg),
            'profile' => env('SECURITY_PROFILE')
        );
         $content = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-Ionic-Application-Id:'.env('PushAPPId'),
            'Authorization:Bearer '.env('APIToken')
        ));
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
