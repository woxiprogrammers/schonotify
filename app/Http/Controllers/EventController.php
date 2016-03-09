<?php

namespace App\Http\Controllers;

use App\Body;
use App\Division;
use App\Event;
use App\EventImages;
use App\User;
use App\UserRoles;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\Exception;

class EventController extends Controller
{
    public function __construct()
    {
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

    public function index(Requests\WebRequests\EventRequest $request,$id)
    {
        if($request->authorize()===true)
        {

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
     +   * Desc: it will save event data in database.
     +   * Developed By: Suraj Bande
     +   * Date: 5/3/2016
     +   */

    public function saveEvent(Requests\WebRequests\EventRequest $request)
    {
        if($request->authorize()){

            $user=Auth::User();

            $insertData['title'] = $request->eventName;
            $insertData['event_type_id'] = 1;
            $insertData['detail'] = $request->eventDescription;
            $insertData['start_date'] = date_format(date_create($request->eventStartDate),'Y-m-d H:i:s');
            $insertData['end_date'] = date_format(date_create($request->eventEndDate),'Y-m-d H:i:s');

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
            $insertData['published_by'] = 0;
            $insertData['created_at'] = Carbon::now();
            $insertData['updated_at'] = Carbon::now();

            $lastInsertId=Event::insertGetId($insertData);

            $insertImageData['image'] = $filename;
            $insertImageData['event_id'] = $lastInsertId;
            $insertImageData['created_at'] = Carbon::now();
            $insertImageData['updated_at'] = Carbon::now();

            $result=EventImages::insert($insertImageData);

            if($result){
                Session::flash('message-success','Event created successfully !');
                return 1;
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
     +   * Function Name: getEvents
     +   * Param: $status
     +   * Return: get events.
     +   * Desc: it will return events array on the basis of filter status selected.
     +   * Developed By: Suraj Bande
     +   * Date: 5/3/2016
     +   */

    public function getEvents($status)
    {

        $user = Auth::User();

        $statusArray = array();

        if($user->role_id != 1) {

            if($status == 1) {
                $statusArray = ['0','1','2'];

                $selfEvents = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',$statusArray)
                    ->where('created_by','=',$user->id)
                    ->where('event_type_id','=',1)
                    ->select('title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by');

                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',['2'])
                    ->where('event_type_id','=',1)
                    ->union($selfEvents)
                    ->select('title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
                    ->get();

            } else if($status == 2) {

                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',['1'])
                    ->where('event_type_id','=',1)
                    ->where('created_by','=',$user->id)
                    ->select('title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
                    ->get();

            } else {
                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',['2'])
                    ->where('event_type_id','=',1)
                    ->select('title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
                    ->get();
            }

        } else {
            if($status == 1) {
                $statusArray = ['0','1','2'];

                $selfEvents = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',$statusArray)
                    ->where('created_by','=',$user->id)
                    ->where('event_type_id','=',1)
                    ->select('title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by');

                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->wherein('status',['1','2'])
                    ->where('event_type_id','=',1)
                    ->union($selfEvents)
                    ->select('title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
                    ->get();

            } else if( $status == 2 ) {

                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->where('status',1)
                    ->where('event_type_id','=',1)
                    ->select('title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
                    ->get();

            } else {

                $events = DB::table('events')->join('event_images','events.id','=','event_images.event_id')
                    ->where('status',2)
                    ->where('event_type_id','=',1)
                    ->select('title','start_date as start','end_date as end','detail as content','status','image','events.created_at','events.updated_at','events.created_by','events.published_by')
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
}
