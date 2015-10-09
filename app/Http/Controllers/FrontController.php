<?php

namespace App\Http\Controllers;

use Auth;
use Route;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FrontController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');

    }

    public function index(Request $request)
    {

        if(isset(Auth::user()->email))
        {


            $val1= \DB::table('users')
                ->Join('module_acl', 'users.id', '=', 'module_acl.user_id')
                ->Join('acl_master', 'module_acl.acl_id', '=', 'acl_master.id')
                ->Join('modules', 'modules.id', '=', 'module_acl.module_id')
                ->where('users.id','=',Auth::user()->id)
                ->select('users.id','users.email','users.name as username','acl_master.title as acl','modules.name as module','modules.slug as module_slug')
                ->get();

            $i=0;

        $resultArr=array();
        foreach($val1 as $val)
        {
            array_push($resultArr,$val->acl.'_'.$val->module_slug);

        }
            Session::put('functionArr',$resultArr);

            //return session('functionArr');
            return view('admin.dashboard');

        }else{

            return view('login_signin');
        }
    }
}
