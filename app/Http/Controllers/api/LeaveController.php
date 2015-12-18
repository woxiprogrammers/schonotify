<?php

namespace App\Http\Controllers\api;

use App\Batch;
use App\Classes;
use App\Division;
use App\SubjectClassDivision;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Leave;


class LeaveController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }

    /**
     * Display a listing of the approved list of student.
     *
     * @return \Illuminate\Http\Response
     */
    public function getApprovedLeaveList(Requests\Leave $request)
    {
        try {
            if ($request->teacher != null) {
                $division = $request->teacher->teacher()->lists('division_id');
                $leaves = Leave::whereIn('division_id', $division)->where('status', '1')->orderBy('from date', 'asc')->get();
                $approveList = array();
                foreach($leaves as $leave){
                    $studentDivision = Division::where('id',$leave['division_id'])->first();
                    $studentClass = Classes::where('id',$studentDivision->class_id)->first();
                    $studentBatch = Batch::where('id',$studentClass->batch_id)->first();
                    $studentName = User::where('id',$leave['student_id'])->first();
                    $leaveData['leave_id'] = $leave->id;
                    $leaveData['title'] = $leave->title;
                    $leaveData['created_at'] = $leave['created_at'];
                    $leaveData['student-division']= $studentDivision->division_name;
                    $leaveData['student-class'] = $studentClass->class_name;
                    $leaveData['student-batch'] = $studentBatch->name;
                    $leaveData['student-fname'] = $studentName->first_name;
                    $leaveData['student-lname'] = $studentName->last_name;
                    array_push($approveList,$leaveData);
                }
                $message = 'success';
                $status = 200;
                $responseData['approveList']= $approveList;
            } else {
                $status = 401;
                $message = 'You are not authorised user';
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $responseData
        ];
        return response($response, $status);
    }

    /**
     * Display a listing of the pending leave list of student.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPendingLeaveList(Requests\Leave $request)
    {
        try {
            if ($request->teacher != null){
                $division = $request->teacher->teacher()->lists('division_id');
                $leaves = Leave::whereIn('division_id', $division)->where('status', '0')->orderBy('from date', 'desc')->get();
                $pendingList = array();
                foreach($leaves as $leave){
                    $studentDivision = Division::where('id',$leave['division_id'])->first();
                    $studentClass = Classes::where('id',$studentDivision->class_id)->first();
                    $studentBatch = Batch::where('id',$studentClass->batch_id)->first();
                    $studentName = User::where('id',$leave['student_id'])->first();
                    $leaveData['leave_id'] = $leave->id;
                    $leaveData['title'] = $leave->title;
                    $leaveData['created_at'] = $leave['created_at'];
                    $leaveData['student-division']= $studentDivision->division_name;
                    $leaveData['student-class'] = $studentClass->class_name;
                    $leaveData['student-batch'] = $studentBatch->name;
                    $leaveData['student-fname'] = $studentName->first_name;
                    $leaveData['student-lname'] = $studentName->last_name;
                    array_push($pendingList,$leaveData);
                }
                $message = 'success';
                $status = 200;
                $pendingList = $leaves->toArray();
                $responseData['pendingList']= $pendingList;
            } else {
                $status = 401;
                $message = 'You are not authorised user';
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $responseData
        ];
        return response($response, $status);
    }

    /**
     * Approve the leave of student and send approved list.
     *
     * @return \Illuminate\Http\Response
     */
    public function approveLeave(Requests\LeaveApproveRequest $request){
        try{
            $data = $request->all();
            if (isset($data['teacher'])){
                if($data['leave_id'] != null){
                    Leave::where('id', $data['leave_id'])->update(['status' => 1]);
                    $division = SubjectClassDivision::where('teacher_id',$data['teacher']['id'])->lists('division_id');
                    $leaves = Leave::whereIn('division_id', $division) ->where('status', '0')->orderBy('from date', 'desc')->get();
                    $message = 'Leave Approved Successfully';
                    $status = 200;
                    $pendingList = $leaves->toArray();
                    $responseData['pendingList']= $pendingList;
                } else {
                    $status = 204;
                    $message = 'Insufficient Data';
                }
            } else {
                $status = 401;
                $message = 'You are not authorised user';
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "data" => $responseData
        ];
        return response($response, $status);
    }
    /**
     * get detail information about leave
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetailLeaveInformation(Requests\Leave $request){
        try{
            $data = $request->all();
            $student = Leave::where('id', $data['leave_id'])->first();
            $studentInfo = User::where('id',$student->student_id)->first();
            $studentDivision = Division::where('id',$student->division_id)->first();
            $studentClass = Classes::where('id',$studentDivision->class_id)->first();
            $studentBatch = Batch::where('id',$studentClass->batch_id)->first();
            $message = 'Leave Description Successfully';
            $status = 200;
            $responseData['LeaveInfo']= $student;
            $responseData['studentInfo']['batch'] = $studentBatch->name;
            $responseData['studentInfo']['class'] = $studentClass->class_name;
            $responseData['studentInfo']['division'] = $studentDivision->division_name;
            $responseData['studentInfo']['firstName'] = $studentInfo->first_name;
            $responseData['studentInfo']['lastName'] = $studentInfo->last_name;
        } catch (\Exception $e) {
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "data" => $responseData
        ];
        return response($response, $status);
    }
}
