<?php

namespace App\Http\Controllers\api;

use App\Announcement;
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
    public function createAnnouncement(Requests\createAnnouncement $request)
    {
        $data=$request->all();
        try{
            $Batch = Batch::where('name',$data['batch'])->first();
            $Class = Classes::where('slug',$data['class'])
                ->where('batch_id', '=',$Batch->id)
                ->first();
            $Division = Division::where('slug',$data['division'])
                ->where('class_id', '=',$Class->id)
                ->first();
            $creator =User::where('remember_token',$request->token)->first();
            $eventData['user_id']=$creator->id;
            $eventData['event_type_id']=1 ; //event type is 1 for announcement
            $eventData['image']=null;
            $eventData['title']=$data['title'];
            $eventData['detail']=$data['detail'];
            $date= date("Y-m-d h:i:s", strtotime($data['date']));
            $eventData['date']=$date;
            $eventData['created_at']= Carbon::now();
            $eventData['updated_at']= Carbon::now();
            $event_id=event::insertGetId($eventData);
           if($event_id != null)
            {
                $eventUserRolesData['event_id']=$event_id;
                $eventUserRolesData['user_role_id']=$data['teacher']['role_id'];
                $eventUserRolesData['status']=0; // will be 0 by default for not published
                $eventUserRolesData['division_id']=$Division['id'];
                $eventUserRolesData['created_at']= Carbon::now();
                $eventUserRolesData['updated_at']= Carbon::now();
                event_user_roles::insert($eventUserRolesData);
                $status = 200;
                $message = "Event Created Successfully";
            }
            else{
                $status = 202;
                $message = "Event Not Found";
            }
            $students =User::where('division_id',$Division['id'])
                             ->where('role_id', '=',$data['User'])
                             ->get();
            $studentsArray=$students->toArray();
            $i=0;
            foreach($studentsArray as $value){
                $studentsId[$i]=$value['id'];
                $i++;
            }
            $size=count($studentsId);
            for($i=0;$i<$size;$i++){
                $announcementData['user_id']=$studentsId[$i];
                $announcementData['read_status']=0;//read status will be 0 by default
                $announcementData['event_id']=$event_id;
                $announcementData['created_at']= Carbon::now();
                $announcementData['updated_at']= Carbon::now();
                Announcement::insert($announcementData);
            }
        }
       catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong"  .  $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" =>$status
           ];
        return response($response, $status);
    }
    public function editAnnouncement(Requests\editAnnouncement $request, $id)
    {
           $data=$request->all();
    }
}
