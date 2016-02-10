<?php

namespace App\Http\Controllers\api;

use App\Attendance;
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
                $batchInfo[$i]['id'] = $batchName['id'];
                $batchInfo[$i]['name'] = $batchName['name'];
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
            "data" => $batchInfo
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
                    $classes[$i]['class_id'] = $classId['class_id'];
                    $classes[$i]['class_name'] = $className['class_name'];
                    $i++;
                }
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
            "data" => $classes
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
                     ->select('divisions.id as division_id','division_name')->get();
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
            $attendanceData=array();
            $role=Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if (!Empty($role)) {
                $studentData=$data['student_id'];
                if (!Empty($studentData)) {
                    $markedAttendance=Attendance::where('teacher_id','=',$data['teacher']['id'])
                        ->where('date','=',$data['date'])
                        ->wherein('student_id',$studentData)->get()->toArray();
                    if (!Empty($markedAttendance)) {
                        foreach($studentData as $value) {
                            $attendanceData['teacher_id']=$data['teacher']['id'];
                            $attendanceData['date']=$data['date'];
                            $attendanceData['student_id']=$value;
                            $attendanceData['status']=1;
                            Attendance::where('student_id',$value)->delete();
                            Attendance::insert($attendanceData);
                            $status = 200;
                            $message = "Attendance Successfully updated";
                        }
                    } else {
                        foreach($studentData as $value) {
                            $attendanceData['teacher_id']=$data['teacher']['id'];
                            $attendanceData['date']=$data['date'];
                            $attendanceData['student_id']=$value;
                            $attendanceData['status']=1;
                            Attendance::insert($attendanceData);
                        }
                    }
                }
            } else {
                $status=404;
                $message="Sorry!! Only class teacher can mark attendance";
            }
        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message
        ];
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

    public function viewAttendance(Requests\ViewRequest $request)
    {
     try{
         $data=$request->all();
         $roleId=UserRoles::where('slug','=',['student'])->pluck('id');
         $division=Division::where('id',$request->division_id)->first();
         $studentArray = User::where('division_id',$division->id)
                 ->where('role_id','=',$roleId)->lists('id');
         $absentList = Attendance::wherein('student_id',$studentArray)
                                    ->where('date',$request->date)
             ->
             lists('student_id');
         return $absentList;
         $absentStudentInfo = User::wherein('id',$absentList)->select('id','first_name','last_name','roll_number')->get();
         $leaveApplied= Leave::where('division_id',$division->id)->where('from date',$request->date)->lists('student_id');
         $leaveAppliedStudentInfo = User::wherein('id',$leaveApplied)->select('id','first_name','last_name','roll_number')->get();
         $leaveApproved= Leave::where('division_id',$division->id)
                                   ->where('from date',$request->date)
                                   ->where('status',1)
                                   ->lists('student_id');
         $leaveApprovedStudentInfo = User::wherein('id',$leaveApproved)->select('id','first_name','last_name','roll_number')->get();
         if($absentStudentInfo->toArray() != null || $leaveAppliedStudentInfo->toArray() != null || $leaveApprovedStudentInfo->toArray() != null){
              $data['absent-list'] =$absentStudentInfo->toArray();
              $data['leaveApplied-list'] =$leaveAppliedStudentInfo->toArray();
              $data['leaveApproved-list'] =$leaveApprovedStudentInfo->toArray();
              $status = 200;
              $message = "successfully";
         }
         else{
             $status = 404;
             $message = "list not found";
         }
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
       }
       $response = ["message" => $message,"data" =>$data];
       return response($response, $status);
    }
}
