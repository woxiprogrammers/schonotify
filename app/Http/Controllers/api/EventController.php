<?php
namespace App\Http\Controllers\api;
use App\Event;
use App\EventImages;
use App\EventTypes;
use App\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user',['except'=>['publicGetYearMonth','newViewFiveEvent','publicViewMonthsEvent']]);
    }
    /*
  * Function Name : viewFiveEvent
  * Param : Request $requests
  * Return : $message $status , recent 5 event array
  * Desc : when teacher want to see events then by default he/she can able to see latest five events.
  * Developed By : Shubham chaudhari
  * Date : 3/3/2016
  */
    public function viewFiveEvent(Requests\EventRequest $request)
    {
        $user=$request->all();
        try {
            $finalFiveEvents = array();
            $recentFiveEvents = array();
            $eventTypesId = EventTypes::where('slug',['event'])->pluck('id');
            $recentFiveEvents = Event::join('event_images','events.id','=','event_images.event_id')
                ->where('events.status','=',2)
                ->where('events.body_id','=',$user['teacher']['body_id'])
                ->where('events.event_type_id' , '=' , $eventTypesId)
                ->orderBy('start_date', 'asc')
                ->get()
                ->take(30)->toArray();
             $counter = 0;
            foreach ($recentFiveEvents as $event) {
                $finalFiveEvents[$counter]['id'] =  $event['id'];
                $creatorUser = User::where ('id','=', $event['created_by'])->select('first_name','last_name')->first();
                $finalFiveEvents[$counter]['created_by'] = $creatorUser['first_name']." ".$creatorUser['last_name'];
                $publishedUser = User::where ('id','=', $event['published_by'])->select('first_name','last_name')->first();
                $finalFiveEvents[$counter]['published_by'] = $publishedUser['first_name']." ".$publishedUser['last_name'];
                $finalFiveEvents[$counter]['status'] ="Published";
                $finalFiveEvents[$counter]['title'] = $event['title'];
                $finalFiveEvents[$counter]['created_at'] = $event['created_at'];
                if($event['status'] == 2) {
                    $finalFiveEvents[$counter]['published_at'] = $event['updated_at'];
                } else {
                    $finalFiveEvents[$counter]['published_at'] = ' ';
                }
                if($event['image'] != null) {
                $file = $this->getEventImagePath($event['image']);
                    if($file['status']){
                       $finalFiveEvents[$counter]['image'] = $event['image'];
                       $finalFiveEvents[$counter]['path'] = $file['path'];
                    } else {
                       $finalFiveEvents[$counter]['image'] =$event['image'];

                       $finalFiveEvents[$counter]['path'] =url()."/uploads/events/".$event['image'];

                    }
                } else {
                $finalFiveEvents[$counter]['image'] = $event['image'];
                $imageName=$event['image'];
                $finalFiveEvents[$counter]['path'] = url()."/uploads/events/".$imageName;

                }
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
    public function newViewFiveEvent(Request $request)
    {
        try {
            $status = 200;
            $message = "success";
            $finalFiveEvents = array();
            $recentFiveEvents = array();
            $eventTypesId = EventTypes::where('slug',['event'])->pluck('id');
            $recentFiveEvents = Event::join('event_images','events.id','=','event_images.event_id')
                ->where('events.status','=',2)
                ->where('events.body_id','=',$request->body_id)
                ->where('events.event_type_id' , '=' , $eventTypesId)
                ->orderBy('start_date', 'desc')
                ->get()
                ->take(5)->toArray();
            $counter = 0;
            foreach ($recentFiveEvents as $event) {
                $finalFiveEvents[$counter]['id'] =  $event['id'];
                $creatorUser = User::where ('id','=', $event['created_by'])->select('first_name','last_name')->first();
                $finalFiveEvents[$counter]['created_by'] = $creatorUser['first_name']." ".$creatorUser['last_name'];
                $publishedUser = User::where ('id','=', $event['published_by'])->select('first_name','last_name')->first();
                $finalFiveEvents[$counter]['published_by'] = $publishedUser['first_name']." ".$publishedUser['last_name'];
                $finalFiveEvents[$counter]['status'] ="Published";
                $finalFiveEvents[$counter]['title'] = $event['title'];
                $finalFiveEvents[$counter]['created_at'] = $event['created_at'];
                if($event['status'] == 2) {
                    $finalFiveEvents[$counter]['published_at'] = $event['updated_at'];
                } else {
                    $finalFiveEvents[$counter]['published_at'] = ' ';
                }
                if($event['image'] != null) {
                    $file = $this->getEventImagePath($event['image']);
                    if($file['status']){
                        $finalFiveEvents[$counter]['image'] = $event['image'];
                        $finalFiveEvents[$counter]['path'] = $file['path'];
                    } else {
                        $finalFiveEvents[$counter]['image'] =$event['image'];

                        $finalFiveEvents[$counter]['path'] =url()."/uploads/events/".$event['image'];

                    }
                } else {
                    $finalFiveEvents[$counter]['image'] = $event['image'];
                    $imageName=$event['image'];
                    $finalFiveEvents[$counter]['path'] = url()."/uploads/events/".$imageName;

                }
                $finalFiveEvents[$counter]['detail'] = $event['detail'];
                $finalFiveEvents[$counter]['start_date'] = date("j M y, g:i a",strtotime( $event['start_date']));
                $finalFiveEvents[$counter]['end_date'] = date("j M y, g:i a",strtotime( $event['end_date']));
                $counter++;
            }

        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
            abort(500,$e->getMessage());

        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalFiveEvents
        ];
        return response($response, $status);
    }
    /*
      * Function Name : getEventImagePath
      * Param : Request $requests , $imageName
      * Return : $file
      * Desc : get image path if file exits
      * Developed By : Shubham chaudhari
      * Date : 12/4/2016
      */
    public function getEventImagePath($imageName){
        try{
            $ds = DIRECTORY_SEPARATOR;
            $eventUploadConfig = env('EVENT_FILE_UPLOAD');
            $eventUploadPath = public_path().$eventUploadConfig;
            $eventImageUploadPath = $eventUploadPath.$ds.$imageName;
                $file['status'] = false;
                if (file_exists($eventImageUploadPath)) {
                    $file['status'] = true;
                }
                $path = url().$eventUploadConfig.$ds.$imageName;
                $file['path'] = $path;
                return $file;
        }catch(\Exception $e){
            abort(500,$e->getMessage());
        }
    }
    /*
        * Function Name : getYearMonth
        * Param : Request $requests
        * Return : $message $status , array of years and  months
        * Desc : when user want to see events the months from Jan to Dec of current month selected by user.
        * Developed By : Shubham chaudhari
        * Date : 12/4/2016
        */
    public function getYearMonth(Request $request)
    {
        $message = "Successfully Listed";
        $status = 200;
        $startMonth = 6;
        $endMonth = 5;
        $currentMonth = date('n');
        $data = array();
        $i = 1 ;
        if($currentMonth < $startMonth) {
            $previousYear = strval(date('Y')-1);
            $currentYear = strval(date('Y'));
            $j = 0;
            $i = $startMonth;
            $previousYearData["year"] = $previousYear;
            for($month = $startMonth ; $month<=12 ; $month++) {
                $date = '2016-'.$month.'-05';
                $monthName = date('F', strtotime($date));
                $previousYearData["month"][$j][$i] = substr($monthName,0,3);;
                $i++;
            }
            $i =1;
            $j = 0;
            $nextYearData["year"] = $currentYear;
            for($month = 1 ; $month <= $endMonth ; $month++) {
                $date = '2016-'.$month.'-05';
                $monthName = date('F', strtotime($date));
                $nextYearData["month"][$j][$i] = substr($monthName,0,3);;
                $i++;
            }
        } else {
            $previousYear = strval(date('Y')+1);
            $currentYear = strval(date('Y')) ;
            $j = 0;
            $nextYearData["year"] = $previousYear;
            for($month = 1 ; $month <= $endMonth ; $month++) {
                $date = '2016-'.$month.'-05';
                $monthName = date('F', strtotime($date));
                $nextYearData["month"][$j][$i] = substr($monthName,0,3);;
                $i++;
            }
            $j = 0;
            $previousYearData["year"] = $currentYear;
            for($month = $startMonth ; $month<=12 ; $month++) {
                $date = '2016-'.$month.'-05';
                $monthName = date('F', strtotime($date));
                $previousYearData["month"][$j][$i] = substr($monthName,0,3);;
                $i++;
            }
        }
        $data[0] = $previousYearData;
        $data[1] = $nextYearData;
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $data
        ];
        return response($response, $status);
    }
    public function publicGetYearMonth(Request $request)
    {
        $message = "Successfully Listed";
        $status = 200;
        $startMonth = 6;
        $endMonth = 5;
        $currentMonth = date('n');
        $data = array();
        $i = 1 ;
        if($currentMonth < $startMonth) {
            $previousYear = strval(date('Y')-1);
            $currentYear = strval(date('Y'));
            $j = 0;
            $i = $startMonth;
            $previousYearData["year"] = $previousYear;
            for($month = $startMonth ; $month<=12 ; $month++) {
                $date = '2016-'.$month.'-05';
                $monthName = date('F', strtotime($date));
                $previousYearData["month"][$j][$i] = substr($monthName,0,3);;
                $i++;
            }
            $i =1;
            $j = 0;
            $nextYearData["year"] = $currentYear;
            for($month = 1 ; $month <= $endMonth ; $month++) {
                $date = '2016-'.$month.'-05';
                $monthName = date('F', strtotime($date));
                $nextYearData["month"][$j][$i] = substr($monthName,0,3);;
                $i++;
            }
        } else {
            $previousYear = strval(date('Y')+1);
            $currentYear = strval(date('Y')) ;
            $j = 0;
            $nextYearData["year"] = $previousYear;
            for($month = 1 ; $month <= $endMonth ; $month++) {
                $date = '2016-'.$month.'-05';
                $monthName = date('F', strtotime($date));
                $nextYearData["month"][$j][$i] = substr($monthName,0,3);;
                $i++;
            }
            $j = 0;
            $previousYearData["year"] = $currentYear;
            for($month = $startMonth ; $month<=12 ; $month++) {
                $date = '2016-'.$month.'-05';
                $monthName = date('F', strtotime($date));
                $previousYearData["month"][$j][$i] = substr($monthName,0,3);;
                $i++;
            }
        }
        $data[0] = $previousYearData;
        $data[1] = $nextYearData;
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $data
        ];
        return response($response, $status);
    }
    /*
    * Function Name : viewMonthsEvent
    * Param : Request $requests , $month_id
    * Return : $message $status , event array of current month
    * Desc : when user want to see events the months from Jan to Dec of current month selected by user.
    * Developed By : Shubham chaudhari
    * Date : 3/3/2016
    */
    public function viewMonthsEvent(Requests\EventRequest $request, $year,$month_id)
    {
        $user = $request->all();
        try {
            $data = $request->all();
            $monthsEvents = array();
            $pendingEvents = array();
            $publishedEvents = array();
            $finalMonthsEvents = array();
            $status = 200;
            $message = 'Successfully Listed';
            $eventTypesId = EventTypes::where('slug',['event'])->pluck('id');
            $startDate = $year."-".$month_id ."-"."01"." 00".":"."00".":"."00";
            $endDate = $year."-".$month_id ."-"."31"." 23".":"."59".":"."59";
            $pendingEvents = DB::table('events')->where('event_type_id','=',$eventTypesId)
                ->where('created_by',$data['teacher']['id'])
                ->where('body_id',$user['teacher']['body_id'])
                ->where('status','=',1) //1 is for pending events i.e. Not published and not in draft
                ->where('start_date','>=',$startDate)
                ->where('start_date','<=',$endDate);
            $publishedEvents = DB::table('events')->where('event_type_id','=',$eventTypesId)
                ->where('status','=',2) //1 is for pending events i.e. Not published.
                ->where('body_id',$user['teacher']['body_id'])
                ->where('start_date','>=',$startDate)
                ->where('start_date','<=',$endDate);
            $monthsEvents = DB::table('events')->where('event_type_id','=',$eventTypesId)
                ->where('created_by',$data['teacher']['id'])
                ->where('status','=',0) // 0 is for draft
                ->where('body_id',$user['teacher']['body_id'])
                ->union($pendingEvents)
                ->union($publishedEvents)
                ->where('start_date','>=',$startDate)
                ->where('start_date','<=',$endDate)
                ->orderBy('start_date','desc')
                ->get();
            $counter = 0;
            if(!Empty($monthsEvents)){
                foreach ($monthsEvents as $event) {
                    $image = EventImages::where('event_id','=',$event->id)->pluck('image');
                    $finalMonthsEvents[$counter]['id'] =  $event->id;
                    $creatorUser = User::where ('id','=', $event->created_by)->select('first_name','last_name')->first();
                    $finalMonthsEvents[$counter]['created_by'] = $creatorUser['first_name']." ".$creatorUser['last_name'];
                    $publishedUser = User::where ('id','=', $event->published_by)->select('first_name','last_name')->first();
                    $finalMonthsEvents[$counter]['published_by'] = $publishedUser['first_name']." ".$publishedUser['last_name'];
                    if($event->status == "0"){ //0 for draft
                        $finalMonthsEvents[$counter]['status'] = "Draft" ;
                    } else  if($event->status == "1"){ //0 for draft
                        $finalMonthsEvents[$counter]['status'] ="Pending";
                    } else {
                        $finalMonthsEvents[$counter]['status'] ="Published";
                    }
                    $finalMonthsEvents[$counter]['title'] = $event->title;
                    $finalMonthsEvents[$counter]['detail'] = $event->detail;
                    if($image!=null) {
                        $file = $this->getEventImagePath($image);
                        if($file['status']){
                            $finalMonthsEvents[$counter]['image'] =$image;
                            $finalMonthsEvents[$counter]['path'] = $file['path'];
                        } else {
                            $finalMonthsEvents[$counter]['image'] = $image;
                            $imageName=$image;
                            $finalMonthsEvents[$counter]['path'] = url()."/uploads/events/".$imageName;

                        }
                    } else {
                        $finalMonthsEvents[$counter]['image'] = "picture.svg";
                        $finalMonthsEvents[$counter]['path'] = url()."/uploads/events/picture.svg";
                    }
                    $finalMonthsEvents[$counter]['start_date'] =  date("j M y, g:i a",strtotime( $event->start_date));
                    $finalMonthsEvents[$counter]['end_date'] = date("j M y, g:i a",strtotime( $event->end_date));
                    $finalMonthsEvents[$counter]['created_at'] =  date("j M y, g:i a",strtotime( $event->created_at));
                    if($event->status == 2) {
                        $finalMonthsEvents[$counter]['published_at'] =  date("j M y, g:i a",strtotime( $event->updated_at));
                    } else {
                        $finalMonthsEvents[$counter]['published_at'] = ' ';
                    }
                    $counter++;
                }
            } else {
                $status = 404;
                $message = 'Sorry! No events found for this instance.';
            }
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

    public function publicViewMonthsEvent(Request $request,$year,$month_id){
        $user = $request->all();
        try {
            $data = $request->all();
            $monthsEvents = array();
            $pendingEvents = array();
            $publishedEvents = array();
            $finalMonthsEvents = array();
            $status = 200;
            $message = 'Successfully Listed';
            $eventTypesId = EventTypes::where('slug',['event'])->pluck('id');
            $startDate = $year."-".$month_id ."-"."01"." 00".":"."00".":"."00";
            $endDate = $year."-".$month_id ."-"."31"." 23".":"."59".":"."59";
            $pendingEvents = DB::table('events')->where('event_type_id','=',$eventTypesId)
                ->where('created_by',$data['teacher']['id'])
                ->where('body_id',$user['teacher']['body_id'])
                ->where('status','=',1) //1 is for pending events i.e. Not published and not in draft
                ->where('start_date','>=',$startDate)
                ->where('start_date','<=',$endDate);
            $publishedEvents = DB::table('events')->where('event_type_id','=',$eventTypesId)
                ->where('status','=',2) //1 is for pending events i.e. Not published.
                ->where('body_id',$user['teacher']['body_id'])
                ->where('start_date','>=',$startDate)
                ->where('start_date','<=',$endDate);
            $monthsEvents = DB::table('events')->where('event_type_id','=',$eventTypesId)
                ->where('created_by',$data['teacher']['id'])
                ->where('status','=',0) // 0 is for draft
                ->where('body_id',$user['teacher']['body_id'])
                ->union($pendingEvents)
                ->union($publishedEvents)
                ->where('start_date','>=',$startDate)
                ->where('start_date','<=',$endDate)
                ->orderBy('start_date','desc')
                ->get();
            $counter = 0;
            if(!Empty($monthsEvents)){
                foreach ($monthsEvents as $event) {
                    $image = EventImages::where('event_id','=',$event->id)->pluck('image');
                    $finalMonthsEvents[$counter]['id'] =  $event->id;
                    $creatorUser = User::where ('id','=', $event->created_by)->select('first_name','last_name')->first();
                    $finalMonthsEvents[$counter]['created_by'] = $creatorUser['first_name']." ".$creatorUser['last_name'];
                    $publishedUser = User::where ('id','=', $event->published_by)->select('first_name','last_name')->first();
                    $finalMonthsEvents[$counter]['published_by'] = $publishedUser['first_name']." ".$publishedUser['last_name'];
                    if($event->status == "0"){ //0 for draft
                        $finalMonthsEvents[$counter]['status'] = "Draft" ;
                    } else  if($event->status == "1"){ //0 for draft
                        $finalMonthsEvents[$counter]['status'] ="Pending";
                    } else {
                        $finalMonthsEvents[$counter]['status'] ="Published";
                    }
                    $finalMonthsEvents[$counter]['title'] = $event->title;
                    $finalMonthsEvents[$counter]['detail'] = $event->detail;
                    if($image!=null) {
                        $file = $this->getEventImagePath($image);
                        if($file['status']){
                            $finalMonthsEvents[$counter]['image'] =$image;
                            $finalMonthsEvents[$counter]['path'] = $file['path'];
                        } else {
                            $finalMonthsEvents[$counter]['image'] = $image;
                            $imageName=$image;
                            $finalMonthsEvents[$counter]['path'] = url()."/uploads/events/".$imageName;

                        }
                    } else {
                        $finalMonthsEvents[$counter]['image'] = "picture.svg";
                        $finalMonthsEvents[$counter]['path'] = url()."/uploads/events/picture.svg";
                    }
                    $finalMonthsEvents[$counter]['start_date'] =  date("j M y, g:i a",strtotime( $event->start_date));
                    $finalMonthsEvents[$counter]['end_date'] = date("j M y, g:i a",strtotime( $event->end_date));
                    $finalMonthsEvents[$counter]['created_at'] =  date("j M y, g:i a",strtotime( $event->created_at));
                    if($event->status == 2) {
                        $finalMonthsEvents[$counter]['published_at'] =  date("j M y, g:i a",strtotime( $event->updated_at));
                    } else {
                        $finalMonthsEvents[$counter]['published_at'] = ' ';
                    }
                    $counter++;
                }
            } else {
                $status = 404;
                $message = 'Sorry! No events found for this instance.';
            }

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
    * Developed By : Shubham chaudhari
    * Date : 7/3/2016
    */
    public function createEvent(Requests\EventRequest $request)
    {
        try {
            $data = $request->all();
            $body = User::where('remember_token',$data['token'])->pluck('body_id');
            $mytime = Carbon::now();
            $tempImageName = (strtotime($mytime)).".jpg";
            $tempImagePath = "uploads/events/";
            file_put_contents($tempImagePath.$tempImageName,base64_decode($request->img) );
            $data['teacher']['id'] = User::where('remember_token','=',$data['token'])->pluck('id');
            $eventTypesId = EventTypes::where('slug',['event'])->pluck('id');
            $eventData['event_type_id'] = $eventTypesId;
            $eventData['created_by'] = $data['teacher']['id'];
            $eventData['published_by'] = null;
            $eventData['title'] = $data['title'];
            $eventData['status'] = $data['status'];
            $eventData['detail'] = $data['detail'];
            $eventData['priority'] = 0;
            $eventData['start_date'] = $data['start_date'];
            $eventData['end_date'] = $data['end_date'];
            $eventData['created_at'] = Carbon::now();
            $eventData['updated_at'] = Carbon::now();
            $eventData['body_id'] = $body;
            $event_id = Event::insertGetId($eventData);
            if($event_id != null) {
                $eventImageData['event_id'] = $event_id ;
                $eventImageData['image'] = $tempImageName;
                $eventImageData['created_at'] = Carbon::now();
                $eventImageData['updated_at'] = Carbon::now();
                EventImages::insert($eventImageData);
            }
            if($eventData['status'] == 0) {
                $status = 200;
                $message = 'Event successfully saved in draft';
            } else {
                $status = 200;
                $message = 'Event successfully sent for publish';
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = $e->getMessage();
        }
        $response = [
            "status" => $status,
            "message" => $message
        ];
        return response($response, $status);
    }
    /*
    * Function Name : editEvent
    * Param : Request $requests
    * Return : $message $status
    * Desc : Teacher can edit unpublished events if he/she have an ACL.
    * Developed By : Shubham chaudhari
    * Date : 8/3/2016
    */
    public function editEvent(Requests\EventRequest $request)
    {
        try {
            $data = $request -> all();
            $image = EventImages::where('event_id','=',$data['event_id'])->pluck('image');
            if(!Empty($request->image))
            {
                $tempImageName=$image."k";
                $tempImagePath = "uploads/events/";
                file_put_contents($tempImagePath.$tempImageName,base64_decode($request->imageBase) );
                $query=EventImages::where('event_id','=',$data['event_id'])->update(['image'=>$tempImageName]);
            }else{
                $query=EventImages::where('event_id','=',$data['event_id'])->update(['image'=>$image]);
            }

            $data['teacher']['id'] = User::where('remember_token','=',$data['token'])->pluck('id');
            $event_id = Event::where('id','=',$data['event_id'])->get()->toArray();
            if(!Empty($event_id)) {
                $eventData['title'] = $data['title'];
                $eventData['detail'] = $data['detail'];
                $eventData['priority'] = 0;
                $eventData['start_date'] = $data['start_date'];
                $eventData['end_date'] = $data['end_date'];
                $eventData['updated_at'] = Carbon::now();
                Event::where('id','=',$data['event_id'])->update($eventData);
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
    * Developed By : Shubham chaudhari
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
    * Developed By : Shubham chaudhari
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
                $message = "Sorry!! This event can not be deleted";
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
