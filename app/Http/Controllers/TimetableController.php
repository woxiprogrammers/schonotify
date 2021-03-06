<?php
namespace App\Http\Controllers;
use App\Batch;
use App\Classes;
use App\DayMaster;
use App\Division;
use App\SubjectClassDivision;
use App\Timetable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
class TimetableController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    /*
+   * Function Name: index
+   * Param: Requests\WebRequests\TimetableRequest $requests
+   * Return: Timetable view
+   * Desc: this method returns to view of timetable.
+   * Developed By: Shubham Chaudhari
+   * Date: 10/2/2016
+   */
    public function index(Requests\WebRequests\TimetableRequest $request)
    {
        $user=Auth::user();
        if ($request->authorize() === true) {
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('timetable')->with(compact('batches'));
        } else {
            return Redirect::to('/');
        }
    }
    /*
+   * Function Name: timetableShow
+   * Param: Requests\WebRequests\TimetableRequest $requests, $id
+   * Return: Timetable view on the basis of division selection
+   * Desc: this method returns to view of timetable for perticular division.
+   * Developed By: Shubham Chaudhari
+   * Date: 10/2/2016
+   */
    public function timetableShow(Requests\WebRequests\TimetableRequest $request,$id)
    {
        if ($request->authorize() === true) {
            $divisions = Division::join('classes','classes.id','=','divisions.class_id')
                ->join('batches','batches.id','=','classes.batch_id')
                ->select('batches.id as batch_id','batches.name as batch_name','classes.id as class_id','classes.class_name','divisions.id as division_id','divisions.division_name')
                ->where('divisions.id','=',$id)
                ->get();
            Session::put('timetable_batch_class_division_id',$divisions);
            $subjectClassDiv = SubjectClassDivision::where('division_id',$id)->get();
            $divArray = array();
            foreach ($subjectClassDiv as $division) {
                array_push($divArray,$division->id);
            }
            $timetable = Timetable::join('day_master','timetables.day_id','=','day_master.id')
                ->select('timetables.id','day_master.id as day_id','day_master.name as day','is_break','start_time','end_time','division_subject_id')
                ->where('timetables.div_id',$id)
                ->orderBy('start_time','ASC')
                ->get();
            $arrayTimetable = array();
            foreach($timetable->toArray() as $row)
            {
                if( $row['division_subject_id'] != 0 ) {
                    $subject = SubjectClassDivision::join('subjects','subjects.id','=','division_subjects.subject_id')
                        ->join('users','users.id','=','division_subjects.teacher_id')
                        ->select('users.first_name as teacher','users.last_name as teacher_last_name','subjects.subject_name','users.is_active')
                        ->where('division_subjects.id',$row['division_subject_id'])
                        ->get()->toArray();
                    if (!empty($subject)) {
                        $row['teacher'] = $subject[0]['teacher'];
                        $row['teacher_last_name'] = $subject[0]['teacher_last_name'];
                        $row['teacher_is_active'] = $subject[0]['is_active'];
                        $row['subject'] = $subject[0]['subject_name'];
                    }
                } else {
                    $row['teacher'] = "";
                    $row['subject'] = "";
                    $row['teacher_is_active'] = 1;
                }
                array_push($arrayTimetable,$row);
            }
            $timetables = array();
            foreach($arrayTimetable as $row)
            {
                $startTime = trim($row['start_time']);
                $subStartHours = substr($startTime,0,2);
                $subStartMins = substr($startTime,3,2);
                if($subStartHours >= 12) {
                    if($subStartHours != 12) {
                        $subStartHours = $subStartHours-12;
                    }
                    $row['start_time'] = $subStartHours.":".$subStartMins." PM";
                } else {
                    if($subStartHours == 00) {
                        $subStartHours = 12;
                    }
                    $row['start_time'] = $subStartHours.":".$subStartMins." AM";
                }
                $endTime = trim($row['end_time']);
                $subEndHours = substr($endTime,0,2);
                $subEndMins = substr($endTime,3,2);
                if($subEndHours >= 12) {
                    if($subEndHours != 12) {
                        $subEndHours = $subEndHours-12;
                    }
                    $row['end_time'] = $subEndHours.":"."$subEndMins"." PM";
                } else {
                    if($subEndHours == 00) {
                        $subEndHours = 12;
                    }
                    $row['end_time'] = $subEndHours.":"."$subEndMins"." AM";
                }
                array_push($timetables,$row);
            }
            if (sizeof($timetables) != 0) {
                $mondays = array();
                $tuesdays = array();
                $wednesdays = array();
                $thursdays = array();
                $fridays = array();
                $saturdays = array();
                $sundays = array();
                foreach ($timetables as $day) {
                    if ($day['day'] == "Monday") {
                        array_push($mondays,$day);
                    } elseif ($day['day'] == "Tuesday") {
                        array_push($tuesdays,$day);
                    } elseif ($day['day'] == "Wednesday") {
                        array_push($wednesdays,$day);
                    } elseif ($day['day'] == "Thursday") {
                        array_push($thursdays,$day);
                    } elseif ($day['day'] == "Friday") {
                        array_push($fridays,$day);
                    } elseif ($day['day'] == "Saturday") {
                        array_push($saturdays,$day);
                    } elseif ($day['day'] == "Sunday") {
                        array_push($sundays,$day);
                    }
                }
                $timetableArray = json_encode(array('monday'=>$mondays,'monday'=>$mondays,'tuesday'=>$tuesdays,'wednesday'=>$wednesdays,'thursday'=>$thursdays,'friday'=>$fridays,'saturday'=>$saturdays,'sunday'=>$sundays));
                return $timetableArray;
            } else {
                $str = '{"message":"unavailable"}';
                return $str;
            }
        } else {
            return Redirect::to('/');
        }
    }
    /*
+   * Function Name: create
+   * Param:
+   * Return: Timetable structure create page
+   * Desc: this method returns to view of timetable create.
+   * Developed By: Shubham Chaudhari
+   * Date: 10/2/2016
+   */
    public function create(Requests\WebRequests\CreateTimetableRequest $request)
    {
        if ( $request->authorize() === true ) {
            $divisions = session('timetable_batch_class_division_id');
            $days = DayMaster::get();
            return view('createTimetable')->with(compact('divisions','days'));
        } else {
            return Redirect::to('/');
        }
    }
    /*
+   * Function Name: createTimetable
+   * Param: $requests, $id
+   * Return: Timetable create
+   * Desc: this method returns to the successful creation of timetable.
+   * Developed By: Shubham Chaudhari
+   * Date: 15/2/2016
+   */
    public function createTimetable(Request $request)
    {
        $data = $request->all();
        $insertdata = array();
        $timetableData = array();
        $length = count($data['subjects']);
        for($i = 0; $i < $length; $i++)
        {
            ///////////Formatting start time to 24 hrs format
            $startTime = $data['startTime'][$i];
            $startTime = $this::formatedTime($startTime);
            ///////////Formatting end time to 24 hrs format
            $endTime = $data['endTime'][$i];
            $endTime = $this::formatedTime($endTime);
            $insertdata['division_subject_id'] = $data['subjects'][$i];
            $insertdata['is_break'] = $data['check'][$i];
            $insertdata['start_time'] = $startTime;
            $insertdata['end_time'] = $endTime;
            $insertdata['day_id'] = $data['day'];
            $insertdata['div_id'] = $data['hiddenFormDivId'];
            $insertdata['created_at'] = Carbon::now();
            $insertdata['updated_at'] = Carbon::now();
            array_push($timetableData,$insertdata);
        }
        $status = Timetable::insert($timetableData);
        if($status) {
            Session::flash('message-success','Timetable created successfully !');
            return Redirect::to('timetable');
        }
    }
    /*
 +   * Function Name: getSubjects
 +   * Param: $id
 +   * Return: it returns subjects
 +   * Desc: it will returns subjects array respect to division_id .
 +   * Developed By: Shubham Chaudhari
 +   * Date: 16/2/2016
 +   */
    public function getSubjects($id)
    {
        $subjects = SubjectClassDivision::where('division_subjects.division_id','=',$id)
            ->join('subjects','subjects.id','=','division_subjects.subject_id')
            ->join('users','users.id','=','division_subjects.teacher_id')
            ->select('subjects.subject_name','division_subjects.id','users.username')
            ->get();

        return $subjects;
    }
    /*
 +   * Function Name: getSubjects
 +   * Param: $id
 +   * Return: it returns subjects
 +   * Desc: it will returns subjects array respect to division_id .
 +   * Developed By: Shubham Chaudhari
 +   * Date: 16/2/2016
 +   */
    public function getTimetableCreateSubjects($id)
    {
        $subjects = SubjectClassDivision::where('division_subjects.division_id','=',$id)
            ->join('subjects','subjects.id','=','division_subjects.subject_id')
            ->join('users','users.id','=','division_subjects.teacher_id')
            ->where('users.is_active','=',1)
            ->select('subjects.subject_name','division_subjects.id','users.first_name','users.last_name')
            ->get();
        return $subjects;
    }
    /*
 +   * Function Name: teacherCheck
 +   * Param: $request
 +   * Return: it will returns count of availability of teachers.
 +   * Desc:  It checks teacher availability on the same day and same time.
 +   * Developed By: Shubham Chaudhari
 +   * Date: 17/2/2016
 +   */
    public function teacherCheck(Request $request)
    {   // This is the validation for checking whether the teacher is available or not.
       /*
            $id = $request->id;
            $startTime = $request->startTime;
            $endTime = $request->endTime;
            $day = $request->day;
            $startTime = $this::formatedTime($startTime);
            $endTime = $this::formatedTime($endTime);
            $teacher = SubjectClassDivision::where('id',$id)->select('teacher_id')->first();
            $teacherArray = $teacher->toArray();
            $teacherAvailability = Timetable::join('division_subjects','division_subjects.id','=','timetables.division_subject_id')
            ->where('timetables.day_id','=',$day)
            ->wherein('teacher_id',$teacherArray)
            ->where('timetables.is_break','!=',1)
            ->get();
            $flagCheckForTeacher = 1;
            foreach($teacherAvailability as $arr)
            {
                if($arr->start_time == $startTime.":00") {
                    $flagCheckForTeacher = 0;
                    break;
                } elseif ($arr->end_time == $endTime.":00") {
                    $flagCheckForTeacher = 0;
                    break;
                } elseif ($arr->start_time < $startTime && $arr->end_time > $startTime) {
                    $flagCheckForTeacher = 0;
                    break;
                } elseif ($arr->start_time < $endTime && $arr->end_time > $endTime) {
                    $flagCheckForTeacher = 0;
                    break;
                } elseif ($arr->start_time > $startTime && $arr->end_time < $startTime) {
                    $flagCheckForTeacher = 0;
                    break;
                } elseif ($arr->start_time > $endTime && $arr->end_time < $endTime) {
                    $flagCheckForTeacher = 0;
                    break;
                } else {
                    $flagCheckForTeacher = 1;
                }
            }*/               // This is the validation for checking whether the teacher is available or not.
            $flagCheckForTeacher = 1;
        return $flagCheckForTeacher;
    }
    /*
 +   * Function Name: formatedTime
 +   * Param: $time
 +   * Return: it will returns formated time.
 +   * Desc:  It returns formated time in 24 hrs format.
 +   * Developed By: Shubham Chaudhari
 +   * Date: 17/2/2016
+   */
    public function formatedTime($time)
    {
        $subStartAmpm = substr($time,-2);
        $subStartTime = substr($time,0,5);
        $time = trim($subStartTime);
        $subStartMinutes = substr($time,-2);
        $subStartHours = substr($time,-5,-3);
        if($subStartAmpm == "PM") {
            if($subStartHours != "12") {
                $subStartHours = $time+12;
                $time = $subStartHours.":".$subStartMinutes;
            }
        } else {
            if($subStartHours == "12") {
                $time = "00:".$subStartMinutes;
            }
        }
        if(strlen($time) != 5) {
            $time = "0".$time;
        }
        return $time;
    }
    /*
 +   * Function Name: checkSubjectTeacher
 +   * Param:
 +   * Return: it will returns if the user is subject teacher or not.
 +   * Desc:  if teacher is subject teacher then he cant get link to create timetable.
 +   * Developed By: Shubham Chaudhari
 +   * Date: 18/2/2016
 +   */
    public function checkSubjectTeacher()
    {
        $user = Auth::user();
        $roleId = $user->role_id;
        if( $roleId != 1 ) {
            $classTeacher = Division::where('class_teacher_id','=',$user->id)->get();
            if( $classTeacher->isEmpty() == true ) {
                return 0;
            } else {
               $result = array('division_id'=>$classTeacher[0]->id);
                return $result;
            }
        } else {
            return 1;
        }
    }
    /*
 +   * Function Name: copyStructureDays
 +   * Param: $id
 +   * Return: it will returns available days to copy structure.
 +   * Desc:  it will returns available days to copy structure with respect to division id.
 +   * Developed By: Shubham Chaudhari
 +   * Date: 23/2/2016
 +   */
    public function copyStructureDays($id)
    {
        $days = Timetable::where('div_id','=',$id)
            ->select('day_id')
            ->distinct()
            ->get();
        return $days;
    }
    /*
 +   * Function Name: editPeriod
 +   * Param: $id
 +   * Return: it will returns editable data of periods.
 +   * Desc:  it will returns editable data with respect to period id.
 +   * Developed By: Shubham Chaudhari
 +   * Date: 23/2/2016
 +   */
    public function editPeriod($id)
    {
        $period = Timetable::where('id',$id)->get();
        $periods = $period->toArray();
        $periodsArray=array();
        if($periods[0]['division_subject_id'] == "0") {
            $periods[0]['subject_name'] = "";
        } else {
            $subject = SubjectClassDivision::join('subjects','subjects.id','=','division_subjects.subject_id')
                    ->select('subjects.subject_name')
                    ->where('division_subjects.id','=',$periods[0]['division_subject_id'])
                    ->get()->toArray();
            $periods[0]['subject_name'] = $subject[0]['subject_name'];
        }
        foreach($periods as $row)
        {
            $startTime = trim($row['start_time']);
            $subStartHours = substr($startTime,0,2);
            $subStartMins = substr($startTime,3,2);
            if($subStartHours >= 12) {
                if($subStartHours != 12) {
                    $subStartHours = $subStartHours-12;
                }
                $row['start_time'] = $subStartHours.":".$subStartMins." PM";
            } else {
                if($subStartHours == 00) {
                    $subStartHours = 12;
                }
                $row['start_time'] = $subStartHours.":".$subStartMins." AM";
            }
            $endTime = trim($row['end_time']);
            $subEndHours = substr($endTime,0,2);
            $subEndMins = substr($endTime,3,2);
            if($subEndHours >= 12) {
                if($subEndHours != 12) {
                    $subEndHours = $subEndHours-12;
                }
                $row['end_time'] = $subEndHours.":"."$subEndMins"." PM";
            } else {
                if($subEndHours == 00) {
                    $subEndHours = 12;
                }
                $row['end_time'] = $subEndHours.":"."$subEndMins"." AM";
            }
            array_push($periodsArray,$row);
        }
        return $periodsArray;
    }
    /*
 +   * Function Name: deletePeriod
 +   * Param: $id
 +   * Return: it will delete period.
 +   * Desc:  it will delete period with respect to period id.
 +   * Developed By: Shubham Chaudhari
 +   * Date: 23/2/2016
 +   */
    public function deletePeriod($id)
    {
        $delete = Timetable::where('id',$id)->delete();
        if( $delete )
        {
            return 1;
        }
    }
    /*
 +   * Function Name: copyStructure
 +   * Param: $division,$day,$selectedDay
 +   * Return: it will create another structure of the another day.
 +   * Desc:  it will create timetable structure for selected day and division with respect to available structure.
 +   * Developed By: Shubham Chaudhari
 +   * Date: 23/2/2016
 +   */

    public function copyStructure($division,$day,$selectedDay)
    {
        $copyStructure=Timetable::select('start_time','end_time')
            ->where('day_id','=',$day)
            ->where('div_id','=',$division)
            ->get();
        $arrayStructure=array();
        foreach($copyStructure->toArray() as $structure)
        {
            $structure['division_subject_id'] = 0;
            $structure['is_break'] = 0;
            $structure['day_id'] = $selectedDay;
            $structure['div_id'] = $division;
            $structure['created_at'] = Carbon::now();
            $structure['updated_at'] = Carbon::now();
            array_push($arrayStructure,$structure);
        }
        $status = Timetable::insert($arrayStructure);
        if( $status ) {
            Session::flash('message-success','Timetable structure copied successfully !');
            return 1;
        } else {
            Session::flash('message-error','Something went wrong !');
            return 0;
        }
    }
    /*
         +   * Function Name: updatePeriod
         +   * Param: $request
         +   * Return: it will check teacher and time availability for  period.
         +   * Desc: this method checks wheather the teacher or time is available to modified period with respect to period id.
         +   * Developed By: Shubham Chaudhari
         +   * Date: 28/2/2016
         +   */

    public function teacherCheckEdit(Request $request)
    {
        $id = $request->id;
        $startTime = $request->startTime;
        $endTime = $request->endTime;
        $day = $request->day;
        $period=$request->period;
        $isBreak=$request->checkValue;
        $division=$request->division;
        $startTime = $this::formatedTime($startTime);
        $endTime = $this::formatedTime($endTime);
        $teacher = SubjectClassDivision::where('id',$id)->select('teacher_id')->first();
        $teacherArray = $teacher->toArray();
        $teacherAvailabilityObj = Timetable::join('division_subjects','division_subjects.id','=','timetables.division_subject_id')
            ->where('timetables.day_id','=',$day)
            ->wherein('teacher_id',$teacherArray)
            ->where('timetables.id','!=',$period)
            ->orwhere('timetables.is_break','=',1)
            ->get();
        $timeAvailabilityObj = Timetable::where('div_id','=',$division)->where('timetables.day_id','=',$day)
            ->where('timetables.id','!=',$period)
            ->get();
        $flagCheckForTeacher = 1;
        $teacherAvailability=$teacherAvailabilityObj->toArray();
        $timeAvailability=$timeAvailabilityObj->toArray();
        $startTime=$startTime.":00";
        $endTime=$endTime.":00";
            foreach($timeAvailabilityObj as $arr)
            {
                if($arr->start_time == $startTime) {
                    $flagCheckForTeacher = 2;
                    break;
                } elseif ($arr->end_time == $endTime) {
                    $flagCheckForTeacher = 2;
                    break;
                } elseif ($arr->start_time < $startTime && $arr->end_time > $startTime) {
                    $flagCheckForTeacher = 2;
                    break;
                } elseif ($arr->start_time < $endTime && $arr->end_time > $endTime) {
                    $flagCheckForTeacher = 2;
                    break;
                } elseif ( $startTime < $arr->start_time && $endTime > $arr->start_time) {
                    $flagCheckForTeacher = 2;
                    break;
                } elseif ( $startTime < $arr->end_time && $endTime > $arr->end_time) {
                    $flagCheckForTeacher = 2;
                    break;
                } else {
                    if( $isBreak == 1 ) {
                        $flagCheckForTeacher = 1;
                    } else {
                        foreach($teacherAvailabilityObj as $arr)
                        {
                            if($arr->start_time == $startTime) {
                                $flagCheckForTeacher = 0;
                                break;
                            } elseif ($arr->end_time == $endTime) {
                                $flagCheckForTeacher = 0;
                                break;
                            } elseif ($arr->start_time < $startTime && $arr->end_time > $startTime) {
                                $flagCheckForTeacher = 0;
                                break;
                            } elseif ($arr->start_time < $endTime && $arr->end_time > $endTime) {
                                $flagCheckForTeacher = 0;
                                break;
                            } elseif ( $startTime < $arr->start_time && $endTime > $arr->start_time) {
                                $flagCheckForTeacher = 0;
                                break;
                            } elseif ( $startTime < $arr->end_time && $endTime > $arr->end_time) {
                                $flagCheckForTeacher = 0;
                                break;
                            } else{
                                $flagCheckForTeacher = 1;
                            }
                        }
                    }
                }
            }
            $flagCheckForTeacher = 1;
       return $flagCheckForTeacher;
    }
    /*
         +   * Function Name: updatePeriod
         +   * Param: $request
         +   * Return: it will update period.
         +   * Desc: this method update period with respect to period id.
         +   * Developed By: Shubham Chaudhari
         +   * Date: 28/2/2016
         +   */
    public function updatePeriod(Request $request)
    {
        $data = $request->all();
        $updateData = array();
        $timetableData = array();
            ///////////Formatting start time to 24 hrs format
            $startTime = $data['startTime'];
            $startTime = $this::formatedTime($startTime);
            ///////////Formatting end time to 24 hrs format
            $endTime = $data['endTime'];
            $endTime = $this::formatedTime($endTime);
            $timetable = Timetable::find($data['period']);
            $timetable->start_time = $startTime;
            $timetable->end_time = $endTime;
            if($data['check'] == 0) {
                $timetable->division_subject_id = $data['id'];
            }
            $timetable->is_break = $data['check'];
            $isUpdate = $timetable->save();
            if( $isUpdate ) {
                return 1;
            }
    }
    /*
             +   * Function Name: teacherCheckAdd
             +   * Param: $request
             +   * Return: it will returns teacher avilability.
             +   * Desc: this method will return teacher availabilty with respect to teacher division id.
             +   * Developed By: Shubham Chaudhari
             +   * Date: 28/2/2016
             +   */

    public function teacherCheckAdd(Request $request)
    {
      /*
        $id = $request->id;
        $startTime = $request->startTime;
        $endTime = $request->endTime;
        $day = $request->day;
        $isBreak = $request->checkValue;
        $division = $request->division;
        $startTime = $this::formatedTime($startTime);
        $endTime = $this::formatedTime($endTime);
        $teacher = SubjectClassDivision::where('id',$id)->select('teacher_id')->first();
        $teacherArray = $teacher->toArray();
        $teacherAvailabilityObj = Timetable::join('division_subjects','division_subjects.id','=','timetables.division_subject_id')
            ->where('timetables.day_id','=',$day)
            ->wherein('teacher_id',$teacherArray)
            ->get();
        $timeAvailabilityObj = Timetable::where('div_id','=',$division)
            ->where('timetables.day_id','=',$day)
            ->get();
        $flagCheckForTeacher = 1;
        $teacherAvailability=$teacherAvailabilityObj->toArray();
        $timeAvailability=$timeAvailabilityObj->toArray();
        $startTime=$startTime.":00";
        $endTime=$endTime.":00";
        if(!empty($timeAvailability))
        {
            foreach($timeAvailabilityObj as $arr)
            {
              if($arr->start_time == $startTime) {
                    $flagCheckForTeacher = 2;
                    break;
                } elseif ($arr->end_time == $endTime) {
                    $flagCheckForTeacher = 2;
                    break;
                } elseif ($arr->start_time < $startTime && $arr->end_time > $startTime) {
                    $flagCheckForTeacher = 2;
                    break;
                } elseif ($arr->start_time < $endTime && $arr->end_time > $endTime) {
                    $flagCheckForTeacher = 2;
                    break;
                } elseif ( $startTime < $arr->start_time && $endTime > $arr->start_time) {
                    $flagCheckForTeacher = 2;
                    break;
                } elseif ( $startTime < $arr->end_time && $endTime > $arr->end_time) {
                    $flagCheckForTeacher = 2;
                    break;
                } else{
                    foreach($teacherAvailabilityObj as $arr){
                        if($arr->start_time == $startTime) {
                            $flagCheckForTeacher = 0;
                            break;
                        } elseif ($arr->end_time == $endTime) {
                            $flagCheckForTeacher = 0;
                            break;
                        } elseif ($arr->start_time < $startTime && $arr->end_time > $startTime) {
                            $flagCheckForTeacher = 0;
                            break;
                        } elseif ($arr->start_time < $endTime && $arr->end_time > $endTime) {
                            $flagCheckForTeacher = 0;
                            break;
                        } elseif ( $startTime < $arr->start_time && $endTime > $arr->start_time) {
                            $flagCheckForTeacher = 0;
                            break;
                        } elseif ( $startTime < $arr->end_time && $endTime > $arr->end_time) {
                            $flagCheckForTeacher = 0;
                            break;
                        }else{
                            $flagCheckForTeacher = 1;
                        }
                    }
                }
            }
        }else{
            if($isBreak == 1) {
                $flagCheckForTeacher = 1;
            }else{
                foreach($teacherAvailabilityObj as $arr){
                    if($arr->start_time == $startTime) {
                        $flagCheckForTeacher = 0;
                        break;
                    } elseif ($arr->end_time == $endTime) {
                        $flagCheckForTeacher = 0;
                        break;
                    } elseif ($arr->start_time < $startTime && $arr->end_time > $startTime) {
                        $flagCheckForTeacher = 0;
                        break;
                    } elseif ($arr->start_time < $endTime && $arr->end_time > $endTime) {
                        $flagCheckForTeacher = 0;
                        break;
                    } elseif ( $startTime < $arr->start_time && $endTime > $arr->start_time) {
                        $flagCheckForTeacher = 0;
                        break;
                    } elseif ( $startTime < $arr->end_time && $endTime > $arr->end_time) {
                        $flagCheckForTeacher = 0;
                        break;
                    }else{
                        $flagCheckForTeacher=1;
                    }
                }
            }
        }
        */
        $flagCheckForTeacher = 1;
        return $flagCheckForTeacher;
    }
    /*
             +   * Function Name: addPeriod
             +   * Param: $request
             +   * Return: it will add period.
             +   * Desc: this method will create period.
             +   * Developed By: Shubham Chaudhari
             +   * Date: 28/2/2016
             +   */
    public function addPeriod(Request $request)
    {
        $id = $request->id;
        $startTime = $request->startTime;
        $endTime = $request->endTime;
        $day = $request->day;
        $isBreak = $request->check;
        $division = $request->division;
        $startTime = $this::formatedTime($startTime);
        $endTime = $this::formatedTime($endTime);
        $timetablePeriods['division_subject_id'] = $id;
        $timetablePeriods['div_id'] = $division;
        $timetablePeriods['day_id'] = $day;
        $timetablePeriods['start_time'] = $startTime;
        $timetablePeriods['end_time'] = $endTime;
        $timetablePeriods['is_break'] = $isBreak;
        $timetablePeriods['created_at'] = Carbon::now();
        $timetablePeriods['updated_at'] = Carbon::now();
        $timetable = Timetable::insert($timetablePeriods);
        if($timetable){
            return 1;
        }else{
            return 0;
        }
    }
}
