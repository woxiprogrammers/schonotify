<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Classes;
use App\Division;
use App\Leave;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }

    public function leaveListing(Requests\WebRequests\LeaveRequest $request)
    {
        if ($request->authorize() === true)
        {
            $user = Auth::user();
            $dropDownData = array();
            $leaveArray = array();
            if ($user->role_id == 2) {
                $userCheck = Division::where('class_teacher_id',$user->id)->first();
                if ($userCheck != null) {
                    $batchClassData=Classes::where('classes.id',$userCheck->class_id)
                        ->join('batches','classes.batch_id','=','batches.id')
                        ->select('classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                        ->first();
                    if ($batchClassData != null) {
                            $leaveStatus = Leave::where('division_id',$userCheck->id)->where('status',2)->get();
                            $i = 0;
                            foreach ($leaveStatus as $row) {
                                $studentData = User::where('id',$row['student_id'])->where('is_active',1)->select('id','first_name','last_name','roll_number')->first();
                                $leaveArray[$i]['student_id'] = $row['student_id'];
                                $leaveArray[$i]['student_name'] = $studentData['first_name'] ." ".$studentData['last_name'];
                                $leaveArray[$i]['roll_number'] = $studentData['roll_number'];
                                $leaveArray[$i]['avatar'] = $studentData['avatar'];
                                $leaveArray[$i]['title'] = $row['title'];
                                $leaveArray[$i]['leave_type'] = $row['leave_type'];
                                $leaveArray[$i]['reason'] = $row['reason'];
                                $leaveArray[$i]['from_date'] = $row['from_date'];
                                $leaveArray[$i]['end_date'] = $row['end_date'];
                                $leaveArray[$i]['created_date'] = $row['created_at'];
                                $i++;
                            }
                                $leaveArray = array_unique($leaveArray,SORT_REGULAR);
                                /*$dropDownData['division_id'] = $userCheck->id;
                                $dropDownData['division_name'] = $userCheck->division_name;
                                $dropDownData['class_id'] = $batchClassData->class_id;
                                $dropDownData['class_name'] = $batchClassData->class_name;
                                $dropDownData['batch_id'] = $batchClassData->batch_id;
                                $dropDownData['batch_name'] = $batchClassData->batch_name;*/
                           return view('leaveListing')->with(compact('leaveArray'));
                    } else {
                        Session::flash('message-success','no record found');
                    }

                } else {
                    Session::flash('message-success','no record found');
                }
            } elseif ($user->role_id == 1) {

                $batchClassDivisionData = Division::
                    join('classes','divisions.class_id','=','classes.id')
                    ->join('batches','classes.batch_id','=','batches.id')
                    ->select('divisions.id as division_id','divisions.division_name','classes.id as class_id','classes.class_name','batches.id as batch_id','batches.name as batch_name')
                    ->first();
                    if ($batchClassDivisionData != null) {
                         $leaveStatus = Leave::where('division_id',$batchClassDivisionData['division_id'])->where('status',2)->get();
                        $i = 0;
                        foreach ($leaveStatus as $row) {
                            $studentData = User::where('id',$row['student_id'])->where('is_active',1)->select('id','first_name','last_name','roll_number')->first();
                            $leaveArray[$i]['student_id'] = $row['student_id'];
                            $leaveArray[$i]['student_name'] = $studentData['first_name'] ." ".$studentData['last_name'];
                            $leaveArray[$i]['roll_number'] = $studentData['roll_number'];
                            $leaveArray[$i]['avatar'] = $studentData['avatar'];
                            $leaveArray[$i]['title'] = $row['title'];
                            $leaveArray[$i]['leave_type'] = $row['leave_type'];
                            $leaveArray[$i]['reason'] = $row['reason'];
                            $leaveArray[$i]['from_date'] = $row['from_date'];
                            $leaveArray[$i]['end_date'] = $row['end_date'];
                            $leaveArray[$i]['created_date'] = $row['created_at'];
                            $i++;
                        }
                            $leaveArray = array_unique($leaveArray,SORT_REGULAR);
                            $dropDownData['division_id'] =  $batchClassDivisionData->division_id;
                            $dropDownData['division_name'] = $batchClassDivisionData->division_name;
                            $dropDownData['class_id'] = $batchClassDivisionData->class_id;
                            $dropDownData['class_name'] = $batchClassDivisionData->class_name;
                            $batch=Batch::get();
                            $i=0;
                        foreach ($batch as $row) {
                            $dropDownData['batch'][$i]['batch_id'] = $row['id'];
                            $dropDownData['batch'][$i]['batch_name'] = $row['name'];
                            $i++;
                        }
                        return view('leaveListing')->with(compact('leaveArray','dropDownData'));
                    } else {
                        Session::flash('message-success','no record found');
            }
            }
        } else {
            return Redirect::to('/');
        }

    }

    public function detailedLeave(Requests\WebRequests\LeaveRequest $request)
    {
        if($request->authorize()===true)
        {
            return view('detailedLeave');
        }else{
            return Redirect::to('/');
        }
    }

    /**
     * Function Name: leaveAccess
     * @param:
     * @return int
     * Desc:
     * Date: 10/2/2016
     * author manoj chaudahri
     */
    public function leaveAccess()
    {
        $user=Auth::user();
        if ($user->role_id == 2) {
            $divisionChceck = Division::where('class_teacher_id',$user->id)->count();
            if ($divisionChceck != 0) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 1;
        }
    }
}
