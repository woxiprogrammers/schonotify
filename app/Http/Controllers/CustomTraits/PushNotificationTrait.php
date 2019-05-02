<?php
namespace App\Http\Controllers\CustomTraits;
use App\PushToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

trait PushNotificationTrait{
    public function CreatePushNotification($PushTitle,$PushMsg,$allUser,$push_users){
        try{
            $title = $PushTitle;
            $msg = $PushMsg;
            if($allUser == 1){
                $device_token = PushToken::lists('push_token')->toArray();
            }else{
                $device_token = $push_users->toArray();
            }
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60*20);
            $notificationBuilder = new PayloadNotificationBuilder($title);
            $notificationBuilder->setBody($msg)
                ->setSound('default');
            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData([
                'title' => $title,
                'body' => $msg,
            ]);
            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();
            $downstreamResponse = FCM::sendTo($device_token, $option, $notification, $data);
            return true;
        }catch(\Exception $e){
            $data = [
                'action' => 'Send Push notification from trait',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            return false;
        }
    }
}
