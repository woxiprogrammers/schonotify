<?php

namespace App\Http\Controllers\api;

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

    public function getDetailMessages(Request $request){
        try {
            $data = $request->all();
            $sender = $data['teacher']['id'];
            $receiver = $data['user_id'];
            $messageCount = $data['page_id'] * 2;
            $messages = Message::whereIn('to_id',[$sender,$receiver])
                                ->whereIn('from_id',[$sender,$receiver])
                                ->skip($messageCount)->take(2)
                                ->get();
            $message = $messages->toArray();
            $responseData['messages']= $message;
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
            $userRole = UserRoles::whereNotIn('slug', ['parent'])->get();
            $userRoles = $userRole->toArray();
            $responseData['userRoles']= $userRoles;
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
            $teacher = User::where('role_id',$teacher_id)->get();
            $teachers = $teacher->toArray();
            $responseData['teachers']= $teachers;
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
            $student = User::where('role_id',$student_id)->where('division_id',$request->division)->get();
            $students = $student->toArray();
            $responseData['studentList']= $students;
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
