<?php

namespace App\Http\Controllers;
use App\User;
use App\UserRoles;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

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
            ->select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.gender as gender','users.email','user_roles.name as user_role','users.rollno as rollno','users.parent_id as parent_id','users.is_active')
            ->where('users.role_id','=',$role_id)
            ->where('users.id','!=',Auth::User()->id)
            ->get();
        }else{
            $result= \DB::table('users')
                ->Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                ->select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.gender as gender','users.email','user_roles.name as user_role','users.rollno as rollno','users.parent_id as parent_id','users.is_active')
                ->where('users.role_id','!=',1)
                ->where('users.role_id','=',$role_id)
                ->where('users.id','!=',Auth::User()->id)
                ->get();

        }
        $str="<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";

        $str.="<thead><tr>";

        foreach($result as $row)
        {
            if($row->user_role=='student')
            {
                $str.="<th>Role No.</th>";
            }
        }

        $str.="<th>Name</th></th><th>Username</th><th>Email</th><th>Gender</th>";

        foreach($result as $row)
        {
            if($row->user_role=='student')
            {
                $str.="<th>Parent Name</th>";
            }
        }

        $str.="<th>Status</th>";

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

            if($row->user_role=='student')
            {
                $str.="<tr><td>".$row->rollno."</td>";
            }else{
                $str.="<tr>";
            }

            $str.="<td>".$row->firstname." ".$row->lastname."</td>";
            $str.="<td>".$row->user_name."</td>";
            $str.="<td>".$row->email."</td>";
            $str.="<td>".$row->gender."</td>";
            $parent=User::all()->where('id',$row->parent_id);
            foreach($parent as $row1)
            {
                $str.="<td>".$row1->first_name." ".$row1->last_name."</td>";
            }
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
            }else{
                $str.="<td>";
                if($row->is_active == 1)
                {
                    $str.='<span class="label label-success">Active</span>';
                }else{
                    $str.='<span class="label label-inverse">inActive</span>';
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

    public function searchClasses($id)
    {

        if($id==1)
        {
            return Redirect::To('searchBatch');
        }elseif($id==2)
        {
            return Redirect::To('searchClass');
        }else{
            return Redirect::To('searchDivision');
        }

    }

    public function searchClass()
    {
        $result= \DB::table('class')
            ->Join('batch', 'batch.id', '=', 'class.batch_id')
            ->select('class.id as class_id','class.name as class_name','class.batch_id as batch_id','batch.name as batch_name')
            ->where('class.body_id','=',Auth::User()->body_id)
            ->get();

        $batch=\DB::table('batch')->get();

        return view('admin.searchClasses')->with('results',$result)->with('batches',$batch);
    }

    public function searchBatch()
    {
        $result= \DB::table('batch')
            ->join('class','class.batch_id','=','batch.id')
            ->select('batch.id as batch_id','batch.name as batch_name','batch.description as batch_description')
            ->where('class.body_id','=',Auth::User()->body_id)
            ->get();

        return view('admin.searchBatch')->with('results',$result);
    }

    public function searchDivision()
    {
        $result= \DB::table('division')
            ->Join('class', 'division.class_id', '=', 'class.id')
            ->join('batch','batch.id','=','class.batch_id')
            ->select('class.id as class_id','class.name as class_name','division.name as div_name','division.id as div_id','batch.id as batch_id','batch.name as batch_name')
            ->where('class.body_id','=',Auth::User()->body_id)
            ->get();

        return view('admin.searchDivision')->with('results',$result);
    }

    public function searchSubjects()
    {
        return view('admin.searchSubjects');
    }
}
