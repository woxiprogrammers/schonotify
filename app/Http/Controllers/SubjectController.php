<?php

namespace App\Http\Controllers;

use App\Classes;
use App\Subject;
use App\SubjectClass;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SubjectController extends Controller
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

    public function createSubjects(Requests\WebRequests\SubjectRequest $request)
    {
        if($request->authorize()===true)
        {
            $classes=Classes::join('batches','classes.batch_id','=','batches.id')
                ->select('classes.id as id','classes.class_name as class','batches.name as batch')
                ->where('classes.body_id','=',Auth::User()->body_id)
                ->get();
            $batches=array();
            $classArray=array();

            $i=0;
            foreach($classes->toArray() as $row)
            {
                $classArray[$i]=$row['batch'];
                $i++;
            }
            $batches=array_unique($classArray);

            return view('createSubjects')->with(compact('classes','batches'));
        }else{
            return Redirect::to('/');
        }

    }
    public function create(Requests\WebRequests\SubjectRequest $request)
    {
        if($request->authorize()===true)
        {

            $subject['subject_name']=$request->subject;
            $subject['slug']=strtolower($request->subject);
            $query=Subject::insertGetId($subject);
            $subject_class=array();

            if($query!="")
            {
                $i=0;
                foreach($request->class as $classes)
                {
                   $subject_class[$i]=array('class_id'=>$classes,'subject_id'=>$query);
                    $i++;

                }

                $query1=SubjectClass::insert($subject_class);

                if($query1)
                {

                    Session::flash('message-success','Subject successfully created !');
                    return Redirect::back();
                }

            }
        }else{
            return Redirect::to('/');
        }
    }


}
