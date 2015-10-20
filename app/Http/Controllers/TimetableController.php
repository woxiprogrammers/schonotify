<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class TimetableController extends Controller
{
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
        }else{
            return $this::division2();
        }

    }

    public function division2(){
        $str='{
 "monday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am"}
 ],"tuesday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"5" , "subject":"English","is_break":"0","start_time":"8:00am","end_time":"8:45am"}
 ],"wednesday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"5" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"6" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"7" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am"}
 ],"thursday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am"}
 ],"friday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am"}
 ],"saturday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am"}
 ],"sunday": [

 ]}';

        return $str;
    }

    public function division1()
    {
        $str='{
 "monday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"4" , "subject":"Lunch Break","is_break":"1","start_time":"3:00pm","end_time":"3:30pm"},
 { "period":"5" , "subject":"Maths","is_break":"0","start_time":"3:30pm","end_time":"4:30pm"},
 { "period":"6" , "subject":"English","is_break":"0","start_time":"4:30pm","end_time":"5:30pm"}
 ],"tuesday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"4" , "subject":"Lunch Break","is_break":"1","start_time":"3:00pm","end_time":"3:30pm"},
 { "period":"5" , "subject":"Maths","is_break":"0","start_time":"3:30pm","end_time":"4:30pm"},
 { "period":"6" , "subject":"English","is_break":"0","start_time":"4:30pm","end_time":"5:30pm"}
 ],"wednesday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"3:00pm","end_time":"3:30pm"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"3:30pm","end_time":"4:00pm"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"4:00pm","end_time":"5:45pm"},
 { "period":"4" , "subject":"English","is_break":"0","start_time":"5:00pm","end_time":"6:00pm"}
 ],"thursday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"3:00pm","end_time":"3:30pm"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"3:30pm","end_time":"4:00pm"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"4:00pm","end_time":"5:45pm"},
 { "period":"4" , "subject":"English","is_break":"0","start_time":"5:00pm","end_time":"6:00pm"}
 ],"friday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am"}
 ],"saturday": [
 { "period":"1" , "subject":"Marathi","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"2" , "subject":"History","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"3" , "subject":"Geography","is_break":"0","start_time":"8:00am","end_time":"8:45am"},
 { "period":"4" , "subject":"Hindi","is_break":"0","start_time":"8:00am","end_time":"8:45am"}
 ],"sunday": [

 ]}';

        return $str;
    }
}
