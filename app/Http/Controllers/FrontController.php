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
        $this->middleware('db');

    }

    public function index(Request $request)
    {

        if(isset(Auth::user()->email))
        {


            $val1= \DB::table('users')
                ->Join('module_acls', 'users.id', '=', 'module_acls.user_id')
                ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
                ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
                ->where('users.id','=',Auth::user()->id)
                ->select('users.id','users.email','users.username as username','users.first_name as firstname','users.last_name as lastname','acl_master.slug as acl','modules.title as module','modules.slug as module_slug')
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
