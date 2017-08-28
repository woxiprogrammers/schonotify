<?php
namespace App\Http\Controllers;
use App\Body;
use App\Division;
use App\Event;
use App\EventImages;
use App\Http\Controllers\CustomTraits\PushNotificationTrait;
use App\User;
use App\UserRoles;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\Exception;
class EventController extends Controller
{
    use PushNotificationTrait;
    public function __construct(){
        $this->middleware('db');
        $this->middleware('auth');
    }
    /*
     +   * Function Name: index
     +   * Param: $id
     +   * Return: by default all events.
     +   * Desc: it returns by default all events and selected category id to view.
     +   * Developed By: Suraj Bande
     +   * Date: 5/3/2016
     +   */
    public function index(Requests\WebRequests\EventRequest $request,$id){
        if($request->authorize()===true){
            Session::put('event_selection_id',$id);
            $eventSelectionId = session('event_selection_id');
            return view('admin.event')->with(compact('eventSelectionId'));
        }else{
            return Redirect::to('/');
        }
    }
    /*
     +   * Function Name: saveEvent
     +   * Param: $request
     +   * Return: save event.
     +   * Desc: it will save event data in database or save and publish event.
     +   * Developed By: Suraj Bande
     +   * Date: 5/3/2016
     +   */
    public function saveEvent(Requests\WebRequests\EventRequest $request) {
        if($request->authorize() === true){
            $user=Auth::User();
            $endDate = date_format(date_create($request->eventEndDate),'Y-m-d H:i:s');
            $insertData['title'] = $request->eventName;
            $insertData['event_type_id'] = 3;
            $insertData['detail'] = $request->eventDescription;
            $insertData['start_date'] = date_format(date_create($request->eventStartDate),'Y-m-d H:i:s');
            $insertData['end_date'] = $endDate;
            if(Input::hasFile('image')){
                $image = $request->file('image');
                $name = $request->file('image')->getClientOriginalName();
                $filename = time()."_".$name;
                $path = public_path('uploads/events/');
                if (! file_exists($path)) {
                    File::makeDirectory('uploads/events/', $mode = 0777, true, true);
                }
                $image->move($path,$filename);
            }
            else{
                $filename = null;
            }
            $insertData['created_by'] = $user->id;
            if($request->hiddenField == "Publish") {
                if($user->role_id != 1)
                {
                    $insertData['published_by'] = 0;
                    $insertData['status'] = 1;
                }else{
                    $insertData['published_by'] = $user->id;
                    $insertData['status'] = 2;
                }
            }else{
                $insertData['published_by'] = 0;
                $insertData['status'] = 0;
            }
            $insertData['created_at'] = Carbon::now();
            $insertData['updated_at'] = Carbon::now();
            $insertData['body_id'] = $user->body_id;
            $lastInsertId=Event::insertGetId($insertData);
            $insertImageData['image'] = $filename;
            $insertImageData['event_id'] = $lastInsertId;
            $insertImageData['created_at'] = Carbon::now();
            $insertImageData['updated_at'] = Carbon::now();
            $result=EventImages::insert($insertImageData);
            if($result){
                if($request->hiddenField == "Publish"){
                    if($user->role_id != 1){
                        Session::flash('message-success','Event created and sent for publish successfully !');
                        return 1;
                    } else {
                        Session::flash('message-success','Event created and published successfully !');
                        $title="Event";
                        $message="New Event Created";
                        $allUser=1;
                        $push_users=null;
                        $this->CreatePushNotification($title,$message,$allUser,$push_users);
                        return 1;
                    }
                }else{
                    Session::flash('message-success','Event created successfully !');
                    return 1;
                }
            }
        } else {
            return 0;
        }
    }
    /*
         +   * Function Name: publishEditEvent
         +   * Param: $request,$id
         +   * Return: status of event publish.
         +   * Desc: it will return published event if it is already created.
         +   * Developed By: Suraj Bande
         +   * Date: 13/3/2016
         +   */
    public function publishEditEvent(Requests\WebRequests\EventPublishRequest $request,$id){
        $user=Auth::User();
        $publish=Event::find($id);
         if($publish->created_by == $user->id) {
             if($user->role_id != 1) {
                 $publish->published_by = 0;
                 $publish->status = 1;
             } else {
                 $publish->published_by = $user->id;
                 $publish->status = 2;
             }
             $publish->updated_at = Carbon::now();
             $publish->save();
             if($user->role_id != 1)
             {
                 Session::flash('message-success','Event sent for publish successfully !');
                 return 1;
             } else {
                 Session::flash('message-success','Event published successfully !');
                 $title="Event";
                 $message="New Event Created";
                 $allUser=1;
                 $push_users=null;
                 $this->CreatePushNotification($title,$message,$allUser,$push_users);
                 return 1;
             }
         } else {
             if($request->authorize() === true) {
                 if($user->role_id != 1) {
                     $publish->published_by = 0;
                     $publish->status = 1;
                 } else {
                     $publish->published_by = $user->id;
                     $publish->status = 2;
                 }
                 $publish->updated_at = Carbon::now();
                 $publish->save();
                 if($user->role_id != 1)
                 {
                     Session::flash('message-success','Event sent for publish successfully !');
                     return 1;
                 } else {
                     $title="Event";
                     $message="New Event Created";
                     $allUser=1;
                     $push_users=null;
                     $this->CreatePushNotification($title,$message,$allUser,$push_users);
                     Session::flash('message-success','Event published successfully !');
                     return 1;
                 }
             }
         }
    }
        /*
         +   * Function Name: saveEventCheckAcl
         +   * Param: $request
         +   * Return: access true or false.
         +   * Desc: it will check acl to create event.
         +   * Developed By: Suraj Bande
         +   * Date: 8/3/2016
         +   */
    public function saveEventCheckAcl(Requests\WebRequests\EventCreateRequest $request)
    {
        if($request->authorize() === true) {
            return 1;
        } else {
            return 0;
        }
    }
    /*
         +   * Function Name: editEventAcl
         +   * Param: $request
         +   * Return: access true or false.
         +   * Desc: it will check acl to edit event.
         +   * Developed By: Suraj Bande
         +   * Date: 8/3/2016
         +   */
    public function editEventAcl(Requests\WebRequests\EditEventRequest $request)
    {
        if($request->authorize() === true) {
            return 1;
        } else {
            return 0;
        }
    }
    /*
     +   * Function Name: getEvents
     +   * Param: $status
     +   * Return: get events.
     +   * Desc: it will return events array on the basis of filter status selected.
     +   * Developed By: Suraj Bande
     +   * Date: 5/3/2016
     +   */
    public function getEvents($status){
        $user = Auth::User();
        $statusArray = array();
        if($user->role_id != 1) {
            if($status == 1) {
                $statusArray = ['0','1','2'];
                $selfEvents = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',$statusArray)
                    ->where('created_by','=',$user->id)
                    ->where('body_id',$user->body_id)
                    ->where('event_type_id','=',3)
                    ->select('events.id','title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by');
                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',['2'])
                    ->where('event_type_id','=',3)
                    ->where('body_id',$user->body_id)
                    ->union($selfEvents)
                    ->select('events.id','title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
                    ->get();
            } else if($status == 2) {
                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',['1'])
                    ->where('event_type_id','=',3)
                    ->where('body_id',$user->body_id)
                    ->where('created_by','=',$user->id)
                    ->select('events.id','title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
                    ->get();
            } else {
                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',['2'])
                    ->where('event_type_id','=',3)
                    ->where('body_id',$user->body_id)
                    ->select('events.id','title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
                    ->get();
            }
        } else {
            if($status == 1) {
                $statusArray = ['0','1','2'];
                $selfEvents = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',$statusArray)
                    ->where('created_by','=',$user->id)
                    ->where('body_id',$user->body_id)
                    ->where('event_type_id','=',3)
                    ->select('events.id','title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by');
                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',['1','2'])
                    ->where('event_type_id','=',3)
                    ->where('body_id',$user->body_id)
                    ->union($selfEvents)
                    ->select('events.id','title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
                    ->get();
            } else if( $status == 2 ) {
                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->where('status',1)
                    ->where('event_type_id','=',3)
                    ->where('body_id',$user->body_id)
                    ->select('events.id','title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
                    ->get();
            } else {
                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->where('status',2)
                    ->where('event_type_id','=',3)
                    ->where('body_id',$user->body_id)
                    ->select('events.id','title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
                    ->get();
            }
        }
    return $events;
    }
    /*
     +   * Function Name: getUserEvent
     +   * Param: $id
     +   * Return: return array of user details.
     +   * Desc: it will return first name last name array of user.
     +   * Developed By: Suraj Bande
     +   * Date: 5/3/2016
     +   */
    public function getUserEvent($id)
    {
        $user=User::where('id','=',$id)->select('first_name','last_name')->get();
        return $user;
    }
    /*
     +   * Function Name: deleteEvent
     +   * Param: $id
     +   * Return: 1.
     +   * Desc: it will delete event.
     +   * Developed By: Suraj Bande
     +   * Date: 15/3/2016
     +   */
    public function deleteEvent(Requests\WebRequests\DeleteEventRequest $request,$id)
    {
        $delete = Event::join('event_images','events.id','=','event_images.event_id')->where('events.id','=',$id)->first();
        if($delete->created_by == Auth::User()->id) {
            if($delete->image != "" || $delete->image != null) {
                unlink('uploads/events/'.$delete->image);
            }
            EventImages::where('event_id',$delete->id)->delete();
            Event::where('id','=',$id)->delete();
            Session::flash('message-success','Event deleted successfully !');
            return 1;
        } else {
            if($request->authorize() === true)
            {
                if($delete->image != "" || $delete->image != null) {
                    unlink('uploads/events/'.$delete->image);
                }
                EventImages::where('event_id',$delete->id)->delete();
                Event::where('id','=',$id)->delete();
                Session::flash('message-success','Event deleted successfully !');
                return 1;
            }else{
                return 0;
            }
        }
    }
    /*
     +   * Function Name: saveEditEvent
     +   * Param: $request
     +   * Return: 1.
     +   * Desc: it will update event.
     +   * Developed By: Suraj Bande
     +   * Date: 15/3/2016
     +   */
    public function saveEditEvent(Requests\WebRequests\EditEventRequest $request)
    {
        if($request->authorize()) {
            $endDate = date_format(date_create($request->eventEndDate),'Y-m-d H:i:s');
            $event = Event::join('event_images','event_images.event_id','=','events.id')->where('events.id','=',$request->hiddenEventId)->first();
            $eventImage = EventImages::where('event_id','=',$request->hiddenEventId)->first();
            $eventToUpdate = Event::where('id','=',$request->hiddenEventId)->first();
            if($request->isNewImage == 1)
            {
                if($request->hasFile('image'))
                {
                    if($event->image != null)
                    {
                        unlink('uploads/events/'.$event->image);
                    }
                    $image = $request->file('image');
                    $name = $request->file('image')->getClientOriginalName();
                    $filename = time()."_".$name;
                    $path = public_path('uploads/events/');
                    if (! file_exists($path)) {
                        File::makeDirectory('uploads/events/', $mode = 0777, true, true);
                    }
                    $image->move($path,$filename);
                    //update image
                } else {
                    unlink('uploads/events/'.$event->image);
                    $filename = null;
                    //delete existing image
                }
            }else if($request->isNewImage == 2) {
                //delete existing image
                unlink('uploads/events/'.$event->image);
                $filename = null;
            } else {
                $filename = $eventImage->image;
                //no change in image
            }
            $eventImage->image = $filename;
            $eventImage->updated_at = Carbon::now();
            $eventImage->save();
            $eventToUpdate->title = $request->eventName;
            $eventToUpdate->detail = $request->eventDescription;
            $eventToUpdate->start_date = date_format(date_create($request->eventStartDate),'Y-m-d H:i:s');
            $eventToUpdate->end_date = $endDate;
            $eventToUpdate->updated_at = Carbon::now();
            $eventToUpdate->save();
            Session::flash('message-success','Event updated successfully !');
            return 1;
        }
    }
}
