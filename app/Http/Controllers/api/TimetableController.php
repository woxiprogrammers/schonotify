<?php

namespace App\Http\Controllers\api;

use App\Batch;
use App\Classes;
use App\DayMaster;
use App\Division;
use App\Subject;
use App\SubjectClassDivision;
use App\Timetable;
use App\User;
use App\UserRoles;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
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
                    $batches = Batch::select('id as id ','name as name')->where('body_id',$data['teacher']['body_id'])->get()->toArray();
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
            $classes = Classes::where('batch_id','=',$batchId)->select('id as id ','class_name as name')->get()->toArray();
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
            $finalDivisions = array();
            $divisions = array();
            $divisions = Division::where('class_id','=',$classId)->get()->toArray();
            $counter = 0;
            foreach ($divisions as $division) {
                $finalDivisions[$counter]['id'] = $division['id'];
                $finalDivisions[$counter]['name'] = $division['division_name'];
                $counter++;
            }
            $status = 200;
            $message = "Successfully Listed";
        }catch (\Exception $e) {
            echo $e->getMessage();
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
            $finalTimetable=array();
            $user=User::where('id','=',$studentId)->first();
            $subjectClassDivision=SubjectClassDivision::where('division_id','=',$user['division_id'])->get();
            $finalSubjectClassDivision=array();
            foreach($subjectClassDivision as $value){
                array_push($finalSubjectClassDivision,$value['id']);
            }
            $timetable=Timetable::wherein('division_subject_id',$finalSubjectClassDivision)
                ->where('day_id', '=', $day_id)
                ->orderBy('start_time', 'asc')
                ->get();
            $timetables=array();
            foreach($timetable as $row)
            {
                $startTime=trim($row->start_time);
                $subStartHours=substr($startTime,0,2);
                $subStartMins=substr($startTime,3,2);
                if($subStartHours>=12)
                {
                    if($subStartHours!=12)
                    {
                        $subStartHours=$subStartHours-12;
                    }
                    $row->start_time=$subStartHours.":".$subStartMins." PM";
                }else{
                    if($subStartHours == 00)
                    {
                        $subStartHours = 12;
                    }
                    $row->start_time=$subStartHours.":".$subStartMins." AM";
                }
                $endTime=trim($row->end_time);
                $subEndHours=substr($endTime,0,2);
                $subEndMins=substr($endTime,3,2);
                if($subEndHours>=12)
                {
                    if($subEndHours!=12)
                    {
                        $subEndHours=$subEndHours-12;
                    }
                    $row->end_time=$subEndHours.":"."$subEndMins"." PM";
                }else{
                    if($subEndHours==00)
                    {
                        $subEndHours=12;
                    }
                    $row->end_time=$subEndHours.":"."$subEndMins"." AM";
                }
                array_push($timetables,$row);
            }
            $i=0;
            if(!Empty($timetables)) {
                $message = 'success';
                $status = 200;
                $finalTimetable['timetable'] = array();
                foreach($timetables as $value)
                {
                    $subjectTeacher = SubjectClassDivision::where('id', '=', $value['division_subject_id'])->first();
                    $subjectTeacherArray= $subjectTeacher->toArray();
                    if( $value['is_break'] == 1) {
                        $finalTimetable['timetable'][$i]['subject'] = "Break";
                        $finalTimetable['timetable'][$i]['teacher'] = "";
                    } else {
                        $teacher = User::where('id', '=', $subjectTeacherArray['teacher_id'])->first();
                        $subject = Subject::where('id', '=', $subjectTeacherArray['subject_id'])->first();
                        $finalTimetable['timetable'][$i]['subject'] = $subject['subject_name'];
                        $finalTimetable['timetable'][$i]['teacher'] = $teacher['first_name']." ".$teacher['last_name'];
                    }
                    $finalTimetable['timetable'][$i]['is_break'] = $value['is_break'];
                    $finalTimetable['timetable'][$i]['start_time'] = $value['start_time'];
                    $finalTimetable['timetable'][$i]['end_time'] = $value['end_time'];
                    $i++;
                }
            }else {
                $status=406;
                $message = 'Sorry ! No timetable found for this instance';
            }
            $day = DayMaster::where('id','=',$day_id)->pluck('name');
            $finalTimetable['div_id'] = $user['division_id'];
            $divisionName = Division::where('id',$user['division_id'])->select('division_name','class_id')->first();
            $class = Classes::where('id','=',$divisionName['class_id'])->select('class_name','batch_id')->first();
            $batch = Batch::where('id','=',$class['batch_id'])->pluck('name');
            $finalTimetable['batchName'] = $batch;
            $finalTimetable['className'] = $class['class_name'];
            $finalTimetable['divisionName'] =  $divisionName['division_name'];
            $finalTimetable['day'] = $day;
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
            $finalTimetable = array();
            $subjectClassDivision = SubjectClassDivision::where('division_id','=',$div_id)->get();
            $finalSubjectClassDivision = array();
            foreach($subjectClassDivision as $value){
                array_push($finalSubjectClassDivision,$value['id']);
            }
            $timetable = Timetable::wherein('division_subject_id',$finalSubjectClassDivision)
                ->where('day_id', '=', $day_id)
                ->orderBy('start_time', 'asc')
                ->get();
            $timetables = array();
            foreach($timetable as $row)
            {
                $startTime = trim($row->start_time);
                $subStartHours = substr($startTime,0,2);
                $subStartMins = substr($startTime,3,2);
                if($subStartHours >= 12) {
                    if($subStartHours != 12) {
                        $subStartHours = $subStartHours-12;
                    }
                    $row->start_time = $subStartHours.":".$subStartMins." PM";
                } else {
                    if($subStartHours == 00) {
                        $subStartHours = 12;
                    }
                    $row->start_time = $subStartHours.":".$subStartMins." AM";
                }
                $endTime = trim($row->end_time);
                $subEndHours = substr($endTime,0,2);
                $subEndMins = substr($endTime,3,2);
                if($subEndHours >= 12) {
                    if($subEndHours != 12) {
                        $subEndHours = $subEndHours-12;
                    }
                    $row->end_time = $subEndHours.":"."$subEndMins"." PM";
                } else {
                    if($subEndHours == 00) {
                        $subEndHours = 12;
                    }
                    $row->end_time = $subEndHours.":"."$subEndMins"." AM";
                }
                array_push($timetables,$row);
            }
            $i = 0;
            $finalTimetable['timetable'] = array();
            if(!Empty($timetables)) {
                $message = 'success';
                $status = 200;
                foreach($timetable as $value)
                {
                    $subjectTeacher = SubjectClassDivision::where('id', '=', $value['division_subject_id'])->first();
                    $subjectTeacherArray = $subjectTeacher->toArray();
                    if( $value['is_break'] == 1) {
                        $finalTimetable['timetable'][$i]['subject'] = "Break";
                        $finalTimetable['timetable'][$i]['teacher'] = "";
                    } else {
                        $teacher = User::where('id', '=', $subjectTeacherArray['teacher_id'])->first();
                        $subject = Subject::where('id', '=', $subjectTeacherArray['subject_id'])->first();
                        $finalTimetable['timetable'][$i]['subject'] = $subject['subject_name'];
                        $finalTimetable['timetable'][$i]['teacher'] = $teacher['first_name']." ".$teacher['last_name'];
                    }
                    $finalTimetable['timetable'][$i]['is_break'] = $value['is_break'];
                    $finalTimetable['timetable'][$i]['start_time'] = $value['start_time'];
                    $finalTimetable['timetable'][$i]['end_time'] = $value['end_time'];
                    $i++;
                }
            } else {
                $status = 406;
                $message = 'Sorry ! No timetable found for this instance';
            }
            $day = DayMaster::where('id','=',$day_id)->pluck('name');
            $finalTimetable['div_id'] = $div_id;
            $divisionName = Division::where('id',$div_id)->select('division_name','class_id')->first();
            $class = Classes::where('id','=',$divisionName['class_id'])->select('id','class_name','batch_id')->first();
            $batch = Batch::where('id','=',$class['batch_id'])->select('id','name')->first();
            $finalTimetable['classId'] = $class['id'];
            $finalTimetable['batchId'] = $batch['id'];
            $finalTimetable['batchName'] = $batch['name'];
            $finalTimetable['className'] = $class['class_name'];
            $finalTimetable['divisionName'] =  $divisionName['division_name'];
            $finalTimetable['day'] = $day;
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalTimetable,
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
    public function defaultTimetableTeacher(Requests\viewTimetableRequest $request )
    {
        try{
            $timetableDivisions = Timetable::select('div_id')->first();
            if (!Empty($timetableDivisions)) {
                 $timetable = $this->viewTimetableTeacher($request,$timetableDivisions['div_id'],date('N'));
                 return $timetable;
            } else {
                $message = "Sorry ! No timetable found for this instance";
                $status = 406;
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => [],
            "div_id" => $timetableDivisions['div_id']
        ];
        return response($response, $status);
    }
}
