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
    {   $data=array();
     try{

         $user = User::where('email', $request->email)->first();
          if ($user == NULL) {
            $status = 404;
            $message = "Sorry!! Incorrect email or password";
          } elseif ($user->is_active == 0) {
            $status = 401;
            $message = "Please confirm your email id first";

          } elseif (Auth::attempt([
              'email' => $request->email,
              'password' => $request->password
          ])) {
              $status = 200;
              $val1=User::join('module_acls', 'users.id', '=', 'module_acls.user_id')
                  ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
                  ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
                  ->where('users.id','=',$user->id)
                  ->select('users.id','users.email','users.username as username','users.first_name as firstname','users.last_name as lastname','users.avatar','acl_master.title as acl','modules.title as module','modules.slug as module_slug')
                  ->get();
              $resultArr=array();
              foreach($val1 as $val)
              {
                  array_push($resultArr,$val->acl.'_'.$val->module_slug);

              }

              $msgCount=Message::where('to_id',$user->id)
                               ->where('read_status',0)
                               ->count();
              $data['token'] = $user->remember_token;
              $data['fname'] = $user->first_name;
              $data['lname'] = $user->last_name;
              $data['avatar'] = $user->avatar;
              $data['acl_module'] = $resultArr;
              $data['unread_messagees'] = $msgCount;
              $message = 'login successfully';
        }
       else   {
            $status = 404;
            $message = "Sorry!! Incorrect email or password";
        }
     }catch (\Exception $e) {
         $status = 500;
         $message = "Something went wrong";
     }
        $response = ["message" => $message,"userData" =>$data];

        return response($response, $status);

    }

    public function getBatches(Request $request){
        try{
            $data = $request->all();
            $division = $request->teacher->teacher()->lists('division_id');
            $class = Division::whereIn('id', $division)->distinct()->lists('class_id');
            $batch = Classes::whereIn('id', $class)->distinct()->lists('batch_id');
            $batchData = Batch::whereIn('id', $batch)->get();
            $batchList = $batchData->toArray();
            $status = 200;
            $responseData['batchList']= $batchList;
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

    public function getClasses(Request $request){
        try{
            $data = $request->all();
            $division = $request->teacher->teacher()->lists('division_id');
            $class = Division::whereIn('id', $division)->distinct()->lists('class_id');
            $classData = Classes::whereIn('id', $class)->get();
            $classList = $classData->toArray();
            $status = 200;
            $responseData['classList']= $classList;
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

    public function getDivisions(Request $request){
        try{
            $data = $request->all();
            $division = $request->teacher->teacher()->lists('division_id');
            $divisionData = Division::whereIn('id', $division)->get();
            $divisionList = $divisionData->toArray();
            $status = 200;
            $responseData['divisionList']= $divisionList;
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
}
