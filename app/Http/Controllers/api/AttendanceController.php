<?php

namespace App\Http\Controllers\api;

use App\Attendance;
use App\AttendanceStatus;
use App\Batch;
use App\Classes;
use App\Division;
use App\Leave;
use App\LeaveRequest;
use App\SubjectClassDivision;
use App\User;
use App\UserRoles;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;


class AttendanceController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }

    /*
   * Function Name: getAttendanceBatches
   * Param : Request $requests
   * Return :Return the data of batches as JSON array
   * Desc : Display list of batches to the teacher to mark attendance
   * Developed By : Amol Rokade
   * Date : 6/2/2016
   */

    public function getAttendanceBatches(Request $requests)
    {
        try{
            $data = $requests->all();
            $division = array();
            $batchInfo = array();
            $classes = array();
            $divisionArray = array();
            $k = 0;
            $divisions = Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if (!Empty($divisions)) {
                $divisionData = SubjectClassDivision::where('division_id','=',$divisions['id'])
                    ->orwhere('teacher_id','=',$data['teacher']['id'])
                    ->select('division_id')
                    ->get()->toArray();
            } else {
                $divisionData=SubjectClassDivision::where('teacher_id','=',$data['teacher']['id'])
                    ->select('division_id')
                    ->get()->toArray();
            }
            if (!Empty($divisionData)) {
                foreach ($divisionData as $value) {
                    $division['id'][$k] = $value['division_id'];
                    $k++;
                }
            }
            $divisionArray = array_unique($division['id'],SORT_REGULAR);
            $i=0;
            foreach ($divisionArray  as $value)
            {
                $classId = Division::where('id','=',$value)->select('divisions.class_id as class_id')->first();
                $className = Classes::where('id','=',$classId['class_id'])->select('class_name as class_name', 'batch_id as batch_id')->first();
                if (!Empty($classId)) {
                    $classes[$i]['id'] = $classId['class_id'];
                    $classes[$i]['name'] = $className['class_name'];
                    $classes[$i]['batch_id'] = $className['batch_id'];
                    $i++;
                }
            }
            $i = 0;
            foreach ($classes as $row) {
                $batchName = Batch::where('id',$row['batch_id'])->first();
                $batchInfo[$batchName['id']]['id'] = $batchName['id'];
                $batchInfo[$batchName['id']]['name'] = $batchName['name'];
                $i++;
            }
            $i=0;
            foreach($batchInfo as $value) {
                $finalBatchInfo[$i]=$value;
                $i++;
            }
            $status = 200;
            $message = "Successfully Listed";
        }catch (\Exception     $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalBatchInfo
        ];
        return response($response, $status);
    }

    /*
    * Function Name: getAttendanceClasses
    * Param : Request $requests $batchId
    * Return : Return the data of classes as JSON array
    * Desc : Display list of classes to the teacher to mark attendance
    * Developed By : Amol Rokade
    * Date : 6/2/2016
    */

    public function getAttendanceClasses(Request $requests , $batchId)
    {
        try{
            $data = $requests->all();
            $division = array();
            $classes = array();
            $finalClasses = array();
            $k = 0;
            $divisions = Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if (!Empty($divisions)) {
                $divisionData = SubjectClassDivision::where('division_id','=',$divisions['id'])
                    ->orwhere('teacher_id','=',$data['teacher']['id'])
                    ->select('division_id')
                    ->get()->toArray();
            } else {
                $divisionData = SubjectClassDivision::where('teacher_id','=',$data['teacher']['id'])
                    ->select('division_id')
                    ->get()->toArray();
            }
            if (!Empty($divisionData)) {
                foreach($divisionData as $value) {
                    $division['id'][$k] = $value['division_id'];
                    $k++;
                }
            }
            $divisionArray = array_unique($division['id'],SORT_REGULAR);
            $i = 0;
            foreach ($divisionArray  as $value) {
                $classId = Division::where('id','=',$value)->select('divisions.class_id as class_id')->first();
                $className = Classes::where('batch_id','=',$batchId)
                    ->where('id','=',$classId['class_id'])
                    ->select('class_name as class_name')
                    ->first();
                if ($className!=null) {
                    $classes[$classId['class_id']]['id'] = $classId['class_id'];
                    $classes[$classId['class_id']]['name'] = $className['class_name'];
                    $i++;
                }
            }
            $i=0;
            foreach($classes as $value) {
                $finalClasses[$i]=$value;
                $i++;
            }
            $status = 200;
            $message = "Successfully Listed";
        }catch (\Exception     $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalClasses
        ];
        return response($response, $status);
    }


    /*
    * Function Name: getAttendanceDivisions
    * Param : Request $requests $classId
    * Return : Return the data of Divisions as JSON array
    * Desc : Display list of Divisions to the teacher to mark attendance
    * Developed By : Amol Rokade
    * Date : 6/2/2016
    */

    public function getAttendanceDivisions(Request $requests , $classId)
    {
        try{
            $data = $requests->all();
            $division = array();
            $k = 0;
            $divisions = Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if (!Empty($divisions)) {
                $divisionData = SubjectClassDivision::where('division_id','=',$divisions['id'])
                    ->orwhere('teacher_id','=',$data['teacher']['id'])
                    ->select('division_id')
                    ->get()->toArray();
            } else {
                $divisionData = SubjectClassDivision::where('teacher_id','=',$data['teacher']['id'])
                    ->select('division_id')
                    ->get()->toArray();
            }
            if (!Empty($divisionData)){
                foreach($divisionData as $value){
                    $division['id'][$k]=$value['division_id'];
                    $k++;
                }
            }
            $divisionArray = array_unique($division['id'],SORT_REGULAR);
            $finalDivisions = Division::where('class_id','=',$classId)
                ->wherein('id',$divisionArray)
                ->select('divisions.id as id','division_name as name')->get()->toArray();
            $status = 200;
            $message = "Successfully Listed";
        } catch (\Exception     $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalDivisions
        ];
        return response($response, $status);
    }

    /*
   * Function Name: markAttendance
   * Param : Request $requests $classId
   * Return : $status $message
   * Desc : A class teacher can mark attendance of his/her own class.
   * Developed By : Amol Rokade
   * Date : 6/2/2016
   */

    public function markAttendance(Requests\CreateAttendnce $request)
    {
        try{
            $data = $request->all();
            $status = 200;
            $message = "Attendance Successfully Marked";
            $data['teacher']['id'] = User::where('remember_token','=',$data['token'])->pluck('id');
            $attendanceData = array();
            $role = Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if (!Empty($role)) {
                $studentData = $data['student_id'];
                if (!Empty($studentData)) {
                    $markedAttendance = Attendance::where('teacher_id','=',$data['teacher']['id'])
                        ->where('date','=',$data['date'])->get()->toArray();
                    if (!Empty($markedAttendance)) {
                        Attendance::where('date',$data['date'])->delete();
                        foreach($studentData as $value) {
                            $attendanceData['teacher_id'] = $data['teacher']['id'];
                            $attendanceData['date'] = $data['date'];
                            $attendanceData['division_id'] = $role['id'];
                            $attendanceData['student_id'] = $value;
                            $attendanceData['created_at'] = Carbon::now();
                            $attendanceData['updated_at'] = Carbon::now();
                            Attendance::insert($attendanceData);
                            $status = 200;
                            $message = "Attendance Successfully updated";
                        }
                    } else {

                        foreach($studentData as $value) {
                            $attendanceData['teacher_id'] = $data['teacher']['id'];
                            $attendanceData['date'] = $data['date'];
                            $attendanceData['division_id'] = $role['id'];
                            $attendanceData['student_id'] = $value;
                            $attendanceData['created_at'] = Carbon::now();
                            $attendanceData['updated_at'] = Carbon::now();
                            Attendance::insert($attendanceData);
                        }
                        $attendanceStatus['division_id'] = $role['id'];
                        $attendanceStatus['date'] = $data['date'];
                        $attendanceStatus['status'] = 1;
                        $attendanceStatus['created_at'] = Carbon::now();
                        $attendanceStatus['updated_at'] = Carbon::now();
                        AttendanceStatus::insert($attendanceStatus);
                    }
                }
            } else {
                $status=404;
                $message="Sorry!! Only class teacher can mark attendance";
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message
        ];
        return response($response, $status);
    }

    /*
    * Function Name: getStudentsList
    * Param : Request $requests $date
    * Return : $status $message
    * Desc : A class teacher view attendance of perticular day or edit attendance.
    * Developed By : Amol Rokade
    * Date : 15/2/2016
    */

    public function getStudentsList(Requests\CreateAttendnce $request )
    {
        try{
            $data = $request->all();
            $data['teacher']['id'] = User::where('remember_token','=',$data['token'])->pluck('id');
            $finalList = array();
            $markedAttendance = array();
            $leaveApplied = array();
            $divisionId = Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if (!Empty($divisionId)) {
                $studentRole = UserRoles::where('slug',['student'])->pluck('id');
                $studentList = User::where('role_id','=',$studentRole)
                    ->where('division_id','=', $divisionId['id'])
                    ->select('id','first_name','last_name','roll_number')
                    ->get();
                $i = 0;
                if (!Empty($studentList)) {
                    $status = 200;
                    $message = "Successfully listed";
                    $markedAttendance = Attendance::where('teacher_id','=',$data['teacher']['id'])
                        ->where('date','=',$data['date'])
                        ->select('student_id')
                        ->get()->toArray();
                    $date = $data['date'];
                    $leaveApplied = LeaveRequest::select('*')->whereRaw("('$date' between from_date and end_date)")
                        ->wherein('student_id',$studentList)
                        ->get()->toArray();
                }
                $i = 0;
                foreach ($studentList as $students) {
                    $flag = 0;
                    foreach ($markedAttendance as $absents) {
                        if (in_array ($students['id'] , $absents)) {
                            $finalList['studentList'][$i]['id'] = $students['id'];
                            $finalList['studentList'][$i]['name'] = $students['first_name']." ".$students['last_name'];
                            $finalList['studentList'][$i]['roll_number'] = $students['roll_number'];
                            $finalList['studentList'][$i]['absent_status'] = 1;
                            $flag = 1;
                            $i++;
                        }
                    }
                    if ($flag == 0) {
                        $finalList['studentList'][$i]['id'] = $students['id'];
                        $finalList['studentList'][$i]['name'] = $students['first_name']." ".$students['last_name'];
                        $finalList['studentList'][$i]['roll_number'] = $students['roll_number'];
                        $finalList['studentList'][$i]['absent_status'] = 0;
                        $i++;
                    }
                }
                if (Empty($markedAttendance)) {
                    $status = 200;
                    $message = "All students were present on this day";
                }
                $i=0;
                foreach ($studentList as $students) {
                    $flag = 0;
                    foreach ($leaveApplied as $absents) {
                        if (in_array($students['id'],$absents)) {
                            $finalList['studentList'][$i]['id']=$students['id'];
                            $finalList['studentList'][$i]['name'] = $students['first_name']." ".$students['last_name'];
                            $finalList['studentList'][$i]['roll_number'] = $students['roll_number'];
                            $finalList['studentList'][$i]['leave_status']=1;
                            $flag=1;
                            $i++;
                        }
                    }
                    if ($flag == 0) {
                        $finalList['studentList'][$i]['id']=$students['id'];
                        $finalList['studentList'][$i]['name'] = $students['first_name']." ".$students['last_name'];
                        $finalList['studentList'][$i]['roll_number'] = $students['roll_number'];
                        $finalList['studentList'][$i]['leave_status']=0;
                        $i++;
                    }
                }
                $markedAttendance = Attendance::where('teacher_id','=',$data['teacher']['id'])
                    ->where('date','=',$data['date'])
                    ->lists('student_id')->toArray();
                $finalList['absentList'] = $markedAttendance;
            }else {
                $status = 404;
                $message = "Sorry!! Only class teacher can edit attendance";
            }
            $finalList['batchName'] = 1;
            $finalList['className'] = 1;
            $finalList['divisionName'] = 1;
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $finalList
        ];
        return response($response, $status);
    }

    /*
    * Function Name: viwAttendanceTeacher
    * Param : Request $requests $date
    * Return : $status $message
    * Desc : A teacher related to division i.e. class teacher/subject teacher can view attendance of perticular day.
    * Developed By : Amol Rokade
    * Date : 15/2/2016
    */

    public function viwAttendanceTeacher(Requests\ViewRequest $request )
    {
        try{
            $data = $request->all();
            $data['teacher']['id'] = User::where('remember_token','=',$data['token'])->pluck('id');
            $finalList = array();
            $date = $data['date'];
            $markedAttendance = array();
            $leaveApplied = array();
            $attendanceStatus = array();
            $studentList = array();
            $studentRole = UserRoles::where('slug',['student'])->pluck('id');
            $studentList = User::where('role_id','=',$studentRole)
                    ->where('division_id','=',$data['division_id'])
                    ->select('id')
                    ->get();
            $attendanceStatus = AttendanceStatus::where('date','=',$data['date'])
                ->where('division_id','=',$data['division_id'])
                ->where('status','=',1)
                ->first();
            if (!Empty($attendanceStatus)) {
                if (!Empty($studentList)) {
                    $status = 200;
                    $message = "Successfully listed";
                    $markedAttendance = Attendance::where('date','=',$data['date'])
                        ->where('division_id','=',$data['division_id'])
                        ->select('student_id as id')
                        ->get()->toArray();
                }
                if(Empty($markedAttendance)) {
                    $status = 200;
                    $message = "All students were present on this day";
                }
                $i=0;
                foreach ($markedAttendance as $absents) {
                    $finalList[$i]['student_id'] = $absents['id'];
                    $leaveApplied = LeaveRequest::select('*')->whereRaw("('$date' between from_date and end_date)")
                        ->where('student_id', '=', $absents['id'])
                        ->select('student_id as id','status','created_at','updated_at','approved_by')->first();
                    if(!Empty($leaveApplied)) {
                        $finalList[$i]['leave_status'] = $leaveApplied['status'];
                    } else {
                        $finalList[$i]['leave_status'] = 0 ;
                    }
                    $user =  User::where('id','=',$absents['id'])->select('roll_number','first_name','last_name')->first();
                    $finalList[$i]['name'] = $user['first_name']." ".$user['last_name'];
                    $finalList[$i]['roll_number'] = $user['roll_number'];
                    if($finalList[$i]['leave_status'] == 0) {
                        $finalList[$i]['applied_on'] = " ";
                        $finalList[$i]['approved_at'] = " ";
                        $finalList[$i]['approved_by'] = " ";
                    } else if ($finalList[$i]['leave_status'] == 1){
                        $finalList[$i]['applied_on'] = date("M j y",strtotime(date("Y-m-d ",strtotime($leaveApplied['created_at']))));
                        $finalList[$i]['approved_at'] = " ";
                        $finalList[$i]['approved_by'] = " ";
                    } else {
                        $finalList[$i]['applied_on'] = date("M j y",strtotime(date("Y-m-d ",strtotime($leaveApplied['created_at']))));
                        $finalList[$i]['approved_at'] = date("M j y",strtotime(date("Y-m-d ",strtotime($leaveApplied['updated_at']))));
                        $user =  User::where('id','=',$leaveApplied['approved_by'])->select('first_name','last_name')->first();;
                        $finalList[$i]['approved_by'] = $user['first_name']." ".$user['last_name'];
                    }
                    $i++;
                }
            } else {
                $status = 406;
                $message = "No attendance found for this instance";
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $finalList
        ];
        return response($response, $status);
    }

    /*
    * Function Name: viewAttendanceParent
    * Param : Request $requests  $student_id $date
    * Return : $status $message
    * Desc : A parent can view attendance of his/her child of perticular day requested by user.
    * Developed By : Amol Rokade
    * Date : 16/2/2016
    */

    public function viewAttendanceParent(Requests\viewAttendanceParent $request)
    {
       try{
           $data = $request->all();
           $data['teacher']['id'] = User::where('remember_token','=',$data['token'])->pluck('id');
           $attendanceData = array();
            $studentDivisionId=User::where('id','=',$data['student_id'])->select('division_id')->first();
            $attendanceStatus=AttendanceStatus::where('date','=',$data['date'])
                ->where('division_id','=',$studentDivisionId['division_id'])
                ->where('status','=',1)
                ->first();
            if(!Empty($attendanceStatus)) {
                $studentAttendance = Attendance::where('student_id','=',$data['student_id'])
                    ->where('date','=',$data['date'])
                    ->get()->toArray();
                $date=$data['date'];
                $leaveApplied = LeaveRequest::select('*')->whereRaw("('$date' between from_date and end_date)")
                    ->where('student_id','=',$data['student_id'])
                    ->first();
                if(!Empty($studentAttendance)) {
                    if(!Empty($leaveApplied)) {
                        $status = 200;
                        $message = "Your child was absent for this day";
                        $attendanceData['attendance-data']['leaveStatus'] = $leaveApplied['status'];
                        $attendanceData['attendance-data']['applied_on'] = $leaveApplied['status'];
                        $attendanceData['attendance-data']['applied_on'] = date("M j",strtotime(date("Y-m-d ",strtotime($leaveApplied['created_at']))));
                        $approvedBy = User::where('id','=',$leaveApplied['approved_by'])->select('first_name','last_name')->first();
                        $attendanceData['attendance-data']['approved_by'] = $approvedBy['first_name']." ".$approvedBy['last_name'];
                        $attendanceData['attendance-data']['approved_at'] =date("M j ",strtotime(date("Y-m-d ",strtotime($leaveApplied['updated_at']))));
                    } else {
                        $status = 200;
                        $message = "Your child was absent for this day";
                        $attendanceData['leaveStatus'] = null;
                    }
                } else {
                    if(!Empty($leaveApplied)) {
                        $status = 200;
                        $message = "Your child was present for this day";
                        $attendanceData['attendance-data']['leaveStatus'] = $leaveApplied['status'];
                        $attendanceData['attendance-data']['applied_on'] = $leaveApplied['status'];
                        $attendanceData['attendance-data']['applied_on'] = date("M j",strtotime(date("Y-m-d ",strtotime($leaveApplied['created_at']))));
                        $approvedBy = User::where('id','=',$leaveApplied['approved_by'])->select('first_name','last_name')->first();
                        $attendanceData['attendance-data']['approved_by'] = $approvedBy['first_name']." ".$approvedBy['last_name'];
                        $attendanceData['attendance-data']['approved_at'] =date("M j ",strtotime(date("Y-m-d ",strtotime($leaveApplied['updated_at']))));
                    } else {
                        $status = 200;
                        $message = "Your child was present for this day";
                        $attendanceData['leaveStatus'] = null;
                    }
                }
            } else {
                $status = 406;
                $message = "No attendance found for this instance";
            }
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $attendanceData
        ];
        return response($response, $status);
    }

    /*
    * Function Name: viewDefaultAttendanceParent
    * Param : Request $requests  $student_id
    * Return : $status $message $studentAttendance
    * Desc : A parent can view default months attendance of his/her child.
    * Developed By : Amol Rokade
    * Date : 04/03/2016
    */

    public function viewDefaultAttendanceParent(Requests\viewAttendanceParent $request ,$student_id )
    {
        try{
            $studentAttendance = array();
            $studentAttendance = Attendance::where('student_id','=',$student_id)->select('date')->groupBy('date')->orderBy('date','ASC')->get()->toArray();
            $status = 200;
            $message = "Successfully Listed";
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $studentAttendance
        ];
        return response($response, $status);
    }

    /*
    * Function Name: viewDefaultAttendanceTeacher
    * Param : Request $requests
    * Return : $status $message $studentAttendance
    * Desc : A teacher can view default months attendance of division.
    * Developed By : Amol Rokade
    * Date : 04/03/2016
    */

    public function viewDateAttendanceTeacher(Requests\ViewRequest $request , $div_id  )
    {
        try{
            $data = $request->all();
            $studentAttendance = array();
            $data['teacher']['id'] = User::where('remember_token','=',$data['token'])->pluck('id');
            $division = array();
            $status = 200;
            $message = "Successfully Listed";
            $studentAttendance = array();
            $roleId = UserRoles::where('slug','=',['student'])->pluck('id');
            $students = User::where('division_id',$div_id)
                ->where('role_id','=',$roleId)
                ->lists('id');
            $studentAttendance = Attendance::wherein('student_id',$students)->select('date')->groupBy('date')->orderBy('date','ASC')->get()->toArray();
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "status" => $status,

            "message" => $message,
            "data" => $studentAttendance
        ];
        return response($response, $status);
    }

    public function viewDefaultAttendanceTeacher(Requests\ViewRequest $request)
    {
        try{
            $data = $request->all();
            $attendance  = array();
            $studentAttendance = array();
            $div_id = Attendance::select('division_id')->first();
            $data['teacher']['id'] = User::where('remember_token','=',$data['token'])->pluck('id');
            $division = array();
            $status = 200;
            $message = "Successfully Listed";
            $studentAttendance = array();
            $roleId = UserRoles::where('slug','=',['student'])->pluck('id');
            $students = User::where('division_id','=',$div_id['division_id'])
                ->where('role_id','=',$roleId)
                ->lists('id');
            $studentAttendance = Attendance::wherein('student_id',$students)->select('date')->groupBy('date')->orderBy('date','ASC')->get()->toArray();
            $divisionName = Division::where('id',$div_id['division_id'])->select('division_name','class_id')->first();
            $class = Classes::where('id','=',$divisionName['class_id'])->select('id','class_name','batch_id')->first();
            $batch = Batch::where('id','=',$class['batch_id'])->select('id','name')->first();
            $attendance['absentDates'] = $studentAttendance;
            $attendance['batchId'] = $batch['id'];
            $attendance['batchName'] = $batch['name'];
            $attendance['classId'] = $class['id'];
            $attendance['className'] = $class['class_name'];
            $attendance['divId'] = $div_id['division_id'];
            $attendance['divName'] = $divisionName['division_name'];
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $attendance
        ];
        return response($response, $status);
    }
}