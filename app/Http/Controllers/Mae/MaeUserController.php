<?php

/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 8/8/19
 * Time: 11:49 AM
 */
namespace App\Http\Controllers\Mae;

use App\Batch;
use App\Classes;
use App\Division;
use App\StudentExtraInfo;
use App\User;
use App\UserRoles;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MaeUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        //$this->middleware('auth');
    }

    public function createUser(Request $request){
        try{
            $user = Auth::User();
            if($request->password == $request->password2){
                if($request->role == 1){
                    $userData['first_name'] = $request->firstName;
                    $userData['last_name'] = $request->lastName;
                    $userData['username'] = $request->userName;
                    $userData['password'] = bcrypt($request->password);
                    $userData['is_active'] = true;
                    $userData['is_displayed'] = true;
                    $userData['role_id'] = $request->role;
                    $userData['body_id'] = $user['body_id'];
                    $query = User::create($userData);
                }
                if($request->role == 2){
                    $userData['first_name'] = $request->firstName;
                    $userData['last_name'] = $request->lastName;
                    $userData['username'] = $request->userName;
                    $userData['password'] = bcrypt($request->password);
                    $userData['is_active'] = true;
                    $userData['is_displayed'] = true;
                    $userData['role_id'] = $request->role;
                    $userData['body_id'] = $user['body_id'];
                    $query = User::create($userData);
                }
            }else{
                Session::flash('message-error','password does not match');
                return back();
            }
            if($request->role == 3){
                $userData['is_active'] = true;
                $userData['is_displayed'] = true;
                $userData['role_id'] = $request->role;
                $userData['division_id'] = $request->division;
                $userData['body_id'] = $user['body_id'];
                $query = $student = User::create($userData);
                $studentData['student_id'] = $student['id'];
                $studentData['grn'] = $request->prn;
                StudentExtraInfo::create($studentData);
            }
            if(empty($query['id'])){
                Session::flash('message-error','Something went wrong !');
                return back();
            }else{
                Session::flash('message-success','User created successfully .');
                return back();
            }
        }catch (\Exception $exception){
            $data=[
                'action' => 'All student list',
                'message' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
}