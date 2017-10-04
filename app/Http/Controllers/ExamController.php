<?php

namespace App\Http\Controllers;
use App\Classes;
use App\ExamClassStructureRelation;
use App\ExamSubjectStructure;
use App\ExamSubSubjectStructure;
use App\ExamTermDetails;
use App\ExamTerms;
use App\ExamYear;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Batch;
//use function Stringy\create;

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
        $subjectDetails ['sub_subject_name'] = $request->sub_subject;
        $subjectDetails ['subject_id'] = $request->select_subject;
        $subjectDetails ['created_at'] = Carbon::now();
        $subSubject = ExamSubSubjectStructure::insertGetId($subjectDetails);

        $years ['exam_structure_id'] = $subSubject;
        $years ['start_year'] = $request->startYear;
        $years ['end_year'] = $request->endYear;
        $years ['created_at'] = Carbon::now();
        $yearsCreated = ExamYear::insertGetId($years);

        $classes = $request->classes;
        $batches = Batch::where('body_id',Auth::user()->body_id)->get();
        $examSubjects = ExamSubjectStructure::where('body_id',Auth::user()->body_id)->get();
        foreach ($classes as $class)
        {
            $inserData['exam_subject_id'] = $subSubject;
            $inserData['class_id'] = $class;
            $inserData['created_at'] = Carbon::now();
            $query1 = ExamClassStructureRelation::insert($inserData);
        }

        $terms = $request->terms_id;
        foreach ($terms as $key => $term)
        {
            $termData['term_name']= $term;
            $termData['exam_structure_id'] = $subSubject;
            $termData['created_at'] = Carbon::now();
            $CreatedTerm = ExamTerms::insertGetId($termData);
            $examTermInfoData = array();
            $examTermInfoData['term_id'] = $CreatedTerm;
            $examTermInfoData['exam_structure_id'] = $subSubject;
            foreach($request->exam_types as $examInfo){
                $examTermInfoData['exam_type'] = $examInfo['head'];
                $examTermInfoData['out_of_marks'] = $examInfo['out_of_marks'][$key];
                ExamTermDetails::create($examTermInfoData);
            }
        }
        Session::flash('message-success','Subject created successfully .');
        return view('/exam/createExamStructure')->with(compact('subSubject','yearsCreated','batches','examSubjects','CreatedTerm','CreateTeamDetails'));
    }
    public function ExamStructureListing(Request $request){
        $batches = Batch::where('body_id',Auth::user()->body_id)->get();
        return view('/exam/examListing')->with(compact('batches','examSubjects'));
    }
    public function getAllClasses($id){
        $data=array();
        $classData = Classes::where('batch_id',$id)->get();
        $i=0;
        foreach ($classData as $row) {
            $data[$i]['class_id'] = $row['id'] ;
            $data[$i]['class_name']= $row['class_name'] ;
            $i++;
        }
        return $data;
    }
    public function getExamStructures(Request $request,$class_id){
          $structure_lists = ExamSubjectStructure::join('exam_sub_subject_structure','exam_sub_subject_structure.subject_id','=','exam_subject_structure.id')
                                                    ->join('exam_class_structure_relation','exam_class_structure_relation.exam_subject_id','=','exam_sub_subject_structure.id')
                                                    ->join('exam_year','exam_sub_subject_structure.id','=','exam_year.exam_structure_id')
                                                    ->where('exam_class_structure_relation.class_id','=',$class_id)
                                                    ->select('exam_subject_structure.subject_name as name','exam_sub_subject_structure.sub_subject_name','exam_year.start_year','exam_year.end_year')
                                                    ->get()->toArray();
        return view('/exam/examStructureList')->with(compact('structure_lists'));
    }

    public function ExamStructureEdit(Request $request){
        $batches = Batch::where('body_id',Auth::user()->body_id)->get();
        $examSubjects = ExamSubjectStructure::where('body_id',Auth::user()->body_id)->get();
        $classes = ExamClassStructureRelation::select('class_id')->get();

        return view('/exam/examEdit')->with(compact('batches','examSubjects','classes'));
    }
    public function editStructure(Request $request){

    }
}