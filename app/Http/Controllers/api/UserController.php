<?php

namespace App\Http\Controllers\api;

use App\ModuleAcl;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('RememberUserToken');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function login(Request $request)
    {
     try{

         $user = User::where('email', $request->email)->first();
          if ($user == NULL) {
            $status = 404;
            $response = [
                "message" => "Sorry!! Incorrect email or password",
                "user"=>"",
            ];
          } elseif ($user->is_active == 0) {
            $status = 401;
            $response = [
                "message" => "Please confirm your email id first",
                "user"=>"",
          ];
          } elseif (Auth::attempt([
              'email' => $request->email,
              'password' => $request->password
          ])) {
              $status = 200;
              $modules = ModuleAcl::where('user_id' ,$user->id )->get();
             //dd($modules);

              $response = [
                          "token" => $user->remember_token,
                          "modules" => $modules->module_id,
                          "message" => "login successfully",
                          ];

        }
       else   {
            $status = 404;
            $response = [
                "message" => "Sorry!! Incorrect email or password",
                "user"=>"",
            ];
        }
        return response($response, $status);
        }catch (\Exception $e) {
            return false;
        }
    }



}
