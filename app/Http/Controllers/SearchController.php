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
            ->get();
        }else{
            $result= \DB::table('users')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->select('users.id','users.name as user_name','users.email','user_roles.name as user_role','users.is_active')
                ->where('users.role_id','!=',1)
                ->where('users.role_id','=',$role_id)
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
                    $str.="<span class='label label-success'>Active</span>";
                }else{
                    $str.="<span class='label label-inverse'>inActive</span>";


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
        return view('admin.searchClasses');
    }
    public function searchSubjects()
    {
        return view('admin.searchSubjects');
    }
}
