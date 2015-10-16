<?php

namespace App\Http\Controllers;

use App\ClassData;
use App\Division;
use App\User;
use App\UserRoles;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Providers\RouteServiceProvider;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function usersProfile()
    {
        return view('userProfile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

      $role1=UserRoles::find($id);
        if($role1->name=='admin')
        {
            return Redirect::to('adminCreate');
        }elseif($role1->name=='teacher')
        {
            return Redirect::to('teacherCreate');
        }elseif($role1->name=='student')
        {
            return Redirect::to('studentCreate');
        }elseif($role1->name=='parent')
        {
            return Redirect::to('parentCreate');
        }else
        {
            return Redirect::to('usersCreate');
        }

    }

    public function adminCreateForm()
    {
        $roles=UserRoles::all();

        return view('admin.adminCreateForm')->with('userRoles',$roles);

    }

    public function teacherCreateForm()
    {
        $roles=UserRoles::all();

        return view('admin.teacherCreateForm')->with('userRoles',$roles);

    }

    public function studentCreateForm()
    {
        $roles=UserRoles::all();

        return view('admin.studentCreateForm')->with('userRoles',$roles);

    }

    public function parentCreateForm()
    {
        $roles=UserRoles::all();

        return view('admin.parentCreateForm')->with('userRoles',$roles);

    }

    public function usersCreateForm()
    {
        $roles=UserRoles::all();

        return view('admin.usersCreateForm')->with('userRoles',$roles);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
            $result1=User::select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.email','body.name as body_name','user_roles.name as user_role','users.is_active')
                //$result1= \DB::table('users')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->Join('body', 'users.body_id', '=', 'body.id')
                ->where('users.id','=',$id)
                ->get();
            return response()->json($result1->toArray());
        }elseif($userRole[0]->role_slug == 'teacher')
        {
            $result1=User::select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.email','body.name as body_name','user_roles.name as user_role','users.is_active','teacher_view.web_view','teacher_view.mobile_view')
                //$result1= \DB::table('users')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->Join('body', 'users.body_id', '=', 'body.id')
                ->Join('teacher_view', 'users.id', '=', 'teacher_view.teacher_id')
                ->where('users.id','=',$id)
                ->get();

            return response()->json($result1->toArray());
        }elseif($userRole[0]->role_slug == 'student')
        {
            $result1=User::select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.email','body.name as body_name','user_roles.name as user_role','users.is_active','division.name as div_name','division.id as div_id','users.parent_id','division.class_id','class.name as class_name','class.batch_id')
                //$result1= \DB::table('users')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->Join('body', 'users.body_id', '=', 'body.id')
                ->Join('division', 'division.id', '=', 'users.div_id')
                ->Join('class','class.id','=','division.class_id')
                ->where('users.id','=',$id)
                ->get();

            $result2=ClassData::all();
            $result3=Division::all();
            $arr1=json_decode($result1);
            $arr2=json_decode($result2);
            $arr3=json_decode($result3);
            array_push($arr1,array($arr2,$arr3));

            return response()->json($arr1);
        }elseif($userRole[0]->role_slug == 'parent')
        {
            $result1=User::select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.email','user_roles.name as user_role','users.is_active')
                //$result1= \DB::table('users')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                //->Join('body', 'users.body_id', '=', 'body.id')
                ->where('users.id','=',$id)
                ->get();

            return response()->json($result1->toArray());

        }
        else{
            $result1=User::select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.email','body.name as body_name','user_roles.name as user_role','users.is_active')
                //$result1= \DB::table('users')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->Join('body', 'users.body_id', '=', 'body.id')
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
