<?php

namespace App\Http\Controllers\api;

use App\Batch;
use App\Classes;
use App\Division;
use App\Subject;
use App\SubjectClassDivision;
use App\timetable;
use App\User;
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

    public function viewTimetableParent(Requests\viewTimetableRequest $request,$day)
    {
        $userToken=$request->all();
        foreach($userToken as $userData)
        {
            $userId=$userData;
        }
        try{
            $timetable=timetable::where('div_id',$userId->division_id)
                ->where('day', '=', $day)
                ->orderBy('period_number', 'asc')
                ->get();
            $i=0;
            foreach($timetable as $key=>$value)
            {
                $data[$i]['period_number']=$value['period_number'];
                $SubjectTeacher=SubjectClassDivision::where('id', '=', $value['division_subject_id'])->first();
                $SubjectTeacherArray= $SubjectTeacher->toArray();
                $Teacher=User::where('id', '=', $SubjectTeacherArray['teacher_id'])->first();
                $Subject=Subject::where('id', '=', $SubjectTeacherArray['subject_id'])->first();
                $data[$i]['subject']=$Subject['subject_name'];
                $data[$i]['teacher']=$Teacher['first_name']." ".$Teacher['last_name'];
                $data[$i]['is_break']=$value['is_break'];
                $data[$i]['start_time']=$value['start_time'];
                $data[$i]['end_time']=$value['end_time'];
                $i++;
            }
            $message = 'success';
            $status = 200;
            $responseData=$data;
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

    public function viewTimetableTeacher(Requests\viewTimetableRequest $request,$batch,$class,$div,$day)
    {
        try{
            $teacherBatch = Batch::where('name',$batch)->first();
            $teacherClass = Classes::where('slug',$class)
                ->where('batch_id', '=',$teacherBatch->id)
                ->first();
            $teacherDivision = Division::where('slug',$div)
                ->where('class_id', '=',$teacherClass->id)
                ->first();
            $timetable=timetable::where('div_id',$teacherDivision->id)
                ->where('day', '=', $day)
                ->orderBy('period_number', 'asc')
                ->get();
            $viewtimetable=$timetable->toArray();
            $i=0;
            foreach($viewtimetable as $key=>$value)
            {
                $data[$i]['period_number']=$value['period_number'];
                $SubjectTeacher=SubjectClassDivision::where('id', '=', $value['division_subject_id'])->first();
                $SubjectTeacherArray= $SubjectTeacher->toArray();
                $Teacher=User::where('id', '=', $SubjectTeacherArray['teacher_id'])->first();
                $Subject=Subject::where('id', '=', $SubjectTeacherArray['subject_id'])->first();
                $data[$i]['subject']=$Subject['subject_name'];
                $data[$i]['teacher']=$Teacher['first_name']." ".$Teacher['last_name'];
                $data[$i]['is_break']=$value['is_break'];
                $data[$i]['start_time']=$value['start_time'];
                $data[$i]['end_time']=$value['end_time'];
                $i++;
            }
            $message = 'success';
            $status = 200;
            $responseData=$data;
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
}


