<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Classes;
use App\DayMaster;
use App\Division;
use App\SubjectClassDivision;
use App\Timetable;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TimetableController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function index(Requests\WebRequests\TimetableRequest $request)
    {
        if ($request->authorize() === true) {

            $batches=Batch::get();

            return view('timetable')->with(compact('batches'));

        } else {
            return Redirect::to('/');
        }

    }
    public function timetableShow(Requests\WebRequests\TimetableRequest $request,$id)
    {

        if ($request->authorize() === true) {

            $divisions=Division::join('classes','classes.id','=','divisions.class_id')
                ->join('batches','batches.id','=','classes.batch_id')
                ->select('batches.id as batch_id','batches.name as batch_name','classes.id as class_id','classes.class_name','divisions.id as division_id','divisions.division_name')
                ->where('divisions.id','=',$id)
                ->get();

            Session::put('timetable_batch_class_division_id',$divisions);

            $subjectClassDiv=SubjectClassDivision::where('division_id',$id)->get();

            $divArray=array();

            foreach ($subjectClassDiv as $division) {

                array_push($divArray,$division->id);

            }

            $timetables=Timetable::join('division_subjects','timetables.division_subject_id','=','division_subjects.id')
                ->join('subjects','subjects.id','=','division_subjects.subject_id')
                ->join('divisions','divisions.id','=','division_subjects.division_id')
                ->join('users','users.id','=','division_subjects.teacher_id')
                ->join('day_master','timetables.day_id','=','day_master.id')
                ->select('day_master.name as day','subjects.subject_name as subject','is_break','start_time','end_time','users.username as teacher')
                ->wherein('timetables.division_subject_id',$divArray)
                ->orderBy('start_time','ASC')
                ->get();


            if (sizeof($timetables->toArray()) != 0) {

                $mondays=array();

                $tuesdays=array();

                $wednesdays=array();

                $thursdays=array();

                $fridays=array();

                $saturdays=array();

                $sundays=array();

                foreach ($timetables as $day) {

                    if ($day->day == "Monday") {

                        array_push($mondays,$day);

                    } elseif ($day->day == "Tuesday") {

                        array_push($tuesdays,$day);

                    } elseif ($day->day == "Wednesday") {

                        array_push($wednesdays,$day);

                    } elseif ($day->day == "Thursday") {

                        array_push($thursdays,$day);

                    } elseif ($day->day == "Friday") {

                        array_push($fridays,$day);

                    } elseif ($day->day == "Saturday") {

                        array_push($saturdays,$day);

                    } elseif ($day->day == "Sunday") {

                        array_push($sundays,$day);

                    }

                }

                $timetableArray=json_encode(array('monday'=>$mondays,'monday'=>$mondays,'tuesday'=>$tuesdays,'wednesday'=>$wednesdays,'thursday'=>$thursdays,'friday'=>$fridays,'saturday'=>$saturdays,'sunday'=>$sundays));

                return $timetableArray;

            }else{

                $str='{"message":"unavailable"}';

                return $str;
            }

        }else{
            return Redirect::to('/');
        }

    }

    public function create()
    {
        $divisions=session('timetable_batch_class_division_id');
        $days=DayMaster::get();

        return view('createTimetable')->with(compact('divisions','days'));
    }

    public function createTimetable(Request $request)
    {
        $data=$request->all();
        $insertdata=array();
        $timetableData=array();

        $length=count($data['subjects']);


        for($i=0; $i<$length; $i++)
        {
            $insertdata['division_subject_id']=$data['subjects'][$i];
            $insertdata['is_break']=$data['check'][$i];
            $insertdata['start_time']=$data['startTime'][$i];
            $insertdata['end_time']=$data['endTime'][$i];
            $insertdata['day_id']=$data['day'];

            array_push($timetableData,$insertdata);

        }

        $status=Timetable::insert($timetableData);

        if($status){
            Session::flash('message-success','Timetable created successfully !');
            return Redirect::to('timetable');
        }

    }

    public function getSubjects($id)
    {
        $subjects=SubjectClassDivision::where('division_id','=',$id)
            ->join('subjects','subjects.id','=','division_subjects.subject_id')
            ->select('subjects.subject_name','division_subjects.id')
            ->get();

        return $subjects;
    }
}
