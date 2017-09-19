<?php
namespace App\Http\Controllers\api;
use App\Announcement;
use App\Batch;
use App\PushToken;
use App\Classes;
use App\Division;
use App\Event;
use App\EventImages;
use App\EventUserRoles;
use App\ModuleAcl;
use App\Http\Controllers\CustomTraits\PushNotificationTrait;
use App\Http\Requests\createAnnouncementRequest;
use App\User;
use App\UserRoles;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
class NoticeBoardController extends Controller
{
    use PushNotificationTrait;
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
     public function viewAnnouncementParent(Request $request){
             $user=Auth::user();
             $event =Event::where('event_type_id',1)
                            -> where('status',2)
                            ->where('body_id',$user->body_id)
                            ->orderBy('id','desc')
                            ->get()
                            ->toArray();
             foreach($event as $key => $val){
                 $event[$key]['createdBy']=User::where('id',$val['created_by'])->select('first_name','last_name')->first()->toArray();
                 $event[$key]['publishedBy']=User::where('id',$val['published_by'])->select('first_name','last_name')->first();
                 if(!empty($event[$key]['publishedBy'])){
                     $event[$key]['publishedBy']->toArray();
                 }
             }
             $response=$event;
             return response($response);
     }
     public function viewAchievementParent(Request $request){
            $user=Auth::user();
            $data=$request->all();
            $parentAchievementPublished = Event::where('event_type_id','=',2)
                  ->where('status',2)
                  ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority')
                  ->where('body_id',$user->body_id)
                  ->orderBy('id','desc')
                  ->get();
            $imageArray=array();
            foreach($parentAchievementPublished as $key => $val){
                $parentAchievementPublished[$key]['path']=url();
                $parentAchievementPublished[$key]['createdBy']=User::where('id',$val['created_by'])->select('first_name','last_name')->first()->toArray();
                if($val['published_by'] != 0){
                    $parentAchievementPublished[$key]['publishedBy']=User::where('id',$val['published_by'])->select('first_name','last_name')->first()->toArray();
                }
                $imageArray[$key]= EventImages::where('event_id',$val['id'])->select('event_id','image')->get()->toArray();
             }
             $response=[
                "imageData"=>$imageArray,
                "teacherAchievement"=>$parentAchievementPublished
             ];
             return response()->json($response);
    }
     public function requestToPublishAnnouncement(Request $request,$id){
          $announcement['status']=1;
          $query = Event::where('id',$id)->update($announcement);
            if($query == 1){
                $status = 200;
                $message = "Publish request sent to admin successfully !";
            }else{
                $status = 500;
                $message = "Something went wrong !";
           }
            $response = [
                "message" => $message,
                "status" =>$status
            ];
      return response($response);
     }
    public function announcementCreate(Request $request){
        $user=Auth::user();
        $data=$request->all();
        $module_id=13;
        $acl=1;
        $isCreate=ModuleAcl::where('user_id',$data['user_id'])->where('acl_id',$acl)->where('module_id',$module_id)->get()->toArray();
        if(!empty($isCreate)){
        try{
            $data=$request->all();
            $announcement['title']=$data['title'];
            $announcement['detail']=$data['detail'];
            $announcement['created_by']=$data['user_id'];
            $announcement['created_at']=Carbon::now();
            $announcement['status']=$data['status'];
            $announcement['priority']=$data['priority'];
            $announcement['event_type_id']=1;
            $announcement['body_id']=$data['teacher']['body_id'];
            $new_event=Event::insertGetId($announcement);
            foreach($data['teacherrr'] as $value){
                $announcementData['event_id']=$new_event;
                $announcementData['user_id']=$value;
                EventUserRoles::insert($announcementData);
            }
            foreach($data['studenttt'] as $value){
                $announcementData['event_id']=$new_event;
                $announcementData['user_id']=$value;
                EventUserRoles::insert($announcementData);
            }
            foreach($data['adminnn'] as $value){
                $announcementData['event_id']=$new_event;
                $announcementData['user_id']=$value;
                EventUserRoles::insert($announcementData);
            }
            $status=200;
            $message="Announcement Created Successfully !";
        }catch(\Exception $e){
            $status=500;
            $message="Something went wrong !";
          dd($e->getMessage());
        }
        }else{
            $status=401;
            $message="You do not have ACL for this module !";
        }
        $response=[
            "status" => $status,
            "message" => $message
        ];
         return response($response);
    }
    public function createAnnouncement(Request $request)
    {
        $user=Auth::user();
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
            $eventData['body_id']=$user->body_id;
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
            Log::info($message);
        }
        $response = [
            "message" => $message,
            "status" =>$status
           ];
        return response($response, $status);
    }
    public function editAnnouncement(Requests\editAnnouncement $request, $id)
    {

    }
    public  function publishAchievement(Request $request){
        $data=$request->all();
        try{
            $editAchievement['title'] = $data['title'];
            $editAchievement['detail'] = $data['detail'];
            $editAchievement['status'] = $data['status'];
            $update=Event::where('id',$data['event_id'])->update($editAchievement);
            $message="Achievement published successfully";
            $status=200;

        }catch (\Exception $e){
            $status = 500;
            $message = "Something went wrong"  .  $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" =>$status
        ];
        return response($response);
    }
    public function editAchievement(Request $request)
    {
        $data=$request->all();
        try{
            $editAchievement['title'] = $data['title'];
            $editAchievement['detail'] = $data['detail'];
            $update=Event::where('id',$data['event_id'])->update($editAchievement);
            $message="Achievement updated successfully";
            $status=200;

        }catch (\Exception $e){
            $status = 500;
            $message = "Something went wrong"  .  $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" =>$status
        ];
        return response($response);
    }
    public function viewAnnouncement(Request $request)
    {
        $user=$request->all();
        $eventUnpublished =Event::where('event_type_id',1)
            ->where('body_id',$user['teacher']['body_id'])
            ->where('created_by',$user['teacher']['id'])
            ->whereIn('status',[0,1])
            ->orderBy('id','desc')
            ->get()
            ->toArray();
        $assignedEvents = EventUserRoles::where('user_id',$user['teacher']['id'])
                                        ->lists('event_id');
        $announcement =Event::where('event_type_id',1)
                       ->where('body_id',$user['teacher']['body_id'])
                       ->whereIn('id',$assignedEvents)
                       ->where('status',2)
                       ->orderBy('id','desc')
                       ->get()
                       ->toArray();
        if(empty($eventUnpublished)){
            $event = $announcement;
        }else if(empty($announcement)){
            $event = $eventUnpublished;
        }else{
            $event = array_merge($eventUnpublished,$announcement);
        }
        usort($event, function ($item1, $item2) {
            return $item1['id'] < $item2['id'];
        });
        foreach($event as $key => $val){
            $event[$key]['createdBy']=User::where('id',$val['created_by'])->select('first_name','last_name')->first()->toArray();
            $event[$key]['publishedBy']=User::where('id',$val['published_by'])->select('first_name','last_name')->first();
            if(!empty($event[$key]['publishedBy'])){
                $event[$key]['publishedBy']->toArray();
            }
        }
        $response=$event;
        return response($response);
    }
    public function deleteAchievement($id){
                   try{
                       $a=EventImages::where('event_id',$id)->delete();
                       $ab=Event::where('id',$id)->delete();
                       $status = 200;
                       $message = "Achievement deleted successfully !";
                   }catch (\Exception $e) {
                       $status = 500;
                       $message = "Something went wrong";
                   }
        $response=[
                   "status" => $status,
                   "message" => $message
                  ];
        return response($response);
    }
    public function getAdmin(Request $request){
          $user = $request->all();
          $response=User::where('role_id',1)->where('body_id',$user['teacher']['body_id'])->select()->get();
        return response($response);
    }
    public function getTeacher(Request $request){
          $user = $request->all();
          $response=User::where('role_id',2)->where('body_id',$user['teacher']['body_id'])->select()->get();
        return response($response);
    }
    public function createAchieve(Request $request){
        $data=$request->all();
        $user=$request->teacher;
        try{
            $module_id=12;
            $acl=1;
            $isCreate=ModuleAcl::where('user_id',$data['user_id'])->where('acl_id',$acl)->where('module_id',$module_id)->get()->toArray();
            if(!empty($isCreate)){
                $achievement['title']=$data['title'];
                $achievement['detail']=$data['detail'];
                $achievement['status']=0;
                $achievement['event_type_id']=2;
                $achievement['created_by']=$user->id;
                $achievement['created_at']=Carbon::now();
                $achievement['body_id']=$user->body_id;
                $a=Event::insertGetId($achievement);
                $tempImagePath = "uploads/achievement/events/".$a.'/';
                $path = public_path('uploads/achievement/events/'.$a);
                if (!file_exists($path)) {
                    File::makeDirectory('uploads/achievement/events/'.$a, $mode = 0777, true,true);
                }
                foreach($data['image'] as $key => $value){
                    $mytime = Carbon::now();
                    $tempImageName = (strtotime($mytime)).$key.".jpg";
                    if($data['image'] != null){
                    $storeAchievementImages['event_id'] = $a;
                    $storeAchievementImages['image'] = $tempImageName;
                    $storeAchievementImages['created_at'] = Carbon::now();
                    EventImages::insert($storeAchievementImages);
                    }
                    file_put_contents($tempImagePath.$tempImageName,base64_decode($value));
                }
                if($data['image'] == null){
                    $storeAchievementImages['event_id'] = $a;
                    $storeAchievementImages['image'] = null;
                    $storeAchievementImages['created_at'] = Carbon::now();
                    $storeAchievementImages['updated_at'] = Carbon::now();
                    EventImages::insert($storeAchievementImages);
                }
                $status=200;
                $message="Achievement created successfully !";
            }
            else{
                $status=401;
                $message="You do not have ACL for this module !";
            }
        }catch(\Exception $e){
            $status=500;
            $message=$e -> getMessage();
        }
        $response=[
            "status" => $status,
            "message" => $message
        ];
        return response($response);
    }
    public function createAchievement(Requests\CreateAchievement $request)
    {
        $user=Auth::user();
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
            $eventData['body_id']= $user->body_id;
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
                $message = "Achievement Broadcasted Successfully";
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
    public function viewAchievement(Request $request,$id){
      $user = $request->teacher;
      if($id == 'teacher'){
           $user_id=$user->id;
           $role_id=UserRoles::where('slug',$id)->pluck('id');
           $teacherAchievementAllPublished = Event::where('event_type_id','=',2)
              ->wherein('status',[0,1])
              ->where('events.body_id',$user->body_id)
              ->where('created_by',$user_id)
              ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority')
              ->orderBy('id','desc')
              ->get();
           $teacherAchievementPublished = Event::where('event_type_id','=',2)
                 ->where('status',2)
                 ->where('events.body_id',$user->body_id)
                 ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority')
                 ->orderBy('id','desc')
                 ->get();
                 if((!empty($teacherAchievementPublished->toArray())) && (!empty($teacherAchievementAllPublished->toArray()))){
                   $teacherAchievementAllPublished = array_merge($teacherAchievementAllPublished->toArray(),$teacherAchievementPublished->toArray());
                 }else if(!empty($teacherAchievementAllPublished->toArray())){
                   $teacherAchievementAllPublished = $teacherAchievementAllPublished;
                 }else{
                   $teacherAchievementAllPublished = $teacherAchievementPublished;
                 }
          if($role_id == 0)
          {
              $teacherAchievementSelfPendingAndCreatedLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                  ->where('event_type_id','=',2)
                  ->where('events.body_id',$user->body_id)
                  ->wherein('status',[0,1])
                  ->orderBy('id','desc')
                  ->min('events.created_at');
              $teacherAchievementAllPublishedLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                  ->where('event_type_id','=',2)
                  ->where('events.body_id',$user->body_id)
                  ->where('status','=',2)
                  ->min('events.created_at');
              $arrayMergedForLastDate = array_merge(array($teacherAchievementSelfPendingAndCreatedLastDate),array($teacherAchievementAllPublishedLastDate));
              $lastDate = date('');
              foreach(array_unique($arrayMergedForLastDate) as $row){
                  if($row != null){
                      if(strtotime($lastDate) < strtotime($row)){
                          $lastDate = $row;
                      }
                  }
              }
              $teacherAchievement = json_decode(json_encode($teacherAchievementAllPublished),true);
          }else{
              $teacherAchievement = json_decode(json_encode($teacherAchievementAllPublished),true);
          }
          $imageArray=array();
           foreach($teacherAchievement as $key => $val){
               $teacherAchievement[$key]['path']=url();
               $teacherAchievement[$key]['createdBy']=User::where('id',$val['created_by'])->select('first_name','last_name')->first()->toArray();
               if($val['published_by'] != 0){
                   $teacherAchievement[$key]['publishedBy']=User::where('id',$val['published_by'])->select('first_name','last_name')->first()->toArray();
               }
               $imageArray[$key]= EventImages::where('event_id',$val['id'])->select('event_id','image')->get()->toArray();
           }
           $response=[
               "imageData"=>$imageArray,
               "teacherAchievement"=>$teacherAchievement
           ];
      }else{
               $teacherAchievementPublished = Event::where('event_type_id','=',2)
                      ->where('status',2)
                      ->where('events.body_id',$user->body_id)
                      ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority')
                      ->orderBy('id','desc')
                      ->get();
                      $imageArray=array();
               foreach($teacherAchievement as $key => $val){
                   $teacherAchievement[$key]['path']=url();
                   $teacherAchievement[$key]['createdBy']=User::where('id',$val['created_by'])->select('first_name','last_name')->first()->toArray();
                   if($val['published_by'] != 0){
                       $teacherAchievement[$key]['publishedBy']=User::where('id',$val['published_by'])->select('first_name','last_name')->first()->toArray();
                   }
                   $imageArray[$key]= EventImages::where('event_id',$val['id'])->select('event_id','image')->get()->toArray();
               }
               $response=[
                   "imageData"=>$imageArray,
                   "teacherAchievement"=>$teacherAchievement
               ];
         }
         return response()->json($response);
   }
}
