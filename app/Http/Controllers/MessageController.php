<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use App\UserRoles;
use Illuminate\Http\Request;
use DateTime;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use Mockery\CountValidator\Exception;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');

    }
    public function getMessageCount(Request $request){
      dd($request->all())
        $userId = Auth::user()->id;
        $unreadMsgCount=Message::where('to_id',$userId)->where('read_status',0)->count();
        return $unreadMsgCount;
    }
    public function getUnreadMessageListing(Request $request){
        $userId = Auth::user()->id;
        $senderArray = array();
        array_push($senderArray,$userId);
        $tomessageList = Message::where('to_id',$userId)->where('read_status',0)->lists('from_id');
        $toMessageData = array_unique(array_diff($tomessageList->toArray(),$senderArray));
        $messageContactLists = User::whereIn('id',$toMessageData)->select('id','first_name','last_name','role_id',
            'division_id','avatar','is_active')->get();
        $message = array();
        $messagesLists = array();
        $profileImagePath = URL::asset(env('PROFILE_IMAGE_UPLOAD'));
        $ProfileDirectory = $profileImagePath . "/";
        foreach($messageContactLists as $messageList){
            $messages = Message::where('to_id',$userId)
                ->where('read_status',0)
                ->orderby('created_at','desc')->first();
            $message['description'] = $messages->description;
            $message['avatar'] = $ProfileDirectory.$messageList['avatar'];
            $currentDate = new DateTime(Carbon::now());
            $messageDate = new DateTime($messages->timestamp);
            $dateDiff = $currentDate->diff($messageDate);
            $message['timestamp'] = $dateDiff->h;
            $message['user_id'] = $messageList['id'];
            $message['is_active'] = $messageList['is_active'];
            $message['first_name'] = $messageList['first_name'];
            $message['last_name'] = $messageList['last_name'];
            array_push($messagesLists,$message);
        }
        return $messagesLists;
    }
    public function getMessageList(){
        $userId = Auth::user()->id;
        $senderArray = array();
        array_push($senderArray,$userId);
        $tomessageList = Message::where('to_id',$userId)->orwhere('from_id',$userId)->lists('to_id');
        $frommessageList = Message::where('to_id',$userId)->orwhere('from_id',$userId)->lists('from_id');
        $toMessageData = array_unique(array_diff($tomessageList->toArray(),$senderArray));
        $fromMessageData = array_unique(array_diff($frommessageList->toArray(),$senderArray));
        $messagecontact = array_unique(array_merge($toMessageData,$fromMessageData));
        $messageContactLists = User::whereIn('id',$messagecontact)->select('id','first_name','last_name','role_id',
            'division_id','avatar','is_active')->get();
        $message = array();
        $messagesLists = array();
        $profileImagePath = URL::asset(env('PROFILE_IMAGE_UPLOAD'));
        $ProfileDirectory = $profileImagePath . "/";
        foreach($messageContactLists as $messageList){
            $message['user_id'] = $messageList['id'];
            $userRoleId = User::where('id',$messageList['id'])->select('role_id')->first();
            $userRole = UserRoles::where('id',$userRoleId->role_id)->select('name')->first();
            $message['first_name'] = $messageList['first_name'];
            $message['last_name'] = $messageList['last_name'];
            $message['role'] = $userRole->name;
            $message['is_active'] = $messageList['is_active'];
            $message['avatar'] = $ProfileDirectory.$messageList['avatar'];
            array_push($messagesLists,$message);
        }
        return $messagesLists;
    }
    public function getDetailMessages($id){
        $userId = Auth::user()->id;
        $sender = $userId;
        $receiver = $id;
        $messagesLists = $this->getDetailMessageListing($sender,$receiver);
       Message::whereIn('to_id',[$sender])->whereIn('from_id',[$receiver])
            ->update(['read_status' => 1]);
        return $messagesLists;
    }
    public function sendMessage(Request $request){
        if($request->ajax()){
           $data = $request->all();
            $userId = Auth::user()->id;
            $messageData['to_id'] = $data['id'];
            $messageData['from_id'] = $userId;
            $messageData['description'] = $data['description'];
            $messageData['timestamp'] = Carbon::now();
            $messageData['created_at'] = Carbon::now();
            $messageData['updated_at'] = Carbon::now();
            $newMessage = Message::insert($messageData);
            $messagesLists = $this->getDetailMessageListing($userId,$data['id']);
            return $messagesLists;
        }
    }
    public function getDetailMessageListing($sender,$receiver){
        $message = array();
        $messagesLists = array();
        $profileImagePath = URL::asset(env('PROFILE_IMAGE_UPLOAD'));
        $ProfileDirectory = $profileImagePath . "/";
        $messages = Message::whereIn('to_id',[$sender,$receiver])
            ->whereIn('from_id',[$sender,$receiver])
            ->where('is_delete','0')
            ->orderby('created_at','asc')
            ->get();
        foreach($messages as $messageHistory){
            $message['description'] = $messageHistory['description'];
            $message['to_id'] = $messageHistory['to_id'];
            $to_name = User::where('id',$message['to_id'])->select('id','first_name','last_name','avatar')->first();
            $message['to_avatar'] = $ProfileDirectory.$to_name['avatar'];
            $message['to_name'] = $to_name['first_name'].' '.$to_name['last_name'];
            $message['from_id'] = $messageHistory['from_id'];
            $from_name = User::where('id',$message['from_id'])->select('id','first_name','last_name','avatar')->first();
            $message['from_avatar'] = $ProfileDirectory.$from_name['avatar'];
            $message['from_name'] = $from_name['first_name'].' '.$from_name['last_name'];
            $message['timestamp'] = $messageHistory['timestamp'];
            $message['date'] = date("M j, g:i a",strtotime($messageHistory['timestamp']));
            $message['read_status'] = $messageHistory['read_status'];
            $message['is_delete'] = $messageHistory['is_delete'];
            array_push($messagesLists,$message);
        }
        return $messagesLists;
    }
    public function composeMessage(Requests\WebRequests\MessageRequest $request){
        try{
        $data = $request->all();
        $userId = Auth::user()->id;
        $messageData['to_id'] = $data['user_id'];
        $messageData['from_id'] = $userId;
        $messageData['description'] = $data['description'];
        $messageData['timestamp'] = Carbon::now();
        $messageData['created_at'] = Carbon::now();
        $messageData['updated_at'] = Carbon::now();
        $newMessage = Message::insert($messageData);
        Session::flash('message-success', "Message Successfully send");
        return Redirect::back();
        }catch (Exception $e){
            Session::flash('message-error',  "Message Not Successfully send");
            return Redirect::back();
        }
    }
}
