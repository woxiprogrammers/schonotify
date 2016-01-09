<?php

namespace App\Http\Controllers\api;

use App\Batch;
use App\Classes;
use App\Division;
use App\User;
use App\UserRoles;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;

class MessageController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }

    public function getDetailMessages(Request $request ){
        try {
            $data = $request->all();
            $sender = $data['teacher']['id'];
            $messages = Message::where('to_id',$sender)
                ->orwhere('from_id',$sender)
                ->get()->toArray();
            $i=0;
            foreach($messages as $value)
            {
                if($data['teacher']['id']==$value['from_id'])
                {
                    $receiverName = User::where('id','=',$value['to_id'])
                        ->select('first_name', 'last_name')->first();
                }else{
                    $receiverName = User::where('id','=',$value['from_id'])
                        ->select('first_name', 'last_name')->first();
                }
                $receiver= $receiverName['first_name']." ".$receiverName['last_name'];
                $messageData['MessageList'][$receiver][$i]['message_id']=$value['id'];
                $messageData['MessageList'][$receiver][$i]['user_id']=$data['teacher']['id'];
                $messageData['MessageList'][$receiver][$i]['from_id']=$value['from_id'];
                $messageData['MessageList'][$receiver][$i]['to_id']=$value['to_id'];
                $messageData['MessageList'][$receiver][$i]['description']=$value['description'];
                $finalSender=User::where('id','=',$value['from_id'])->select('first_name', 'last_name')->first();
                $finalSenderName=$finalSender['first_name']." ".$finalSender['last_name'];
                $finalReceiver = User::where('id','=',$value['to_id'])->select('first_name', 'last_name')->first();
                $finalReceiverName =$finalReceiver['first_name']." ".$finalReceiver['last_name'];
                $messageData['MessageList'][$receiver][$i]['sender_name']=$finalSenderName;
                $messageData['MessageList'][$receiver][$i]['receiver_name']=$finalReceiverName;
                $messageData['MessageList'][$receiver][$i]['timestamp'] = date("M j, g:i a",strtotime($value['timestamp']));
                $messageData['MessageList'][$receiver][$i]['read_status']=$value['read_status'];
                $i++;
            }
            $i=0;
            foreach($messageData as $value)
            {
                foreach($value as $key=>$val)
                {
                    $finalMessageData[$i]['Name']= $key;
                    $finalMessageData[$i]['Messages']=$val;
                    $i++;
                }
            }
            $status = 200;
            $message = "Success";
        } catch (\Exception $e) {
            $status = 500;
            $message = "something went wrong". $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalMessageData
        ];
        return response($response, $status);
    }

    public function getDetailMessagesTeacher(Request $request , $id){
        try {
            $data = $request->all();
            $sender = $id;
            $messages = Message::where('to_id',$sender)
                ->orwhere('from_id',$sender)
                ->get()->toArray();
            $i=0;
            foreach($messages as $value)
            {
                if($data['teacher']['id']==$value['from_id'])
                {
                    $receiverName = User::where('id','=',$value['to_id'])
                        ->select('first_name', 'last_name')->first();
                }else{
                    $receiverName = User::where('id','=',$value['from_id'])
                        ->select('first_name', 'last_name')->first();
                }
                $receiver= $receiverName['first_name']." ".$receiverName['last_name'];
                $messageData['MessageList'][$receiver][$i]['message_id']=$value['id'];
                $messageData['MessageList'][$receiver][$i]['user_id']=$data['teacher']['id'];
                $messageData['MessageList'][$receiver][$i]['from_id']=$value['from_id'];
                $messageData['MessageList'][$receiver][$i]['to_id']=$value['to_id'];
                $messageData['MessageList'][$receiver][$i]['description']=$value['description'];
                $finalSender=User::where('id','=',$value['from_id'])->select('first_name', 'last_name')->first();
                $finalSenderName=$finalSender['first_name']." ".$finalSender['last_name'];
                $finalReceiver = User::where('id','=',$value['to_id'])->select('first_name', 'last_name')->first();
                $finalReceiverName =$finalReceiver['first_name']." ".$finalReceiver['last_name'];
                $messageData['MessageList'][$receiver][$i]['sender_name']=$finalSenderName;
                $messageData['MessageList'][$receiver][$i]['receiver_name']=$finalReceiverName;
                $messageData['MessageList'][$receiver][$i]['timestamp'] = date("M j, g:i a",strtotime($value['timestamp']));
                $messageData['MessageList'][$receiver][$i]['read_status']=$value['read_status'];
                $i++;
            }
               $i=0;
            foreach($messageData as $value)
                {
                    foreach($value as $key=>$val)
                        {
                            $finalMessageData[$i]['Name']= $key;
                            $finalMessageData[$i]['Messages']=$val;
                            $i++;
                        }
                }
            $status = 200;
            $message = "Success";
        } catch (\Exception $e) {
            $status = 500;
            $message = "something went wrong". $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalMessageData
        ];
        return response($response, $status);
    }
   public function getMessageList(Request $request){
        try {
            $data = $request->all();
            $sender = $data['teacher']['id'];
            $senderArray = array();
            array_push($senderArray,$sender);
            $tomessageList = Message::where('to_id',$sender)->orwhere('from_id',$sender)->lists('to_id');
            $frommessageList = Message::where('to_id',$sender)->orwhere('from_id',$sender)->lists('from_id');
            $toMessageData = array_unique(array_diff($tomessageList->toArray(),$senderArray));
            $fromMessageData = array_unique(array_diff($frommessageList->toArray(),$senderArray));
            $messagecontact = array_unique(array_merge($toMessageData,$fromMessageData));
            $userInfo = User::whereIn('id',$messagecontact)->select('id','first_name','last_name','role_id',
            'division_id')->get();
        $messageData=array();
            $da=array();
            foreach($userInfo as $user){
                $messages = Message::Where(function ($query) use($sender) {
                    $query->orwhere('to_id', $sender)->orwhere('from_id', $sender);
                })->orderby('timestamp','desc')->first();
                $messageData['message_id']=$messages['id'];
                $messageData['user_id']=$messages['from_id'];
                $messageData['from_id']=$messages['from_id'];
                $messageData['to_id']=$messages['to_id'];
                $messageData['description']=$messages['description'];
                $userInfo = User::where('id','=',$messageData['from_id'])
                    ->select('first_name', 'last_name')->first();
                $messageData['name']=$userInfo['first_name']." ".$userInfo['last_name'];
                $messageData['timestamp']=$messages['timestamp'];
                $messageData['read_status']=$messages['read_status'];

                if($user['role_id'] == 3)
                {
                    $studentDivision = Division::where('id',$user['division_id'])->first();
                    $studentClass = Classes::where('id',$studentDivision->class_id)->first();
                    $studentBatch = Batch::where('id',$studentClass->batch_id)->first();
                    $messageData['studentInfo']['student-division']= $studentDivision->division_name;
                    $messageData['studentInfo']['student-class'] = $studentClass->class_name;
                    $messageData['studentInfo']['student-batch'] = $studentBatch->name;
                }else{
                    $messageData['studentInfo']='';
                }
                array_push($da,$messageData);
            }
            $responseData['data']= $da;
            $status = 200;
            $message = 'Successful';
        } catch (\Exception $e) {
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $responseData
        ];
        return response($response, $status);
    }

    public function deleteMessages(Requests\Message $request){
        try {
            $data = $request->all();
            $sender = $data['teacher']['id'];
            $receiver = $data['user_id'];
            Message::whereIn('to_id',[$sender,$receiver])->whereIn('from_id',[$sender,$receiver])->update(['is_delete' => 1]);
            $messages = Message::where('is_delete',0)->Where(function ($query) use($sender) {
                                                            $query->orwhere('to_id', $sender)->orwhere('from_id', $sender);
                                                        })->get();

            $message = $messages->toArray();
            $responseData['messages']= $message;
            $status = 200;
            $message = 'Successfully Deleted';
        } catch (\Exception $e) {
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $responseData
        ];
        return response($response, $status);
    }

    public function getUserRoles(){
        try{
            $userRole = UserRoles::whereNotIn('slug', ['parent','admin'])
                        ->select('user_roles.id','user_roles.name')
                        ->get()->toArray();;
            $responseData['userRoles']= $userRole;
            $status = 200;
            $message = 'Successfully Listed';
        }catch (\Exception $e){
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $responseData
        ];
        return response($response, $status);
    }

    public function getTeachers(){
        try{
            $teacher_id = UserRoles::whereIn('slug', ['teacher'])->pluck('id');
            $teacher = User::where('role_id',$teacher_id)->get()->toArray();
            $i=0;
            foreach($teacher as $value){
                $teacherData[$i]['id']=$value['id'];
                $teacherData[$i]['name']=$value['first_name']." ".$value['first_name'];
                $i++;
            }
            $responseData['teachers']= $teacherData;
            $status = 200;
            $message = 'Successfully Listed';
        }catch (\Exception $e){
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $responseData
        ];
        return response($response, $status);
    }

    public function getAdmins(){
        try{
            $teacher_id = UserRoles::whereIn('slug', ['admin'])->pluck('id');
            $admin = User::where('role_id',$teacher_id)->get();
            $admins = $admin->toArray();
            $responseData['admins']= $admins;
            $status = 200;
            $message = 'Successfully Listed';
        }catch (\Exception $e){
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $responseData
        ];
        return response($response, $status);
    }
    public function getStudentList(Request $request){
        try{
            $student_id = UserRoles::whereIn('slug', ['student'])->pluck('id');
            $student = User::where('role_id',$student_id)->where('division_id',$request->division)
                                ->select('id','first_name', 'last_name')
                                ->get()->toArray();
            $i=0;
            foreach($student as $value){
                $responseData['studentList'][$i]['id']= $value['id'];
                $responseData['studentList'][$i]['name']= $value['first_name']."".$value['last_name'];
                $i++;
            }
            $status = 200;
            $message = 'Successfully Listed';
        }catch (\Exception $e){
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $responseData
        ];
        return response($response, $status);
    }
    public function sendMessage(Requests\Message $request){
        try{
            $data = $request->all();
            $from_id = $data['teacher']['id'];
            $to_id = $data['to_id'];
            $status = 200;
            $message = 'Message Successfully Sent';
            $messageData['to_id'] = $to_id;
            $messageData['from_id'] = $from_id;
            $messageData['description'] = $data['description'];
            $messageData['timestamp'] = Carbon::now();
            $messageData['created_at'] = Carbon::now();
            $messageData['updated_at'] = Carbon::now();
            $newMessage = Message::insert($messageData);
        }catch (\Exception $e){
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
        ];
        return response($response, $status);
    }
}
