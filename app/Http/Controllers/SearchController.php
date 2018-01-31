<?php
namespace App\Http\Controllers;
use App\Batch;
use App\Classes;
use App\Division;
use App\Subject;
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
        $this->middleware('db');
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
    public function Studentfilter(Request $request)
    {
        $role_id=3;
        $user=Auth::user();
        if($user->role_id == 1)
        {
            if($role_id == 3){
                if($request->Division == "-1"){
                    $result= User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                        ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
                        ->select('users.id','users.roll_number as roll_number','users.first_name as firstname','users.last_name as lastname','users.gender as gender','students_extra_info.category as category','user_roles.slug as user_role','students_extra_info.grn as rollno','users.parent_id as parent_id','users.is_active','users.hide_result')
                        ->whereNull('division_id')
                        ->where('users.body_id','=',$user->body_id)
                        ->where('users.role_id','!=',1)
                        ->where('users.role_id','=',$role_id)
                        ->where('users.id','!=',$user->id)
                        ->get();
                }else{
                    $result= User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                        ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
                        ->select('users.id','users.roll_number as roll_number','users.first_name as firstname','users.last_name as lastname','users.gender as gender','students_extra_info.category as category','user_roles.slug as user_role','students_extra_info.grn as rollno','users.parent_id as parent_id','users.is_active','users.hide_result')
                        ->where('division_id',$request->Division)
                        ->where('users.body_id','=',$user->body_id)
                        ->where('users.role_id','!=',1)
                        ->where('users.role_id','=',$role_id)
                        ->where('users.id','!=',$user->id)
                        ->get();
                }
            }else{
                $result= User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                    ->select('users.id','users.roll_number as roll_number','users.first_name as firstname','users.last_name as lastname','users.gender as gender','students_extra_info.category as category','user_roles.slug as user_role','users.roll_number as rollno','users.parent_id as parent_id','users.is_active','users.hide_result')
                    ->where('users.body_id','=',$user->body_id)
                    ->where('users.role_id','=',$role_id)
                    ->where('users.id','!=',$user->id)
                    ->get();
            }
        }else{
            if($role_id == 3){
                if($request->Division == "-1"){
                    $result= User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                        ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
                        ->select('users.id','users.roll_number as roll_number','users.first_name as firstname','users.last_name as lastname','users.gender as gender','students_extra_info.category as category','user_roles.slug as user_role','students_extra_info.grn as rollno','users.parent_id as parent_id','users.is_active','users.hide_result')
                        ->whereNull('division_id')
                        ->where('users.body_id','=',$user->body_id)
                        ->where('users.role_id','!=',1)
                        ->where('users.role_id','=',$role_id)
                        ->where('users.id','!=',$user->id)
                        ->get();
                }else{
                    $result= User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                        ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
                        ->select('users.id','users.roll_number as roll_number','users.first_name as firstname','users.last_name as lastname','users.gender as gender','students_extra_info.category as category','user_roles.slug as user_role','students_extra_info.grn as rollno','users.parent_id as parent_id','users.is_active','users.hide_result')
                        ->where('division_id',$request->Division)
                        ->where('users.body_id','=',$user->body_id)
                        ->where('users.role_id','!=',1)
                        ->where('users.role_id','=',$role_id)
                        ->where('users.id','!=',$user->id)
                        ->get();
                }
            }else{
                $result= User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                    ->select('users.id','users.roll_number as roll_number','users.first_name as firstname','users.last_name as lastname','users.gender as gender','users.email','user_roles.slug as user_role','users.roll_number as rollno','users.parent_id as parent_id','users.is_active','users.hide_result')
                    ->where('users.body_id','=',$user->body_id)
                    ->where('users.role_id','!=',1)
                    ->where('users.role_id','=',$role_id)
                    ->where('users.id','!=',$user->id)
                    ->get();
            }
        }
        $str="<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
        $str.="<thead><tr>";
        if($role_id == 3)
        {
            $str.="<th>Result</th>";
            $str.="<th>GRN No.</th>";
        }
        $str.="<th>Name</th></th><th>Roll No</th><th>Category</th><th>Gender</th>";
        if($role_id == 3)
        {
            $str.="<th>Parent Name</th>";
            $str.="<th>Parent Email</th>";
        }
        if(sizeof($result->toArray()) != 0 )
        {
            if($user->role_id == 1)
            {
                $str.="<th>Status</th>";
            }
            $str.="<th>Action</th>";
            $str.="</tr></thead><tbody>";
            foreach($result as $row)
            {
                if($row->user_role=='student')
                {
                    if($row->hide_result == 1){
                        $str.="<tr><td>"."<input type='checkbox' class='result_status' onchange='return result(this)' value='".$row->id."'checked>"."</td>";
                    }else{
                        $str.="<tr><td>"."<input type='checkbox' class='result_status' onchange='return result(this)' value='".$row->id."'>"."</td>";

                    }
                    $str.="<td>".$row->rollno."</td>";
                }else{
                    $str.="<tr>";
                }
                $str.="<td>".$row->firstname." ".$row->lastname."</td>";
                $str.="<td>".$row->roll_number."</td>";
                $str.="<td>".$row->category."</td>";
                $str.="<td>".$row->gender."</td>";
                if($row->user_role=='student') {
                    $parent=User::all()->where('id',$row->parent_id);
                    if($parent->toArray() == null) {
                        $str.="<td> -- </td>";
                    } else {
                        foreach($parent as $row1)
                        {
                            $str.="<td>".$row1->first_name." ".$row1->last_name."</td>";
                            $str.="<td>".$row1->email."</td>";
                        }
                    }
                }
                if($user->role_id == 1)
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
                $str.="<td>";
                $str.="<a href='/edit-user/".$row->id."'>Edit </a>";
                if($row->user_role != 'student') {
                    $str.=" / <a href='/view-user/".$row->id."'> View</a>";
                }
                $str.="</td>";
            }
        } else {
            $str1 = "<h5 class='center'>No records found !</h5>";
        }
        $str.="</tr></tbody>";
        $str.="</table>";
        if(sizeof($result->toArray()) != 0 )
        {
            return $str;
        } else {
            return $str1;
        }
    }
    public function selectRole($role_id)
    {
        if($role_id != 3){
          $user=Auth::user();
          if($user->role_id == 1)
          {
              if($role_id == 3){
                  $result= User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                      ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
                      ->select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.gender as gender','users.email','user_roles.slug as user_role','students_extra_info.grn as rollno','users.parent_id as parent_id','users.is_active')
                      ->where('users.body_id','=',$user->body_id)
                      ->where('users.role_id','!=',1)
                      ->where('users.role_id','=',$role_id)
                      ->where('users.id','!=',$user->id)
                      ->get()->toArray();
          }else{
          $result= User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
              ->select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.gender as gender','users.email','user_roles.slug as user_role','users.roll_number as rollno','users.parent_id as parent_id','users.is_active')
              ->where('users.is_active',true)
              ->where('users.body_id','=',$user->body_id)
              ->where('users.role_id','=',$role_id)
              ->where('users.id','!=',$user->id)
              ->get();
              }
          }else{
              if($role_id == 3){
                  $result= User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                      ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
                      ->select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.gender as gender','users.email','user_roles.slug as user_role','students_extra_info.grn as rollno','users.parent_id as parent_id','users.is_active')
                      ->where('users.body_id','=',$user->body_id)
                      ->where('users.role_id','!=',1)
                      ->where('users.role_id','=',$role_id)
                      ->where('users.id','!=',$user->id)
                      ->get();
              }else{
                  $result= User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                      ->select('users.id','users.username as user_name','users.first_name as firstname','users.last_name as lastname','users.gender as gender','users.email','user_roles.slug as user_role','users.roll_number as rollno','users.parent_id as parent_id','users.is_active')
                      ->where('users.body_id','=',$user->body_id)
                      ->where('users.role_id','!=',1)
                      ->where('users.role_id','=',$role_id)
                      ->where('users.id','!=',$user->id)
                      ->get();
              }
          }

          $str="<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
          $str.="<thead><tr>";
          if($role_id == 3)
          {
              $str.="<th>GRN No.</th>";
          }
          if($role_id == 2){
            $str.="<th>Name</th><th>CLass Teacher</th><th>Email</th><th>Gender</th>";
          }else{
            $str.="<th>Name</th><th>Username</th><th>Email</th><th>Gender</th>";
          }
          if($role_id == 3)
          {
              $str.="<th>Parent Name</th>";
          }
          if(sizeof($result) != 0 )
          {
              if($user->role_id == 1)
              {
                  $str.="<th>Status</th>";
              }
              $str.="<th>Action</th>";
              $str.="</tr></thead><tbody>";
              foreach($result as  $teacher){
                      $class_name = Division::where('class_teacher_id',$teacher->id)->pluck('division_name');
                      $classes = Division::where('class_teacher_id',$teacher->id)->pluck('class_id');
                      $Class_namee = Classes::where('id',$classes)->pluck('class_name');
                      $teacher['class'] = $class_name;
                      $teacher['div'] = $Class_namee;
              }
              foreach($result as $row)
              {
                  if($row['user_role'] == 'student')
                  {
                      $str.="<tr><td>".$row['rollno']."</td>";
                  }else{
                      $str.="<tr>";
                  }
                  $str.="<td>".$row['firstname']." ".$row['lastname']."</td>";
                  if($role_id == 2){
                         $str.="<td>".$row['div']." - ".$row['class']."</td>";
                  }else{
                    $str.="<td>".$row['user_name']."</td>";
                  }
                  $str.="<td>".$row['email']."</td>";
                  $str.="<td>".$row['gender']."</td>";
                  if($row['user_role']=='student') {
                      $parent=User::all()->where('id',$row['parent_id']);
                      if($parent->toArray() == null) {
                          $str.="<td> -- </td>";
                      } else {
                          foreach($parent as $row1)
                          {
                              $str.="<td>".$row1->first_name." ".$row1->last_name."</td>";
                          }
                      }
                  }
                  if($user->role_id == 1)
                  {
                      $str.="<td>";
                      if($row['is_active'] == 1)
                      {   $a_id=$row['id'];
                          $str.="<input type='checkbox' class='js-switch' onchange='return statusUser(this.checked,$a_id)' id='status$a_id' value='$a_id' checked/>";
                      }else{
                          $a_id=$row['id'];
                          $str.="<input type='checkbox' class='js-switch' onchange='return statusUser(this.checked,$a_id)' id='status$a_id' value='$a_id'/>";
                      }
                      $str.="</td>";
                  }
                  $str.="<td>";
                  $str.="<a href='/edit-user/".$row['id']."'>Edit </a>";
                  if($row['user_role'] != 'student') {
                  $str.=" / <a href='/view-user/".$row['id']."'> View</a>";
                  }
                  $str.="</td>";
              }
          } else {
              $str1 = "<h5 class='center'>No records found !</h5>";
          }
          $str.="</tr></tbody>";
          $str.="</table>";
          if(!empty($result))
          {
              return $str;
          } else {
              return $str1;
          }
        }
    }
    public function searchClasses(Requests\WebRequests\ViewClassRequest $request,$id)
    {

        if($request->authorize()===true)
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
        }else{
            return Redirect::to('/');
        }

    }

    public function searchClass()
    {
        $user=Auth::user();
        $result= Classes::Join('batches', 'batches.id', '=', 'classes.batch_id')
            ->select('classes.id as class_id','classes.class_name as class_name','classes.batch_id as batch_id','batches.name as batch_name')
            ->where('classes.body_id','=',$user->body_id)
            ->get();

        $batch=Batch::all();

        return view('admin.searchClasses')->with('results',$result)->with('batches',$batch);
    }

    public function searchBatch()
    {
        $user=Auth::User();
        $result= Batch::where('body_id','=',$user->body_id)
            ->get();
        return view('admin.searchBatch')->with('results',$result);
    }

    public function searchDivision()
    {
        $user=Auth::User();
        $result= Division::Join('classes', 'divisions.class_id', '=', 'classes.id')
            ->join('batches','batches.id','=','classes.batch_id')
            ->select('classes.id as class_id','classes.slug as class_name','divisions.slug as div_name','divisions.id as div_id','batches.id as batch_id','batches.slug as batch_name')
            ->where('classes.body_id','=',$user->body_id)
            ->get();

        return view('admin.searchDivision')->with('results',$result);
    }

    public function searchSubjects()
    {
         $body_id = Auth::user()->body_id;
         $result=Subject::where('body_id',$body_id)->get()->toArray();
         return view('admin.searchSubjects')->with('results',$result);
    }
}
