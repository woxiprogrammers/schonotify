<?php

namespace App\Http\Controllers\api;

use App\AclMaster;
use App\Batch;
use App\CASTECONCESSION;
use App\ClassData;
use App\Classes;
use App\ConcessionTypes;
use App\Division;
use App\ExtraConcession;
use App\FeeConcessionAmount;
use App\FullPaymentConcession;
use App\FullPaymentType;
use App\Http\Controllers\CustomTraits\PushNotificationTrait;
use App\Message;
use App\Module;
use App\ModuleAcl;
use App\PushToken;
use App\SubjectClassDivision;
use App\TeacherView;
use App\User;
use App\StudentFee;
use App\StudentExtraInfo;
use App\StudentFeeConcessions;
use App\FeeInstallments;
use App\fee_installments;
use App\fee_particulars;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    use PushNotificationTrait;
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('remember.user.token');
        $this->middleware('authenticate.user',['except' => ['login','publicGetSwitchingDetails','minimum_supported_version']]);
    }
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
            }else{
                $parentId = User::where('email','=',$request['email'])->lists('id')->toArray();
                $checkStudent = User::whereIn('parent_id',$parentId)->where('is_active',1)->count();
                $userView=TeacherView::where('user_id','=',$user['id'])->first();
                if($checkStudent > 0 || $userView['mobile_view']==1){
                    if (Auth::attempt(['email' => $request->email,'password' => $request->password])) {
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
                                $data['users']['firstname']=$val['firstname'];
                                $data['users']['lastname']=$val['lastname'];
                                $grn=StudentExtraInfo::where('student_id',$val['id'])->select('grn');
                                $data['users']['grn']=$grn;
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
                                $userData=User::where('parent_id','=',$data['users']['user_id'])->where('is_active',1)->first();
                                $messageCount=Message::where('to_id',$userData['id'])
                                    ->where('read_status','=',0)
                                    ->where('is_delete','=',0)
                                    ->count();
                                $data['Badge_count']['user_id']=$userData['id'];
                                $data['Badge_count']['body_id']=$user['body_id'];
                                $data['Badge_count']['message_count'] = $messageCount;
                                $data['Badge_count']['auto_notification_count'] = $messageCount;
                            }else{
                                $messageCount=Message::where('to_id',$user['id'])
                                    ->where('read_status','=',0)
                                    ->where('is_delete','=',0)
                                    ->count();
                                $data['Badge_count']['user_id']=$user['id'];
                                $data['Badge_count']['body_id']=$user['body_id'];
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
                }else{
                    $status =406;
                    $message = 'Sorry!! your Account has been deactivated.';
                }
            }
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message,"status" => $status,"data" =>$data,];
        return response($response,$status);
    }

    public function logout(Request $request,$user_id){
         try{
             $message = "User logged out successfully";
             $status = 200;
             $query = PushToken::where('user_id',$user_id)->delete();

         }catch (\Exception $e) {
             $status = 500;
             $message = "Something went wrong";
         }
        $response = [
            "message" => $message,
            "status" => $status,
        ];
        return response($response, $status);
    }

    public function savePushToken(Request $request){
        try{
            $status = 200;
            $data=$request->all();
            $is_present = PushToken::where('user_id',$data['user_id'])->count();
            if($is_present == 0){
                $pushData['user_id'] = $data['user_id'];
                $pushData['push_token'] = $data['pushToken'];
                PushToken::create($pushData);
            }
            else{
                $pushData['user_id']=$data['user_id'];
                $pushData['push_token']=$data['pushToken'];
                PushToken::where('user_id',$data['user_id'])->update($pushData);
            }
        }catch(\Exception $e){
            $status = 500;
            $data= [
                'action' => "token created" ,
                'exception' => $e->getMessage()
            ];
        }
        return response($data,$status);
    }
    public function getBatchesTeacher(Request $request){
        try{
            $data=$request->all();
            $finalInfo=array();
            $division=array();
            $batchInfo=array();
            $classes=array();
            $divisionData=SubjectClassDivision::where('teacher_id','=',$data['teacher']['id'])
                ->select('division_id')
                ->get()->toArray();
            $k=0;
            if(!Empty($divisionData))
            {
                foreach($divisionData as $value){
                    $division['id'][$k]=$value['division_id'];
                    $k++;
                }
            }
            $divisions=Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if(!Empty($divisions)){
                $divisionData=SubjectClassDivision::where('division_id','=',$divisions['id'])
                    ->select('division_id')
                    ->get()->toArray();
                if(!Empty($divisionData))
                {
                    foreach($divisionData as $value){
                        $division['id'][$k]=$value['division_id'];
                        $k++;
                    }
                }
            }
            $DivisionArray=array_unique($division['id'],SORT_REGULAR);
            $i=0;
            foreach ($DivisionArray  as $value)
            {
                $class_id=Division::where('id','=',$value)->select('divisions.class_id as class_id')->first();
                $className=Classes::where('id','=',$class_id['class_id'])->select('class_name as class_name', 'batch_id as batch_id')->first();
                if(!Empty($class_id)){
                    $classes[$i]['id']=$class_id['class_id'];
                    $classes[$i]['name']=$className['class_name'];
                    $classes[$i]['batch_id']=$className['batch_id'];
                    $i++;
                }
            }
            $i=0;
            foreach($classes as $row)
            {
                $batchName=Batch::where('id',$row['batch_id'])->first();
                $batchInfo[$batchName['id']]['id'] = $batchName['id'];
                $batchInfo[$batchName['id']]['name'] = $batchName['name'];
                $i++;
            }
            $i=0;
            foreach($batchInfo as $value) {
                $finalInfo[$i]=$value;
                $i++;
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
            "data" => $finalInfo
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
               "data" => $responseData,

           ];
           return response($response, $status);
     }
    public function getClassesTeacher(Request $request, $batch_id){
        try{
            $data = $request->all();
            $division = array();
            $finalClasses = array();
            $finalClassInfo = array();
            $divisionData=SubjectClassDivision::where('teacher_id','=',$data['teacher']['id'])
                ->select('division_id')
                ->get()->toArray();
            $k=0;
            if(!Empty($divisionData))
            {
                foreach($divisionData as $value){
                    $division['id'][$k]=$value['division_id'];
                    $k++;
                }
            }
            $divisions=Division::where('class_teacher_id','=',$data['teacher']['id'])->first();

            if(!Empty($divisions)){
                $divisionData=SubjectClassDivision::where('division_id','=',$divisions['id'])
                    ->select('division_id')
                    ->get()->toArray();
                if(!Empty($divisionData))
                {
                    foreach($divisionData as $value){
                        $division['id'][$k]=$value['division_id'];
                        $k++;
                    }
                }
            }
            $DivisionArray=array_unique($division['id'],SORT_REGULAR);
            $i=0;
            foreach ($DivisionArray  as $value){
                $class_id=Division::where('id','=',$value)->select('divisions.class_id as class_id')->first();
                $className=Classes::where('id','=',$class_id['class_id'])
                    ->where('batch_id','=',$batch_id)
                    ->select('id','class_name as class_name')->first();

                if(!Empty($class_id)&&!Empty($className)){
                    $finalClasses[$class_id['class_id']]['id']=$class_id['class_id'];
                    $finalClasses[$class_id['class_id']]['class_name']=$className['class_name'];
                    $i++;
                }
            }
            $i=0;
            foreach($finalClasses as $value) {
                $finalClassInfo[$i]=$value;
                $i++;
            }
            $status = 200;
            $responseData['classList']= $finalClassInfo;
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
    public function getDivisions(Request $request, $class_id){
        try{
            $data = $request->all();
            $division = array();
            $finalDivisionsInfo = array();
            $finalDivisions = array();
            $divisionData=SubjectClassDivision::where('teacher_id','=',$data['teacher']['id'])
                ->select('division_id')
                ->get()->toArray();
            $k=0;
            if(!Empty($divisionData))
            {
                foreach($divisionData as $value){
                    $division['id'][$k]=$value['division_id'];
                    $k++;
                }
            }
            $divisions=Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if(!Empty($divisions)){
                $divisionData=SubjectClassDivision::where('division_id','=',$divisions['id'])
                    ->select('division_id')
                    ->get()->toArray();
                if(!Empty($divisionData))
                {
                    foreach($divisionData as $value){
                        $division['id'][$k]=$value['division_id'];
                        $k++;
                    }
                }
            }
            $DivisionArray=array_unique($division['id'],SORT_REGULAR);
            $i=0;
            foreach($DivisionArray as $division_id){
                $finalData=Division::join('classes','divisions.class_id', '=', 'classes.id')
                    ->where('divisions.class_id','=',$class_id)
                    ->where('divisions.id','=',$division_id)
                    ->select('divisions.id as id','divisions.division_name as division_name')
                    ->first();
                if(!Empty($finalData)){
                    $finalDivisions[$finalData['id']]=$finalData;
                    $i++;
                }
            }
            $i=0;
            foreach($finalDivisions as $value) {
                $finalDivisionsInfo[$i]=$value;
                $i++;
            }
            $status = 200;
            $responseData['divisionList']= $finalDivisionsInfo;
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
    public function studentInstallmentview(Request $request,$id,$student_id){
      try{
           $installment_data = array();
          $installment_info = array();
          $sum = 0;
          $concessionAmount = 0;
           $student_fee=StudentFee::where('student_id',$student_id)->select('fee_id','year','fee_concession_type','caste_concession')->get()->toArray();
           if($id == 'full') {
               foreach ($student_fee as $key => $a) {
                   $installmentIds = FeeInstallments::where('fee_id', $a['fee_id'])->select('installment_id')->distinct('installment_id')->get()->toArray();
                   foreach ($installmentIds as $installment) {
                       if ($installment['installment_id'] == 1) {
                           $installment_info = FeeInstallments::where('fee_id', $a['fee_id'])->where('installment_id', $installment['installment_id'])->select('particulars_id', 'amount')->get()->toArray();
                           if(!empty($installment_info)) {
                               $iterator = 0;
                               foreach ($installment_info as $i) {
                                   $installment_info[$iterator]['particulars_name'] = fee_particulars::where('id', $i['particulars_id'])->pluck('particular_name');
                                   $iterator++;
                               }
                           }
                       } else {
                           $newInstallmentInfo = FeeInstallments::where('fee_id', $a['fee_id'])->where('installment_id', $installment['installment_id'])->select('particulars_id', 'amount')->get()->toArray();
                           $iterator = 0;
                           foreach ($newInstallmentInfo as $InstallmentInfo){
                               if($installment_info[$iterator]['particulars_id'] == $InstallmentInfo['particulars_id']){
                                   $installment_info[$iterator]['amount'] += $InstallmentInfo['amount'];
                               }
                               $iterator++;
                           }
                       }
                       $extraConcessionData = ExtraConcession::where('fee_id',$a['fee_id'])->where('student_id',$student_id)->where('installment_id',$installment['installment_id'])->select('label','amount')->get()->toArray();
                       $i = count($installment_info);
                       if(count($extraConcessionData) > 0){
                           foreach ($extraConcessionData as $extraConcession){
                               $installment_info[$i]['particulars_id'] = $i + 1;
                               $installment_info[$i]['amount'] =$extraConcession['amount'];
                               $installment_info[$i]['particulars_name'] = $extraConcession['label'];
                               $i++;
                           }
                       }
                   }
                   if(!empty($installment_info)){
                       $fullPayType = FullPaymentType::where('slug','full-payment')->value('id');
                       $fullPayConcessionData = FullPaymentConcession::where('fee_id',$a['fee_id'])->where('concession_type',$fullPayType)->first();
                       $i = count($installment_info);
                       if($fullPayConcessionData != null){
                           $installment_info[$i]['particulars_id'] = $i + 1;
                           $installment_info[$i]['amount'] =$fullPayConcessionData['amount'];
                           $installment_info[$i]['particulars_name'] = FullPaymentType::where('slug','full-payment')->value('name');
                       }
                   }
                   $concessions = StudentFee::where('student_id',$student_id)->where('fee_id',$a['fee_id'])->select('fee_concession_type','caste_concession')->get()->toArray();
                   if(!empty($concessions)){
                       $i = count($installment_info);
                       foreach ($concessions as $concession){
                           if($concession['fee_concession_type'] == 2 || $concession['fee_concession_type'] == null){
                               $installment_info[$i]['particulars_id'] = $i + 1;
                               $installment_info[$i]['amount'] = CASTECONCESSION::where('fee_id',$a['fee_id'])->where('caste_id',$concession['caste_concession'])->value('concession_amount');
                               $installment_info[$i]['particulars_name'] = ConcessionTypes::where('id',$concession['fee_concession_type'])->value('name');
                           } else {
                               $installment_info[$i]['particulars_id'] = $i + 1;
                               $installment_info[$i]['amount'] = FeeConcessionAmount::where('fee_id',$a['fee_id'])->where('concession_type',$concession['fee_concession_type'])->value('amount');
                               $installment_info[$i]['particulars_name'] = ConcessionTypes::where('id',$concession['fee_concession_type'])->value('name');
                           }
                       }
                   }
               }

           } else {
               foreach ($student_fee as $key => $a) {
                   $installment_info = FeeInstallments::where('fee_id', $a['fee_id'])->where('installment_id', $id)->select('particulars_id', 'amount')->get()->toarray();
                   $amount = FeeInstallments::where('fee_id', $a['fee_id'])->where('installment_id', $id)->sum('amount');
                   $studentFeeIds = FeeInstallments::where('fee_id',$a['fee_id'])->select('installment_id')->distinct('installment_id')->get()->toArray();
                   if(count($studentFeeIds) > 0) {
                       $totalAmount = 0;
                       foreach ($studentFeeIds as $installment) {
                           $totalAmount += FeeInstallments::where('fee_id', $a['fee_id'])->where('installment_id', $installment['installment_id'])->sum('amount');
                       }
                   }
                   $percenrageOfAmount = ($amount/$totalAmount)*100;
                   $concessions = StudentFee::where('student_id',$student_id)->where('fee_id',$a['fee_id'])->select('fee_concession_type','caste_concession')->get()->toArray();
                   if(!empty($concessions)){
                       $i = count($installment_info);
                       foreach ($concessions as $concession){
                           if($concession['fee_concession_type'] == 2 || $concession['fee_concession_type'] == null){
                               $installment_info[$i]['particulars_id'] = $i + 1;
                               $installment_info[$i]['amount'] =round((CASTECONCESSION::where('fee_id',$a['fee_id'])->where('caste_id',$concession['caste_concession'])->value('concession_amount') * $percenrageOfAmount) / 100,2);
                               $installment_info[$i]['particulars_name'] = ConcessionTypes::where('id',2)->value('name');
                           } else {
                               $installment_info[$i]['particulars_id'] = $i + 1;
                               $installment_info[$i]['amount'] = round((FeeConcessionAmount::where('fee_id',$a['fee_id'])->where('concession_type',$concession['fee_concession_type'])->value('amount') * $percenrageOfAmount) / 100,2);
                               $installment_info[$i]['particulars_name'] = ConcessionTypes::where('id',$concession['fee_concession_type'])->value('name');
                           }
                       }
                   }
               }
               $fee_pert = fee_particulars::select('particular_name')->get()->toArray();
               if (!empty($installment_info)) {
                   $iterator = 0;
                   foreach ($installment_info as $i) {
                       $installment_info[$iterator]['particulars_name'] = fee_particulars::where('id', $i['particulars_id'])->pluck('particular_name');
                       if($iterator >= 11){
                           break;
                       }
                       $iterator++;
                   }
                   $extraConcessionData = ExtraConcession::where('fee_id',$a['fee_id'])->where('student_id', $student_id)->where('installment_id', $id)->select('label', 'amount')->get()->toArray();
                   $i = count($installment_info);
                   if (count($extraConcessionData) > 0) {
                       foreach ($extraConcessionData as $extraConcession) {
                           $installment_info[$i]['particulars_id'] = $i + 1;
                           $installment_info[$i]['amount'] = $extraConcession['amount'];
                           $installment_info[$i]['particulars_name'] = $extraConcession['label'];
                           $i++;
                       }
                   }
               }
           }
                foreach ($installment_info as $installmentData){
                    if($installmentData['particulars_name'] == FullPaymentType::where('slug','full-payment')->value('name')){
                        $sum -= 2 * $installmentData['amount'];
                    }else if($installmentData['particulars_name'] == 'RTE' || $installmentData['particulars_name'] == 'Caste' || $installmentData['particulars_name'] == 'Teaching Staff' || $installmentData['particulars_name'] == 'Non-Teaching Staff / Admin') {
                        $sum -= 2 * $installmentData['amount'];
                    } else {
                        $sum=array_sum(array_column($installment_info,'amount'));
                    }
                }
               $installment_data= $installment_info;
               $installment_data['total']=round($sum,2);
               $message = "suceess";
               $status=200;
           }catch (\Exception $e){
               echo $e->getMessage();
               $status = 500;
               $message = "something went wrong";
           }
           $response = [
               "message" => $message,
               "status" => $status,
               "data" => $installment_data,
           ];
           return response($response);
    }
    public function getSwitchingDetails(Request $request){
        try{
            $data=$request->all();
            $finalData=array();
            $parent_student=User::where('parent_id',$data['teacher']['id'])->where('is_active',1)->get();
            $finalData['Parent_student_relation']['parent_id']=$data['teacher']['id'];
                               $i=0;
                              foreach($parent_student as $val)
                                 {
                                     $finalData['Parent_student_relation']['Students'][$i]['student_id']=$val->id;
                                     $finalData['Parent_student_relation']['Students'][$i]['student_name']=$val->first_name;
                                     $division_name=Division::where('id',$val->division_id)->pluck('division_name');
                                     $class=Division::where('id',$val->division_id)->pluck('class_id');
                                     $class_name=Classes::where('id',$class)->pluck('class_name');
                                     $grn=StudentExtraInfo::where('student_id',$val->id)->pluck('grn');
                                     $finalData['Parent_student_relation']['Students'][$i]['grn']=$grn;
                                     $finalData['Parent_student_relation']['Students'][$i]['class_name']=$class_name;
                                     $finalData['Parent_student_relation']['Students'][$i]['student_div']=$division_name;
                                     $finalData['Parent_student_relation']['Students'][$i]['last_name']=$val->last_name;
                                     $finalData['Parent_student_relation']['Students'][$i]['roll_number']=$val->roll_number;
                                     $finalData['Parent_student_relation']['Students'][$i]['body_id']=$val->body_id;
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
    public function publicGetSwitchingDetails(Request $request){
        try{
            $data=$request->all();
            $finalData=array();
            $parent_student=User::where('parent_id',$data['teacher']['id'])->where('is_active',1)->get();
            $finalData['Parent_student_relation']['parent_id']=$data['teacher']['id'];
            $i=0;
            foreach($parent_student as $val)
            {
                $finalData['Parent_student_relation']['Students'][$i]['student_id']=$val->id;
                $finalData['Parent_student_relation']['Students'][$i]['student_name']=$val->first_name;
                $division_name=Division::where('id',$val->division_id)->pluck('division_name');
                $class=Division::where('id',$val->division_id)->pluck('class_id');
                $class_name=Classes::where('id',$class)->pluck('class_name');
                $grn=StudentExtraInfo::where('student_id',$val->id)->pluck('grn');
                $finalData['Parent_student_relation']['Students'][$i]['grn']=$grn;
                $finalData['Parent_student_relation']['Students'][$i]['class_name']=$class_name;
                $finalData['Parent_student_relation']['Students'][$i]['student_div']=$division_name;
                $finalData['Parent_student_relation']['Students'][$i]['last_name']=$val->last_name;
                $finalData['Parent_student_relation']['Students'][$i]['roll_number']=$val->roll_number;
                $finalData['Parent_student_relation']['Students'][$i]['body_id']=$val->body_id;
                $i++;
            }
            $message="Successfully Listed";
            $status=200;
        }catch(\Exception $e){
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
    public function lcGenerated(Request $request,$id){
        try{
            $data = array();
            $status = 200;
            $message = "LC created for this student";
            $lc_data = User::where('id',$id)->lists('is_lc_generated');
            if($lc_data[0] == 1){
                $data = true;
            }else{
                $data = false;
            }

        }catch(\Exception $exception){
            $status = 500;
            $message = "Something went wrong" .  $exception->getMessage();
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "is_lc_generated" =>$data
        ];
        return response($response, $status);
    }
    public function minimum_supported_version(Request $request){
        try{
            $status = 200;
            $message = "Successfully Listed";
            $data['minimum_app_version'] = env('MINIMUM_APP_VERSION');
            $data['current_app_version'] = env('CURRENT_APP_VERSION');
            $data['maximum_app_version'] = env('MAXIMUM_APP_VERSION');
        }catch(\Exception $e){
            $message = "Something went wrong.";
            $status = 500;
            $data = [
                'action' => 'Minimum supported Version',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
        $response = [
            "message" => $message,
            "data" => $data
        ];
        return response()->json($response,$status);
    }
}
