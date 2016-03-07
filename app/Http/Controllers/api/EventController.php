<?php

namespace App\Http\Controllers\api;

use App\Event;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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

    public function viewFiveEvent(Request $request)
    {
        try {
            $finalFiveEvents = array();
            $recentFiveEvents = array();
            $recentFiveEvents = Event::where('event_type_id','=',1)
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
                $finalFiveEvents[$counter]['detail'] = $event['detail'];
                $finalFiveEvents[$counter]['priority'] = $event['priority'];
                $finalFiveEvents[$counter]['start_date'] = $event['start_date'];
                $finalFiveEvents[$counter]['end_date'] = $event['end_date'];
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

    public function viewMonthsEvent(Request $request , $month_id)
    {
        try {
            $monthsEvents = array();
            $finalMonthsEvents = array();
            $year = date('Y');;
            $startDate = $year."-".$month_id ."-"."01"." 00".":"."00".":"."00";
            $endDate = $year."-".$month_id ."-"."31"." 23".":"."59".":"."59";
            $monthsEvents = Event::where('event_type_id','=',1)
                ->where('start_date','>=',$startDate)
                ->where('start_date','<=',$endDate)
                ->get()
                ->toArray();
            $counter = 0;
            foreach ($monthsEvents as $event) {
                $finalMonthsEvents[$counter]['id'] =  $event['id'];
                $creatorUser = User::where ('id','=', $event['created_by'])->select('first_name','last_name')->first();
                $finalMonthsEvents[$counter]['created_by'] = $creatorUser['first_name']." ".$creatorUser['last_name'];
                $publishedUser = User::where ('id','=', $event['published_by'])->select('first_name','last_name')->first();
                $finalMonthsEvents[$counter]['published_by'] = $publishedUser['first_name']." ".$publishedUser['last_name'];
                $finalMonthsEvents[$counter]['status'] = $event['status'];
                $finalMonthsEvents[$counter]['detail'] = $event['detail'];
                $finalMonthsEvents[$counter]['priority'] = $event['priority'];
                $finalMonthsEvents[$counter]['start_date'] = $event['start_date'];
                $finalMonthsEvents[$counter]['end_date'] = $event['end_date'];
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
    * Date : 3/3/2016
    */
}
