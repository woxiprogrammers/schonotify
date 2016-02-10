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
  public function getMessages(Requests\Message $request ){
        try {
            $finalMessageData=array();
            $messageData=array();
            $data = $request->all();
            $sender = $data['teacher']['id'];
            $messages= Message::where('is_delete','=',0)
                        ->Where(function($query) use ($sender)
                                {
                                        $query->where('to_id',$sender)
                                        ->orwhere('from_id',$sender);
                                })->get()->toArray();

            $i=0;
            if($messages!=null){
                $status = 200;
                $message = "Success";
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
                    $messageData['MessageList'][$receiver]['message_id']=$value['id'];
                    $messageData['MessageList'][$receiver]['user_id']=$data['teacher']['id'];
                    $messageData['MessageList'][$receiver]['from_id']=$value['from_id'];
                    $messageData['MessageList'][$receiver]['to_id']=$value['to_id'];
                    $messageData['MessageList'][$receiver]['description']=$value['description'];
                    $finalSender=User::where('id','=',$value['from_id'])->select('first_name', 'last_name')->first();
                    $finalSenderName=$finalSender['first_name']." ".$finalSender['last_name'];
                    $finalReceiver = User::where('id','=',$value['to_id'])->select('first_name', 'last_name')->first();
                    $finalReceiverName =$finalReceiver['first_name']." ".$finalReceiver['last_name'];
                    if($messageData['MessageList'][$receiver]['user_id']==$messageData['MessageList'][$receiver]['from_id']){
                        $title=$finalReceiverName;
                        $title_id=$value['to_id'];
                    }else{
                        $title=$finalSenderName;
                        $title_id=$value['from_id'];;
                    }
                    $messageData['MessageList'][$receiver]['sender_name']=$finalSenderName;
                    $messageData['MessageList'][$receiver]['title_id']=$title_id;
                    $messageData['MessageList'][$receiver]['receiver_name']=$finalReceiverName;
                    $messageData['MessageList'][$receiver]['title']=$title;
                    $messageData['MessageList'][$receiver]['timestamp'] = date("M j, g:i a",strtotime($value['timestamp']));
                    if($data['teacher']['id']==$value['from_id'])
                    {
                        $messageData['MessageList'][$receiver]['read_status']=1;

                    }else{
                        $messageData['MessageList'][$receiver]['read_status']=$value['read_status'];
                    }
                    $messageData['MessageList'][$receiver]['created_at']=$value['timestamp'];

                    $i++;
                }
                $i=0;
                foreach($messageData as $value)
                {
                    foreach($value as $key=>$val)
                    {
                        $finalMessageData[$i]=$val;
                        $i++;
                    }
                }
                foreach ($finalMessageData as $key => $part) {
                    $sort[$key] = strtotime($part['created_at']);
                }
                array_multisort($sort, SORT_DESC, $finalMessageData);
            }else{
                $status = 200;
                $message = "No Messages Found";
                $finalMessageData=[];
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = "something went wrong". $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" => $status,
           "MessageList" => $finalMessageData
        ];
        return response($response, $status);
    }
    public function getMessagesParent(Requests\Message $request ,$student_id){
        try {
            $finalMessageData=array();
            $data = $request->all();
            $sender = $student_id;
            $messages= Message::where('is_delete','=',0)
                ->Where(function($query) use ($sender)
                {
                    $query->where('to_id',$sender)
                        ->orwhere('from_id',$sender);
                })->get()->toArray();
            $i=0;
            if($messages!=null){
            $status = 200;
            $message = "Success";
            foreach($messages as $value)
            {
                if($student_id == $value['from_id'])
                {
                    $receiverName = User::where('id','=',$value['to_id'])
                        ->select('first_name', 'last_name')->first();
                }else{
                    $receiverName = User::where('id','=',$value['from_id'])
                        ->select('first_name', 'last_name')->first();
                }
                $receiver= $receiverName['first_name']." ".$receiverName['last_name'];
                $messageData['MessageList'][$receiver]['message_id']=$value['id'];
                $messageData['MessageList'][$receiver]['user_id']=$data['teacher']['id'];
                $messageData['MessageList'][$receiver]['from_id']=$value['from_id'];
                $messageData['MessageList'][$receiver]['to_id']=$value['to_id'];
                $messageData['MessageList'][$receiver]['description']=$value['description'];
                $finalSender=User::where('id','=',$value['from_id'])->select('first_name', 'last_name')->first();
                $finalSenderName=$finalSender['first_name']." ".$finalSender['last_name'];
                $finalReceiver = User::where('id','=',$value['to_id'])->select('first_name', 'last_name')->first();
                $finalReceiverName =$finalReceiver['first_name']." ".$finalReceiver['last_name'];
                if($student_id == $messageData['MessageList'][$receiver]['from_id']){
                    $title=$finalReceiverName;
                    $title_id=$value['to_id'];
                }else{
                    $title=$finalSenderName;
                    $title_id=$value['from_id'];
                }
                $messageData['MessageList'][$receiver]['sender_name']=$finalSenderName;
                $messageData['MessageList'][$receiver]['title_id']=$title_id;
                $messageData['MessageList'][$receiver]['receiver_name']=$finalReceiverName;
                $messageData['MessageList'][$receiver]['title']=$title;
                $messageData['MessageList'][$receiver]['timestamp'] = date("M j, g:i a",strtotime($value['timestamp']));
                if($data['teacher']['id']==$value['from_id'])
                {
                    $messageData['MessageList'][$receiver]['read_status']=1;

                }else{
                    $messageData['MessageList'][$receiver]['read_status']=$value['read_status'];
                }
                $messageData['MessageList'][$receiver]['created_at']=$value['timestamp'];
                $i++;

            }
            $i=0;
            foreach($messageData as $value)
            {
                foreach($value as $key=>$val)
                {
                    $finalMessageData[$i]=$val;
                    $i++;
                }
            }
            foreach ($finalMessageData as $key => $part) {
                $sort[$key] = strtotime($part['created_at']);
            }
            array_multisort($sort, SORT_DESC, $finalMessageData);
            }else{
                $status = 200;
                $message = "No Messages Found";
                $finalMessageData=[];
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = "something went wrong". $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "MessageList" => $finalMessageData
        ];
        return response($response, $status);
    }

    public function getMessageCount(Request $request , $id){
        try {

                $finalMessageCount=array();
                $messageCount=Message::where('to_id',$id)
                    ->where('read_status','=',0)
                    ->where('is_delete','=',0)
                    ->count();
            $finalMessageCount['Badge_count']['user_id']=$id;
            $finalMessageCount['Badge_count']['message_count'] = $messageCount;
            $finalMessageCount['Badge_count']['auto_notification_count'] = $messageCount;
        $status=200;
        $message="Success";
         } catch (\Exception $e) {
                $status = 500;
                $message = "something went wrong". $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalMessageCount
        ];
        return response($response, $status);
}
    public function getAclDetails(Request $request ){
    try {
        $data=$request->all();
        $finalAclDetails=array();
        $acl_module=User::join('module_acls', 'users.id', '=', 'module_acls.user_id')
            ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
            ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
            ->where('users.id','=', $data['teacher']['id'])
            ->select('users.id','acl_master.title as acl','modules.title as module','modules.slug as module_slug')
            ->get();
        $AclModuleArray=array();
        $i=0;
        if($acl_module!=null)
        {
            foreach($acl_module as $val)
            {
                array_push($AclModuleArray,$val->acl.'_'.$val->module_slug);
            }
            $data['Acl_Modules']['user_id']= $data['teacher']['id'];

            foreach($AclModuleArray as $val)
            {
                $finalAclDetails['Acl_Modules'][$i]=$val;
                $i++;
            }
        }
        $message="Success";
        $status=200;
     }catch (\Exception $e) {
        $status = 500;
        $message = "something went wrong". $e->getMessage();
    }
        $response = [
            "message" => $message,
            "status" => $status,
            "Data" => $finalAclDetails
        ];
        return response($response, $status);
    }
    public function getDetailMessages(Requests\Message $request ){
        try {
            $finalMessageData=array();
            $MessageData=array();
            $data = $request->all();
            $from_id = $data['from_id'];
            $to_id = $data['to_id'];
            $user_id = $data['user_id'];
            if($user_id!=$from_id)
            {
                Message::where('to_id', $to_id)
                    ->where('from_id', $from_id)
                    ->where('is_delete','=',0)
                    ->update(['read_status' => 1]);
            }
            $messages1= Message::where('is_delete','=',0)
                ->Where(function($query) use ($to_id,$from_id)
                {
                    $query->where('to_id',$to_id)
                        ->where('from_id',$from_id);
                })->get()->toArray();
            $messages2= Message::where('is_delete','=',0)
                ->Where(function($query) use ($to_id,$from_id)
                     {
                        $query->where('to_id',$from_id)
                             ->where('from_id',$to_id);
                       })->get()->toArray();
            $MessageData=array_merge_recursive($messages1,$messages2);
                foreach ($MessageData as $key => $part) {
                               $sort[$key] = strtotime($part['created_at']);
                                                   }
                array_multisort($sort, SORT_ASC, $MessageData);
                    $i=0;
            foreach($MessageData as $value){
                        if($value['from_id']==$user_id){
                            $finalMessageData[$i]['description']=$value['description'];
                            $finalMessageData[$i]['timestamp']=date("M j, g:i a",strtotime($value['timestamp']));
                            $finalMessageData[$i]['type']="Sent";
                }else{
                            $finalMessageData[$i]['description']=$value['description'];
                            $finalMessageData[$i]['timestamp']=date("M j, g:i a",strtotime($value['timestamp']));
                            $finalMessageData[$i]['type']="Receive";
                        }
                $i++;
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
    public function deleteMessages(Requests\Message $request){
        try {
            $data = $request->all();
            $from_id = $data['from_id'];
            $to_id = $data['to_id'];
            Message::whereIn('to_id',[$from_id,$to_id])->whereIn('from_id',[$from_id,$to_id])->update(['is_delete' => 1]);
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
        ];
        return response($response, $status);
    }

    public function getUserRoles(){
        try{
            $userRole = UserRoles::whereNotIn('slug', ['parent','admin'])
                        ->select('user_roles.id','user_roles.name')
                        ->get()->toArray();
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

    public function getTeachers(Request $requests){
        try{
            $data=$requests->all();
            $teacher_id = UserRoles::whereIn('slug', ['teacher'])->pluck('id');
            $teacher = User::where('role_id',$teacher_id)->get()->toArray();
            $i=0;
            foreach($teacher as $value){
                if($value['id']!=$data['teacher']['id'])
                {
                    $teacherData[$i]['id']=$value['id'];
                    $teacherData[$i]['name']=$value['first_name']." ".$value['last_name'];
                    $i++;
                }
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
            $student = User::where('role_id',$student_id)->where('division_id',$request->division_id)
                                ->select('id','first_name', 'last_name')
                                ->get()->toArray();
            $i=0;
            foreach($student as $value){
                $responseData['studentList'][$i]['id']= $value['id'];
                $responseData['studentList'][$i]['name']= $value['first_name']."  ".$value['last_name'];
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
            $from_id = $data['from_id'];
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
