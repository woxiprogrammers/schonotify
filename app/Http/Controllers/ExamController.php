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
                                                    ->select('exam_sub_subject_structure.id','exam_subject_structure.subject_name as name','exam_sub_subject_structure.sub_subject_name','exam_year.start_year','exam_year.end_year')
                                                    ->get()->toArray();
        return view('/exam/examStructureList')->with(compact('structure_lists'));
    }

    public function ExamStructureEdit(Request $request,$id){
        $user=Auth::user();
        $batches = Batch::where('body_id',$user->body_id)->get();
        $batchh = Batch::where('body_id',$user->body_id)->pluck('id');
        $selectedClass = ExamClassStructureRelation::where('exam_subject_id',$id)->pluck('class_id');
        $batch = Classes::where('id',$selectedClass)->pluck('body_id');
        $examSubjects = ExamSubjectStructure::where('body_id',$user->body_id)->get();
        $classes = Classes::where('batch_id',$batchh)->select('batch_id','id','class_name')->get()->toArray();
        $class = ExamClassStructureRelation::where('exam_subject_id',$id)->lists('class_id')->toArray();
        $examSubSubject = ExamSubSubjectStructure::where('id',$id)->select('id','sub_subject_name')->get()->toArray();
        $examStartYear = ExamYear::where('exam_structure_id',$id)->select('start_year')->get();
        $examEndYear = ExamYear::where('exam_structure_id',$id)->select('end_year')->get();
        $subjects = ExamSubjectStructure::join('exam_sub_subject_structure','exam_sub_subject_structure.subject_id','=','exam_subject_structure.id')
                                            ->where('exam_sub_subject_structure.id','=',$id)
                                            ->select('exam_subject_structure.id')
                                            ->first()->toArray();
        $examTerm = ExamTerms::where('exam_structure_id',$id)->select('id','term_name')->get()->toArray();
        $detail = array();
        foreach ($examTerm as $key => $value) {
            $detail[$value['term_name']] = ExamTermDetails::where('term_id', $value['id'])->select('exam_type', 'out_of_marks')->get()->toArray();
        }
        return view('/exam/examEdit')->with(compact('batches','examSubjects','class','classes','examSubSubject','examStartYear','examEndYear','subjects','examTerm','Term','detail','batch'));
    }
    public function editStructure(Request $request,$id){
        $classData = $request->classes;
        $deleteOldRecordsClass = ExamClassStructureRelation::where('exam_subject_id',$id)->whereNotIn('class_id',$classData)->delete();
           foreach ($classData as  $class){
               $query= ExamClassStructureRelation::where('exam_subject_id',$id)->where('class_id',$class)->first();
               if($query == null){
                   $inserData['exam_subject_id'] = $id;
                   $inserData['class_id'] = $class;
                   $inserData['created_at'] = Carbon::now();
                   $inserData['updated_at'] = Carbon::now();
                   $query1 = ExamClassStructureRelation::insert($inserData);
               }
           }

        $year['start_year'] = $request->start_Year;
        $year['end_year'] = $request->end_Year;
        $year['updated_at'] = Carbon::now();
        $updateYear = ExamYear:: where('exam_structure_id',$id)->update($year);
        $deleteOldRecordsTerm = ExamTerms::where('exam_structure_id',$id)->delete();
        $deleteOldRecordsType = ExamTermDetails::where('exam_structure_id',$id)->delete();
        $terms = $request->edit_terms_id;
        foreach ($terms as $key => $term)
        {
            $termData['term_name']= $term;
            $termData['exam_structure_id'] = $id;
            $termData['created_at'] = Carbon::now();
            $termData['updated_at'] = Carbon::now();
            $CreatedTerm = ExamTerms::insertGetId($termData);
            $examTermInfoData = array();
            $examTermInfoData['term_id'] = $CreatedTerm;
            $examTermInfoData['exam_structure_id'] = $id;
            foreach($request->exam_types as $examInfo){
                $examTermInfoData['exam_type'] = $examInfo['edit_head'];
                $examTermInfoData['out_of_marks'] = $examInfo['edit_out_of_marks'][$key];
                ExamTermDetails::create($examTermInfoData);
            }
        }
        Session::flash('message-success','Structure updated successfully .');
            return Redirect::back();
    }
}