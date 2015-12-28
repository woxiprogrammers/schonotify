<?php

namespace App\Http\Controllers;

use App\AclMaster;
use App\ClassData;
use App\Classes;
use App\Division;
use App\Module;
use App\ModuleAcl;
use App\User;
use App\UserRoles;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
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
    public function store(Request $request)
    {

       $data=Input::all();
        dd($data);
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


}
