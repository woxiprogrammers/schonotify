<?php

namespace App\Http\Controllers\api;

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
    public function getApprovedLeaveList(Request $request)
    {
        try {
            if ($request->teacher != null) {
                $division = $request->teacher->teacher()->lists('division_id');
                $leaves = Leave::whereIn('division_id', $division)->where('status', '1')->orderBy('from date', 'asc')->get();
                $message = 'success';
                $status = 200;
                $approveList = $leaves->toArray();
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
    public function getPendingLeaveList(Request $request)
    {
        try {
            if ($request->teacher != null){
                $division = $request->teacher->teacher()->lists('division_id');
                $leaves = Leave::whereIn('division_id', $division)->where('status', '0')->orderBy('from date', 'desc')->get();
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
    public function approveLeave(Requests\Leave $request){
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
}
