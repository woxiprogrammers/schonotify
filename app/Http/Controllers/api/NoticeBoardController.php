<?php

namespace App\Http\Controllers\api;
use App\Announcement;
use App\Batch;
use App\Classes;
use App\Division;
use App\Event;
use App\EventImages;
use App\EventUserRoles;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;


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

            $Batch = Batch::where('slug',$data['batch'])->first();
            $Class = Classes::where('slug',$data['class'])
                ->where('batch_id', '=',$Batch->id)
                ->first();
            $Division = Division::where('slug',$data['division'])
                ->where('class_id', '=',$Class->id)
                ->first();
            $creator =User::where('remember_token',$request->token)->first();
            $eventData['user_id']=$creator->id;
            $eventData['event_type_id']=1 ; //event type is 1 for announcement
            $eventData['title']=$data['title'];
            $eventData['detail']=$data['detail'];
            $date= date("Y-m-d h:i:s", strtotime($data['date']));
            $eventData['date']=$date;
            $eventData['created_at']= Carbon::now();
            $eventData['updated_at']= Carbon::now();
            $event_id=Event::insertGetId($eventData);

           if($event_id != null)
            {
                $eventUserRolesData['event_id']=$event_id;
                $eventUserRolesData['user_role_id']=$data['teacher']['role_id'];
                $eventUserRolesData['status']=0; // will be 0 by default for not published
                $eventUserRolesData['division_id']=$Division['id'];
                $eventUserRolesData['created_at']= Carbon::now();
                $eventUserRolesData['updated_at']= Carbon::now();
                EventUserRoles::insert($eventUserRolesData);
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
    public function viewAnnouncement(Requests\ViewAnnouncement $request)
    {
        $data=$request->all();
        try{
            $user =User::where('remember_token',$data['token'])->first();
            $unreadAnnouncement =Announcement::where('user_id', '=',$user['id'])
                ->where('read_status','=',0)
                ->get();
            $unreadAnnouncementArray=$unreadAnnouncement->toArray();
            $i=0;
            foreach($unreadAnnouncementArray as $value){
                $unreadAnnouncementData[$i]['event_id']=$value['event_id'];
                $event =Event::where('id', '=',$value['event_id'])->first();
                $user=User::where('id', '=',$event ['user_id'])->first();
                if($user!=null){
                    $unreadAnnouncementData[$i]['created_by']=$user['first_name']." ".$user['last_name'];
                }else{
                    $unreadAnnouncementData[$i]['created_by']=null;
                }
                $unreadAnnouncementData[$i]['title']=$event['title'];
                $unreadAnnouncementData[$i]['detail']=$event['detail'];
                $unreadAnnouncementData[$i]['date']=$event['date'];
                $i++;
            }
            $status = 200;
            $message = "Success";
            $responseData=$unreadAnnouncementData;
        }catch (\Exception $e) {
                $status = 500;
                $message = "Something went wrong"  .  $e->getMessage();
            }
        $response = [
            "message" => $message,
            "status" =>$status,
            "data" => $responseData
        ];
        return response($response, $status);
    }
    public function createAchievement(Requests\CreateAchievement $request)
    {
        $data=$request->all();
        try{
            $creator =User::where('remember_token',$request->token)->first();
            $eventData['user_id']=$creator->id;
            $eventData['event_type_id']=2 ; //event type is 2 for Achievement

                  if($request->hasFile('image')){
                       $image = $request->file('image');
                       $name = $request->file('image')->getClientOriginalName();
                       $filename = time()."_".$name;
                       $path = public_path('uploads/achievements/');
                             if (!file_exists($path)) {
                                 File::makeDirectory('uploads/achievements/', $mode = 0777, true,true);
                             }
                            $image->move($path,$filename);
                        }
                 else{
                        $filename=null;
                     }
            $eventData['title']=$data['title'];
            $eventData['detail']=$data['detail'];
            $date= date("Y-m-d h:i:s", strtotime($data['date']));
            $eventData['date']=$date;
            $eventData['created_at']= Carbon::now();
            $eventData['updated_at']= Carbon::now();
            $event_id=Event::insertGetId($eventData);

            if($event_id != null)
            {
                $eventUserRolesData['event_id']=$event_id;
                $eventUserRolesData['user_role_id']=$data['teacher']['role_id'];
                $eventUserRolesData['status']=0; // will be 0 by default for not published
                $eventUserRolesData['division_id']=0;
                $eventUserRolesData['created_at']= Carbon::now();
                $eventUserRolesData['updated_at']= Carbon::now();
                EventUserRoles::insert($eventUserRolesData);
                $eventImageData['event_id']=$event_id;
                $eventImageData['image']=$filename;
                $eventImageData['created_at']= Carbon::now();
                $eventImageData['updated_at']= Carbon::now();
                EventImages::insert($eventImageData);
                $status = 200;
                $message = "Achivement Broadcast Successfully";
            }
            else{
                $status = 202;
                $message = "Event Not Found";
            }
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong"  .  $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" =>$status
        ];
        return response($response, $status);
    }

    public function viewAchievement(Requests\ViewAnnouncement $request)
    {
        try{
            $achievementsData =Event::join('event_user_roles','events.id', '=', 'event_user_roles.event_id')
                ->where('events.event_type_id','=',2)
                ->where('event_user_roles.status','=',1)
                ->select('events.id','events.user_id','events.title','events.detail','events.date')
                ->orderBy('events.id', 'desc')
                ->get();
            $achievementDataArray=$achievementsData->toArray();
            $i=0;
            foreach($achievementDataArray as $value){
                $finalAchievementDataArray[$achievementDataArray[$i]['id']]['user_id']=$value['user_id'];
                $finalAchievementDataArray[$achievementDataArray[$i]['id']]['title']=$value['title'];
                $finalAchievementDataArray[$achievementDataArray[$i]['id']]['detail']=$value['detail'];
                $finalAchievementDataArray[$achievementDataArray[$i]['id']]['date']=$value['date'];
                     $i++;
            }
            $i=0;
            foreach($achievementDataArray as $value){
                  $result=EventImages::where('event_id','=',$value['id'])
                                             ->groupby('image')
                                             ->orderBy('event_id', 'asc')
                                             ->get();
                $resultArray=$result->toArray();
                $key=$resultArray[0]['event_id'];
                $images[$key]=$resultArray;
                          $i++;
            }
            $i=0;$j=0;
           foreach($images as $key=>$value){
               foreach($value as $val){
                   $achievementImageArray[$key]['image'][$i]=$val['image'];
                   $i++;
               }
              $i=0;
            }
            $status = 200;
            $message = "Success";
            $dataArray=$finalAchievementDataArray;
            $imageArray=$achievementImageArray;
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong"  .  $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" =>$status,
            "dataArray" => $dataArray,
            "imageArray" => $imageArray
        ];
        return response($response, $status);
    }
}
