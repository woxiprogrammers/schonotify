<?php

namespace App\Http\Controllers\api;

use App\Event;
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

    public function viewFiveEvent(Requests\Result $request)
    {
        try {
            $recentFiveEvents = array();
            $recentFiveEvents = Event::orderBy('date', 'desc')
                ->select('id','user_id as created_by','event_type_id as event_type','title','detail','date')
                ->get()
                ->take(5);
            $status=200;
            $message = 'Successfully Listed';
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $recentFiveEvents
        ];
        return response($response, $status);
    }

    public function viewMonthsEvent(Requests\Result $request , $month_id)
    {
        try {
            $monthsEvents = array();
            $year = date('Y');;
            $startDate = $year."-".$month_id ."-"."01"." 00".":"."00".":"."00";
            $endDate = $year."-".$month_id ."-"."31"." 23".":"."59".":"."59";
            $monthsEvents = Event::where('date','>=',$startDate)
                ->where('date','<=',$endDate)->get()->toArray();
            $status = 200;
            $message = 'Successfully Listed';
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $monthsEvents
        ];
        return response($response, $status);
    }
}
