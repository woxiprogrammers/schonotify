<?php
namespace App\Http\Controllers;
use App\AclMaster;
use App\Attendance;
use App\Batch;
use App\CASTECONCESSION;
use App\category_types;
use App\ClassData;
use App\Classes;
use App\ConcessionTypes;
use App\Division;
use App\fee_installments;
use App\fee_particulars;
use App\FeeClass;
use App\FeeConcessionAmount;
use App\FeeDueDate;
use App\FeeInstallments;
use App\Fees;
use App\HomeworkTeacher;
use App\Leave;
use App\Module;
use App\ModuleAcl;
use App\ParentExtraInfo;
use App\StudentDocument;
use App\StudentDocumentMaster;
use App\StudentExtraInfo;
use App\StudentFamily;
use App\StudentFee;
use App\StudentFeeConcessions;
use App\StudentHobby;
use App\StudentPreviousSchool;
use App\StudentSibling;
use App\StudentSpecialAptitude;
use App\SubjectClassDivision;
use App\SubmittedDocuments;
use App\TeacherExtraInfo;
use App\TeacherQualification;
use App\TeacherReferences;
use App\TeacherView;
use App\TeacherWorkExperience;
use App\TransactionDetails;
use App\TransactionTypes;
use App\User;
use App\UserRoles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
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
use SebastianBergmann\Environment\Console;
use Symfony\Component\CssSelector\Tests\Parser\Shortcut\EmptyStringParserTest;


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
    public function studentInstallmentview(Request $request)
    {
        $installment_data = array();
        $student_fee = StudentFee::where('student_id',$request->str2)->lists('fee_id');
        $installment_info = Fees::join('fee_installments','fee_installments.fee_id','=','fees.id')
                                ->whereIn('fees.id',$student_fee)
                                ->where('fee_installments.installment_id',$request->str1)
                                ->select('fees.fee_name','fees.id')
                                ->groupBy('fees.fee_name')
                                ->get()->toArray();
            $itrator = 0;
        foreach ($installment_info as $data){
            $installment_info[$itrator]['particulars'] = FeeInstallments::join('fee_particulars','fee_particulars.id','=','fee_installments.particulars_id')
                ->where('fee_installments.fee_id',$data['id'])
                ->where('fee_installments.installment_id',$request->str1)
                ->select('fee_installments.particulars_id','fee_installments.amount','fee_particulars.particular_name')
                ->get()->toArray();
            $itrator ++;
        }
        $installment_data[] = $installment_info;
         if(empty($installment_data)){
            $str = "Installment Not Found ";
           }
         return view('fee.student_installment')->with(compact('str','installment_data'));
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
        foreach($modules as $row1){
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
        if($role1->slug=='admin'){
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
        if($request->authorize()===true){
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
        if($request->authorize()===true){
            return view('admin.teacherCreateForm')->with('userRoles',$roles);
        }else{
            return Redirect::to('/');
        }
    }
    public function studentCreateForm(Requests\WebRequests\UserRequest $request)
    {
        $userRoles =UserRoles::all();
        $role_id='3';
        Session::put('role_id', $role_id);
        $documents = StudentDocumentMaster::all();
        if($request->authorize()===true){
            return view('admin.studentCreateForm')->with(compact('userRoles','documents'));
        }else{
            return Redirect::to('/');
        }
    }
    public function parentCreateForm(Requests\WebRequests\UserRequest $request)
    {
        $roles=UserRoles::all();
        $role_id='4';
        Session::put('role_id', $role_id);
        if($request->authorize()===true){
            return view('admin.parentCreateForm')->with('userRoles',$roles);
        }else{
            return Redirect::to('/');
        }
    }
    public function usersCreateForm(Requests\WebRequests\UserRequest $request)
    {
        $roles=UserRoles::all();
        if($request->authorize()===true){
            return view('admin.usersCreateForm')->with('userRoles',$roles);
        }else{
            return Redirect::to('/');
        }

    }
    public function studentCreateFormEnquiry(Requests\WebRequests\UserRequest $request)
    {
        $roles=UserRoles::all();
        if($request->authorize()===true){
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
                $userData->email = $data['email'];
                $userData->address = $data['address'];
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
               //Student documents submitted status.
                $document=$request->documents;
                if(!empty($document)){
                    $document=implode(",",$document);
                }
                if(!empty($document)){
                    $documentData['student_id']=$LastInsertId;
                    $documentData['submitted_documents']=$document;
                    $query=SubmittedDocuments::insert($documentData);
                }
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
                if($user->body_id == 1){
                    $paymentLink = '/fees/billing-page';
                }elseif($user->body_id == 2){
                    $paymentLink = '/fees/billing-page/gems';
                }else{
                    $paymentLink = 'javascript:void(0);';
                }
                $division=User::where('id',$id)->pluck('division_id');
                $class=Division::where('id',$division)->pluck('class_id');
                $assigned_fee_for_class = FeeClass::where('class_id',$class)->lists('fee_id')->toArray();
                $fees = Fees::whereIn('id',$assigned_fee_for_class)->select('id','fee_name','year')->get()->toArray();
                $student_fee = StudentFee::where('student_id',$id)->select('fee_id','year','fee_concession_type','caste_concession')->get()->toarray();
                    foreach($student_fee as $key => $a)
                    {
                        $installment_info=FeeInstallments::where('fee_id',$a['fee_id'])->select('installment_id','particulars_id','amount')->get()->toarray();
                    }
                $installment_data = array();
                    $fee_ids =StudentFee::where('student_id',$id)->select('fee_id')->distinct('fee_id')->get()->toArray();
                    $fee_due_date = FeeDueDate::join('fees','fees.id','=','fee_due_date.fee_id')
                                                ->whereIn('fee_due_date.fee_id',$fee_ids)
                                                ->select('fee_due_date.fee_id','fee_due_date.installment_id as installment_id','fee_due_date.due_date as due_date','fees.fee_name as fee_name')
                                                ->get();
                   $fee_due_date=($fee_due_date->groupBy('fee_id')->toArray());
                    $total_installment_amount =array();
                    foreach ($fee_ids as $key => $feeId){
                        $installment_ids = fee_installments::join('fees','fees.id','=','fee_installments.fee_id')
                                                            ->where('fee_installments.fee_id',$feeId['fee_id'])
                                                            ->select('fee_installments.installment_id as installment_id','fees.id as fee_id')
                                                            ->distinct('fee_installments.installment_id')
                                                            ->get()->toArray();
                        foreach ($installment_ids as $installmentId){
                            $total_installment_amount[$installmentId['fee_id']][$installmentId['installment_id']] = fee_installments::where('fee_id',$feeId['fee_id'])->where('installment_id',$installmentId['installment_id'])->sum('amount');
                        }
                    }
                foreach ($total_installment_amount as $key=> $amount){
                    $total_fee_amount[$key]['total'] = array_sum($amount);
                }
                $installment_percent_amount=array();
                foreach($total_installment_amount as $key => $installment_amounts)
                {
                   foreach ($installment_amounts as $installmentId => $amount1){
                       $installment_amounts=($amount1/$total_fee_amount[$key]['total'])*100;
                       $installment_percent_amount[$key][$installmentId]=$installment_amounts;
                   }
                }
                $concession_For_structure = array();
                $fee_assign_student = StudentFee::join('fees','fees.id','=','student_fee.fee_id')
                                                    ->where('student_fee.student_id',$id)
                                                    ->select('student_fee.fee_concession_type','student_fee.fee_id as fee_id')
                                                    ->get();
                $fee_assign_student = ($fee_assign_student->groupBy('fee_id')->toArray());
                foreach ($fee_assign_student as $fees_name => $student_fees) {
                    foreach ($student_fees as $key => $fees_concession) {
                        if ($fees_concession['fee_concession_type'] != 2) {
                            $concession_For_structure[$fees_name][$key] = FeeConcessionAmount::where('fee_id', $fees_concession['fee_id'])->where('concession_type', $fees_concession['fee_concession_type'])->pluck('amount');
                        }
                    }
                }
              $caste_concn_amnt = array();
              $caste_concession_type = StudentFee::join('fees','fees.id','=','student_fee.fee_id')
                                        ->where('student_fee.student_id',$id)
                                        ->whereNotNull('student_fee.caste_concession')
                                        ->select('fees.id','student_fee.caste_concession')
                                        ->get();
                $caste_concession_type = ($caste_concession_type->groupBy('id')->toArray());

                if($caste_concession_type != "" && $caste_concession_type != null){
                    foreach ($caste_concession_type as $key => $casteConcession){
                        foreach ($casteConcession as $key_1=> $caste_amount){
                            $caste_concn_amnt[$key][$key_1]= CASTECONCESSION::where('caste_id', $caste_amount['caste_concession'])->where('fee_id',$key)->pluck('concession_amount');
                        }
                    }
                }
                $amountArray = array(); // key is fee id
                if(count($caste_concn_amnt) > count($concession_For_structure)){
                    foreach($caste_concn_amnt as $feeId => $casteConcnAmount){
                        if(!array_key_exists($feeId, $amountArray)){
                            $amountArray[$feeId]['amount'] = 0;
                        }
                        $amountArray[$feeId]['amount'] += array_sum($casteConcnAmount);
                        if(array_key_exists($feeId,$concession_For_structure)){
                            $amountArray[$feeId]['amount'] += array_sum($concession_For_structure[$feeId]);
                        }
                    }
                }else{
                    foreach($concession_For_structure as $feeId => $concessionStructure){
                        if(!array_key_exists($feeId, $amountArray)){
                            $amountArray[$feeId]['amount'] = 0;
                        }
                        $amountArray[$feeId]['amount'] += array_sum($concessionStructure);
                        if(array_key_exists($feeId,$caste_concn_amnt)){
                            $amountArray[$feeId]['amount'] += array_sum($caste_concn_amnt[$feeId]);
                        }
                    }
                }
                $concession_amount_array = array();
                   foreach($installment_percent_amount as $key => $percent_discout_collection){
                       foreach ($percent_discout_collection as $key2=> $discount){
                           $concession_amount_array[$key][$key2] = (($discount / 100) * ($amountArray[$key]['amount']));
                       }
                   }
                $final_discounted_amounts = array();
                if(count($concession_amount_array) == count($total_installment_amount))
                {
                    foreach($concession_amount_array as $key => $value){
                        foreach ($value as $key3 => $discount_amount){
                            $final_discounted_amounts[$key][$key3] = $total_installment_amount[$key][$key3] - $discount_amount;
                        }
                    }
                }
                if(!empty($fee_due_date) && !empty($final_discounted_amounts)){
                    foreach($fee_due_date as $key => $fee_id){
                        for($iterator = 0; $iterator < count($fee_id) ; $iterator++){
                            $fee_due_date[$key][$iterator]['discount'] = $final_discounted_amounts[$key][$fee_id[$iterator]['installment_id']];
                        }
                    }
                }
                if(!empty($installment_info))
                   {
                       $iterator = 0;
                       foreach($installment_info as $i)
                       {
                           $installment_info[$iterator]['particulars_name'] = fee_particulars::where('id',$i['particulars_id'])->pluck('particular_name');
                           $iterator++;
                       }
                       $installment_data[] = $installment_info;
                   }
                    $concession_types=ConcessionTypes::select('id','name')->get()->toarray();
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
                    $transaction_types=TransactionTypes::select('id','transaction_type')->get()->toArray();
                    $transactions=TransactionDetails::join('fees','fees.id','=','transaction_details.fee_id')
                                                      ->where('transaction_details.student_id',$id)
                                                      ->select('fees.fee_name as fee_name','transaction_details.id as id','transaction_details.transaction_type as transaction_type','transaction_details.transaction_detail as transaction_detail','transaction_details.transaction_amount as transaction_amount','transaction_details.date as date')
                                                      ->get();
                    $new_array=array();
                    $total_paid_fees = TransactionDetails::join('fees','fees.id','=','transaction_details.fee_id')
                                                            ->where('transaction_details.student_id',$id)
                                                            ->select('fees.fee_name','transaction_details.transaction_amount')
                                                            ->get()->groupBy('fee_name')->toarray();
                        foreach ($total_paid_fees as $key => $paid_fees){
                            $new_array[$key]=array_sum(array_column($paid_fees,'transaction_amount'));
                        }
                     $division_for_updation=User::where('id',$id)->pluck('division_id');
                     if($division_for_updation != null)
                         {
                             $division_status="";
                         }
                     else
                         {
                             $division_status="Division Not Assigned !";
                         }
                $total_fee_for_current_year = array();
                     foreach($fee_due_date as $fee_name => $val){
                         $total_fee_for_current_year[$val[0]['fee_name']]['discount'] = 0;
                           foreach($val as $discount){
                               $total_fee_for_current_year[$val[0]['fee_name']]['discount'] += $discount['discount'];
                           }
                     }
                $total_due_fee_for_current_year = array();
                $assigned_fee = StudentFee::where('student_id',$id)->lists('fee_id');
                $caste_concession_type_edit = StudentFee::where('student_id',$id)->lists('fee_concession_type');
                foreach ($total_fee_for_current_year as $key=> $total_fee){
                    if(array_key_exists($key,$new_array)){
                        $total_due_fee_for_current_year[$key] = $total_fee['discount'] - $new_array[$key];
                    }else{
                        $total_due_fee_for_current_year[$key] = $total_fee['discount'] - 0;
                    }
                }
                $queryn=category_types::select('caste_category','id')->get()->toArray();
                $querym=StudentFee::where('student_id',$request['user'])->pluck('caste_concession');
                $chkstatus=StudentFeeConcessions::where('student_id',$id)->select('fee_concession_type')->first();
                $student_info=StudentExtraInfo::where('student_id',$id)->get();
                $student_school=StudentPreviousSchool::where('student_id',$id)->get();
                $school=array();

                $aptitude=StudentSpecialAptitude::where('student_id',$id)->select('special_aptitude','score')->get();
                foreach($student_school as $school_info){
                             $school['name']=$school_info['school_name'];
                             $school['udise_no']=$school_info['udise_no'];
                             $school['city']=$school_info['city'];
                             $school['medium_of_instruction']=$school_info['medium_of_instruction'];
                             $school['board_examination']=$school_info['board_examination'];
                             $school['grades']=$school_info['grades'];
                }
                $hobbies=array();
                $interests=StudentHobby::where('student_id',$id)->get()->toArray();
                foreach($interests as $interest){
                             $hobbies['hobby']=$interest['hobby'];
                }
                if(!empty($chkstatus)){
                    $chkstatus = $chkstatus->fee_concession_type;
                }else{
                    $chkstatus='null';
                }
                $documents = StudentDocumentMaster::all();
                $doc=SubmittedDocuments::where('student_id',$id)->pluck('submitted_documents');
                $doc=explode(',',$doc);
                $family_info=ParentExtraInfo::where('parent_id',$user['parent_id'])->first();
                $parent_email=User::where('id',$user['parent_id'])->pluck('email');
                $caste=StudentExtraInfo::where('student_id',$id)->pluck('caste');
                $grn=StudentExtraInfo::where('student_id',$id)->pluck('grn');
                $religion=StudentExtraInfo::where('student_id',$id)->pluck('religion');
                $batches=Batch::where('body_id',$user->body_id)->select('id','name')->first();
                $divisionStudent=User::where('id',$id)->pluck('division_id');
                if($divisionStudent != null){
                    $divisionStudent=$divisionStudent;
                }else{
                    $divisionStudent="null";
                }
                $installmentIds = FeeInstallments::whereIn('fee_id',$assigned_fee)->select('installment_id')->distinct()->get()->toArray();
                return  view('editStudent')->with(compact('installmentIds','divisionStudent','batches','religion','grn','query1','assigned_fee','caste','caste_concession_type_edit','division_status','division_for_updation','user','fees','concession_types','student_fee','installment_data','fee_due_date','total_installment_amount','transaction_types','transactions','total_fee_for_current_year','total_due_fee_for_current_year','queryn','querym','chkstatus','student_info','school','aptitude','hobbies','documents','doc','family_info','parent_email','paymentLink'));
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
        $dataStudent = $request->all();
        $divisionStudent = User::where('id',$id)->pluck('division_id');
        if($divisionStudent == null){
            $div=array();
            $div['division_id']=$request->Divisiondropdown;
            $divisionupdate = User::where('id',$id)->update($div);
        }
        $query2 = StudentFee::where('student_id',$id)->select('fee_id')->get();
        foreach ($dataStudent['student_fee'] as $key => $value){
            $query = Fees::where('id',$key)->pluck('year');
            if($request->student_fee != null){
                if($query2->isEmpty()){
                    $student_fee['student_id'] = $id;
                    if( $request->student_fee == null){
                        $student_fee['fee_id'] = 0;
                    }else{
                        $student_fee['fee_id'] = $key;
                    }
                    foreach($value['concession'] as $item){
                        if(array_key_exists('caste1',$value)&& $item==2){
                            $student_fee['caste_concession'] = $value['caste1'];
                        }else{
                            $student_fee['caste_concession'] = null;
                        }
                        $student_fee['fee_concession_type'] = $item;
                        $student_fee['year']=$query;
                        StudentFee::create($student_fee);
                    }
                }else{
                    $presentData = StudentFee::where('student_id',$id)->where('fee_id',$key)->where('year',$query)->lists('fee_concession_type')->toArray();
                    $removeFeeType = array_diff($presentData,$value['concession']);
                    foreach ($removeFeeType as $remove){
                       StudentFee::where('student_id',$id)->where('fee_id',$key)->where('year',$query)->where('fee_concession_type',$remove)->delete();
                    }
                    foreach($value['concession'] as $item){
                        $student_fee['fee_concession_type'] = $item;
                        $studentFeeId = StudentFee::where('student_id',$id)->where('fee_id',$key)->where('year',$query)->where('fee_concession_type',$item)->first();
                        if(array_key_exists('caste1',$value) && $item == 2){
                            $student_fee['caste_concession'] = $value['caste1'];
                        }else{
                            $student_fee['caste_concession'] = null;
                        }
                        if($studentFeeId != null){
                             StudentFee::where('student_id',$id)->where('fee_id',$key)->where('year',$query)->where('fee_concession_type',$item)->update($student_fee);
                        }else{
                            $student_fee['fee_id'] = $key;
                            $student_fee['student_id'] = $id;
                            $student_fee['year'] = $query;
                            StudentFee::create($student_fee);
                        }
                    }
                }
            }
        }
        $existCheck = StudentFeeConcessions::where('student_id',$id)->exists();
        if($request->student_fee != null){
            if($existCheck == true){
                foreach ($dataStudent['student_fee'] as $key => $value){
                    $concessions = array();
                    foreach ($value['concession'] as $item1){
                        $studentFeeConcessionCount = StudentFeeConcessions::where('student_id',$id)->where('fee_id',$key)->where('fee_concession_type',$item)->first();
                        $concessions['fee_concession_type'] = $item1;
                        if($studentFeeConcessionCount == null){
                            $concessions['student_id'] = $id;
                            $concessions['fee_id'] = $key;
                            StudentFeeConcessions::create($concessions);
                        }else{
                            StudentFeeConcessions::where('student_id',$id)->where('fee_id',$key)->update($concessions);
                        }
                    }
                }
            }else{
                foreach ($dataStudent['student_fee'] as $key => $value){
                    $concessions=array();
                    $concessions['fee_id'] = $key;
                    $concessions['student_id'] = $id;
                    foreach ($value['concession'] as $item) {
                        $concessions['fee_concession_type'] = $item;
                    }
                    $b = StudentFeeConcessions::create($concessions);
                }
            }
        }
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
        $userData['first_name']= $request->firstname;
        $userData['last_name']= $request->lastname;
        $userData['gender']= $request->gender;
        $userData['mobile']= $request->mobile;
        $userData['alternate_number']= $request->alternate_number;
        $userData['confirmation_code'] = str_random(30);
        $userData['address']= $request->address;
        $userData['avatar']= $filename;
        $userData['birth_date']= $date;
        $userData['roll_number']=$request->roll_number;
        $homework['division_id'] = $request->division_id;
        $checkRollNumber = User::where('division_id',$request->division_id)->where('roll_number',$request->roll_number)->whereNotIn('id',[$id])->first();
        if($checkRollNumber){
           User::where('id',$checkRollNumber->id)->update(['roll_number'=>'0']);
        }
        HomeworkTeacher::where('student_id',$id)->update($homework);
        Attendance::where('student_id',$id)->update($homework);
        $leaves['division_id'] = $request->division_id;
        Leave::where('student_id',$request->id)->update($leaves);
        $userUpdate = User::where('id',$id)->update($userData);
        $grnNumber = $request->grn;
        $extraInfo = StudentExtraInfo::where('student_id',$id)->update(['grn' => $grnNumber]);
        $student_previous_school = array();
        $student_previous_school['school_name'] = $request->school_name;
        $student_previous_school['udise_no'] = $request->udise_no;
        $student_previous_school['city'] = $request->city;
        $student_previous_school['medium_of_instruction'] = $request->medium_of_instruction;
        $student_previous_school['board_examination'] = $request->board_examination;
        $student_previous_school['grades'] = $request->grades;
        $student_pre_school = StudentPreviousSchool::where('student_id',$id)->update($student_previous_school);
        if(isset($request['hobbies'])){
            $hobbyInfo = array();
            $hobbies = $request['hobbies'];
            foreach($hobbies as $hobby){
                if($hobby != ''){
                    $hobbyInfo['student_id'] = $id;
                    $hobbyInfo['hobby'] = $hobby;
                    $hobbyInfo['updated_at'] = Carbon::now();
                    StudentHobby::where('student_id',$id)->update($hobbyInfo);
                }

            }
        }
        if(isset($request['special_aptitude'])){
            $aptitudeInfo = array();
            $aptitudes = $request['special_aptitude'];
            foreach($aptitudes as $aptitude){
                if($aptitude['test'] != '' && $aptitude != ''){
                    $aptitudeInfo['student_id'] = $id;
                    $aptitudeInfo['special_aptitude'] = $aptitude['test'];
                    $aptitudeInfo['score'] = $aptitude['score'];
                    $aptitudeInfo['updated_at'] = Carbon::now();
                    $q=StudentSpecialAptitude::where('student_id',$id)->update($aptitudeInfo);
                }
            }
        }
        if(empty($dataStudent['communication_address_student'])){
            $communication_address_student = $dataStudent['address'];
        }else{
            $communication_address_student = $dataStudent['communication_address_student'];
        }
        $extraInfo = $request->only('grn','birth_place','nationality','religion','caste','category','aadhar_number','blood_group','mother_tongue','other_language','highest_standard','academic_to','academic_from');
        $extraInfo['communication_address'] = $communication_address_student;
        $extraInfo['student_id'] = $id;
        $extraInfo['created_at'] = Carbon::now();
        $extraInfo['updated_at'] = Carbon::now();
        StudentExtraInfo::where('student_id',$id)->update($extraInfo);

        if(isset($data['parent_communication_address'])){
            $communication_address_parent = $request['permanent_address'];
        }else{
            $communication_address_parent = $request['communication_address_parent'];
        }
       $student = SubmittedDocuments::exists($id);
        if($student == false){
            $document = $request->documents;
            if(!empty($document)){
                $document = implode(",",$document);
            }
            $documentData['student_id'] = $id;
            $documentData['submitted_documents'] = $document;
            $query = SubmittedDocuments::insert($documentData);
        }else{
            $document = $request->documents;
            if(!empty($document)){
                $document = implode(",",$document);
             }
            $documentData['student_id'] = $id;
            $documentData['submitted_documents'] = $document;
            $query = SubmittedDocuments::where('student_id',$id)->update($documentData);
        }
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
        $data=$request->all();
        if(isset($data['parent_communication_address'])){
            $communication_address_parent = $data['permanent_address'];
        }else{
            $communication_address_parent = $data['communication_address_parent'];
        }
        $familyInfo = $request->only('father_first_name','father_middle_name','father_last_name','father_occupation','father_income','father_contact','mother_first_name','mother_middle_name','mother_last_name','mother_occupation','mother_income','mother_contact','parent_email','permanent_address');
        $familyInfo['permanent_address'] = $communication_address_parent;
        $familyInfo['updated_at'] = Carbon::now();
        $userFamilyUpdate=ParentExtraInfo::where('parent_id',$request->userId)->update($familyInfo);
        $chk=StudentSibling::exists($id);
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
        if($userUpdate == 1 ){
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
                    $user->is_active=1;
                    $user->save();
                    $parent_id=User::where('id',$id)->pluck('parent_id');
                    User::where('id','=',$parent_id)
                        ->update(['is_active' => 1]);
                    Session::flash('message-success','student and parent activated !');
                    return response()->json(['status'=>'record has been activated.']);
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
    public function getClassesForSearch(Request $request){
        $classData = Classes::where('batch_id',$request->batch)->select('id','class_name')->get();
        $classList = $classData;
        return view('class')->with(compact('classList'));
    }
    public function getDivisions($id){
        $divisionData = Division::where('class_id', $id)->select('id','division_name')->get();
        $divisionList = $divisionData->toArray();
        return $divisionList;
    }
    public function getDivisionsForsearch(Request $request){
        $id=$request->classs;
        $divisionData = Division::where('class_id', $id)->select('id','division_name')->get();
        $divisionList = $divisionData;
        return view('divisions')->with(compact('divisionList'));
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
        $userRole = UserRoles::whereNotIn('slug', ['parent','admin'])->top(3)->get();
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
            $body_id=User::where('id',$request->userId)->pluck('body_id');
            $grnCount= StudentExtraInfo::where('body_id',$body_id)->where('student_id','!=',$request->userId)->where('grn',$request->grn)->count();
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
