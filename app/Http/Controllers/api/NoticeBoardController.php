<?php

namespace App\Http\Controllers\api;

use App\announcement_read_unread;
use App\Batch;
use App\Classes;
use App\Division;
use App\event;
use App\event_user_roles;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class NoticeBoardController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CreateAnnouncement(Requests\createAnnouncement $request,$batch,$class,$div)
    {
        $data=$request->all();
        try{
            $Batch = Batch::where('name',$batch)->first();
            $Class = Classes::where('slug',$class)
                ->where('batch_id', '=',$Batch->id)
                ->first();
            $Division = Division::where('slug',$div)
                ->where('class_id', '=',$Class->id)
                ->first();
            $creator =User::where('remember_token',$request->token)->first();
            $eventData['user_id']=$creator->id;
            $eventData['event_type_id']=1 ; //event type is 1 for announcement
            $eventData['image']=null;
            $eventData['title']=$data['title'];
            $eventData['detail']=$data['detail'];
            $eventData['date']=$data['date'];
            $eventData['created_at']= Carbon::now();
            $eventData['updated_at']= Carbon::now();
            $event_id=event::insertGetId($eventData);
           if($event_id != null)
            {
                $eventUserRolesData['event_id']=
                $eventUserRolesData['user_role_id']=$data['teacher']['role_id'];
                $eventUserRolesData['status']=0; // will be 0 by default for not published
                $eventUserRolesData['division_id']=$Division['id'];
                $eventUserRolesData['created_at']= Carbon::now();
                $eventUserRolesData['updated_at']= Carbon::now();
                event_user_roles::insert($eventUserRolesData);
                $status = 200;
                $message = "Event Updated Successfully";
            }
            else{
                $status = 202;
                $message = "Event Not Found";
            }
        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong"  .  $e->getMessage();
        }

   $studentData=User::where('id','=');



        $response = [
            "message" => $message,
            "status" =>$status
           ];
        return response($response, $status);
    }
}
