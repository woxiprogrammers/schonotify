<?php

namespace App\Http\Controllers\api;

use App\Batch;
use App\Classes;
use App\Division;
use App\LeaveType;
use App\SubjectClassDivision;
use Carbon\Carbon;
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

    /*
       * Function Name : getLeaveListParent
       * Param : Request $requests $leave_id $student_id
       * Return : Return the array of pending and approved leaves depending upon condition  and status .
       * Desc : if the leave id is 1 the it returns the pending leaves and if leave_id is 2 then
       *        it returns approved leave list to parent of the students only.
       * Developed By : Amol Rokade
       * Date : 20/2/2016
       */

    public function getLeaveListParent(Requests\Leave $request , $flag , $student_id)
    {
        try {
            $leaveData = array();
            if ( $flag == 1 ) // 1 is for pending leaves
                {
                    $message = 'Successfully Listed';
                    $status = 200;
                    $leaves = Leave::where('student_id', $student_id)
                        ->where('status', '1') //1 is for pending leaves and 2 for approved leaves.
                        ->orderBy('created_at', 'ASC')
                        ->get()->toArray();
                } else if( $flag == 2 ) {
                    $message = 'Successfully Listed';
                    $status = 200;
                    $leaves = Leave::where('student_id', $student_id)
                        ->where('status', '2') //1 is for pending leaves and 2 for approved leaves.
                        ->orderBy('created_at', 'ASC')
                        ->get()->toArray();
                }
                $i=0;
                if(!Empty($leaves)) {
                    foreach($leaves as $leave){
                        $studentDivision = Division::where('id',$leave['division_id'])->first();
                        $studentClass = Classes::where('id',$studentDivision['class_id'])->first();
                        $studentBatch = Batch::where('id',$studentClass['batch_id'])->first();
                        $studentName = User::where('id',$leave['student_id'])->first();
                        $leaveData[$i]['leave_id'] = $leave['id'];
                        $leaveData[$i]['student_id'] = $leave['student_id'];
                        $leaveData[$i]['leave_type'] = LeaveType::where('id','=',$leave['leave_type_id'])->pluck('name');
                        $leaveData[$i]['title'] = $leave['title'];
                        $leaveData[$i]['applied_on'] = date("Y-m-d ",strtotime($leave['created_at']));
                        $leaveData[$i]['form_date'] = $leave['from_date'];
                        $leaveData[$i]['end_date'] = $leave['end_date'];
                        $leaveData[$i]['name'] = $studentName['first_name']." ".$studentName['last_name'];
                        $leaveData[$i]['batch'] = $studentBatch['name'];
                        $leaveData[$i]['class'] = $studentClass['class_name'];
                        $leaveData[$i]['division'] = $studentDivision['division_name'];
                        $i++;
                    }
                } else {
                    $status = 404;
                    $message = "Sorry ! No leaves found for this instance";
                }
        } catch (\Exception $e) {
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $leaveData
        ];
        return response($response, $status);
    }

    /*
     * Function Name : getLeaveListTeacher
     * Param : Request $requests $leave_id
     * Return : Return the array of pending and approved leaves depending upon condition  and status .
     * Desc : if the leave id is 1 the it returns the pending leaves and if leave_id is 2 then
     *        it returns approved leave list to class teacher only.
     * Developed By : Amol Rokade
     *Date : 18/2/2016
      */
    public function getLeaveListTeacher(Requests\Leave $request , $flag)
    {
        try {
            $data = $request->all();
            $leaveData = array();
            $division = Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if(!Empty($division)) {
                if ( $flag == 1 ) // 1 is for pending leaves
                {
                    $message = 'Successfully Listed';
                    $status = 200;
                    $leaves = Leave::where('division_id', $division['id'])
                        ->where('status', '1') //1 is for pending leaves and 2 for approved leaves.
                        ->orderBy('created_at', 'ASC')
                        ->get()->toArray();
                } else if( $flag == 2 ) {
                    $message = 'Successfully Listed';
                    $status = 200;
                    $leaves = Leave::where('division_id', $division['id'])
                        ->where('status', '2') //1 is for pending leaves and 2 for approved leaves.
                        ->orderBy('created_at', 'ASC')
                        ->get()->toArray();
                }
                $i=0;
                if(!Empty($leaves)) {
                    foreach($leaves as $leave){
                        $studentDivision = Division::where('id',$leave['division_id'])->first();
                        $studentClass = Classes::where('id',$studentDivision['class_id'])->first();
                        $studentBatch = Batch::where('id',$studentClass['batch_id'])->first();
                        $studentName = User::where('id',$leave['student_id'])->first();
                        $leaveData[$i]['leave_id'] = $leave['id'];
                        $leaveData[$i]['student_id'] = $leave['student_id'];
                        $leaveData[$i]['leave_type'] = LeaveType::where('id','=',$leave['leave_type_id'])->pluck('name');
                        $leaveData[$i]['title'] = $leave['title'];
                        $leaveData[$i]['applied_on'] =  date("Y-m-d ",strtotime($leave['created_at']));
                        $leaveData[$i]['form_date'] = $leave['from_date'];
                        $leaveData[$i]['end_date'] = $leave['end_date'];
                        $leaveData[$i]['name'] = $studentName['first_name']." ".$studentName['last_name'];
                        $leaveData[$i]['batch'] = $studentBatch['name'];
                        $leaveData[$i]['class'] = $studentClass['class_name'];
                        $leaveData[$i]['division'] = $studentDivision['division_name'];
                        $i++;
                    }
                } else {
                    $status = 404;
                    $message = "Sorry ! No leaves found for this instance";
                }
            } else {
                $message = 'Sorry ! Only class teacher can access this functionality';
                $status = 406;
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $leaveData
        ];
        return response($response, $status);
    }

    /*
    * Function Name : approveLeave
    * Param : Request $requests
    * Return : message and status .
    * Desc : a class teacher can approve leaves of student.
    * Developed By : Amol Rokade
    * Date : 17 /2/2016
     */

    public function approveLeave(Requests\LeaveApproveRequest $request){
        try{
            $data = $request->all();
            if(Leave::where('id', $data['leave_id'])->first()!=null) {
                $status=Leave::where('id', $data['leave_id'])->pluck('status');
                if ( $status == 1 ) {
                    Leave::where('id', $data['leave_id'])->update(['status' => 2]);
                    $message = 'Leave Approved Successfully';
                    $status = 200;
                } else {
                    $message = 'Operation Not allowed.';
                    $status = 406;
                }
            } else {
                $message = 'Leave Not Found';
                $status = 406;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message
        ];
        return response($response, $status);
    }

    /*
     * Function Name : createLeave
     * Param : Request $requests
     * Return : message and status .
     * Desc : parent can create a leave for studenta and by default it will be in pending status.
     * Developed By : Amol Rokade
     * Date : 17 /2/2016
      */

    public function createLeave(Requests\Leave $request){
        try{
            $data=$request->all();
            $status = 200;
            $message = 'Leave Applied Successfully.';
            $createData['student_id'] = $data['student_id'];
            $createData['division_id'] = User::where('id','=',$data['student_id'])->pluck('division_id');
            $createData['status'] = 1;
            $createData['title'] = $data['title'];
            $createData['leave_type_id'] = $data['leave_type_id'];
            $createData['reason'] = $data['reason'];
            $createData['from_date'] = $data['from_date'];
            $createData['end_date'] = $data['end_date'];
            $createData['created_at'] = Carbon::now();
            $createData['updated_at'] = Carbon::now();
            Leave::insert($createData);
        } catch (\Exception $e) {
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message
        ];
        return response($response, $status);
    }

    /*
   * Function Name : leaveTypes
   * Param : Request $requests
   * Return : message , status and JSON array of Leaves Types  .
   * Desc :  Parent will get leaves types to apply i.e. full day or half day
   * Developed By : Amol Rokade
   * Date : 22 /2/2016
    */

    public function leaveTypes(Requests\Leave $request){
        try{
            $message = "Successfully Listed";
            $status = 200;
            $leaveTypes = array();
            $leaveTypes = LeaveType::select('id','name')->get()->toArray();
        } catch (\Exception $e) {
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $leaveTypes
        ];
        return response($response, $status);
    }
}
