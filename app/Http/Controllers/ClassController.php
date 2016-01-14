<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Classes;
use App\Division;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\Support\Facades\Session;

class ClassController extends Controller
{

    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function index(Requests\WebRequests\ClassRequest $request)
    {
        if($request->authorize()===true)
        {
            $user=Auth::User();
            $batches=Batch::where('body_id',$user->body_id)->get();
            return view('admin.classCreate')->with(compact('batches'));
        }else{
            return Redirect::to('/');
        }
    }
    public function create(Requests\WebRequests\ClassRequest $request)
    {
        $user=Auth::User();
        $class['batch_id']=$request->dropdown;
        $class['class_name']=$request->class;
        $class['body_id']=$user->body_id;
        $query=Classes::insert($class);
        if($query){
            Session::flash('message-success','Class created successfully!');
            return Redirect::back();
        }else{
            Session::flash('message-error','Something went wrong!');
            return Redirect::back();
        }

    }
    public function createBatch($batchName)
    {
        $user=Auth::User();
        $batch['body_id']=$user->body_id;
        $batch['name']=$batchName;
        $cnt=Batch::where('name',$batchName)->count();
        if($cnt<1)
        {
            $query=Batch::insertGetId($batch);
            if($query)
            {
                return $query;
            }
        }else{
            return 0;
        }
    }
    public function deleteBatch(Requests\WebRequests\DeleteClassRequest $request,$id)
    {
        if($request->authorize()===true)
        {
            Batch::where('id',$id)->delete();
            if($request->ajax())
            {
                return 1;
            }else{
                Session::flash('message-success','Batch has been deleted!');
                return Redirect::back();
            }
        }else{
            if($request->ajax())
            {
                return 403;
            }else{
                return Redirect::to('/');
            }
        }

    }
    public function createDivision(Requests\WebRequests\DivisionRequest $request)
    {
        if($request->authorize()===true)
        {
            $user=Auth::User();
            $batches=Batch::where('body_id',$user->body_id)->get();
            return view('divisionCreate')->with(compact('batches'));
        }else{
            return Redirect::to('/');
        }
    }

    public function saveDivision(Requests\WebRequests\DivisionRequest $request)
    {

        $div['class_id']=$request->classDropdown;
        $div['division_name']=strtoupper($request->division);
        $cnt=Division::where($div)->count();

        if($cnt>0)
        {
            Session::flash('message-error','Division Name for this class is already in use !');
            return Redirect::back();
        }else{
            $query=Division::insert($div);

            if($query)
            {
                Session::flash('message-success','Division has been created!');
                return Redirect::back();
            }
        }

    }

}
