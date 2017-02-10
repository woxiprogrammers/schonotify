<?php

namespace App\Http\Controllers;

use App\AclMaster;
use App\Attendance;
use App\Batch;
use App\ClassData;
use App\Classes;
use App\Division;
use App\HomeworkTeacher;
use App\Leave;
use App\Module;
use App\ModuleAcl;
use App\ParentExtraInfo;
use App\StudentDocument;
use App\StudentExtraInfo;
use App\StudentFamily;
use App\StudentHobby;
use App\StudentPreviousSchool;
use App\StudentSibling;
use App\StudentSpecialAptitude;
use App\SubjectClassDivision;
use App\TeacherExtraInfo;
use App\TeacherQualification;
use App\TeacherReferences;
use App\TeacherView;
use App\TeacherWorkExperience;
use App\User;
use App\UserRoles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Log;





class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth',['except' => [
        'verifyUser'
    ],
    ]);
    }

    public function index()
    {
        //
    }

    public function usersProfile()
    {
        $user=Auth::user();
        return view('userProfile')->with('user',$user);

    }



    public function updateUsersProfile(Requests\WebRequests\ProfileRequest $request,$id)
    {
         $userImage=User::where('id',$id)->first();
          unset($request->_method);
          $user=Auth::user();
          if($request->hasFile('avatar')){
               $image = $request->file('avatar');
               $name = $request->file('avatar')->getClientOriginalName();
               $filename = time()."_".$name;
               $path = public_path('uploads/profile-picture/');
              if (! file_exists($path)) {
                   File::makeDirectory('uploads/profile-picture/', $mode = 0777, true, true);
              }
              $image->move($path,$filename);
          }
          else{
                $filename=$userImage->avatar;

          }
        $date = date('Y-m-d', strtotime(str_replace('-', '/', $request->DOB)));
          $userData['username']= $request->username;
          $userData['first_name']= $request->firstname;
          $userData['email']= $request->email;
          $userData['last_name']= $request->lastname;
          $userData['gender']= $request->gender;
          $userData['mobile']= $request->mobile;
          $userData['alternate_number']= $request->alternate_number;
          $userData['address']= $request->address;
          $userData['avatar']= $filename;
          $userData['birth_date']= $date;
        $userUpdate=User::where('id',$id)->update($userData);
            if($userUpdate == 1){
                Session::flash('message-success','profile updated successfully');
               return Redirect::back();
            }
            else{
                Session::flash('message-error','something went wrong');
                return Redirect::back();
            }

    }

    public function changePassword(Requests\WebRequests\ChangePasswordRequest $request)
    {
        $password = $request->all();
        unset($password['_method']);
        $user = Auth::user();
        $user->update(array('password' => bcrypt($password['password'])));
        Session::flash('message-success','password successfully updated');
        return Redirect::to('/myProfile');

    }
    public function userModuleAcls()
    {
        
        $modules=Module::select('slug')->get();

        $acls=AclMaster::all();
        $allModuleAcl=array();
        $arrMod=array();
        $userModAclArr=array();
        $mainArr=array();

        $userModAclArr=session('functionArr');

        foreach($modules as $row1)
        {
            $i=0;
            foreach($acls as $row)
            {

                $allModuleAcl[$row1->slug][$i]=$row->slug;
                $i++;

            }

        }

        $mainArr['allModules']=$modules;
        $mainArr['allAcls']=$acls;
        $mainArr['userModAclArr']=$userModAclArr;
        $mainArr['allModAclArr']=$allModuleAcl;

        return $mainArr;

    }
    public function userModuleAclsEdit( $id)
    {

        $modules=Module::select('slug','id')->get();

        $acls=AclMaster::all();
        $allModuleAcl=array();
        $arrMod=ModuleAcl::where('user_id',$id)
            ->join('modules','module_acls.module_id','=','modules.id')
            ->join('acl_master','module_acls.acl_id','=','acl_master.id')
            ->select('modules.slug as modules','acl_master.slug as acls')
            ->get();

        $userModAclArr=array();
        foreach($arrMod as $row)
        {
            array_push($userModAclArr,$row->acls.'_'.$row->modules);
        }

        $mainArr=array();


        foreach($modules as $row1)
        {
            $i=0;
            foreach($acls as $row)
            {

                $allModuleAcl[$row1->slug][$i]=$row->slug;
                $i++;

            }

        }

        $mainArr['allModules']=$modules;
        $mainArr['allAcls']=$acls;
        $mainArr['userModAclArr']=$userModAclArr;
        $mainArr['allModAclArr']=$allModuleAcl;

        return $mainArr;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $role1=UserRoles::find($id);

        Session::put('user_create_role',$role1->slug);

        if($role1->slug=='admin')
        {
            return Redirect::to('adminCreate');
        }elseif($role1->slug=='teacher')
        {
            return Redirect::to('teacherCreate');
        }elseif($role1->slug=='student')
        {
            return Redirect::to('studentCreate');
        }elseif($role1->slug=='parent')
        {
            return Redirect::to('parentCreate');
        }else
        {
            return Redirect::to('usersCreate');
        }

    }

    public function adminCreateForm(Requests\WebRequests\UserRequest $request)
    {
        $roles=UserRoles::all();
        $role_id='1';
        Session::put('role_id', $role_id);
        if($request->authorize()===true)
        {
            return view('admin.adminCreateForm')->with('userRoles',$roles);
        }else{
            return Redirect::to('/');
        }

    }

    public function teacherCreateForm(Requests\WebRequests\UserRequest $request)
    {
        $roles=UserRoles::all();
        $role_id='2';
        Session::put('role_id', $role_id);
        if($request->authorize()===true)
        {
            return view('admin.teacherCreateForm')->with('userRoles',$roles);
        }else{
            return Redirect::to('/');
        }

    }

    public function studentCreateForm(Requests\WebRequests\UserRequest $request)
    {
        $roles=UserRoles::all();
        $role_id='3';
        Session::put('role_id', $role_id);
        if($request->authorize()===true)
        {
            return view('admin.studentCreateForm')->with('userRoles',$roles);
        }else{
            return Redirect::to('/');
        }

    }

    public function parentCreateForm(Requests\WebRequests\UserRequest $request)
    {
        $roles=UserRoles::all();
        $role_id='4';
        Session::put('role_id', $role_id);
        if($request->authorize()===true)
        {
            return view('admin.parentCreateForm')->with('userRoles',$roles);
        }else{
            return Redirect::to('/');
        }
    }

    public function usersCreateForm(Requests\WebRequests\UserRequest $request)
    {
        $roles=UserRoles::all();
        if($request->authorize()===true)
        {
            return view('admin.usersCreateForm')->with('userRoles',$roles);
        }else{
            return Redirect::to('/');
        }

    }

    public function studentCreateFormEnquiry(Requests\WebRequests\UserRequest $request)
    {
        $roles=UserRoles::all();
        if($request->authorize()===true)
        {
            return view('admin.studentCreateFormEnquiry')->with('userRoles',$roles);
        }else{
            return Redirect::to('/');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\WebRequests\UserRequest $request)
    {
        $data = $request->all();
        $user=Auth::user();
        if(!empty($data)){
            if(isset($data['dob'])){
                $dob = $data['dob'];
            }else{
                $dob = $data['mobile'];
            }
            $unique_user_string = strtolower($data['firstName'] . $data['lastName'] . $dob);
            $username = ucfirst(substr($data['firstName'], 0, 1)) . ucfirst($data['lastName']) . crc32($unique_user_string);
            $userData= new User;
            $userData->first_name = $data['firstName'];
            $userData->last_name = $data['lastName'];
            $userData->username = $username;
            $userData->password = bcrypt($data['password']);
            $userData->gender = $data['gender'];
            $userData->mobile = $data['mobile'];
            $userData->alternate_number = $data['alt_number'];
            $userData->role_id = $data['role'];
            $userData->avatar = 'default-user.jpg';
            $userData->is_active = 0;
            $userData->remember_token = csrf_token().'_'.time();
            $userData->confirmation_code = str_random(30);
            $userData->body_id = $user->body_id;
            $userData->created_at = Carbon::now();
            $userData->updated_at = Carbon::now();
            if($data['role_name']== 'admin'){
                $userData->email = $data['email'];
                $userData->address = $data['address'];
                $userData = array_add($userData, 'emp_type', $data['emp_type']);
                $userData->save();
                $LastInsertId = $userData->id;
            }elseif($data['role_name']== 'teacher'){
                $userData->email = $data['email'];
                $userData->middle_name = $data['middleName'];
                $date = str_replace('/', '-', $data['dob']);
                $userData->birth_date = date('Y-m-d', strtotime($date));
                $userData = array_add($userData, 'emp_type', $data['emp_type']);
                $userData->save();
                $LastInsertId = $userData->id;
                if(isset($data['class-teacher'])){
                    Division::where('id',$data['division'])->update(['class_teacher_id' => $LastInsertId]);
                }
                $teacherViews['web_view']= 0;
                $teacherViews['mobile_view']= 0;
                if(!empty($data['access'])){
                    foreach($data['access'] as $report_id){
                        if($report_id == 'web'){
                            $teacherViews['web_view']= 1;
                        }else{
                            $teacherViews['mobile_view']=1;
                        }
                    }
                }
                $teacherViews['user_id'] = $LastInsertId;
                $teacherViews['created_at'] = Carbon::now();
                $teacherViews['updated_at'] = Carbon::now();
                TeacherView::insert($teacherViews);


                if(isset($data['teacher_communication_address'])){
                    $communication_address_teacher = $data['permanent_address'];
                }else{
                    $communication_address_teacher = $data['communication_address_teacher'];
                }
                $teacherExtraInfo = $request->only('martial_status','spouse_first_name','spouse_middle_name','spouse_last_name','issues','permanent_address','aadhar_number','pan_card','designation','b_ed_methods','total_work_experience');
                $joiningDate = str_replace('/', '-', $data['joining_date']);
                $teacherExtraInfo['joining_date'] = date('Y-m-d', strtotime($joiningDate));
                $teacherExtraInfo['teacher_id'] = $LastInsertId;
                $teacherExtraInfo['communication_address']=$communication_address_teacher;
                $teacherExtraInfo['created_at'] = Carbon::now();
                $teacherExtraInfo['updated_at'] = Carbon::now();
                TeacherExtraInfo::insert($teacherExtraInfo);

                if(isset($data['qualification'])){
                    $qualificationInfo = array();
                    $qualifications = $data['qualification'];
                    foreach($qualifications as $qualification){
                        $qualificationInfo['teacher_id'] = $LastInsertId;
                        $qualificationInfo['certificate'] = $qualification['certificate'];
                        $qualificationInfo['passing_year'] = $qualification['passing_year'];
                        $qualificationInfo['university'] = $qualification['university'];
                        $qualificationInfo['subjects'] = $qualification['subjects'];
                        $qualificationInfo['created_at'] = Carbon::now();
                        $qualificationInfo['updated_at'] = Carbon::now();
                        TeacherQualification::insert($qualificationInfo);
                    }
                }

                if(isset($data['work_experience'])){
                    $workExperienceInfo = array();
                    $workExperiences = $data['work_experience'];
                    foreach($workExperiences as $workExperience){
                        $workExperienceInfo['teacher_id'] = $LastInsertId;
                        $workExperienceInfo['organisation'] = $workExperience['organisation'];
                        $workExperienceInfo['designation'] = $workExperience['designation'];
                        $workExperienceInfo['duration'] = $workExperience['duration'];
                        $workExperienceInfo['created_at'] = Carbon::now();
                        $workExperienceInfo['updated_at'] = Carbon::now();
                        TeacherWorkExperience::insert($workExperienceInfo);
                    }
                }
                if(isset($data['reference'])){
                    $referenceInfo = array();
                    $references = $data['reference'];
                    foreach($references as $reference){
                        $referenceInfo['teacher_id'] = $LastInsertId;
                        $referenceInfo['reference_name'] = $reference['reference_name'];
                        $referenceInfo['contact_no'] = $reference['contact_no'];
                        $referenceInfo['address'] = $reference['address'];
                        $referenceInfo['created_at'] = Carbon::now();
                        $referenceInfo['updated_at'] = Carbon::now();
                        TeacherReferences::insert($referenceInfo);
                    }
                }
                if(isset($data['upload_doc'])){
                    foreach($data['upload_doc'] as $doc){
                        if($doc != null){
                            $image = $doc;
                            $name = $doc->getClientOriginalName();
                            $filename = time()."_".$name;
                            $path1 = public_path('uploads/teacher_documents/'.$LastInsertId);
                            if (! file_exists($path1)) {
                                File::makeDirectory('uploads/teacher_documents/'.$LastInsertId, $mode = 0777, true, true);
                            }
                            $image->move($path1,$filename);
                            $studentDocument['document'] = $filename;
                            $studentDocument['student_id'] = $LastInsertId;
                            $studentDocument['created_at'] = Carbon::now();
                            $studentDocument['updated_at'] = Carbon::now();
                            StudentDocument::insert($studentDocument);
                        }
                    }
                }

            }elseif($data['role_name']== 'parent'){
                $userData->save();
                $LastInsertId = $userData->id;
            }elseif($data['role_name']== 'student'){
                $userData->address = $data['address'];
                $date = str_replace('/', '-', $data['dob']);
                $userData->birth_date = date('Y-m-d', strtotime($date));
                $userData->middle_name = $data['middleName'];
                $userData->roll_number = $data['roll_number'];
                if(isset($data['division'])){
                    $userData = array_add($userData, 'division_id', $data['division']);
                }
                if(!empty($data['parent_id'])){
                    $userData = array_add($userData, 'parent_id', $data['parent_id']);
                    $parent=User::where('id',$data['parent_id'])->select('is_active')->first();
                    if($parent->is_active == 1){
                        $userData->is_active = 1;
                    }
                }else{
                    if(isset($data['parent_communication_address'])){
                        $communication_address_parent = $data['permanent_address'];
                    }else{
                        $communication_address_parent = $data['communication_address_parent'];
                    }
                    $unique_user_string = strtolower($data['father_first_name'] . $data['father_last_name'] . $data['dob']);
                    $username = ucfirst(substr($data['father_first_name'], 0, 1)) . ucfirst($data['father_last_name']) . crc32($unique_user_string);
                    $parentData= new User;
                    $parentData->first_name = $data['father_first_name'];
                    $parentData->last_name = $data['father_last_name'];
                    $parentData->middle_name = $data['father_middle_name'];
                    $parentData->username = $username;
                    $parentData->password = bcrypt($data['password']);
                    $parentData->gender = $data['gender'];
                    $parentData->address = $communication_address_parent;
                    $parentData->mobile = $data['father_contact'];
                    $parentData->email = $data['parent_name'];
                    $parentData->role_id = 4;
                    $parentData->avatar = 'default-user.jpg';
                    $parentData->is_active = 0;
                    $parentData->remember_token = csrf_token().'_'.time();
                    $parentData->confirmation_code = str_random(30);
                    $parentData->body_id = $user->body_id;
                    $parentData->created_at = Carbon::now();
                    $parentData->updated_at = Carbon::now();
                    $parentData->save();
                    $parnetId = $parentData->id;
                    $familyInfo = $request->only('father_first_name','father_middle_name','father_last_name','father_occupation','father_income','father_contact','mother_first_name','mother_middle_name','mother_last_name','mother_occupation','mother_income','mother_contact','parent_email','permanent_address');
                    $familyInfo['communication_address'] = $communication_address_parent;
                    $familyInfo['parent_id'] = $parnetId;
                    $familyInfo['created_at'] = Carbon::now();
                    $familyInfo['updated_at'] = Carbon::now();
                    ParentExtraInfo::insert($familyInfo);
                    $userData = array_add($userData, 'parent_id', $parnetId);
                        if(!empty($data['modules'])){
                            $userAclsData = array();
                            $modules = $data['modules'];
                            foreach($modules as $module){
                                $acl_module = $module;
                                $aclData = explode("_", $acl_module);
                                $userAcl = $aclData[0];
                                $userModule = $aclData[1];
                                $aclMasters = AclMaster::select('id','slug')->get();
                                $aclMasters = $aclMasters->toArray();
                                foreach ($aclMasters as $aclMaster){
                                    if($aclMaster['slug'] == $userAcl){
                                        $userAclData['acl_id'] = $aclMaster['id'];
                                    }
                                }
                                $moduleMasters = Module::select('id','slug')->get();
                                $moduleMasters = $moduleMasters->toArray();
                                foreach ($moduleMasters as $moduleMaster){
                                    if($moduleMaster['slug'] == $userModule){
                                        $userAclData['module_id'] = $moduleMaster['id'];
                                    }
                                }
                                $userAclData['user_id'] = $parnetId;
                                $userAclData['created_at'] = Carbon::now();
                                $userAclData['updated_at'] = Carbon::now();
                                array_push($userAclsData,$userAclData);
                            }
                            ModuleAcl::insert($userAclsData);
                        }
                }
                $userData->save();
                $LastInsertId = $userData->id;

                if(isset($data['hobbies'])){
                    $hobbyInfo = array();
                    $hobbies = $data['hobbies'];
                    foreach($hobbies as $hobby){
                        if($hobby != ''){
                            $hobbyInfo['student_id'] = $LastInsertId;
                            $hobbyInfo['hobby'] = $hobby;
                            $hobbyInfo['created_at'] = Carbon::now();
                            $hobbyInfo['updated_at'] = Carbon::now();
                            StudentHobby::insert($hobbyInfo);
                        }

                    }
                }
                if(isset($data['special_aptitude'])){
                    $aptitudeInfo = array();
                    $aptitudes = $data['special_aptitude'];
                    foreach($aptitudes as $aptitude){
                        if($aptitude['test'] != '' && $aptitude != ''){
                            $aptitudeInfo['student_id'] = $LastInsertId;
                            $aptitudeInfo['special_aptitude'] = $aptitude['test'];
                            $aptitudeInfo['score'] = $aptitude['score'];
                            $aptitudeInfo['created_at'] = Carbon::now();
                            $aptitudeInfo['updated_at'] = Carbon::now();
                            StudentSpecialAptitude::insert($aptitudeInfo);
                        }
                    }
                }
                $previousSchool = $request->only('school_name','udise_no','city','medium_of_instruction','board_examination','grades');
                $previousSchool['student_id'] = $LastInsertId;
                $previousSchool['created_at'] = Carbon::now();
                $previousSchool['updated_at'] = Carbon::now();
                StudentPreviousSchool::insert($previousSchool);

                if(isset($data['sibling'])){
                    $siblingInfo = array();
                    $siblings = $data['sibling'];
                    foreach($siblings as $sibling){
                        if($sibling['name'] != '' && $sibling['age'] != ''){
                            $siblingInfo['student_id'] = $LastInsertId;
                            $siblingInfo['name'] = $sibling['name'];
                            $siblingInfo['age'] = $sibling['age'];
                            $siblingInfo['created_at'] = Carbon::now();
                            $siblingInfo['updated_at'] = Carbon::now();
                            StudentSibling::insert($siblingInfo);
                        }

                    }
                }
                if(isset($data['student_communication_address'])){
                    $student_communication_address = $data['address'];
                }else{
                    $student_communication_address = $data['communication_address'];
                }
                $extraInfo = $request->only('grn','birth_place','nationality','religion','caste','category','aadhar_number','blood_group','mother_tongue','other_language','highest_standard','academic_to','academic_from');
                $extraInfo['communication_address']=$student_communication_address;
                $extraInfo['student_id'] = $LastInsertId;
                $extraInfo['created_at'] = Carbon::now();
                $extraInfo['updated_at'] = Carbon::now();
                StudentExtraInfo::insert($extraInfo);

                if(isset($data['upload_doc'])){
                    foreach($data['upload_doc'] as $doc){
                        if($doc != null){
                            $image = $doc;
                            $name = $doc->getClientOriginalName();
                            $filename = time()."_".$name;
                            $path1 = public_path('uploads/student_documents/'.$LastInsertId);
                            if (! file_exists($path1)) {
                                File::makeDirectory('uploads/student_documents/'.$LastInsertId, $mode = 0777, true, true);
                            }
                            $image->move($path1,$filename);
                            $studentDocument['document'] = $filename;
                            $studentDocument['student_id'] = $LastInsertId;
                            $studentDocument['created_at'] = Carbon::now();
                            $studentDocument['updated_at'] = Carbon::now();
                            StudentDocument::insert($studentDocument);
                        }
                    }
                }
            }
            if($data['role_name'] != 'student'){
            if(!empty($data['modules'])){
                $userAclsData = array();
                $modules = $data['modules'];
                foreach($modules as $module){
                    $acl_module = $module;
                    $aclData = explode("_", $acl_module);
                    $userAcl = $aclData[0];
                    $userModule = $aclData[1];
                    $aclMasters = AclMaster::select('id','slug')->get();
                    $aclMasters = $aclMasters->toArray();
                    foreach ($aclMasters as $aclMaster){
                        if($aclMaster['slug'] == $userAcl){
                            $userAclData['acl_id'] = $aclMaster['id'];
                        }
                    }
                    $moduleMasters = Module::select('id','slug')->get();
                    $moduleMasters = $moduleMasters->toArray();
                    foreach ($moduleMasters as $moduleMaster){
                        if($moduleMaster['slug'] == $userModule){
                            $userAclData['module_id'] = $moduleMaster['id'];
                        }
                    }
                    if($data['role_name']== 'student'){
                        $userAclData['user_id'] = $parnetId;
                    }else{
                    $userAclData['user_id'] = $LastInsertId;
                    }
                    $userAclData['created_at'] = Carbon::now();
                    $userAclData['updated_at'] = Carbon::now();
                    array_push($userAclsData,$userAclData);
                }
                ModuleAcl::insert($userAclsData);
            }
            }
            /*if($data['role_name'] != 'student'){
            $mailData['email']  = $data['email'];
            $mailData['confirmation_code']  = $userData->confirmation_code;
            $mailData['password']  = $data['password'];
            Mail::send('emails.welcome', $mailData, function($message) use ($mailData)
            {
                $message->from('no-reply@site.com', "Site name");
                $message->subject("Welcome to site name");
                $message->to($mailData['email']);
            });
            }*/
            return $request;
        }else{
            return "Please Insert Data";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function viewUser(Requests\WebRequests\ViewUserRequest $request,$id)
    {

        if($request->authorize() === true)
        {
            $user=User::where('id',$id)->first();

            $userRole=UserRoles::where('id',$user->role_id)->select('slug')->first();

            $userModuleAcls = $this::userModuleAclsEdit($id);

            if($userRole->slug == 'admin')
            {
                return view('viewUser')->with(compact('user','userModuleAcls'));
            }elseif($userRole->slug == 'teacher')
            {
                $classTeacher=Division::where('class_teacher_id',$id)->first();
                if($classTeacher != null)
                {
                    $class=Classes::where('id',$classTeacher->class_id)->first();
                    $batch=Batch::where('id',$class->batch_id)->first();
                    $user['batch_id']=$batch->id;
                    $user['batch_name']=$batch->slug;
                    $user['class_id']=$class->id;
                    $user['class_name']=$class->slug;
                    $user['division_id']=$classTeacher->id;
                    $user['division_name']=$classTeacher->slug;
                }
                $teacherView=TeacherView::where('user_id',$id)->first();
                $user['web_view'] = $teacherView->web_view;
                $user['mobile_view']= $teacherView->mobile_view;
                return view('viewUser')->with(compact('user','userModuleAcls'));
            }elseif($userRole->slug == 'student')
            {
                $userData=User::where('id',$user['parent_id'])->first();
                $user['parentUserId']=$user['parent_id'];
                $user['parentUserName']=$userData->username;
                $user['parentFirstName']=$userData->first_name;
                $user['parentLastName']=$userData->last_name;
                $user['parentEmail']=$userData->email;
                $user['parentGender']=$userData->gender;
                $user['parentBirth_date']=$userData->birth_date;
                $user['parentMobile']=$userData->mobile;
                $user['parentAddress']=$userData->address;
                $user['parentAlternateNumber']=$userData->alternate_number;
                $user['parentAvatar']=$userData->avatar;

                $division=Division::where('id',$user['division_id'])->first();
                $class=Classes::where('id',$division->class_id)->first();
                $batch=Batch::where('id',$class->batch_id)->first();
                $user['batch_id']=$batch->id;
                $user['batch_name']=$batch->slug;
                $user['class_id']=$class->id;
                $user['class_name']=$class->slug;
                $user['division_id']=$division->id;
                $user['division_name']=$division->slug;
                return view('viewUser')->with(compact('user','userModuleAcls'));
            }elseif($userRole->slug == 'parent')
            {
                $students=User::where('parent_id',$user->id)->get();
                return view('viewUser')->with(compact('user','userModuleAcls','students'));
            }

        }else{
            return Redirect::back();
        }
    }


    public function editUser(Requests\WebRequests\EditUserRequest $request,$id)
    {
        if($request->authorize()===true)
        {
            $user=User::where('id',$id)->with('studentExtraInfo')->first();
            $userRole=UserRoles::where('id',$user->role_id)->select('slug')->first();
            if($userRole->slug == 'admin')
            {
                return view('editAdmin')->with('user',$user);
            }elseif($userRole->slug == 'teacher')
            {
                $classTeacher=Division::where('class_teacher_id',$id)->first();
                if($classTeacher != null)
                {
                    $class=Classes::where('id',$classTeacher->class_id)->first();
                    $batch=Batch::where('id',$class->batch_id)->first();
                    $user['batch_id']=$batch->id;
                    $user['batch_name']=$batch->slug;
                    $user['class_id']=$class->id;
                    $user['class_name']=$class->slug;
                    $user['division_id']=$classTeacher->id;
                    $user['division_name']=$classTeacher->slug;
                }
                $teacherView=TeacherView::where('user_id',$id)->first();
                $user['web_view'] = $teacherView->web_view;
                $user['mobile_view']= $teacherView->mobile_view;
                return view('editTeacher')->with('user',$user);
            }elseif($userRole->slug == 'student')
            {
                $userData=User::where('id',$user['parent_id'])->first();
                $user['parentUserId']=$user['parent_id'];
                $user['parentUserName']=$userData->username;
                $user['parentFirstName']=$userData->first_name;
                $user['parentLastName']=$userData->last_name;
                $user['parentEmail']=$userData->email;
                $user['parentGender']=$userData->gender;
                $user['parentBirth_date']=$userData->birth_date;
                $user['parentMobile']=$userData->mobile;
                $user['parentAddress']=$userData->address;
                $user['parentAlternateNumber']=$userData->alternate_number;
                $user['parentAvatar']=$userData->avatar;

                $division=Division::where('id',$user['division_id'])->first();
                if($division != null){
                $class=Classes::where('id',$division->class_id)->first();
                $batch=Batch::where('id',$class->batch_id)->first();
                $user['batch_id']=$batch->id;
                $user['batch_name']=$batch->slug;
                $user['class_id']=$class->id;
                $user['class_name']=$class->slug;
                $user['division_id']=$division->id;
                $user['division_name']=$division->slug;
                }
                return view('editStudent')->with('user',$user);
            }elseif($userRole->slug == 'parent')
            {
                $students=User::where('parent_id',$user->id)->get();
                return view('editParent')->with(compact('user','students'));
            }

        }else{
            return Redirect::back();
        }
    }
    public function editMyChildren($id)
    {
        $user=User::where('id',$id)->first();
        $userData=User::where('id',$user['parent_id'])->first();
        $user['parentUserName']=$userData->username;
        $user['parentFirstName']=$userData->first_name;
        $user['parentLastName']=$userData->last_name;
        $user['parentEmail']=$userData->email;
        $user['parentGender']=$userData->gender;
        $user['parentBirth_date']=$userData->birth_date;
        $user['parentMobile']=$userData->mobile;
        $user['parentAddress']=$userData->address;
        $user['parentAlternateNumber']=$userData->alternate_number;
        $user['parentAvatar']=$userData->avatar;
        $division=Division::where('id',$user['division_id'])->first();
        $class=Classes::where('id',$division->class_id)->first();
        $batch=Batch::where('id',$class->batch_id)->first();
        $user['batch_id']=$batch->id;
        $user['batch_name']=$batch->slug;
        $user['class_id']=$class->id;
        $user['class_name']=$class->slug;
        $user['division_id']=$division->id;
        $user['division_name']=$division->slug;

        return view('myChildrensEdit')->with(compact('user'));
    }

    public function checkEmail(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $email = trim($data['email']);
            $userCount = User::where('email',$email)->count();
            if($userCount >= 1){
                $count = '1';
            }else{
                $count = '0';
            }
            return $count;
        }
    }


    public function aclUpdate(Request $request,$id)
    {
        $aclRequest=$request->all();
        if($aclRequest)
        {
            $acl_mod=$aclRequest['acls'];
            $aclSeperate=array();
            foreach($acl_mod as $row)
            {
                array_push($aclSeperate,explode('_',$row));
            }

           ModuleAcl::where('user_id',$id)->delete();
            $module_acl=array();
            foreach($aclSeperate as $row)
            {
                $module_acl['user_id']=$id;
                $module_acl['acl_id']=$row[0];
                $module_acl['module_id']=$row[1];
                $dml=ModuleAcl::insert($module_acl);
            }
            Session::flash('message-success','Acl updated successfully');
            return Redirect::back();
        }else{
            ModuleAcl::where('user_id',$id)->delete();
            Session::flash('message-success','Acl updated successfully');
            return Redirect::back();
        }
    }


    public function updateAdmin(Requests\WebRequests\EditAdminRequest $request,$id)
    {
        $userImage=User::where('id',$id)->first();
        $existingEmail= trim($userImage->email);
        unset($request->_method);
        if($request->hasFile('avatar')){
            $image = $request->file('avatar');
            $name = $request->file('avatar')->getClientOriginalName();
            $filename = time()."_".$name;
            $path = public_path('uploads/profile-picture/');
            if (! file_exists($path)) {
                File::makeDirectory('uploads/profile-picture/', $mode = 0777, true, true);
            }
            $image->move($path,$filename);
        }
        else{
            $filename=$userImage->avatar;

        }
        $date = date('Y-m-d', strtotime(str_replace('-', '/', $request->DOB)));
        $userData['username']= $request->username;
        $userData['first_name']= $request->firstname;
        $userData['email']= trim($request->email);
        $userData['last_name']= $request->lastname;
        $userData['emp_type']= $request->emp_type;
        $userData['gender']= $request->gender;
        $userData['mobile']= $request->mobile;
        $userData['address']= $request->address;
        $userData['avatar']= $filename;
        $userData['birth_date']= $date;
        $userData['alternate_number']= $request->alternate_number;
        $userData['confirmation_code'] = str_random(30);

        $userUpdate=User::where('id',$id)->update($userData);
        if($userUpdate == 1){
            $this->sendUpdateMail($existingEmail,$userData,$id);
            Session::flash('message-success','User updated successfully');
            return Redirect::to('/edit-user/'.$id);
        }
        else{
            Session::flash('message-error','Something went wrong');
            return Redirect::to('/edit-user/'.$id);
        }

    }
    public function updateStudent(Requests\WebRequests\EditStudentRequest $request,$id)
    {
        $userImage=User::where('id',$id)->first();
        $existingEmail= trim($userImage->email);
        unset($request->_method);
        if($request->hasFile('avatar')){
            $image = $request->file('avatar');
            $name = $request->file('avatar')->getClientOriginalName();
            $filename = time()."_".$name;
            $path = public_path('uploads/profile-picture/');
            if (! file_exists($path)) {
                File::makeDirectory('uploads/profile-picture/', $mode = 0777, true, true);
            }
            $image->move($path,$filename);
        }
        else{
            $filename=$userImage->avatar;

        }
        $date = date('Y-m-d', strtotime(str_replace('-', '/', $request->DOB)));
        $userData['username']= $request->username;
        $userData['first_name']= $request->firstname;
        $userData['email']= $request->email;
        $userData['last_name']= $request->lastname;
        $userData['gender']= $request->gender;
        $userData['mobile']= $request->mobile;
        $userData['alternate_number']= $request->alternate_number;
        $userData['confirmation_code'] = str_random(30);
        $userData['address']= $request->address;
        $userData['avatar']= $filename;
        $userData['birth_date']= $date;
        $userData['division_id']=$request->division;
        $userData['roll_number']=$request->roll_number;
        $homework['division_id'] = $request->division;
        $checkRollNumber = User::where('division_id',$request->division)->where('roll_number',$request->roll_number)->whereNotIn('id',[$id])->first();
        if($checkRollNumber){
           User::where('id',$checkRollNumber->id)->update(['roll_number'=>'0']);
        }
        HomeworkTeacher::where('student_id',$request->id)->update($homework);
        Attendance::where('student_id',$request->id)->update($homework);
        $leaves['division_id'] = $request->division;
        Leave::where('student_id',$request->id)->update($leaves);
        $userUpdate=User::where('id',$id)->update($userData);

        $grnNumber = $request->grn;
        $extraInfo = StudentExtraInfo::where('student_id',$id)->update(['grn' => $grnNumber]);
        if ($userUpdate == 1) {
            Session::flash('message-success','student updated successfully');
            return Redirect::back();
        }
        else{
            Session::flash('message-error','something went wrong');
            return Redirect::back();
        }
    }
    public function updateParent(Requests\WebRequests\EditParentRequest $request,$id)
    {
        $userImage=User::where('id',$id)->first();
        $existingEmail= trim($userImage->email);
        unset($request->_method);
        if($request->hasFile('avatar')){
            $image = $request->file('avatar');
            $name = $request->file('avatar')->getClientOriginalName();
            $filename = time()."_".$name;
            $path = public_path('uploads/profile-picture/');
            if (! file_exists($path)) {
                File::makeDirectory('uploads/profile-picture/', $mode = 0777, true, true);
            }
            $image->move($path,$filename);
        }
        else{
            $filename=$userImage->avatar;

        }
        $date = date('Y-m-d', strtotime(str_replace('-', '/', $request->DOB)));
        $userData['username']= $request->username;
        $userData['first_name']= $request->firstname;
        $userData['email']= $request->email;
        $userData['last_name']= $request->lastname;
        $userData['gender']= $request->gender;
        $userData['mobile']= $request->mobile;
        $userData['alternate_number']= $request->alternate_number;
        $userData['confirmation_code'] = str_random(30);
        $userData['address']= $request->address;
        $userData['avatar']= $filename;
        $userData['birth_date']= $date;
        $userData['division_id']=$request->division;
        $userData['roll_number']=$request->roll_number;
        $homework['division_id'] = $request->division;
        HomeworkTeacher::where('student_id',$request->id)->update($homework);
        $leaves['division_id']=$request->division;
        Leave::where('student_id',$request->id)->update($leaves);
        $userUpdate=User::where('id',$id)->update($userData);
        if($userUpdate == 1){
            $this->sendUpdateMail($existingEmail,$userData,$id);
            Session::flash('message-success','Parent updated successfully');
            return Redirect::back();
        }
        else{
            Session::flash('message-error','something went wrong');
            return Redirect::back();
        }
    }
    public function updateTeacher(Requests\WebRequests\EditTeacherRequest $request,$id)
    {
        $userImage=User::where('id',$id)->first();
        $existingEmail= trim($userImage->email);
        unset($request->_method);
        if($request->hasFile('avatar')){
            $image = $request->file('avatar');
            $name = $request->file('avatar')->getClientOriginalName();
            $filename = time()."_".$name;
            $path = public_path('uploads/profile-picture/');
            if (! file_exists($path)) {
                File::makeDirectory('uploads/profile-picture/', $mode = 0777, true, true);
            }
            $image->move($path,$filename);
        }
        else{
            $filename=$userImage->avatar;
        }
        if(in_array('web_view',$request->access)){
            $teacherView['web_view']=1;

        }else{
            $teacherView['web_view']=0;
        }

        if(in_array('mobile_view',$request->access)){
            $teacherView['mobile_view']=1;
        }else{
            $teacherView['mobile_view']=0;
          }

        $date = date('Y-m-d', strtotime(str_replace('-', '/', $request->DOB)));
        $userData['username']= $request->username;
        $userData['first_name']= $request->firstname;
        $userData['email']= $request->email;
        $userData['last_name']= $request->lastname;
        $userData['emp_type']= $request->emp_type;
        $userData['gender']= $request->gender;
        $userData['mobile']= $request->mobile;
        $userData['alternate_number']= $request->alternate_number;
        $userData['confirmation_code'] = str_random(30);
        $userData['address']= $request->address;
        $userData['avatar']= $filename;
        $userData['birth_date']= $date;

        $userUpdate=User::where('id',$id)->update($userData);
        $teacherViewUpdate=TeacherView::where('user_id',$id)->update($teacherView);
        if ($request->has('checkbox8')){
            Division::where('class_teacher_id',$id)->update(['class_teacher_id'=>0]);
            Division::where('id',$request->division)->
                      where('class_id',$request->class)->update(['class_teacher_id'=>$id]);
        }else{
            Division::where('id',$request->division)->
                where('class_id',$request->class)->update(['class_teacher_id'=>0]);
        }
        if($userUpdate == 1){
            $this->sendUpdateMail($existingEmail,$userData,$id);
            Session::flash('message-success','teacher updated successfully');
            return Redirect::back();
        }
        else{
            Session::flash('message-error','something went wrong');
            return Redirect::back();
        }
    }

    public function edit($id)
    {
        $userRole=User::select('user_roles.slug as role_slug')
            ->join('user_roles','users.role_id','=','user_roles.id')
            ->where('users.id','=',$id)
            ->get();

        if($userRole[0]->role_slug == 'admin')
        {
            $result1=User::select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.email','bodies.name as body_name','user_roles.name as user_role','users.is_active')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->Join('bodies', 'users.body_id', '=', 'bodies.id')
                ->where('users.id','=',$id)
                ->get();
            return response()->json($result1->toArray());
        }elseif($userRole[0]->role_slug == 'teacher')
        {
            $result1=User::select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.email','bodies.name as body_name','user_roles.name as user_role','users.is_active','teacher_views.web_view','teacher_views.mobile_view')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->Join('bodies', 'users.body_id', '=', 'bodies.id')
                ->Join('teacher_views', 'users.id', '=', 'teacher_views.user_id')
                ->where('users.id','=',$id)
                ->get();

            return response()->json($result1->toArray());
        }elseif($userRole[0]->role_slug == 'student')
        {
            $result1=User::select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.email','bodies.name as body_name','user_roles.name as user_role','users.is_active','divisions.slug as div_name','divisions.id as div_id','users.parent_id','divisions.class_id','classes.slug as class_name','classes.batch_id')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->Join('bodies', 'users.body_id', '=', 'bodies.id')
                ->Join('divisions', 'divisions.id', '=', 'users.div_id')
                ->Join('classes','classes.id','=','divisions.class_id')
                ->where('users.id','=',$id)
                ->get();

            $result2=Classes::all();
            $result3=Division::all();
            $arr1=json_decode($result1);
            $arr2=json_decode($result2);
            $arr3=json_decode($result3);
            array_push($arr1,array($arr2,$arr3));

            return response()->json($arr1);
        }elseif($userRole[0]->role_slug == 'parent')
        {
            $result1=User::select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.email','user_roles.name as user_role','users.is_active')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->where('users.id','=',$id)
                ->get();

            return response()->json($result1->toArray());

        }
        else{
            $result1=User::select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.email','bodies.name as body_name','user_roles.slug as user_role','users.is_active')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->Join('bodies', 'users.body_id', '=', 'bodies.id')
                ->where('users.id','=',$id)
                ->get();

            return response()->json($result1->toArray());

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request->ajax())
        {
            return response()->json($request->all());
        }
    }

    public function activeUser(Requests\WebRequests\DeleteUserRequest $request,$id)
    {
        if($request->authorize()===true)
        {
            $user=User::find($id);
            $user->is_active=1;
            $user->save();

            if($user->role_id == 4) {
                User::where('parent_id','=',$user->id)
                    ->update(['is_active' => 1]);
            }

            if($user->role_id == 3) {
                $parent = User::where('id','=',$user->id)
                    ->select('parent_id')->get();

                $userParentStatus = User::where('id','=',$parent[0]['parent_id'])
                    ->select('is_active')->get();

                if($userParentStatus[0]['is_active'] == 0) {
                    $user->is_active=0;
                    $user->save();
                    Session::flash('message-error','student cant be activated as its parent is deactivate !');
                    return response()->json(['status'=>401]);
                } else {
                    return response()->json(['status'=>'record has been activated.']);
                }

            }
            return response()->json(['status'=>'record has been activated.']);
        }else{
            return response()->json(['status'=>403]);
        }
    }

    public function deactiveUser(Requests\WebRequests\DeleteUserRequest $request,$id)
    {
        if($request->authorize()===true)
        {
            $user=User::find($id);
            $user->is_active=0;
            $user->save();

            if($user->role_id == 4) {
                User::where('parent_id','=',$user->id)
                    ->update(['is_active' => 0]);
            }

            return response()->json(['status'=>'record has been deactivated.']);
        }else{
            return response()->json(['status'=>403]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getBatches(){
        $user=Auth::user();
        $batchData = Batch::where('body_id',$user->body_id)->select('id','name')->get();
        $batchList = $batchData->toArray();
        return $batchList;
    }
    public function getClasses($id){
        $classData = Classes::where('batch_id', $id)->select('id','class_name')->get();
        $classList = $classData->toArray();
        return $classList;
    }

    public function getDivisions($id){
        $divisionData = Division::where('class_id', $id)->select('id','division_name')->get();
        $divisionList = $divisionData->toArray();
        return $divisionList;
    }

    public function getBatch(){
        $user=Auth::user();
        $batchData = Batch::where('body_id',$user->body_id)->select('id','name')->get();
        $batchList = $batchData->toArray();
        return $batchData;
    }
    public function getClass($id){
        $classData = Classes::where('batch_id', $id)->select('id','class_name')->get();
        $classList = $classData->toArray();
        return $classList;
    }

    public function getDiv($id){
        $divisionData = Division::where('class_id', $id)->select('id','division_name')->get();
        $divisionList = $divisionData->toArray();
        return $divisionList;
    }
    public function getParents(){
        $user=Auth::user();
        $userInformation =array();
        $userData = User::where('body_id',$user->body_id)->where('role_id',4)->get();
        $userList = $userData->toArray();
        foreach($userList as $user){
            $parentInfo = ParentExtraInfo::where('parent_id',$user['id'])->first();
            $parentInfo['userId'] = $user['id'];
            $userInfo['data'] = $parentInfo;
            $userInfo['value'] = $user["email"];
            array_push($userInformation,$userInfo);
        }
        return $userInformation;
    }

    public function checkUser(Request $request){

        if($request->ajax()){
            $data = $request->all();
            $userName = trim($data['name']);
            $userCount = User::where('username',$userName)->count();
            if($userCount >= 1){
                $count = '1';
            }else{
                $count = '0';
            }
            return $count;
        }
    }


    public function getUserRoles(){
        $userRole = UserRoles::whereNotIn('slug', ['parent','admin'])->get();
        $userRoles = $userRole->toArray();
        return $userRoles;
    }

    public function getAdmins(){
        $user=Auth::user();
        $admin_role_id = UserRoles::whereIn('slug', ['admin'])->pluck('id');
        $admin = User::where('role_id',$admin_role_id)->where('body_id',$user->body_id)->whereNotIn('id', [$user->id])->get();
        $admins = $admin->toArray();
        $userInformation =array();
        foreach($admins as $admin){
            $userInfo['id'] = $admin['id'];
            $userInfo['name'] = $admin['first_name']." ".$admin['last_name'];
            array_push($userInformation,$userInfo);
        }
        return $userInformation;
    }

    public function getTeachers(){
        $user=Auth::user();
        $teacher_role_id = UserRoles::whereIn('slug', ['teacher'])->pluck('id');
        $teacher = User::where('role_id',$teacher_role_id)->where('is_active','=',1)->where('body_id',$user->body_id)->whereNotIn('id', [$user->id])->get();
        $teachers = $teacher->toArray();
        $userInformation =array();
        foreach($teachers as $teacher){
            $userInfo['id'] = $teacher['id'];
            $userInfo['name'] = $teacher['first_name']." ".$teacher['last_name'];
            array_push($userInformation,$userInfo);
        }
        return $userInformation;
    }

    public function getStudentList(Request $request){
        $user=Auth::user();
        $student_id = UserRoles::whereIn('slug', ['student'])->pluck('id');
        $student = User::where('role_id',$student_id)->where('division_id',$request->division)->where('is_active',1)->get();
        $students = $student->toArray();
        $userInformation =array();
        foreach($students as $student){
            $userInfo['id'] = $student['id'];
            $userInfo['name'] = $student['first_name']." ".$student['last_name'];
            array_push($userInformation,$userInfo);
        }
        return $userInformation;
    }

    public function getDivisionsTeacher($id){
        $user=Auth::user();
        if($user->role_id == 1){
            $divisionData = Division::where('class_id', $id)->select('id','division_name')->get();
            $divisionList = $divisionData->toArray();
        }elseif($user->role_id == 2){
            $divisionList = SubjectClassDivision::where('teacher_id',$user->id)->select('division_id')->get();
            $divisionData = Division::wherein('id', $divisionList)->where('class_id',$id)->select('id','division_name')->get();
            $divisionList = $divisionData->toArray();
        }
        return $divisionList;
    }


    public function getBatchesTeacher(){
        $user=Auth::user();
        if($user->role_id == 1){
            $batchData = Batch::where('body_id',$user->body_id)->select('id','name')->get();
            $batchList = $batchData->toArray();
        }elseif($user->role_id == 2){
            $divisionList = SubjectClassDivision::where('teacher_id',$user->id)->select('division_id')->get();
            $divisionInfo = Division::wherein('id',$divisionList)->select('class_id')->get();
            $classInfo = Classes::wherein('id',$divisionInfo)->select('batch_id')->get();
            $batchInfo = Batch::wherein('id',$classInfo)->select('id')->get();
            $batchData = Batch::wherein('id',$batchInfo)->select('id','name')->get();
            $batchList = $batchData->toArray();
        }
        return $batchList;
    }

    public function getClassesTeacher($id){
        $user=Auth::user();
        if($user->role_id == 1){
            $classData = Classes::where('batch_id', $id)->select('id','class_name')->get();
            $classList = $classData->toArray();
        }elseif($user->role_id == 2){
            $divisionList = SubjectClassDivision::where('teacher_id',$user->id)->select('division_id')->get();
            $divisionInfo = Division::wherein('id',$divisionList)->select('class_id')->distinct()->get();
            $classInfo = Classes::wherein('id',$divisionInfo)->select('id')->distinct()->get();
            $classData = Classes::wherein('id', $classInfo)->where('batch_id',$id)->select('id','class_name')->distinct()->get();
            $classList = $classData->toArray();
        }
        return $classList;
    }

    public function verifyUser($confirmation_code)
    {
        if( ! $confirmation_code)
        {
            Session::flash('message-error','Confirmation Code missing.');
        }
        $user = User::where('confirmation_code', $confirmation_code)->first();
        if ($user)
        {
            $user->is_active = 1;
            $user->confirmation_code = null;
            $user->save();

            Session::flash('message-success','You have successfully verified your account.');
            return Redirect::to('/');

        }else{
        Session::flash('message-error','Link you are using is not Valid.');
        return Redirect::to('/');
        }
    }

    public function sendUpdateMail($existingEmail,$userData,$id){
        $emailStatus = strcmp($existingEmail,$userData['email']);
            if($emailStatus != 0){
                User::where('id',$id)->update(['is_active' => 0]);
                Mail::send('emails.updateInfo', $userData, function($message) use ($userData)
                {
                    $message->from('no-reply@site.com', "VEZA");
                    $message->subject("Welcome to VEZA");
                    $message->to($userData['email']);
                });
        }
    }

    public function checkClassTeacher($id){
        $classTeacher = Division::where('id',$id)->first();
        $users = User::where('id',$classTeacher->class_teacher_id)->select('first_name','last_name')->get();
        $userinfo = $users->toArray();
        if($users){
            return $userinfo;
        }
    }

    public function checkEmailEdit(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $email = trim($data['email']);
            $userCount = User::where('email',$email)->count();
            if($userCount >= 1){
                $userEmail = User::where('email',$email)->where('id',$data['userId'])->count();
                if($userEmail >= 1){
                    $count = '2';
                }else{
                $count = '1';
                }
            }else{
                $count = '0';
            }
            return $count;
        }

    }

    public function checkRollNumber(Request $request){
        $users = User::where('roll_number',$request->roll_number)->where('division_id',$request->division)->select('first_name','last_name','id')->get();
        $userinfo = $users->toArray();
        if($users){
            return $userinfo;
        }
    }
    
    public function checkParent(Request $request){
        $data = $request->all();
        if($data['parentID'] == " "){
            return 'false';
        }else{
            $count = User::where('id',$data['parentID'])->count();
            if($count >=1){
                return 'true';
            }else{
                return 'false';
            }
        }
    }

    public function checkGrnNumber(Request $request){
        try{

            $grnCount= StudentExtraInfo::where('student_id','!=',$request->userId)->where('grn',$request->grn)->count();
            if($grnCount > 0){
                return 'false';
            }else{
                return 'true';
            }
        }catch(\Exception $e){
            $data = [
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }
    }

}
