<?php

namespace App\Http\Controllers\api;

use App\Batch;
use App\Classes;
use App\Division;
use App\Subject;
use App\SubjectClassDivision;
use App\Timetable;
use App\User;
use App\UserRoles;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TimetableController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }

    /*
    * Function Name : getBatches
    * Param : Request $requests
    * Return : $message $status
    * Desc : when teacher want to see timetable teacher will get all the batches related to his/her body.
    * Developed By : Amol Rokade
    *Date : 4/2/2016
    */
    public function getBatches(Request $requests)
    {
        try{
            $batches = array();
            $data=$requests->all();
            $teacherId = UserRoles::where('slug',['teacher'])->pluck('id');
            if($teacherId != null){
                if($data['teacher']['role_id'] == $teacherId){
                    $batches = Batch::select('id as batch_id ','name as batch_name')->get()->toArray();
                }
            }
            $status = 200;
            $message = "Successfully Listed";
        }catch (\Exception $e) {
        $status = 500;
        $message = "Something went wrong";
        }
        $response = [
         "message" => $message,
         "status" => $status,
         "data" => $batches
        ];
        return response($response, $status);
    }

    /*
   * Function Name : getClasses
   * Param : Request $requests $batchId
   * Return : $message $status
   * Desc : when teacher want to see timetable teacher will get all the classes related to selected batches.
   * Developed By : Amol Rokade
   *Date : 4/2/2016
   */
    public function getClasses(Request $requests, $batchId)
    {
        try{
            $classes = array();
            $classes = Classes::where('batch_id','=',$batchId)->select('id as class_id ','class_name')->get()->toArray();
            $status = 200;
            $message = "Successfully Listed";
        }catch (\Exception $e) {
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
   * Function Name : getDivisions
   * Param : Request $requests $classId
   * Return : $message $status
   * Desc : when teacher want to see timetable teacher will get all the divisions related to selected classes.
   * Developed By : Amol Rokade
   *Date : 4/2/2016
   */
    public function getDivisions(Request $requests, $classId)
    {
        try{
            $divisions = array();
            $divisions = Division::where('class_id','=',$classId)->select('id as division_id ','division_name')->get()->toArray();
            $status = 200;
            $message = "Successfully Listed";
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $divisions
        ];
        return response($response, $status);
    }

    /*
    * Function Name : viewTimetableParent
    * Param : Request $requests $studentId $day_id
    * Return :$message $status JSON array of timetable
    * Desc : Parent can see the timetable of his/her students.
    * Developed By : Amol Rokade
    * Date: 4/2/2016
    */
    public function viewTimetableParent(Requests\viewTimetableRequest $request , $studentId , $day_id)
    {
        try{
            $responseData=array();
            $user=User::where('id','=',$studentId)->first();
            $subjectClassDivision=SubjectClassDivision::where('division_id','=',$user['division_id'])->get();
            $finalSubjectClassDivision=array();
            foreach($subjectClassDivision as $value){
                 array_push($finalSubjectClassDivision,$value['id']);
            }
            $timetable=Timetable::wherein('division_subject_id',$finalSubjectClassDivision)
                 ->where('day_id', '=', $day_id)
                 ->orderBy('period_number', 'asc')
                 ->get();
            $i=0;
            foreach($timetable as $value)
            {
                $responseData[$i]['period_number']=$value['period_number'];
                $subjectTeacher=SubjectClassDivision::where('id', '=', $value['division_subject_id'])->first();
                $subjectTeacherArray= $subjectTeacher->toArray();
                $teacher=User::where('id', '=', $subjectTeacherArray['teacher_id'])->first();
                $subject=Subject::where('id', '=', $subjectTeacherArray['subject_id'])->first();
                $responseData[$i]['subject']=$subject['subject_name'];
                $responseData[$i]['teacher']=$teacher['first_name']." ".$teacher['last_name'];
                if($value['is_break'] == 1){
                    $responseData[$i]['is_break'] = "Break";
                }else{
                    $responseData[$i]['is_break'] = $value['is_break'];
                }
                $responseData[$i]['start_time']=$value['start_time'];
                $responseData[$i]['end_time']=$value['end_time'];
                $i++;
            }
            $message = 'success';
            $status = 200;
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $responseData
        ];
        return response($response, $status);
    }

    /*
    * Function Name : viewTimetableTeacher
    * Param : Request $requests $batch $class $div $day
    * Return : $message $status JSON array of timetable
    * Desc : Teacher can see the timetable of all bodies divisions based on selection.
    * Developed By : Amol Rokade
    * Date : 4/2/2016
    */
    public function viewTimetableTeacher(Requests\viewTimetableRequest $request , $div_id,$day_id)
    {
        try{
            $finalTimetable=array();
            $subjectClassDivision=SubjectClassDivision::where('division_id','=',$div_id)->get();
            $finalSubjectClassDivision=array();
            foreach($subjectClassDivision as $value){
                array_push($finalSubjectClassDivision,$value['id']);
            }
            $timetable=Timetable::wherein('division_subject_id',$finalSubjectClassDivision)
                  ->where('day_id', '=', $day_id)
                  ->orderBy('period_number', 'asc')
                  ->get();
            $i=0;
            foreach($timetable as $value)
            {
                $finalTimetable[$i]['period_number'] = $value['period_number'];
                $subjectTeacher = SubjectClassDivision::where('id', '=', $value['division_subject_id'])->first();
                $subjectTeacherArray= $subjectTeacher->toArray();
                $teacher = User::where('id', '=', $subjectTeacherArray['teacher_id'])->first();
                $subject = Subject::where('id', '=', $subjectTeacherArray['subject_id'])->first();
                $finalTimetable[$i]['subject'] = $subject['subject_name'];
                $finalTimetable[$i]['teacher'] = $teacher['first_name']." ".$teacher['last_name'];
                if($value['is_break'] == 1){
                    $finalTimetable[$i]['is_break'] = "Break";
                }else{
                    $finalTimetable[$i]['is_break'] = $value['is_break'];
                }
                $finalTimetable[$i]['start_time'] = $value['start_time'];
                $finalTimetable[$i]['end_time'] = $value['end_time'];
                $i++;
            }
            $message = 'success';
            $status = 200;
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalTimetable
        ];
        return response($response, $status);
    }
}