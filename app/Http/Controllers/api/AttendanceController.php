<?php

namespace App\Http\Controllers\api;

use App\Batch;
use App\Classes;
use App\Division;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;


class AttendanceController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }

    public function markAttendance(Requests\AttendanceRequest $request)
    {   $resultArr=array();
        try{
             $status = 200;
             $message = "student list";
             $batch=Batch::where('id',$request->batch_id)->first();
             $class=Classes::where('id',$request->class_id)->first();
             $division=Division::where('id',$request->division_id)->first();
             $student_list=User::where('division_id',$division->id)->where('is_active', '1')->get();
             $this->rollno = array('User');
             foreach($student_list as $val)
             {
                 $resultArr[$val->roll_number] = $val->first_name.'_'.$val->last_name;
             }
        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message,"Data" =>$resultArr];

        return response($response, $status);
    }
}
