<?php
    namespace App\Http\Controllers;
    use App\Batch;
    use App\Division;
    use App\Subject;
    use App\SubjectClass;
    use App\SubjectClassDivision;
    use App\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use App\Http\Requests;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Session;
    class SubjectTeacherController extends Controller
    {
        public function __construct()
        {
            $this->middleware('db');
            $this->middleware('auth');
        }
        public function index(Requests\WebRequests\SubjectRequest $request)
        {
            if($request->authorize()===true)
            {
                $user=Auth::User();
                $subjects=SubjectClass::join('subjects','subjects.id','=','subject_classes.subject_id')
                    ->join('classes','subject_classes.class_id','=','classes.id')
                    ->where('classes.body_id','=',$user->body_id)
                    ->where('subjects.body_id','=',$user->body_id)
                    ->select('subjects.id as id','subjects.subject_name as subject')
                    ->distinct()
                    ->get();
                $associations=SubjectClassDivision::join('divisions','division_subjects.division_id','=','divisions.id')
                    ->join('classes','classes.id','=','divisions.class_id')
                    ->join('batches','batches.id','=','classes.batch_id')
                    ->join('users','users.id','=','division_subjects.teacher_id')
                    ->join('subjects','subjects.id','=','division_subjects.subject_id')
                    ->where('users.body_id','=',$user->body_id)
                    ->where('users.is_active',1)
                    ->select('subjects.subject_name as subject','batches.name as batch','classes.class_name as class','divisions.division_name as division','users.first_name as teacherFirstName','users.last_name as teacherLastName','users.username as teacherUsername','division_subjects.id as id')
                    ->get();
                return view('subjectTeacher')->with(compact('subjects','associations','user'));
            }else{
                return Redirect::to('/');
            }
        }
        public function getSubjectBatches($id)
        {
            $batches=SubjectClass::join('classes','classes.id','=','subject_classes.class_id')
                ->join('batches','classes.batch_id','=','batches.id')
                ->where('subject_classes.subject_id','=',$id)
                ->select('batches.id as id','batches.name as batch')
                ->distinct()
                ->get();
            return $batches;
        }
        public function getSubjectClasses($id,$subject)
        {
            $classes=SubjectClass::join('classes','classes.id','=','subject_classes.class_id')
                ->join('batches','classes.batch_id','=','batches.id')
                ->where('classes.batch_id','=',$id)
                ->where('subject_classes.subject_id','=',$subject)
                ->select('classes.id as id','classes.class_name as class')
                ->distinct()
                ->get();
            return $classes;
        }
        public function getSubjectDivisions($id)
        {
            $divisions=Division::where('class_id','=',$id)
                ->select('divisions.id as id','divisions.division_name as division')
                ->get();

            return $divisions;
        }
        public function getDivisionTeachers($id,$subject)
        {
            $body_id = Auth::user()->body_id;
            $teachers=SubjectClassDivision::join('users','users.id','=','division_subjects.teacher_id')
                ->select('users.id as id')
                ->where('division_subjects.division_id','=',$id)
                ->where('division_subjects.subject_id','=',$subject)
                ->where('users.is_displayed',1)
                ->where('is_active','=',1)
                ->distinct()
                ->get();
            $dummy=array();
            foreach($teachers as $teacher)
            {
                array_push($dummy,$teacher->id);
            }
            $availableTeacher=User::where('role_id','=',2)
                ->whereNotIn('id',$teachers)
                ->where('is_active','=',1)
                ->where('body_id','=',$body_id)
                ->select('users.last_name as lastname','users.first_name as firstname','users.username as username','users.id as id')
                ->get();
            return $availableTeacher;
        }
        public function createRelation(Requests\WebRequests\AssignSubjectRequest $request)
        {
            if($request->authorize())
            {
                $data=$request->all();
                $relation['teacher_id']=$data['teacherDropdown'];
                $relation['subject_id']=$data['subjectDropdown'];
                $relation['division_id']=$data['divisionDropdown'];
                $relation['created_at'] = Carbon::now();
                $relation['updated_at'] = Carbon::now();
                $cnt=SubjectClassDivision::where('subject_id',$relation['subject_id'])
                    ->where('division_id',$relation['division_id'])
                    ->count();
                if($cnt>=1)
                {
                    $query=SubjectClassDivision::where('subject_id',$relation['subject_id'])
                        ->where('division_id',$relation['division_id'])
                        ->update($relation);
                }else{
                    $query=SubjectClassDivision::insert($relation);
                }
                if($query)
                {
                    Session::flash('message-success','Subject assigned to teacher successfully !');
                    return Redirect::back();
                }else{
                    Session::flash('message-error','Something went wrong !');
                    return Redirect::back();
                }
            }else{
                return Redirect::to('/');
            }
        }
        public function deleteRelation(Request $request,$id)
        {
            $query=SubjectClassDivision::where('id',$id)->delete();
            if($query)
            {
                Session::flash('message-success','Association deleted successfully !');
                return Redirect::back();
            }else{
                Session::flash('message-error','Something went wrong !');
                return Redirect::back();
            }
        }
        public function checkTeacher($subject,$division)
        {
            $check=SubjectClassDivision::join('users','users.id','=','division_subjects.teacher_id')->where('subject_id','=',$subject)->where('division_subjects.division_id','=',$division)->select('users.username','users.first_name as firstname','users.last_name as lastname')->get();
            return $check;
        }
    }
