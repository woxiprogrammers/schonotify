<?php

namespace App\Http\Controllers\api;

use App\AclMaster;
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
              $val1= \DB::table('users')
                  ->Join('module_acls', 'users.id', '=', 'module_acls.user_id')
                  ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
                  ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
                  ->where('users.id','=',$user->id)
                  ->select('users.id','users.email','users.username as username','users.first_name as firstname','users.last_name as lastname','acl_master.title as acl','modules.title as module','modules.slug as module_slug')
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



}
