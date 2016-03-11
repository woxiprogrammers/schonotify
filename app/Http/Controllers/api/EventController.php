<?php

namespace App\Http\Controllers\api;

use App\Event;
use App\EventImages;
use App\EventTypes;
use App\User;
use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class EventController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }

    /*
  * Function Name : viewFiveEvent
  * Param : Request $requests
  * Return : $message $status , recent 5 event array
  * Desc : when teacher want to see events then by default he/she can able to see latest five events.
  * Developed By : Amol Rokade
  * Date : 3/3/2016
  */

    public function viewFiveEvent(Requests\EventRequest $request)
    {
        try {
            $finalFiveEvents = array();
            $recentFiveEvents = array();
            $eventTypesId = EventTypes::where('slug',['event'])->pluck('id');
            $recentFiveEvents = Event::where('event_type_id' , '=' , $eventTypesId)
                ->where('status','=',2)
                ->orderBy('start_date', 'desc')
                ->get()
                ->take(5);
            $counter = 0;
            foreach ($recentFiveEvents as $event) {
                $finalFiveEvents[$counter]['id'] =  $event['id'];
                $creatorUser = User::where ('id','=', $event['created_by'])->select('first_name','last_name')->first();
                $finalFiveEvents[$counter]['created_by'] = $creatorUser['first_name']." ".$creatorUser['last_name'];
                $publishedUser = User::where ('id','=', $event['published_by'])->select('first_name','last_name')->first();
                $finalFiveEvents[$counter]['published_by'] = $publishedUser['first_name']." ".$publishedUser['last_name'];
                $finalFiveEvents[$counter]['status'] = $event['status'];
                $finalFiveEvents[$counter]['title'] = $event['title'];
                $finalFiveEvents[$counter]['detail'] = $event['detail'];
                $finalFiveEvents[$counter]['start_date'] = date("j M y, g:i a",strtotime( $event['start_date']));
                $finalFiveEvents[$counter]['end_date'] = date("j M y, g:i a",strtotime( $event['end_date']));
                $counter++;
            }
            $status = 200;
            $message = 'Successfully Listed';
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalFiveEvents
        ];
        return response($response, $status);
    }

    /*
    * Function Name : viewMonthsEvent
    * Param : Request $requests , $month_id
    * Return : $message $status , event array of current month
    * Desc : when user want to see events the months from Jan to Dec of current month selected by user.
    * Developed By : Amol Rokade
    * Date : 3/3/2016
    */

    public function viewMonthsEvent(Requests\EventRequest $request, $month_id)
    {
        try {
            $data = $request->all();
            $monthsEvents = array();
            $pendingEvents = array();
            $publishedEvents = array();
            $finalMonthsEvents = array();
            $year = date('Y');
            $eventTypesId = EventTypes::where('slug',['event'])->pluck('id');
            $startDate = $year."-".$month_id ."-"."01"." 00".":"."00".":"."00";
            $endDate = $year."-".$month_id ."-"."31"." 23".":"."59".":"."59";
            $pendingEvents = DB::table('events')->where('event_type_id','=',$eventTypesId)
                ->where('created_by',$data['teacher']['id'])
                ->where('status','=',1) //1 is for pending events i.e. Not published and not in draft
                ->where('start_date','>=',$startDate)
                ->where('start_date','<=',$endDate);
            $publishedEvents = DB::table('events')->where('event_type_id','=',$eventTypesId)
                ->where('status','=',2) //1 is for pending events i.e. Not published.
                ->where('start_date','>=',$startDate)
                ->where('start_date','<=',$endDate);
            $monthsEvents = DB::table('events')->where('event_type_id','=',$eventTypesId)
                ->where('created_by',$data['teacher']['id'])
                ->where('status','=',0) // 0 is for draft
                ->union($pendingEvents)
                ->union($publishedEvents)
                ->where('start_date','>=',$startDate)
                ->where('start_date','<=',$endDate)
                ->orderBy('id','desc')
                ->get();
            $counter = 0;
            foreach ($monthsEvents as $event) {
                $finalMonthsEvents[$counter]['id'] =  $event->id;
                $creatorUser = User::where ('id','=', $event->created_by)->select('first_name','last_name')->first();
                $finalMonthsEvents[$counter]['created_by'] = $creatorUser['first_name']." ".$creatorUser['last_name'];
                $publishedUser = User::where ('id','=', $event->published_by)->select('first_name','last_name')->first();
                $finalMonthsEvents[$counter]['published_by'] = $publishedUser['first_name']." ".$publishedUser['last_name'];
                $finalMonthsEvents[$counter]['status'] = $event->status;
                $finalMonthsEvents[$counter]['title'] = $event->title;
                $finalMonthsEvents[$counter]['detail'] = $event->detail;
                $finalMonthsEvents[$counter]['start_date'] =  date("j M y, g:i a",strtotime( $event->start_date));
                $finalMonthsEvents[$counter]['end_date'] = date("j M y, g:i a",strtotime( $event->end_date));
                $counter++;
            }
            $status = 200;
            $message = 'Successfully Listed';
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalMonthsEvents
        ];
        return response($response, $status);
    }

    /*
    * Function Name : createEvent
    * Param : Request $requests
    * Return : $message $status
    * Desc : when teacher can create event if he/she have an ACL.
    * Developed By : Amol Rokade
    * Date : 7/3/2016
    */

    public function createEvent(Requests\EventRequest $request)
    {
        try {
            $data = $request->all();
            $eventTypesId = EventTypes::where('slug',['event'])->pluck('id');
            $eventData['event_type_id'] = $eventTypesId;
            $eventData['created_by'] = $data['teacher']['id'];
            $eventData['published_by'] = null;
            $eventData['title'] = $data['title'];
            $eventData['status'] = 0;
            $eventData['detail'] = $data['detail'];
            $eventData['priority'] = 0;
            $eventData['start_date'] = $data['start_date'];
            $eventData['end_date'] = $data['end_date'];
            $eventData['created_at'] = Carbon::now();
            $eventData['updated_at'] = Carbon::now();
            $event_id = Event::insertGetId($eventData);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = $request->file('image')->getClientOriginalName();
                $filename = time()."_".$name;
                $path = public_path('uploads/events/');
                if (!file_exists($path)) {
                    File::makeDirectory('uploads/events/', $mode = 0777, true,true);
                }
                $image->move($path,$filename);
            }
            else{
                $filename = null;
            }
            if($event_id != null) {
                $eventImageData['event_id'] = $event_id;
                $eventImageData['image'] = $filename;
                $eventImageData['created_at'] = Carbon::now();
                $eventImageData['updated_at'] = Carbon::now();
                EventImages::insert($eventImageData);
            }
            $status = 200;
            $message = 'Event Successfully Created';
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status
        ];
        return response($response, $status);
    }

    /*
    * Function Name : editEvent
    * Param : Request $requests
    * Return : $message $status
    * Desc : Teacher can edit unpublished events if he/she have an ACL.
    * Developed By : Amol Rokade
    * Date : 8/3/2016
    */

    public function editEvent(Requests\EventRequest $request)
    {
        try {
            $data = $request -> all();
            $event_id = Event::where('id','=',$data['event_id'])->get()->toArray();
            if(!Empty($event_id)) {
                $eventData['title'] = $data['title'];
                $eventData['detail'] = $data['detail'];
                $eventData['priority'] = 0;
                $eventData['start_date'] = $data['start_date'];
                $eventData['end_date'] = $data['end_date'];
                $eventData['updated_at'] = Carbon::now();
                Event::where('id','=',$data['event_id'])->update($eventData);
                $image = EventImages::where('event_id','=',$data['event_id'])->pluck('image');
                if(!Empty($image)) {
                    unlink('uploads/events/'."".$image);
                }
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $name = $request->file('image')->getClientOriginalName();
                    $filename = time()."_".$name;
                    $path = public_path('uploads/events/');
                    if (!file_exists($path)) {
                        File::makeDirectory('uploads/events/', $mode = 0777, true,true);
                    }
                    $image->move($path,$filename);
                } else {
                    $filename = null;
                }
                $eventImageData['image'] = $filename;
                $eventImageData['updated_at'] = Carbon::now();
                EventImages::where('event_id','=',$data['event_id'])->update($eventImageData);
                $status = 200;
                $message = 'Event Successfully updated';
            } else {
                $status = 406;
                $message = 'Event Not Found';
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status
        ];
        return response($response, $status);
        }

    /*
    * Function Name : sendForPublishEventTeacher
    * Param : Request $requests , $event_id
    * Return : $message $status
    * Desc : Teacher can send to publish unpublished events if he/she have an ACL of publish.
    * Developed By : Amol Rokade
    * Date : 8/3/2016
    */
    public function sendForPublishEventTeacher(Requests\SendForPublishEventRequest $request)
    {
        try {
            $data = $request->all();
            $eventStatus = Event::where('id','=',$data['event_id'])->pluck('status');
            if($eventStatus == "0" | (!Empty($eventStatus))) {
                if($eventStatus == "1") {
                    $message = "Sorry!! This event already submited for publish";
                    $status = 406;
                } else {
                    Event::where('id', '=' , $data['event_id'])->update(array('status' => 1));
                    $message = "Event Successfully send for publish";
                    $status = 200;
                }
            } else {
                $message = "Sorry!! This event can not be send for publish";
                $status = 406;
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status
        ];
        return response($response, $status);
    }

        /*
    * Function Name : deleteEventTeacher
    * Param : Request $requests
    * Return : $message $status
    * Desc : Teacher can delete his/her own unpublished events if he/she have an ACL.
    * Developed By : Amol Rokade
    * Date : 8/3/2016
    */

    public function deleteEventTeacher(Requests\DeleteEventRequest $request)
    {
        try {
            $data = $request->all();
            $eventStatus = Event::where('id','=',$data['event_id'])->pluck('status');
            $createdBy = Event::where('id','=',$data['event_id'])->pluck('created_by');
            if($eventStatus == "0" || (!Empty($eventStatus)) && $eventStatus != "2" && $eventStatus != "1") {
                Event::where('id', '=' , $data['event_id'])->delete();
                $message = "Event Successfully Deleted";
                $status = 200;
            } else {
                $message = "Sorry!! This event can not be delete";
                $status = 406;
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status
        ];
        return response($response, $status);
    }

    /*
    * Function Name : detailView
    * Param : Request $requests, $event_id
    * Return : $message $status
    * Desc : Teacher can view detail event . required only image as in listing all data all ready passed
    * Developed By : Amol Rokade
    * Date : 8/3/2016
    */

    public function detailView(Requests\EventRequest $request ,$event_id)
    {
        try {
            $imageData = array();
            $eventImages = array();
            $eventId = Event::where('id','=',$event_id)->first();
            if (!Empty($eventId)) {
                $message = "Successfully Listed";
                $status = 200;
                $eventImages = EventImages::where('event_id','=',$eventId['id'])->pluck('image');
            } else {
                $status = 406;
                $message = "Sorry ! No event found";
            }
            $imageData['event_id'] = $event_id;
            $imageData['image'] = $eventImages;
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "image" => $imageData
        ];
        return response($response, $status);
    }
}
