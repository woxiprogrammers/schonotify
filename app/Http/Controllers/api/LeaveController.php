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
    public function __construct()
    {
        $this->middleware('db');
    }

    /**
     * Display a listing of the approved list of student.
     *
     * @return \Illuminate\Http\Response
     */
    public function getApprovedLeaveList(Request $request)
    {
        try {
            $teacher = User::where('remember_token',$request->token)->first();
            if ($teacher != null) {
                $division = $teacher->teacher()->lists('division_id');
                $leaves = Leave::whereIn('division_id', $division)->where('status', '1')->orderBy('from date', 'asc')->get();
                $message = 'success';
                $status = 200;
                $teacher = $leaves->toArray();
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
            "ApprovedList" => $teacher
        ];
        return response($response, $status);
    }
}
