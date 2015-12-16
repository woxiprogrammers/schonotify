<?php

namespace App\Http\Controllers\api;

use App\Attendance;
use App\Batch;
use App\Classes;
use App\Division;
use App\User;
use Carbon\Carbon;
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
    {   $data=array();
        $resultArr=array();
        try{


             $batch=Batch::where('id',$request->batch_id)->first();
             $class=Classes::where('id',$request->class_id)->first();
             $division=Division::where('id',$request->division_id)->first();
             $student_list=User::where('division_id',$division->id)->where('is_active', '1')->get();
             $techer_id =User::where('remember_token',$request->token)->first();

            if($student_list->toArray() != null){
             foreach($student_list as $val)
             {
                 $resultArr[$val->roll_number] = $val->first_name.'_'.$val->last_name;
             }
                 $status = 200;
                 $message = "student list";
                 $data['teacher_id']=$techer_id->id;
                 $data['student_list']= $resultArr;
             }
            else{
                 $status = 404;
                $message = "student list not found";
            }
        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message,"data" =>$data];

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
            $techer_id =User::where('remember_token',$request->token)->first();
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
                $data['teacher_id']=$techer_id->id;
                $data['absent-students']=$resultArr;
                $data['present-students']=$presentArr;
            }
            else
            {

                $allStudArr=array();

                $student_list=User::where('division_id',$division->id)->where('is_active', '1')->get();
            if($student_list->toArray() != null){
                foreach($student_list as $val)
                {
                    $allStudArr[$val->roll_number] = $val->first_name.'_'.$val->last_name;
                }
                $data['teacher_id']=$techer_id->id;
                $data['student-list']=$allStudArr;
            }
            else{
                $status = 404;
                $message = "student list not found";
            }
            }

        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message,"data" =>$data];

        return response($response, $status);

    }
    public function submitAttendance(Requests\SubmitAttendance $request)
    {
        $resultArr=array();
        $valueArr=array();
        $data=array();
        $presentArr=array();
        $message='';
        $status='';
       try{

            $batch=Batch::where('id',$request->batch_id)->first();
            $class=Classes::where('id',$request->class_id)->first();
            $division=Division::where('id',$request->division_id)->first();
            $teacher_id =User::where('remember_token',$request->token)->first();
            $absentList=$request->all();
            $students=array();
            $students=$request->student;
            $studentExists=User::wherein('id',$students)
                                ->where('division_id',$division->id)
                                ->select('id')
                                ->get();

            if($studentExists->toArray() != null)
            {

                 $checkDate=Attendance::where('date',$request->date)->get();
                    $studentArray=array();
                    $checkStudentAvl='';
                  foreach($students as $key=>$value)
                    {
                        array_push($studentArray,$value);

                    }
                     $checkStudentAvl = Attendance::wherein('student_id',$students)->get();
                      if($checkDate->toArray() == null &&  $checkStudentAvl->toArray() == null)
                       {
                                 foreach($studentExists as $val)
                                {
                                    $data['student_id'] = $val->id;
                                    $data['teacher_id'] = $teacher_id['id'];
                                    $data['date'] = $request->date;
                                    $data['status'] = 0;
                                    Attendance::insert($data);
                                }
                        $status = 200;
                        $message = "attendance submitted successfully";
                       }
                       else{
                               $data['teacher_id'] = $teacher_id['id'];
                               $data['date'] = $request->date;
                               $data['status'] = 0;
                               $arrayAvl=array();
                               foreach($checkStudentAvl as $val)
                               {
                                   $arrayAvl[]=$val->student_id;
                               }
                              $difference = array_merge(array_diff($arrayAvl, $students), array_diff($students, $arrayAvl));

                                   foreach($difference as $value)
                                   {
                                       $data['student_id'] = $value;
                                       $data['teacher_id'] = $teacher_id['id'];
                                       $data['date'] = $request->date;
                                       $data['status'] = 0;
                                       Attendance::insert($data);
                                   }
                                  $status = 202;
                                  $message = "attendance update ";
                             }

            }else{
                $status = 404;
                $message = "attendance submit failure ";
            }
       }
       catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message];

        return response($response, $status);
    }
}
