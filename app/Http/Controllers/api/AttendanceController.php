<?php

namespace App\Http\Controllers\api;

use App\Attendance;
use App\Batch;
use App\Classes;
use App\Division;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;



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
             foreach($student_list as $val)
             {
                 $resultArr[$val->roll_number] = $val->first_name.'_'.$val->last_name;
             }
        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message,"data" =>$resultArr];

        return response($response, $status);
    }

    public function markPreviousAttendance(Requests\PreviousAttendance $request)
    {
        $resultArr=array();
        $valueArr=array();
        $data=array();
        $presentArr=array();
        try{
            $status = 200;
            $message = "previous student list";
            $batch=Batch::where('id',$request->batch_id)->first();
            $class=Classes::where('id',$request->class_id)->first();
            $division=Division::where('id',$request->division_id)->first();
            $checkDate=Attendance::where('date',$request->date)->get();
            if($checkDate->toArray() != null)
            {
              foreach($checkDate as $val)
                {
                    $valueArr[] =$val->student_id;
                }
                $listAbsent=User::whereIn('id',$valueArr)->get();

                foreach($listAbsent as $val)
                {
                    $resultArr[$val->roll_number] = $val->first_name.'_'.$val->last_name;
                }


                $presentData=User::whereNotIn('id',$valueArr)
                                 ->where('division_id',$division->id)
                                 ->where('is_active', '1')
                                 ->get();

                foreach($presentData as $val)
                {
                    $presentArr[$val->roll_number] = $val->first_name.'_'.$val->last_name;
                }
                $data['absent-students']=$resultArr;
                $data['present-students']=$presentArr;

            }
            else
            {

                $allStudArr=array();

                $student_list=User::where('division_id',$division->id)->where('is_active', '1')->get();

                foreach($student_list as $val)
                {
                    $allStudArr[$val->roll_number] = $val->first_name.'_'.$val->last_name;
                }
                $data['student-list']=$allStudArr;

            }

        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message,"data" =>$data];

        return response($response, $status);

    }
}
