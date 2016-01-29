<?php

namespace App\Http\Controllers\api;

use App\AclMaster;
use App\Batch;
use App\ClassData;
use App\Classes;
use App\Division;
use App\Message;
use App\Module;
use App\ModuleAcl;
use App\SubjectClassDivision;
use App\TeacherView;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('remember.user.token');
        $this->middleware('authenticate.user',['except' => ['login']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function login(Requests\LoginRequest $request)
    {
        $data=array();
        try{
            $user = User::where('email', $request->email)->first();
            if ($user == NULL) {
                $status =404;
                $message = 'Sorry!! Incorrect email or password';
            } elseif ($user->is_active == 0) {
                $status = 401;
                $message = "Sorry ... Your account is not activated";
            } elseif (Auth::attempt(['email' => $request->email,'password' => $request->password])) {
                $user=Auth::User();
                $userView=TeacherView::where('user_id','=',$user['id'])->first();
                if(Empty($userView) && $user['role_id']==4 || $userView['mobile_view']==1)
                {
                    $userData=User::join('user_roles', 'users.role_id', '=', 'user_roles.id')
                        ->where('users.id','=',$user->id)
                        ->select('users.id','users.role_id','users.id','users.email','users.username as username','users.first_name as firstname','users.last_name as lastname','users.avatar','user_roles.slug','users.remember_token as token','users.password as pass')
                        ->get()->toArray();
                    foreach($userData as $val)
                    {
                        $data['users']['user_id']=$val['id'];
                        $data['users']['role_type']=$val['slug'];
                        $data['users']['role_id']=$val['role_id'];
                        $data['users']['user_id']=$val['id'];
                        $data['users']['username']=$val['firstname'].''.$val['lastname'];
                        $data['users']['password']=$val['pass'];
                        $data['users']['token']=$val['token'];
                        $data['users']['email']=$val['email'];
                        $data['users']['avatar']=$val['avatar'];
                    }
                    $acl_module=User::join('module_acls', 'users.id', '=', 'module_acls.user_id')
                        ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
                        ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
                        ->where('users.id','=',$user->id)
                        ->select('users.id','acl_master.title as acl','modules.title as module','modules.slug as module_slug')
                        ->get();
                    $AclModuleArray=array();
                    foreach($acl_module as $val)
                    {
                        array_push($AclModuleArray,$val->acl.'_'.$val->module_slug);
                    }
                    $data['Acl_Modules']['user_id']=$user->id;
                    $i=0;
                    foreach($AclModuleArray as $val)
                    {
                        $data['Acl_Modules']['acl_module '][$i]=$val;
                        $i++;
                    }
                    if($data['users']['role_id']==4)
                    {
                        $i=0;
                        $userData=User::where('parent_id','=',$data['users']['user_id'])->get();
                        $userDataArray=$userData->toArray();
                        foreach($userDataArray as $value ){
                            $messageCount=Message::where('to_id',$value['id'])
                                ->where('read_status','=',0)
                                ->where('is_delete','=',0)
                                ->count();
                            $data['Badge_count'][$i]['user_id']=$value['id'];
                            $data['Badge_count'][$i]['message_count'] = $messageCount;
                            $data['Badge_count'][$i]['auto_notification_count'] = $messageCount;
                            $i++;
                        }
                    }else{
                        $messageCount=Message::where('to_id',$user['id'])
                            ->where('read_status','=',0)
                            ->where('is_delete','=',0)
                            ->count();
                        $data['Badge_count']['user_id']=$user['id'];
                        $data['Badge_count']['message_count'] = $messageCount;
                        $data['Badge_count']['auto_notification_count'] = $messageCount;
                    }
                    $message = 'login successfully';
                    $status =200;
                }else{
                    $status =406;
                    $message = 'Sorry!! you do not have mobile view';
                }
            }else   {
                $status =404;
                $message = 'Sorry!! Incorrect email or password';
            }
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message,"status" => $status,"data" =>$data];

        return response($response,$status);

    }
    public function getBatchesTeacher(Request $request){
           $data=$request->all();
        try{
            if($data['teacher']['role_id'] == 1){
                $batchData = Batch::where('body_id',$data['teacher']['body_id'])->select('id','name')->get();
                $batchList = $batchData->toArray();
            }elseif($data['teacher']['role_id'] == 2){
                $divisionList = SubjectClassDivision::where('teacher_id',$data['teacher']['id'])->select('division_id')->get();
                $divisionInfo = Division::wherein('id',$divisionList)->select('class_id')->distinct()->get();
                $classInfo = Classes::wherein('id',$divisionInfo)->select('id')->get();
                $batchInfo = Batch::wherein('id',$classInfo)->select('id','name')->get()->toArray();
            }
            $message="Successfully Listed";
            $status=200;
        }catch (\Exception $e){
            echo $e->getMessage();
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $batchInfo
        ];
        return response($response, $status);
    }



    public function getTeachersList(Request $request , $id )
       {
           try{
            $data=$request->all();
            $studentData=User::where('id','=',$id)->first();
            $divisions=SubjectClassDivision::where('division_id','=',$studentData['division_id'])
                                             ->groupBy('teacher_id')
                                             ->get();
           $i=0;
           foreach($divisions as $value){
               $studentData1=User::where('id','=',$value['teacher_id'])->first();
               $teacherData[$i]['id']=$value['teacher_id'];
               $teacherData[$i]['name']=$studentData1['first_name']." ".$studentData1['last_name'];
               $i++;
           }
               $status = 200;
               $responseData['teachersList']= $teacherData;
               $message = 'Successfully Listed';
           }catch (\Exception $e){
               $status = 500;
               $message = "Something went wrong"  .  $e->getMessage();
           }
           $response = [
               "message" => $message,
               "status" => $status,
               "data" => $responseData
           ];
           return response($response, $status);
     }
    public function getClassesTeacher(Request $request, $id){
        try{
            $data=$request->all();
            if($data['teacher']['role_id'] == 1){
                $classData = Classes::where('batch_id', $id)->select('id','class_name')->get();
                $classList = $classData->toArray();
            }elseif($data['teacher']['role_id']== 2){
                $divisionList = SubjectClassDivision::where('teacher_id',$data['teacher']['id'])->select('division_id')->get();
                $divisionInfo = Division::wherein('id',$divisionList)->select('class_id')->distinct()->get();
                $classInfo = Classes::wherein('id',$divisionInfo)->select('id')->distinct()->get();
                $classData = Classes::wherein('id', $classInfo)->where('batch_id',$id)->select('id','class_name')->distinct()->get()->toArray();
            }
            $status = 200;
            $responseData['classList']= $classData;
            $message = 'Successfully Listed';
        }catch (\Exception $e){
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $responseData
        ];
        return response($response, $status);
    }

    public function getDivisions(Request $request, $id){
        try{
            $data=$request->all();
            if($data['teacher']['role_id']  == 1){
                $divisionData = Division::where('class_id', $id)->select('id','division_name')->get();
                $divisionList = $divisionData->toArray();
            }elseif($data['teacher']['role_id'] == 2){
                $divisionList = SubjectClassDivision::where('teacher_id',$data['teacher']['id'] )->select('division_id')->get();
                $divisionData = Division::wherein('id', $divisionList)->where('class_id',$id)->select('id','division_name')->get()->toArray();
            }
            $status = 200;
            $responseData['divisionList']= $divisionData;
            $message = 'Successfully Listed';
        }catch (\Exception $e){
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $responseData
        ];
        return response($response, $status);
    }
    public function getSwitchingDetails(Request $request){
        try{
            $data=$request->all();
            $finalData=array();
            $parent_student=User::where('parent_id',$data['teacher']['id'])->get();
            $finalData['Parent_student_relation']['parent_id']=$data['teacher']['id'];
                               $i=0;
                              foreach($parent_student as $val)
                                 {
                                     $finalData['Parent_student_relation']['Students'][$i]['student_id']=$val->id;
                                     $finalData['Parent_student_relation']['Students'][$i]['student_name']=$val->first_name;
                                     $finalData['Parent_student_relation']['Students'][$i]['student_div']=$val->division_id;
                                       $i++;
                                   }
            $message="Successfully Listed";
            $status=200;
        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong" .  $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" =>$finalData
        ];
        return response($response, $status);
    }
}
