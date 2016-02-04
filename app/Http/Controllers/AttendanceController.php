<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Division;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function markAttendance(Requests\WebRequests\CreateAttendanceRequest $request)
    {
        if($request->authorize()===true)
        {
            $user=Auth::user();
            $dropDownData=array();

            if($user->role_id == 2){

                $userCheck=Division::where('class_teacher_id',$user->id)->first();

                if($userCheck != null){
                        $i=0;
                        $batchClassData=Classes::where('classes.id',$userCheck->class_id)
                                               ->join('batches','classes.batch_id','=','batches.id')
                                               ->select('classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                                               ->first();
                        if($batchClassData != null){
                                $studentData=User::where('division_id',$userCheck->id)->where('is_active',1)->select('id','first_name','last_name','roll_number')->get();
                                $dropDownData['division_id'] = $userCheck->id;
                                $dropDownData['division_name'] = $userCheck->division_name;
                                $dropDownData['class_id'] = $batchClassData->class_id;
                                $dropDownData['class_name'] = $batchClassData->class_name;
                                $dropDownData['batch_id'] = $batchClassData->batch_id;
                                $dropDownData['batch_name'] = $batchClassData->batch_name;
                                foreach($studentData as $student){
                                    $dropDownData['student_list'][$i]['student_id'] = $student['id'];
                                    $dropDownData['student_list'][$i]['student_name'] = $student['first_name'] ." ".$student['last_name'];;
                                    $dropDownData['student_list'][$i]['roll_number'] = $student['roll_number'];
                                    $i++;
                                }
                            return view('markAttendance')->with(compact('dropDownData'));
                        }
                        else{
                            Session::flash('message-success','no record found');
                        }

                }
                else{
                    Session::flash('message-success','no record found');

                }
            }
            elseif($user->role_id==1){
                dd();
            }
            else{

            }

            return view('markAttendance');
        }else{
            return Redirect::to('/');
        }

    }
    public function viewAttendance(Requests\WebRequests\ViewAttendanceRequest $request)
    {
        if($request->authorize()===true)
        {
            return view('viewAttendance');
        }else{
            return Redirect::to('/');
        }

    }

}
