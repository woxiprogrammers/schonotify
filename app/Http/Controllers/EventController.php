<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('admin.event');
    }

    public function saveEvent()
    {
        $tmp_file=$_FILES['image']['tmp_name'];
        $filename=$_FILES['image']['name'];
        $arr=array();
        $arr['request']=$_REQUEST;

        if(move_uploaded_file($tmp_file,'assets/images/events/'.$filename))
        {
            $arr['status']='uploaded';
        }else{
            $arr['status']='not uploaded';
        }

        return $arr;
    }
}
