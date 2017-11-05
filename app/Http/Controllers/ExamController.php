<?php
namespace App\Http\Controllers;
use App\Classes;
use App\Division;
use App\ExamClassStructureRelation;
use App\ExamSubjectStructure;
use App\ExamSubSubjectStructure;
use App\ExamTeacherConfirmation;
use App\ExamTermDetails;
use App\ExamTerms;
use App\ExamYear;
use App\StudentExamDetails;
use App\StudentExamMarks;
use App\User;
use App\UserRoles;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
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
        if($request->is_scholastic == 'true'){

            $subjectDetails['is_co_scholastic'] = true;
        }else{
            $subjectDetails['is_co_scholastic'] = false;
        }
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
        if($request->is_scholastic == 'true'){
            Session::flash('message-success','Co-Scholastic Subject Structure created successfully .');
        }else{
            Session::flash('message-success','Scolastic Subject Structure created successfully .');
        }
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
        $batchs = Batch::where('body_id',$user->body_id)->pluck('id');
        $selectedClass = ExamClassStructureRelation::where('exam_subject_id',$id)->pluck('class_id');
        $batch = Classes::where('id',$selectedClass)->pluck('body_id');
        $examSubjects = ExamSubjectStructure::where('body_id',$user->body_id)->get();
        $classes = Classes::where('batch_id',$batchs)->select('batch_id','id','class_name')->get()->toArray();
        $class = ExamClassStructureRelation::where('exam_subject_id',$id)->lists('class_id')->toArray();
        $examSubSubject = ExamSubSubjectStructure::where('id',$id)->select('id','sub_subject_name','is_co_scholastic')->get()->toArray();
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
        if($request->is_scholastic == 'true'){

            $subjectDetails['is_co_scholastic'] = true;
        }else{
            $subjectDetails['is_co_scholastic'] = false;
        }
         ExamSubSubjectStructure::where('id',$id)->update($subjectDetails);
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
    public function studentEntry(Request $request){
        $batches = Batch::where('body_id',Auth::user()->body_id)->get();
        $examSubjects = ExamSubjectStructure::where('body_id',Auth::user()->body_id)->get();
        return view('exam/subjectMarksEntry')->with(compact('batches','examSubjects'));
    }
    public function getAllDivision(Request $request,$id)
    {
        $divisions= Division::where('class_id',$id)->select('id','division_name')->get();
        return $divisions;
    }
    public function getSubject(Request $request,$id){
        $subjects = ExamSubjectStructure::join('exam_sub_subject_structure','exam_sub_subject_structure.subject_id','=','exam_subject_structure.id')
            ->join('exam_class_structure_relation','exam_class_structure_relation.exam_subject_id','=','exam_sub_subject_structure.id')
            ->where('exam_class_structure_relation.class_id','=',$id)
            ->select('exam_subject_structure.id','exam_subject_structure.subject_name')
            ->groupBy('subject_name')
            ->get()->toArray();
        return $subjects;
    }
    public function getSubSubject(Request $request,$id,$class_id){
        $subSubjects = ExamSubSubjectStructure::join('exam_class_structure_relation','exam_class_structure_relation.exam_subject_id','=','exam_sub_subject_structure.id')
                                                ->where('exam_sub_subject_structure.subject_id','=',$id)
                                                ->where('exam_class_structure_relation.class_id','=',$class_id)
                                                ->select('exam_sub_subject_structure.id','exam_sub_subject_structure.sub_subject_name')->get();
        return $subSubjects;
    }
    public function getTerms(Request $request,$id){
        $termData = ExamTerms::where('exam_structure_id',$id)->select('id','term_name')->get();
        return $termData;
    }
    public function subjectStructure(Request $request,$term_id,$div_id,$class_id,$sub_subject_id){
        $termName = ExamTerms::where('id',$term_id)->pluck('term_name');
        $termDetails = ExamTermDetails::where('term_id',$term_id)->select('id','exam_type','out_of_marks')->orderBy('term_id','asc')->get()->toArray();
        $StudentsDetails= User::where('division_id',$div_id)->where('role_id','=',3)->where('is_active','=',1)->select('id','first_name','last_name','roll_number')->orderBy('roll_number','asc')->get()->toArray();
        $studentMarks=array();
        $iterator = 0;
        foreach($StudentsDetails as $key => $student){
            $studentExamDetail = StudentExamDetails::where('student_id',$student['id'])->where('term_id',$term_id)->first();
            $studentMarks[$iterator]['full_name'] = $student['first_name'].' '.$student['last_name'];
            $studentMarks[$iterator]['id'] = $student['id'];
            $studentMarks[$iterator]['roll_no'] = $student['roll_number'];
            $jIterator = 0;
            foreach($termDetails as $key1 => $termData){
                $studentExamMarks = StudentExamMarks::where('student_exam_details_id',$studentExamDetail['id'])->where('exam_term_details_id',$termData['id'])->first();
                $studentMarks[$iterator]['term_marks'][$jIterator]['term_id'] = $termData['id'];
                $studentMarks[$iterator]['term_marks'][$jIterator]['marks'] = $studentExamMarks['marks_obtained'];
                $jIterator++;
            }
            $iterator++;
        }
        $StudentsDetails = $studentMarks;
        $details = ExamTeacherConfirmation::join('exam_sub_subject_structure','exam_sub_subject_structure.id','=','exam_teacher_confirmation.exam_structure_id')
            ->join('exam_class_structure_relation','exam_class_structure_relation.exam_subject_id','=','exam_sub_subject_structure.id')
            ->where('exam_teacher_confirmation.div_id','=',$div_id)
            ->where('exam_class_structure_relation.class_id','=',$class_id)
            ->where('exam_teacher_confirmation.exam_structure_id','=',$sub_subject_id)
            ->select('exam_sub_subject_structure.id','exam_teacher_confirmation.check_sign','exam_teacher_confirmation.remark')
            ->get()->toArray();
        return view('exam/ExamMarksStructure')->with(compact('termDetails','StudentsDetails','termName','studentMarks','details'));
    }
    public function createSubjectStructureDetails(Request $request){
        $user = Auth::user();
        $studentId = $request->details;
        foreach ($studentId as $key => $student) {
            $studentExamDetail = StudentExamDetails::where('student_id',$student['student_id'])->where('term_id',$request->term_select)
                ->where('exam_structure_id',$request->sub_subject_select)->first();
            $studentsDetails['student_id'] = $student['student_id'];
            $studentsDetails['term_id'] = $request->term_select;
            $studentsDetails['exam_structure_id'] = $request->sub_subject_select;
            if(count($studentExamDetail) > 0){
                StudentExamDetails::where('id',$studentExamDetail['id'])->update($studentsDetails);
                $query = $studentExamDetail['id'];
            }else{
                $studentsDetails['updated_at'] = Carbon::now();
                $studentsDetails['created_at'] = Carbon::now();
                $query = StudentExamDetails::insertGetId($studentsDetails);
            }
            foreach ($student['marks_details'] as $index => $mark) {
                if(array_key_exists('marks_obtain',$mark)){
                    $studentExamMarks = StudentExamMarks::where('student_exam_details_id',$query)->where('term_id',$request->term_select)->where('exam_structure_id',$request->sub_subject_select)
                        ->where('exam_term_details_id',$mark['exam_type_id'])->first();
                    $StudentsMarks['student_exam_details_id'] = $query;
                    $StudentsMarks['term_id'] = $request->term_select;
                    $StudentsMarks['exam_structure_id'] = $request->sub_subject_select;
                    $StudentsMarks['exam_term_details_id'] = $mark['exam_type_id'];
                    $StudentsMarks['marks_obtained'] = $mark['marks_obtain'];
                    if(count($studentExamMarks) > 0){
                        StudentExamMarks::where('id',$studentExamMarks['id'])->update($StudentsMarks);
                    }else{
                        $StudentsMarks['updated_at'] = Carbon::now();
                        $StudentsMarks['created_at'] = Carbon::now();
                        $insertMarks = StudentExamMarks::insert($StudentsMarks);
                    }
                }
            }
        }
            $teacherConfirmationDetails = ExamTeacherConfirmation::where('class_id',$request->class_select)
                                                                ->where('div_id',$request->div_select)
                                                                ->where('check_sign',$request->checkSign)
                                                                ->where('exam_structure_id',$request->sub_subject_select)->first();
            $teacherConfirmation['class_id'] = $request->class_select;
            $teacherConfirmation['div_id'] = $request->div_select;
            $teacherConfirmation['exam_structure_id'] = $request->sub_subject_select;
            $teacherConfirmation['check_sign'] = $request->checkSign;
            $teacherConfirmation['remark'] = $request->teacher_remark;
            $teacherConfirmation['teacher_id'] = $user['id'];
            $teacherConfirmation['status'] = 0;
            if($teacherConfirmationDetails != null ){
             $update =  ExamTeacherConfirmation::where('id',$teacherConfirmationDetails['id'])->update($teacherConfirmation);
            }else{
                $teacherConfirmation['created_at'] = Carbon::now();
                $teacherConfirmation['updated_at'] = Carbon::now();
                ExamTeacherConfirmation::insert($teacherConfirmation);
            }
            Session::flash('message-success','Students Marks updated successfully ..');
        return Redirect::back();
    }
    public function adminPublishView(Request $request){
        $batches = Batch::where('body_id',Auth::user()->body_id)->get();
        $examSubjects = ExamSubjectStructure::where('body_id',Auth::user()->body_id)->get();
        return view('exam/adminPublish')->with(compact('batches','examSubjects'));

    }
    public function publish(Request $request,$div_id,$class_id){
            $teacherInfo = ExamTeacherConfirmation::join('exam_sub_subject_structure','exam_sub_subject_structure.id','=','exam_teacher_confirmation.exam_structure_id')
                                                ->join('exam_class_structure_relation','exam_class_structure_relation.exam_subject_id','=','exam_sub_subject_structure.id')
                                                ->where('exam_class_structure_relation.class_id','=',$class_id)
                                                ->where('exam_teacher_confirmation.div_id','=',$div_id)
                                                ->select('exam_sub_subject_structure.sub_subject_name','exam_teacher_confirmation.check_sign','exam_teacher_confirmation.remark','exam_teacher_confirmation.exam_structure_id','status')
                                                ->get()->toArray();
            $subSubject = ExamSubSubjectStructure::join('exam_class_structure_relation','exam_class_structure_relation.exam_subject_id','=','exam_sub_subject_structure.id')
                                                    ->where('exam_class_structure_relation.class_id','=',$class_id)
                                                    ->select('exam_sub_subject_structure.sub_subject_name')->get();
         return view('exam/adminPublishPartial')->with(compact('teacherInfo','subSubject'));
    }
    public function publishStatus(Request $request){
        $user = Auth::user();
        $adminPublishTeacher = ExamTeacherConfirmation::where('class_id',$request->class_select)
                                                        ->where('exam_structure_id',$request->sub_subject[0])
                                                        ->where('remark',$request->remark[0])
                                                        ->where('div_id',$request->div_select)
                                                        ->where('check_sign',$request->checkedSign)
                                                        ->first();
        $teacherConfirmation['teacher_id'] = $user['id'];
        $adminPublish['class_id'] = $request->class_select;
        $adminPublish['exam_structure_id'] = $request->sub_subject[0];
        $adminPublish['status'] = 1;
        $adminPublish['remark'] = $request->remark[0];
        $adminPublish['div_id'] = $request->div_select;
        $adminPublish['check_sign'] = $request->checkedSign;
        $adminPublish['created_at'] = Carbon::now();
        $adminPublish['updated_at'] = Carbon::now();
       $query = ExamTeacherConfirmation::where('id',$adminPublishTeacher['id'])->update($adminPublish);
        Session::flash('message-success','Students Marks are Publish ..');
        return Redirect::back();
    }
    public function UnPublishStatus(Request $request){
        $user = Auth::user();
        $adminPublishTeacher = ExamTeacherConfirmation::where('class_id',$request->class_select)
            ->where('exam_structure_id',$request->sub_subject[0])
            ->where('remark',$request->remark)
            ->where('div_id',$request->div_select)
            ->where('check_sign',$request->checkedSign)
            ->first();
        $teacherConfirmation['teacher_id'] = $user['id'];
        $adminPublish['class_id'] = $request->class_select;
        $adminPublish['exam_structure_id'] = $request->sub_subject[0];
        $adminPublish['status'] = 0;
        $adminPublish['remark'] = $request->remark[0];
        $adminPublish['div_id'] = $request->div_select;
        $adminPublish['check_sign'] = $request->checkedSign;
        $adminPublish['created_at'] = Carbon::now();
        $adminPublish['updated_at'] = Carbon::now();
        $query = ExamTeacherConfirmation::where('id',$adminPublishTeacher['id'])->update($adminPublish);
        Session::flash('message-success','Students Marks are Un-Publish ..');
        return Redirect::back();
    }
}