<?php

namespace App\Http\Controllers;
use App\Classes;
use App\ExamSubjectStructure;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Batch;

class ExamController extends Controller
{
    public function __construct(){
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function createExamStructureView(Request $request)
    {
        $batches = Batch::where('body_id',Auth::user()->body_id)->get();
        $examSubjects = ExamSubjectStructure::where('body_id',Auth::user()->body_id)->get();
        return view('/exam/createExamStructure')->with(compact('batches','examSubjects'));
    }
    public function createExamSubjectView(Request $request)
    {
        return view('/exam/createExamSubject');
    }
    public function createExamSubject(Request $request)
    {
        $data=$request->all();
        $subjectData['subject_name'] = $data['subject_name'];
        $subjectData['body_id'] = $data['body_id'];
        $subjectData['created_at'] = Carbon::now();
        $subjectData['updated_at'] = Carbon::now();
        $query = ExamSubjectStructure::insert($subjectData);
        if($query){
            Session::flash('message-success','Subject created successfully .');
            return Redirect::back();
        }else{
            Session::flash('message-error','Something went wrong !');
            return Redirect::back();
        }
    }
    public function getClasses($str)
    {
        $classes = Classes::where('batch_id',$str)->select('id','class_name')->get()->toArray();
        return view('/exam/examClasses')->with(compact('classes'));
    }
    public function createStructureTable(Request $request){
        //$batches=;
    }
}
