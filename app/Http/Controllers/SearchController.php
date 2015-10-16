<?php

namespace App\Http\Controllers;
use App\User;
use App\UserRoles;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    }
    public function searchUsers()
    {

        $roles=UserRoles::all();

        return view('admin.searchUsers')->with('userRoles',$roles);

    }
    public function selectRole($role_id=1)
    {

        if(Auth::user()->role_id == 1)
        {
        $result= \DB::table('users')
            ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
            ->select('users.id','users.name as user_name','users.email','user_roles.name as user_role','users.is_active')
            ->where('users.role_id','=',$role_id)
            ->where('users.id','!=',Auth::User()->id)
            ->get();
        }else{
            $result= \DB::table('users')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->select('users.id','users.name as user_name','users.email','user_roles.name as user_role','users.is_active')
                ->where('users.role_id','!=',1)
                ->where('users.role_id','=',$role_id)
                ->where('users.id','!=',Auth::User()->id)
                ->get();
        }
        $str="<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
        $str.="<thead><tr><th>Name</th><th>Email</th><th>Role</th>";
        if(Auth::user()->role_id == 1)
        {
                $str.="<th>Status</th>";
        }
        foreach(session('functionArr') as $row)
        {
            if($row == 'update_user')
            {
                $str.="<th>Action</th>";
            }
        }
        $str.="</tr></thead><tbody>";

        foreach($result as $row)
        {
            $str.="<tr><td>".$row->user_name."</td>";
            $str.="<td>".$row->email."</td>";
            $str.="<td>".$row->user_role."</td>";
            if(Auth::user()->role_id == 1)
            {
                $str.="<td>";
                if($row->is_active == 1)
                {
                    $str.="<input type='checkbox' class='js-switch' onchange='return statusUser(this.checked,$row->id)' id='status$row->id' value='$row->id' checked/>";
                }else{
                    $str.="<input type='checkbox' class='js-switch' onchange='return statusUser(this.checked,$row->id)' id='status$row->id' value='$row->id'/>";
                }
                $str.="</td>";
            }

            foreach(session('functionArr') as $row1)
            {
                if($row1 == 'update_user')
                {
                    $str.="<td><a data-toggle='modal' onclick='userEdit(".$row->id.")' id='popup_valid' data-target='.bs-example-modal-sm' value='$row->id'>Edit</a></td>";
                }
            }

        }

        $str.="</tr>";

        $str.="</table>";

        return $str;

    }
    public function searchClasses()
    {
        if(Auth::user()->role_id == 1)
        {
            $result= \DB::table('class')
                ->Join('division', 'division.class_id', '=', 'class.id')
                ->Join('batch', 'batch.id', '=', 'class.batch_id')
                ->select('class.id as class_id','class.name as class_name','class.batch_id','batch.name as batch_name','division.name as div_name')
                ->where('class.body_id','=',Auth::User()->body_id)
                ->get();
        }
        return view('admin.searchClasses')->with('results',$result);
    }
    public function searchSubjects()
    {
        return view('admin.searchSubjects');
    }
}
