<?php

    namespace App\Http\Controllers;

    use App\Batch;
    use App\Classes;
    use App\Division;
    use App\Event;
    use App\EventUserRoles;
    use App\Http\Requests\WebRequests\CreateAnnouncementRequest;
    use App\Http\Requests\WebRequests\NoticeBoardRequest;
    use App\SubjectClassDivision;
    use App\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Session;

    class NoticeBoardController extends Controller
    {
        public function __construct()
        {
            $this->middleware('db');
            $this->middleware('auth');
        }
        public function show(NoticeBoardRequest $request)
        {
            $data = array();
            $pageCount = 0;
            $user = Auth::user();
            $val1 = User::join('module_acls', 'users.id', '=', 'module_acls.user_id')
                ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
                ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
                ->where('users.id','=',Auth::User()->id)
                ->select('users.id','acl_master.slug as acl','modules.slug as module_slug')
                ->get();
            $resultArr=array();
            foreach($val1 as $val)
            {
                array_push($resultArr,$val->acl.'_'.$val->module_slug);
            }
            if(in_array('view_announcement',$resultArr) && in_array('view_achivement',$resultArr)) {
              if($user->role_id == 1) {
                            $dataPublish = Event::where('status',2)->orWhere('status',1)->skip($pageCount*4)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                            $dataUnpublish = Event::where('created_by',$user->id)->where('status',0)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                            $data = array_merge($dataPublish,$dataUnpublish);
              } elseif ($user->role_id == 2) {
                  $divisionCheck = Division::where('class_teacher_id',$user->id)->first();
                    if ($divisionCheck !== null) {
                            $dataCreatedBy = Event::where('created_by',$user->id)->where('status',0)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                            $dataForUser = EventUserRoles::where('event_user_roles.user_id',$user->id)
                                                           ->join('events','event_user_roles.event_id','=','events.id')
                                                           ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                           ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                            $dataForUserDivision = EventUserRoles::where('event_user_roles.division_id',$divisionCheck->id)
                                                                ->join('events','event_user_roles.event_id','=','events.id')
                                                                ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                                ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                            $dataForUserSubjectDivision = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                                                                ->join('event_user_roles','division_subjects.division_id','=','event_user_roles.division_id')
                                                                                ->join('events','event_user_roles.event_id','=','events.id')
                                                                                ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                                                ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                             $data = array_merge($dataCreatedBy,$dataForUser,$dataForUserDivision,$dataForUserSubjectDivision);
                             $data = array_unique($data,SORT_REGULAR);
                    } else {
                            $dataCreatedBy = Event::where('created_by',$user->id)->where('status',0)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                            $dataForUser = EventUserRoles::where('event_user_roles.user_id',$user->id)
                                                            ->join('events','event_user_roles.event_id','=','events.id')
                                                            ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                            ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                            $dataForUserSubjectDivision = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                                                                ->join('event_user_roles','division_subjects.division_id','=','event_user_roles.division_id')
                                                                                ->join('events','event_user_roles.event_id','=','events.id')
                                                                                ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                                                ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                            $data = array_merge($dataCreatedBy,$dataForUser,$dataForUserSubjectDivision);
                            $data = array_unique($data,SORT_REGULAR);
                    }
              }
            } elseif(in_array('view_announcement',$resultArr)) {
                    if($user->role_id == 1) {
                        $dataPublish = Event::where('event_type_id',1)->where('status',2)->orWhere('status',1)->skip($pageCount*4)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                        $dataUnpublish = Event::where('event_type_id',1)->where('created_by',$user->id)->where('status',0)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                        $data = array_merge($dataPublish,$dataUnpublish);
                    } elseif ($user->role_id == 2) {
                        $divisionCheck = Division::where('class_teacher_id',$user->id)->first();
                        if ($divisionCheck !== null) {
                            $dataCreatedBy = Event::where('event_type_id',1)->where('created_by',$user->id)->where('status',1)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                            $dataForUser = EventUserRoles::where('event_user_roles.user_id',$user->id)
                                                            ->where('events.event_type_id',1)
                                                            ->join('events','event_user_roles.event_id','=','events.id')
                                                            ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                            ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                            $dataForUserDivision = EventUserRoles::where('event_user_roles.division_id',$divisionCheck->id)
                                                                    ->where('events.event_type_id',1)
                                                                    ->join('events','event_user_roles.event_id','=','events.id')
                                                                    ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                                    ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                            $dataForUserSubjectDivision = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                                                                ->where('events.event_type_id',1)
                                                                                ->join('event_user_roles','division_subjects.division_id','=','event_user_roles.division_id')
                                                                                ->join('events','event_user_roles.event_id','=','events.id')
                                                                                ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                                                ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                            $data = array_merge($dataCreatedBy,$dataForUser,$dataForUserDivision,$dataForUserSubjectDivision);
                            $data = array_unique($data,SORT_REGULAR);
                        } else {
                            $dataCreatedBy = Event::where('event_type_id',1)->where('created_by',$user->id)->where('status',0)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                            $dataForUser = EventUserRoles::where('event_user_roles.user_id',$user->id)
                                                            ->where('events.event_type_id',1)
                                                            ->join('events','event_user_roles.event_id','=','events.id')
                                                            ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                            ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                            $dataForUserSubjectDivision = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                                                                ->where('events.event_type_id',1)
                                                                                ->join('event_user_roles','division_subjects.division_id','=','event_user_roles.division_id')
                                                                                ->join('events','event_user_roles.event_id','=','events.id')
                                                                                ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                                                ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                            $data = array_merge($dataCreatedBy,$dataForUser,$dataForUserSubjectDivision);
                            $data = array_unique($data,SORT_REGULAR);
                        }
                    }
            } elseif(in_array('view_achivement',$resultArr)){
                        if($user->role_id == 1) {
                            $dataPublish = Event::where('event_type_id',2)->where('status',2)->orWhere('status',1)->skip($pageCount*4)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                            $dataUnpublish = Event::where('event_type_id',2)->where('created_by',$user->id)->where('status',0)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                            $data = array_merge($dataPublish,$dataUnpublish);
                        } elseif ($user->role_id == 2) {
                            $divisionCheck = Division::where('class_teacher_id',$user->id)->first();
                            if ($divisionCheck !== null) {
                                $dataCreatedBy = Event::where('event_type_id',1)->where('created_by',$user->id)->where('status',0)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                                $dataForUser = EventUserRoles::where('event_user_roles.user_id',$user->id)
                                                                ->where('events.event_type_id',2)
                                                                ->join('events','event_user_roles.event_id','=','events.id')
                                                                ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                                ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                                $dataForUserDivision = EventUserRoles::where('event_user_roles.division_id',$divisionCheck->id)
                                                                        ->where('events.event_type_id',2)
                                                                        ->join('events','event_user_roles.event_id','=','events.id')
                                                                        ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                                        ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                                $dataForUserSubjectDivision = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                                                                    ->where('events.event_type_id',2)
                                                                                    ->join('event_user_roles','division_subjects.division_id','=','event_user_roles.division_id')
                                                                                    ->join('events','event_user_roles.event_id','=','events.id')
                                                                                    ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                                                    ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                                $data = array_merge($dataCreatedBy,$dataForUser,$dataForUserDivision,$dataForUserSubjectDivision);
                                $data = array_unique($data,SORT_REGULAR);
                            } else {
                                $dataCreatedBy = Event::where('event_type_id',2)->where('created_by',$user->id)->where('status',0)->take(4)->orderBy('created_at', 'desc')->get()->toArray();
                                $dataForUser = EventUserRoles::where('event_user_roles.user_id',$user->id)
                                                                ->where('events.event_type_id',2)
                                                                ->join('events','event_user_roles.event_id','=','events.id')
                                                                ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                                ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                                $dataForUserSubjectDivision = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                                                                    ->where('events.event_type_id',2)
                                                                                    ->join('event_user_roles','division_subjects.division_id','=','event_user_roles.division_id')
                                                                                    ->join('events','event_user_roles.event_id','=','events.id')
                                                                                    ->select('events.id as event_id','events.event_type_id','events.created_by','events.published_by','events.title','events.status','events.detail','events.priority','events.created_at','events.updated_at')
                                                                                    ->skip($pageCount*4)->take(4)->orderBy('events.created_at', 'desc')->get()->toArray();
                                $data = array_merge($dataCreatedBy,$dataForUser,$dataForUserSubjectDivision);
                                $data = array_unique($data,SORT_REGULAR);
                            }
                        }
            }

            $count = 0;
            foreach($data as $row) {
                $dataDate[]=date('F',strtotime($row['created_at']));
                $count++;
            }
            $dataDate = array_unique($dataDate,SORT_REGULAR);
            return view('noticeBoard')->with(compact('data','dataDate'));
        }

        public function loadMore()
        {
            $str='{"august":[
                 { "day":"Monday", "date":"17", "time":" 12:00 PM" , "type":"announcement" , "title":"School Trip"},
                 { "day":"Saturday", "date":"15", "time":" 10:30 AM" , "type":"announcement" , "title":"Amount For School Trip"},
                 { "day":"Saturday", "date":"15", "time":" 10:00 AM" , "type":"acheivement" , "title":"First in state in SSC Results"},
                 { "day":"Friday", "date":"14", "time":" 9:30 AM" , "type":"announcement",  "title":"Parent Meet"},
                 { "day":"Friday", "date":"14", "time":" 9:00 AM" , "type":"acheivement", "title":"Second in Zonal Sport"}

             ],"july":[
                 { "day":"Thursday", "date":"13", "time":" 12:00 PM" , "type":"announcement","title":"Results for last exam published"},
                 { "day":"Thursday", "date":"13", "time":" 10:30 AM" , "type":"announcement", "title":"Zonal Sport timetable" },
                 { "day":"Thursday", "date":"13", "time":" 10:00 AM" , "type":"announcement" , "title":"Zonal Sport teams"}
             ]}';

            return $str;
        }
        /**
         * Function Name: showCreateAnnouncement
         * @param
         * @return mixed
         * Desc: will show all user to create announcement page
         * Date: 03/03/2016
         * author manoj chaudahri
         */
        public function showCreateAnnouncement(Request $request)
        {
            $user = Auth::user();
            $classDivision = array();
            $batchList = array();
            $divisionData2 = array();
            $divisionData1 = array();
            $divisionData = array();
            if ($user->role_id == 1) {
                $user=Auth::user();
                $batchData = Batch::where('body_id',$user->body_id)->select('id','name')->get();
                $batchList = $batchData->toArray();
                if ($request->ajax()) {
                    $classData = Classes::where('batch_id',$request->batch_id)->select('id','class_name')->get();
                    $classList = $classData->toArray();
                } else {
                    $batch = Batch::where('body_id',$user->body_id)->select('id','name')->first();
                    $classData = Classes::where('batch_id',$batch->id)->select('id','class_name')->get();
                    $classList = $classData->toArray();
                }
                if($request->ajax()) {
                    $count = 0;
                    foreach($classList as $row) {
                        $classDivision[$count]['class_id'] = $row['id'];
                        $classDivision[$count]['class_name'] = $row['class_name'];
                        $divisionData = Division::where('class_id',$row['id'])->select('id','division_name')->get();
                        $countDivision = 0;
                        foreach($divisionData as $division) {
                            $classDivision[$count]['division'][$countDivision]['division_id'] = $division['id'];
                            $classDivision[$count]['division'][$countDivision]['division_name'] = $division['division_name'];
                            $countDivision++;
                        }
                        $count++;
                    }
                } else {
                    $count = 0;

                    foreach($classList as $row) {
                        $classDivision[$count]['class_id'] = $row['id'];
                        $classDivision[$count]['class_name'] = $row['class_name'];
                        $divisionData = Division::where('class_id',$row['id'])->select('id','division_name')->get();
                        $countDivision = 0;
                        foreach($divisionData as $division) {
                            $classDivision[$count]['division'][$countDivision]['division_id'] = $division['id'];
                            $classDivision[$count]['division'][$countDivision]['division_name'] = $division['division_name'];
                            $countDivision++;
                        }
                        $count++;
                    }
                }
            } elseif ($user->role_id == 2 ) {
                $userCheck = Division::where('class_teacher_id',$user->id)->first();
                if ($userCheck != null) {
                    $count=0;
                    if ($request->ajax()) {
                        $batchClassData = Division::where('divisions.class_teacher_id',$user->id)
                            ->join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->get()->toArray();
                        $divisionSubjects = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                            ->join('divisions','division_subjects.division_id','=','divisions.id')
                            ->join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->get()->toArray();

                        $mergedArray = array_merge($batchClassData,$divisionSubjects);
                        $mergedArray = array_unique($mergedArray, SORT_REGULAR);

                        foreach($mergedArray as $row) {
                            $batchList[$count]['id'] = $row['batch_id'];
                            $batchList[$count]['name'] = $row['batch_name'];
                            $count++;
                        }

                        $batchList = array_unique($batchList, SORT_REGULAR);
                        $countClass = 0;

                        foreach($mergedArray as $row) {
                            $classDivision[$countClass]['class_id'] = $row['class_id'];
                            $classDivision[$countClass]['class_name'] = $row['class_name'];

                            if ($userCheck != null) {
                                $divisionData1 = Division::where('class_id',$row['class_id'])->where('class_teacher_id',$user->id)->select('id','division_name')->get()->toArray();

                            }
                            $divisionSubject = SubjectClassDivision::where('teacher_id',$user->id)->select('division_id')->get();
                            $divArr=array();
                            foreach($divisionSubject as $divs)
                            {
                                array_push($divArr,$divs->division_id);
                            }
                            $divArr=array_unique($divArr);
                            $divisionData2 = Division::where('class_id',$row['class_id'])->whereIn('id',$divArr)
                                ->select('id','division_name')->get()->toArray();

                            $divisionData2 = array_filter($divisionData2);
                            $divisionData1 = array_filter($divisionData1);
                            if($divisionData1 != null) {
                                $divisionData = array_merge ($divisionData1, $divisionData2);
                            } else {
                                $divisionData = $divisionData2;
                            }
                            $divisionData = array_unique($divisionData, SORT_REGULAR);

                            $countDivision = 0;
                            foreach($divisionData as $division) {
                                $classDivision[$countClass]['division'][$countDivision]['division_id'] = $division['id'];
                                $classDivision[$countClass]['division'][$countDivision]['division_name'] = $division['division_name'];
                                $countDivision++;
                            }
                            $countClass++;
                        }
                        $classDivision = array_unique($classDivision, SORT_REGULAR);
                    } else {
                        $batchClassData = Division::where('divisions.class_teacher_id',$user->id)
                            ->join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->get()->toArray();
                        $divisionSubjects = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                            ->join('divisions','division_subjects.division_id','=','divisions.id')
                            ->join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->get()->toArray();

                        $mergedArray = array_merge($batchClassData,$divisionSubjects);
                        $mergedArray = array_unique($mergedArray, SORT_REGULAR);

                        foreach($mergedArray as $row) {
                            $batchList[$count]['id'] = $row['batch_id'];
                            $batchList[$count]['name'] = $row['batch_name'];
                            $count++;
                        }
                        $batchList = array_unique($batchList, SORT_REGULAR);
                        $countClass = 0;
                        foreach($mergedArray as $row) {
                            $classDivision[$countClass]['class_id'] = $row['class_id'];
                            $classDivision[$countClass]['class_name'] = $row['class_name'];
                            if ($userCheck != null) {
                                $divisionData1 = Division::where('class_id',$row['class_id'])->where('class_teacher_id',$user->id)->select('id','division_name')->get()->toArray();
                            }
                            $divisionSubject = SubjectClassDivision::where('teacher_id',$user->id)->select('division_id')->get();
                            $divArr=array();
                            foreach($divisionSubject as $divs)
                            {
                                array_push($divArr,$divs->division_id);
                            }
                            $divArr=array_unique($divArr);
                            $divisionData2 = Division::where('class_id',$row['class_id'])->whereIn('id',$divArr)
                                    ->select('id','division_name')->get()->toArray();
                            $divisionData2 = array_filter($divisionData2);
                            $divisionData1 = array_filter($divisionData1);
                            if($divisionData1 != null) {
                            $divisionData = array_merge ($divisionData1, $divisionData2);
                            } else {
                                $divisionData = $divisionData2;
                            }
                            $divisionData = array_unique($divisionData, SORT_REGULAR);
                            $countDivision = 0;
                            foreach($divisionData as $division) {
                                    $classDivision[$countClass]['division'][$countDivision]['division_id'] = $division['id'];
                                    $classDivision[$countClass]['division'][$countDivision]['division_name'] = $division['division_name'];
                                    $countDivision++;
                            }
                            $countClass++;
                        }
                        $classDivision = array_unique($classDivision, SORT_REGULAR);
                    }
                } else {
                    if ($request->ajax()) {
                        $count=0;
                        $divisionSubjects = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                            ->join('divisions','division_subjects.division_id','=','divisions.id')
                            ->join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->get()->toArray();

                        $divisionSubjects = array_unique($divisionSubjects, SORT_REGULAR);
                        foreach($divisionSubjects as $row) {
                            $batchList[$count]['id'] = $row['batch_id'];
                            $batchList[$count]['name'] = $row['batch_name'];
                            $count++;
                        }
                        $batchList = array_unique($batchList, SORT_REGULAR);
                        $countClass = 0;
                        foreach($divisionSubjects as $row) {
                            $classDivision[$countClass]['class_id'] = $row['class_id'];
                            $classDivision[$countClass]['class_name'] = $row['class_name'];
                            $divisionSubject = SubjectClassDivision::where('teacher_id',$user->id)->select('division_id')->get()->toArray();
                            $divisionSubject = array_unique($divisionSubject, SORT_REGULAR);
                            $count = 0;
                            foreach($divisionSubject as $divs ) {
                                $divisionData2[$count] =Division::where('class_id',$row['class_id'])->where('id',$divs['division_id'])
                                    ->select('id','division_name')->get()->toArray();
                                $count++;
                            }
                            $divisionData2 = array_filter($divisionData2);
                            $divisionData = array_unique($divisionData2, SORT_REGULAR);
                            $countDivision = 0;
                            $i = 0;
                            foreach($divisionData as $division) {
                                foreach($division as $row) {
                                    $classDivision[$countClass]['division'][$countDivision]['division_id'] = $row['id'];
                                    $classDivision[$countClass]['division'][$countDivision]['division_name'] = $row['division_name'];
                                    $countDivision++;
                                }
                                $i++;
                            }
                            $countClass++;
                        }
                        $classDivision = array_unique($classDivision, SORT_REGULAR);
                    } else {
                        $count=0;
                        $divisionSubjects = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                            ->join('divisions','division_subjects.division_id','=','divisions.id')
                            ->join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->get()->toArray();

                        $divisionSubjects = array_unique($divisionSubjects, SORT_REGULAR);
                        foreach($divisionSubjects as $row) {
                            $batchList[$count]['id'] = $row['batch_id'];
                            $batchList[$count]['name'] = $row['batch_name'];
                            $count++;
                        }
                        $batchList = array_unique($batchList, SORT_REGULAR);
                        $countClass = 0;
                        foreach($divisionSubjects as $row) {
                            $classDivision[$countClass]['class_id'] = $row['class_id'];
                            $classDivision[$countClass]['class_name'] = $row['class_name'];
                            $divisionSubject = SubjectClassDivision::where('teacher_id',$user->id)->select('division_id')->get()->toArray();
                            $divisionSubject = array_unique($divisionSubject, SORT_REGULAR);
                            $count = 0;
                            foreach($divisionSubject as $divs ) {
                                $divisionData2[$count] =Division::where('class_id',$row['class_id'])->where('id',$divs['division_id'])
                                    ->select('id','division_name')->get()->toArray();
                                $count++;
                            }
                            $divisionData2 = array_filter($divisionData2);
                            $divisionData = array_unique($divisionData2, SORT_REGULAR);
                            $countDivision = 0;
                            $i = 0;
                            foreach($divisionData as $division) {
                                foreach($division as $row) {
                                    $classDivision[$countClass]['division'][$countDivision]['division_id'] = $row['id'];
                                    $classDivision[$countClass]['division'][$countDivision]['division_name'] = $row['division_name'];
                                    $countDivision++;
                                }
                                $i++;
                            }
                            $countClass++;
                        }
                        $classDivision = array_unique($classDivision, SORT_REGULAR);
                    }
                }
            }
            if($request->ajax()) {
                return $classDivision;
            } else {
                return view('createNoticeBoard')->with(compact('batchList','classDivision'));
            }

        }

        /**
         * Function Name: getAllAdmins
         * @param
         * @return mixed
         * Desc: will show all admins of body
         * Date: 03/03/2016
         * author manoj chaudahri
         */

        public function getAllAdmins()
        {
            $user = Auth::user();
            $adminList = User::where('role_id',1)->where('is_active',1)->where('body_id',$user->body_id)->whereNotIn('id',[$user->id])->select('id','first_name','last_name')->get();
            return $adminList;

        }

        /**
         * Function Name: getAllTeachers
         * @param
         * @return mixed
         * Desc: will show all teachers of body
         * Date: 03/03/2016
         * author manoj chaudahri
         */

        public function getAllTeachers()
        {
            $user = Auth::user();
            $teacherList = User::where('role_id',2)->where('is_active',1)->where('body_id',$user->body_id)->whereNotIn('id',[$user->id])->select('id','first_name','last_name')->get();
            return $teacherList;

        }


        public function createNoticeBoard(CreateAnnouncementRequest $request)
        {
            if ($request->authorize() === true)
            {    $annoucement =array();
                $userEntry = array();
                $user = Auth::user();
                $annoucement['event_type_id'] = 1;
                $annoucement['title'] = $request->title;
                $annoucement['priority'] = $request->priority;
                $annoucement['detail'] = $request->announcement;
                $annoucement['created_at'] = Carbon::now();
                $annoucement['updated_at'] = Carbon::now();

                if($request->buttons == 'publish') {
                    if($user->role_id == 1) {
                        $annoucement['created_by'] = $user->id;
                        $annoucement['published_by'] = $user->id;
                        $annoucement['status'] = 2;
                    } elseif($user->role_id == 2){
                        $annoucement['created_by'] = $user->id;
                        $annoucement['status'] = 1;
                    }
                } elseif($request->buttons == 'save'){
                    $annoucement['created_by'] = $user->id;
                    $annoucement['status'] = 0;
                }
                $eventId = Event::insertGetId($annoucement);
                if($eventId != null) {
                    if($request->adminList) {
                        $count = 0;
                        foreach($request->adminList as $row) {
                            $userEntry['event_id'] = $eventId;
                            $userEntry['user_id'] = $row;
                            $userEntry['created_at'] = Carbon::now();
                            $userEntry['updated_at'] = Carbon::now();
                            EventUserRoles::insert($userEntry);
                            $count++;
                        }
                    }
                    if($request->teacherList) {
                        $count = 0;
                        foreach($request->teacherList as $row) {
                            $userEntry['event_id'] = $eventId;
                            $userEntry['user_id'] = $row;
                            $userEntry['created_at'] = Carbon::now();
                            $userEntry['updated_at'] = Carbon::now();
                            EventUserRoles::insert($userEntry);
                            $count++;
                        }
                    }
                    if($request->FirstDiv){
                        $count = 0;
                        foreach($request->FirstDiv as $row) {
                            $userEntry['event_id'] = $eventId;
                            $userEntry['division_id'] = $row;
                            $userEntry['created_at'] = Carbon::now();
                            $userEntry['updated_at'] = Carbon::now();
                            EventUserRoles::insert($userEntry);
                            $count++;
                        }
                    } elseif(!($request->FirstDiv) && !($request->classFirst) && $request['batch-select'] ) {

                        if($user->role_id == 1) {
                            $divisionData = Classes::join('divisions','classes.id','=','divisions.class_id')
                                ->where('classes.body_id',$user->body_id)
                                ->where('classes.batch_id',$request['batch-select'])
                                ->select('divisions.id as division_id','divisions.division_name')
                                ->get();
                            $count = 0;
                            foreach($divisionData as $row) {
                                $userEntry['event_id'] = $eventId;
                                $userEntry['division_id'] = $row['division_id'];
                                $userEntry['created_at'] = Carbon::now();
                                $userEntry['updated_at'] = Carbon::now();
                                EventUserRoles::insert($userEntry);
                                $count++;
                            }
                        } elseif ($user->role_id == 2) {
                            $teacherCheck = Division::where('class_teacher_id',$user->id)->first();
                            if($teacherCheck != null) {
                                $divisionData = Division::where('divisions.class_teacher_id',$user->id)
                                    ->join('classes','divisions.class_id','=','classes.id')
                                    ->where('classes.batch_id',$request['batch-select'])
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get()->toArray();
                                $divSubjectData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                    ->join('divisions','division_subjects.division_id','=','divisions.id')
                                    ->join('classes','divisions.class_id','=','classes.id')
                                    ->where('classes.batch_id',$request['batch-select'])
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get()->toArray();
                                $division = array_merge ($divSubjectData, $divisionData);
                                $division = array_unique($division, SORT_REGULAR);
                                $count = 0;
                                foreach($division as $row) {
                                    $userEntry['event_id'] = $eventId;
                                    $userEntry['division_id'] = $row['division_id'];
                                    $userEntry['created_at'] = Carbon::now();
                                    $userEntry['updated_at'] = Carbon::now();
                                    EventUserRoles::insert($userEntry);
                                    $count++;
                                }

                            } else {
                                $divisionData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                    ->join('divisions','division_subjects.division_id','=','divisions.id')
                                    ->join('classes','divisions.class_id','=','classes.id')
                                    ->where('classes.batch_id',$request['batch-select'])
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get();
                                $count = 0;
                                foreach($divisionData as $row) {
                                    $userEntry['event_id'] = $eventId;
                                    $userEntry['division_id'] = $row['division_id'];
                                    $userEntry['created_at'] = Carbon::now();
                                    $userEntry['updated_at'] = Carbon::now();
                                    EventUserRoles::insert($userEntry);
                                    $count++;
                                }
                            }
                        }
                    } elseif(!($request->FirstDiv) && $request->classFirst && $request['batch-select'] ) {
                        if($user->role_id == 1) {
                            $divisionData = Division::whereIn('class_id',$request->classFirst)
                                ->select('divisions.id as division_id','divisions.division_name')
                                ->get();
                            $count = 0;
                            foreach($divisionData as $row) {
                                $userEntry['event_id'] = $eventId;
                                $userEntry['division_id'] = $row['division_id'];
                                $userEntry['created_at'] = Carbon::now();
                                $userEntry['updated_at'] = Carbon::now();
                                EventUserRoles::insert($userEntry);
                                $count++;
                            }
                        } elseif ($user->role_id == 2) {
                            $teacherCheck = Division::where('class_teacher_id',$user->id)->first();
                            if($teacherCheck != null) {
                                $divisionData = Division::where('class_teacher_id',$user->id)
                                    ->whereIn('class_id',$request->classFirst)
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get()->toArray();
                                $divSubjectData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                    ->join('divisions','division_subjects.division_id','=','divisions.id')
                                    ->whereIn('divisions.class_id',$request->classFirst)
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get()->toArray();
                                $division = array_merge ($divSubjectData, $divisionData);
                                $division = array_unique($division, SORT_REGULAR);
                                $count = 0;
                                foreach($division as $row) {
                                    $userEntry['event_id'] = $eventId;
                                    $userEntry['division_id'] = $row['division_id'];
                                    $userEntry['created_at'] = Carbon::now();
                                    $userEntry['updated_at'] = Carbon::now();
                                    EventUserRoles::insert($userEntry);
                                    $count++;
                                }

                            } else {
                                $divisionData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                    ->join('divisions','division_subjects.division_id','=','divisions.id')
                                    ->whereIn('divisions.class_id',$request->classFirst)
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get()->toArray();
                                $count = 0;
                                foreach($divisionData as $row) {
                                    $userEntry['event_id'] = $eventId;
                                    $userEntry['division_id'] = $row['division_id'];
                                    $userEntry['created_at'] = Carbon::now();
                                    $userEntry['updated_at'] = Carbon::now();
                                    EventUserRoles::insert($userEntry);
                                    $count++;
                                }
                            }
                        }
                    } elseif(($request->FirstDiv) && ($request->classFirst) && ($request['batch-select'])) {
                        $count = 0;
                        foreach($request->FirstDiv as $row) {
                            $userEntry['event_id'] = $eventId;
                            $userEntry['division_id'] = $row;
                            $userEntry['created_at'] = Carbon::now();
                            $userEntry['updated_at'] = Carbon::now();
                            EventUserRoles::insert($userEntry);
                            $count++;
                        }
                    }

                }
                Session::flash('message-success','announcement created successfully');
                return view('noticeBoard');
            } else {
                return Redirect::back();
            }


        }

        public function detailAnnouncement()
        {
            return view('detailAnnouncement');
        }
        public function detailAchievement()
        {
            return view('detailAchievement');
        }
    }
