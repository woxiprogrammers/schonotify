<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TimetableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('timetable');
    }
    public function timetableShow($id)
    {
        Session::put('division_id',$id);

        $div=session('division_id');

        if($div==1)
        {
            return $this::division1();
        }elseif($div==2){
            return $this::division2();
        }else{
            return $this::division3();
        }

    }


    public function division1()
    {
        $str='{
 "monday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am","teacher":"Mr. Patil"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am","teacher":"Mr. Raut"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am","teacher":"Mr. Ashwin"},
 { "period":"4" , "subject":"Lunch Break","is_break":"1","start_time":"3:00pm","end_time":"3:30pm", "teacher":"Mr. Jadeja" },
 { "period":"5" , "subject":"Maths","is_break":"0","start_time":"3:30pm","end_time":"4:30pm", "teacher":"Mrs. Rossy"},
 { "period":"6" , "subject":"English","is_break":"0","start_time":"4:30pm","end_time":"5:30pm" , "teacher":"Mrs. Patil"}
 ],"tuesday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mr. Patil"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mr. Raut" },
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mr. Singh"},
 { "period":"4" , "subject":"Lunch Break","is_break":"1","start_time":"3:00pm","end_time":"3:30pm","teacher":"Mr. Rane" },
 { "period":"5" , "subject":"Maths","is_break":"0","start_time":"3:30pm","end_time":"4:30pm", "teacher":"Mr. Mishra"},
 { "period":"6" , "subject":"English","is_break":"0","start_time":"4:30pm","end_time":"5:30pm", "teacher":"Mr. Patil" }
 ],"wednesday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"3:00pm","end_time":"3:30pm", "teacher":"Mr. Patil"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"3:30pm","end_time":"4:00pm", "teacher":"Mr. Patil"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"4:00pm","end_time":"5:45pm", "teacher":"Mr. Patil"},
 { "period":"4" , "subject":"English","is_break":"0","start_time":"5:00pm","end_time":"6:00pm", "teacher":"Mrs. Anjali"}
 ],"thursday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"3:00pm","end_time":"3:30pm" , "teacher":"Mrs. More"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"3:30pm","end_time":"4:00pm" , "teacher":"Mr. Patil"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"4:00pm","end_time":"5:45pm" , "teacher":"Mr. Patil"},
 { "period":"4" , "subject":"English","is_break":"0","start_time":"5:00pm","end_time":"6:00pm" , "teacher":"Mrs. Patil"}
 ],"friday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mr. Patil"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mr. Singh" }
 ],"saturday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mr. Singh"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Jagtap"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mrs. Sali"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mrs. Patil"}
 ],"sunday": [

 ]}';

        return $str;
    }

    public function division2(){
        $str='{
 "monday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mr. Patil"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mr. Singh" },
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mrs. Raut" },
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mrs. Patil"}
 ],"tuesday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mrs. Patil"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Singh"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Sali"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mrs. More"},
 { "period":"5" , "subject":"English","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Sutar"}
 ],"wednesday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Dange"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Patil"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mrs. Patil"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Patil"},
 { "period":"5" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Patil"},
 { "period":"6" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mrs. Mishra"},
 { "period":"7" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mrs. Rossy"}
 ],"thursday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mrs. Rossy"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mrs. Patil"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Patil"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Patil"}
 ],"friday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Patil"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mr. Dange"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Sali"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Sali"}
 ],"saturday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mr. Sali"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am", "teacher":"Mrs. Patil"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Singh"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am" , "teacher":"Mr. Patil"}
 ],"sunday": [

 ]}';

        return $str;
    }


    public function division3(){

        $str='{"message":"unavailable"}';

        return $str;
    }

    public function create()
    {
        return view('createTimetable');
    }
}
