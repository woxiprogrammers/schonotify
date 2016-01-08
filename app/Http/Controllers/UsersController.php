<?php

namespace App\Http\Controllers;

use App\AclMaster;
use App\Batch;
use App\ClassData;
use App\Classes;
use App\Division;
use App\Module;
use App\ModuleAcl;
use App\SubjectClassDivision;
use App\TeacherView;
use App\User;
use App\UserRoles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Auth;




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
        $this->middleware('auth');
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
          $userData['address']= $request->address;
          $userData['avatar']= $filename;
          $userData['birth_date']= $date;
        $userUpdate=User::where('id',$id)->update($userData);
            if($userUpdate == 1){
                Session::flash('message-success','profile updated successfully');
               return Redirect::to('/myProfile');
            }
            else{
                Session::flash('message-error','something went wrong');
                return Redirect::to('/myProfile');
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\WebRequests\UserRequest $request)
    {
        $data = Input::all();
        $user=Auth::user();
        if(!empty($data)){
            $userData= new User;
            $userData->first_name = $data['firstName'];
            $userData->last_name = $data['lastName'];
            $userData->password = bcrypt($data['password']);
            $userData->email = $data['email'];
            $userData->gender = $data['gender'];
            $userData->address = $data['address'];
            $userData->mobile = $data['mobile'];
            $userData->alternate_number = $data['alt_number'];
            $userData->role_id = $data['role'];
            $userData->is_active = 0;
            $userData->remember_token = csrf_token();
            $userData->body_id = $user->body_id;
            $userData->created_at = Carbon::now();
            $userData->updated_at = Carbon::now();
            if($data['role_name']== 'admin'){
                $userData = array_add($userData, 'emp_type', $data['emp_type']);
                $userData->save();
                $LastInsertId = $userData->id;
            }elseif($data['role_name']== 'teacher'){
                $userData = array_add($userData, 'emp_type', $data['emp_type']);
                $userData->save();
                $LastInsertId = $userData->id;
                if(isset($data['class-teacher'])){
                    Division::where('id',$data['division'])->update(['class_teacher_id' => $LastInsertId]);
                }
                $teacherViews['web_view']= 0;
                $teacherViews['mobile_view']= 0;
                if(isset($data['web-access'])){
                    $teacherViews['web_view'] = $data['web-access'];
                }
                if(isset($data['mobile-access'])){
                    $teacherViews['mobile_view'] = $data['mobile-access'];
                }
                $teacherViews['user_id'] = $LastInsertId;
                $teacherViews['created_at'] = Carbon::now();
                $teacherViews['updated_at'] = Carbon::now();
                TeacherView::insert($teacherViews);
            }elseif($data['role_name']== 'parent'){
                $userData->save();
                $LastInsertId = $userData->id;
            }elseif($data['role_name']== 'student'){
                if(isset($data['division'])){
                    $userData = array_add($userData, 'division_id', $data['division']);
                }
                if(isset($data['parent_id'])){
                    $userData = array_add($userData, 'parent_id', $data['parent_id']);
                }
                $userData->save();
                $LastInsertId = $userData->id;
            }
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
                            $userAclData['module_id'] = $aclMaster['id'];
                        }
                    }
                    $userAclData['user_id'] = $LastInsertId;
                    $userAclData['created_at'] = Carbon::now();
                    $userAclData['updated_at'] = Carbon::now();
                    array_push($userAclsData,$userAclData);
                }
                ModuleAcl::insert($userAclsData);
            }
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

    public function editUser(Request $request,$id)
    {

        $user=User::where('id',$id)->first();
        $userRole=UserRoles::where('id',$user->role_id)->select('slug')->get();
        if($userRole[0]['slug'] == 'admin')
        {
            return view('editAdmin')->with('user',$user);
        }elseif($userRole[0]['slug'] == 'teacher')
        {
            return view('editTeacher')->with('user',$user);
        }elseif($userRole[0]['slug'] == 'student')
        {
            return view('editStudent')->with('user',$user);
        }elseif($userRole[0]['slug'] == 'parent')
        {

            return view('editParent')->with('user',$user);
        }
        else{

        }


    }

    public function checkEmail(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $email = $data['email'];
            $userCount = User::where('email',$email)->count();
            if($userCount >= 1){
                $count = '1';
            }else{
                $count = '0';
            }
            return $count;
        }
    }

    public function updateAdmin(Request $request,$id)
    {

    }
    public function updateStudent(Request $request,$id)
    {

    }
    public function updateParent(Request $request,$id)
    {

    }
    public function updateTeacher(Request $request,$id)
    {

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

    public function activeUser($id)
    {
        $user=User::find($id);
        $user->is_active=1;
        $user->save();

        return response()->json(['status'=>'record has been activated.']);
    }

    public function deactiveUser($id)
    {
        $user=User::find($id);
        $user->is_active=0;
        $user->save();

        return response()->json(['status'=>'record has been deactivated.']);
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

    public function getBatches(Request $request){
        $user=Auth::user();
        if($user->role_id == 1){
        $batchData = Batch::where('body_id',$user->body_id)->select('id','name')->get();
        $batchList = $batchData->toArray();
        }elseif($user->role_id == 2){
        $divisionList = SubjectClassDivision::where('teacher_id',$user->id)->select('division_id')->get();
        $divisionInfo = Division::wherein('id',$divisionList)->select('id')->get();
        $classInfo = Classes::wherein('id',$divisionInfo)->select('id')->get();
        $batchInfo = Batch::wherein('id',$classInfo)->select('id')->get();
        $batchData = Batch::wherein('id',$batchInfo)->select('id','name')->get();
        $batchList = $batchData->toArray();
        }
        return $batchList;
    }

    public function getClasses($id){
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

    public function getDivisions($id){
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

    public function getParents(){
        $user=Auth::user();
        $userInformation =array();
        $userData = User::where('body_id',$user->body_id)->where('role_id',4)->select('id','first_name','last_name','email')->get();
        $userList = $userData->toArray();
        foreach($userList as $user){
            $userInfo['data'] = $user['id'];
            $userInfo['value'] = $user['first_name']." ".$user['last_name']." ,".$user['email'];
            array_push($userInformation,$userInfo);
        }
        return $userInformation;
    }


    public function checkUser(Request $request){

        if($request->ajax()){
            $data = $request->all();
            $userName = $data['name'];
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
        $teacher = User::where('role_id',$teacher_role_id)->where('body_id',$user->body_id)->whereNotIn('id', [$user->id])->get();
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
        $student = User::where('role_id',$student_id)->where('division_id',$request->division)->get();
        $students = $student->toArray();
        $userInformation =array();
        foreach($students as $student){
            $userInfo['id'] = $student['id'];
            $userInfo['name'] = $student['first_name']." ".$student['last_name'];
            array_push($userInformation,$userInfo);
        }
        return $userInformation;
    }


}
