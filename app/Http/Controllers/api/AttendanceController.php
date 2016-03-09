<?php

namespace App\Http\Controllers\api;

use App\Attendance;
use App\AttendanceStatus;
use App\Batch;
use App\Classes;
use App\Division;
use App\Leave;
use App\SubjectClassDivision;
use App\User;
use App\UserRoles;
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

    public function markAttendance(Requests\AttendanceRequest $request)
    {
        try{
            $data=$request->all();
            $attendanceData = array();
            $role = Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if (!Empty($role)) {
                $studentData=$data['student_id'];
                if (!Empty($studentData)) {
                    $markedAttendance = Attendance::where('teacher_id','=',$data['teacher']['id'])
                        ->where('date','=',$data['date'])->get()->toArray();
                    if (!Empty($markedAttendance)) {
                        Attendance::where('date',$data['date'])->delete();
                        foreach($studentData as $value) {
                            $attendanceData['teacher_id']=$data['teacher']['id'];
                            $attendanceData['date']=$data['date'];
                            $attendanceData['student_id']=$value;
                            $attendanceData['created_at']= Carbon::now();
                            $attendanceData['updated_at']= Carbon::now();
                            Attendance::insert($attendanceData);
                            $status = 200;
                            $message = "Attendance Successfully updated";
                        }
                    } else {
                        $status = 200;
                        $message = "Attendance Successfully Marked";
                        foreach($studentData as $value) {
                            $attendanceData['teacher_id']=$data['teacher']['id'];
                            $attendanceData['date']=$data['date'];
                            $attendanceData['student_id']=$value;
                            $attendanceData['created_at']= Carbon::now();
                            $attendanceData['updated_at']= Carbon::now();
                            Attendance::insert($attendanceData);
                        }
                        $attendanceStatus['division_id']=$role['id'];
                        $attendanceStatus['date']=$data['date'];
                        $attendanceStatus['status']=1;
                        $attendanceStatus['created_at']= Carbon::now();
                        $attendanceStatus['updated_at']= Carbon::now();
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

    public function getStudentsList(Requests\AttendanceRequest $request )
    {
        try{
            $data = $request->all();
            $finalList = array();
            $markedAttendance = array();
            $leaveApplied = array();
            $divisionId = Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if (!Empty($divisionId)) {
                $studentRole = UserRoles::where('slug',['student'])->pluck('id');
                $studentList = User::where('role_id','=',$studentRole)
                    ->where('division_id','=', $divisionId['id'])
                    ->select('id')
                    ->get();
                $attendanceStatus = AttendanceStatus::where('date','=',$data['date'])
                    ->where('division_id','=',$divisionId['id'])
                    ->where('status','=',1)
                    ->first();
                if(!Empty($attendanceStatus)) {
                    if (!Empty($studentList)) {
                        $status = 200;
                        $message = "Successfully listed";
                        $markedAttendance = Attendance::where('teacher_id','=',$data['teacher']['id'])
                            ->where('date','=',$data['date'])
                            ->select('student_id')
                            ->get()->toArray();
                        $date = $data['date'];
                        $leaveApplied = Leave::select('*')->whereRaw("('$date' between from_date and end_date)")
                            ->wherein('student_id',$studentList)
                            ->get()->toArray();
                    }
                    $i = 0;
                    foreach ($studentList as $students) {
                        $flag = 0;
                        foreach ($markedAttendance as $absents) {
                            if (in_array ($students['id'] , $absents)) {
                                $finalList['studentList'][$i]['id'] = $students['id'];
                                $finalList['studentList'][$i]['absent_status'] = 1;
                                $flag = 1;
                                $i++;
                            }
                        }
                        if ($flag == 0) {
                            $finalList['studentList'][$i]['id'] = $students['id'];
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
                                $finalList['studentList'][$i]['leave_status']=1;
                                $flag=1;
                                $i++;
                            }
                        }
                        if ($flag == 0) {
                            $finalList['studentList'][$i]['id']=$students['id'];
                            $finalList['studentList'][$i]['leave_status']=0;
                            $i++;
                        }
                    }
                    $markedAttendance = Attendance::where('teacher_id','=',$data['teacher']['id'])
                        ->where('date','=',$data['date'])
                        ->lists('student_id')->toArray();
                    $finalList['absentList'] = $markedAttendance;
                } else {
                    $status = 406;
                    $message = "No attendance found for this instance";
                }
            }else {
                $status = 404;
                $message = "Sorry!! Only class teacher can edit attendance";
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
            $finalList = array();
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
                    $markedAttendance = Attendance::where('teacher_id','=',$data['teacher']['id'])
                        ->where('date','=',$data['date'])
                        ->select('student_id as id')
                        ->get()->toArray();
                    $date=$data['date'];
                }
                if(Empty($markedAttendance)) {
                    $status = 200;
                    $message = "All students were present on this day";
                }
                $i=0;
                foreach ($markedAttendance as $absents) {
                    $finalList[$i]['id'] = $absents['id'];
                    $leaveApplied = Leave::select('*')->whereRaw("('$date' between from_date and end_date)")
                        ->where('student_id', $absents['id'])
                        ->select('student_id as id','status','created_at','updated_at')->first();
                    if(!Empty($leaveApplied)) {
                        $finalList[$i]['leave_status'] = $leaveApplied['status'];
                    } else {
                        $finalList[$i]['leave_status'] = 0 ;
                    }
                    $user =  User::where('id','=',$absents['id'])->select('roll_number','first_name','last_name')->first();;
                    $finalList[$i]['roll_number'] = $user['roll_number'];
                    $finalList[$i]['name'] = $user['first_name']."".$user['last_name'];
                    $finalList[$i]['applied_on'] = date("M j",strtotime(date("Y-m-d ",strtotime($leaveApplied['created_at']))));
                    $finalList[$i]['approved_at'] = date("M j",strtotime(date("Y-m-d ",strtotime($leaveApplied['updated_at']))));
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
            $data=$request->all();
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
                $leaveApplied = Leave::select('*')->whereRaw("('$date' between from_date and end_date)")
                    ->where('student_id','=',$data['student_id'])
                    ->first();
                if(!Empty($studentAttendance)) {
                    if(!Empty($leaveApplied)) {
                        $status = 200;
                        $message = "Your child was absent for this day";
                        $attendanceData['leaveStatus'] = $leaveApplied['status'];
                        $attendanceData['applied_on'] = $leaveApplied['status'];
                        $attendanceData['applied_on'] = date("M j",strtotime(date("Y-m-d ",strtotime($leaveApplied['created_at']))));
                        $approvedBy = User::where('id','=',$leaveApplied['approved_by'])->select('first_name','last_name')->first();
                        $attendanceData['approved_by'] = $approvedBy['first_name']." ".$approvedBy['last_name'];
                        $attendanceData['approved_at'] =date("M j ",strtotime(date("Y-m-d ",strtotime($leaveApplied['updated_at']))));
                    } else {
                        $status = 200;
                        $message = "Your child was absent for this day";
                        $attendanceData['leaveStatus'] = null;
                    }
                } else {
                    if(!Empty($leaveApplied)) {
                        $status = 200;
                        $message = "Your child was present for this day";
                        $attendanceData['leaveStatus'] = $leaveApplied['status'];
                        $attendanceData['applied_on'] = $leaveApplied['status'];
                        $attendanceData['applied_on'] = date("M j",strtotime(date("Y-m-d ",strtotime($leaveApplied['created_at']))));
                        $approvedBy = User::where('id','=',$leaveApplied['approved_by'])->select('first_name','last_name')->first();
                        $attendanceData['approved_by'] = $approvedBy['first_name']." ".$approvedBy['last_name'];
                        $attendanceData['approved_at'] =date("M j ",strtotime(date("Y-m-d ",strtotime($leaveApplied['updated_at']))));
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

    public function viewDefaultAttendanceTeacher(Requests\ViewRequest $request )
    {
        try{
            $data = $request->all();
            $division = array();
            $status = 200;
            $message = "Successfully Listed";
            $studentAttendance = array();
            $division = Division::where('class_teacher_id' , '=' , $data['teacher']['id'])->pluck('id');
            if (Empty($division)) {
                $division = SubjectClassDivision::where('teacher_id','=',$data['teacher']['id'])->pluck('division_id');
            }
            $roleId = UserRoles::where('slug','=',['student'])->pluck('id');
            $students = User::where('division_id',$division)
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
}