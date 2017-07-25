<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function showResults(Requests\WebRequests\ResultRequest $request)
    {
        if($request->authorize()===true)
        {
            return view('showResults');
        }else{
            return Redirect::to('/');
        }
    }
    public function examResults()
    {
        $str='{
         "unit test": [
         {
            "Marathi":["50","100"],"English":["70","100"],"History":["60","100"],"Maths":["80","150"],"Geography":["70","100"]
         }
         ],
         "class test": [
         {
            "Marathi":["51","100"],"English":["71","100"],"History":["61","100"],"Maths":["81","150"],"Geography":["71","100"]
         }
         ],
         "mid test": [
         {
            "Marathi":["52","100"],"English":["72","100"],"History":["62","100"]
         }
         ],
         "final test": [
         {
            "Marathi":["53","100"],"English":["73","100"],"History":["63","100"],"Maths":["83","150"],"Geography":["73","100"]
         }
         ]
         }';

        return $str;
    }
    public function subjectResults()
    {
        $str='{
             "Marathi": [
             {
                "unit test":["50","100"],"class test":["70","100"],"mid test":["60","100"],"final test":["80","100"]
             }
             ],
             "English": [
             {
                "unit test":["51","100"],"class test":["71","100"],"mid test":["61","100"],"final test":["81","100"]
             }
             ],
             "History": [
             {
                "unit test":["52","100"],"class test":["72","100"],"mid test":["62","100"]
             }
             ],
             "Maths": [
             {
                "unit test":["53","100"],"class test":["73","100"],"mid test":["63","100"],"final test":["83","100"]
             }
             ]
             }';

        return $str;
    }
    public function getStudents()
    {
         $results='[
            { "data": "101", "value": "101 Suraj Bande" },
            { "data": "102", "value": "102 Sumit Bande" },
            { "data": "103", "value": "103 Gauri Bande" },
            { "data": "104", "value": "104 Prince Jain" },
            { "data": "105", "value": "105 Abhi Dhat" },
            { "data": "106", "value": "106 Sagar Acharya" },
            { "data": "107", "value": "107 Shantanu Acharya" },
            { "data": "108", "value": "108 Ganesh Dharmawat" },
            { "data": "109", "value": "109 Swapnali Desai" },
            { "data": "110", "value": "110 Jayati Lakade" },
            { "data": "111", "value": "111 Megha" },
            { "data": "112", "value": "112 Amol" },
            { "data": "113", "value": "113 Manoj" },
            { "data": "114", "value": "114 Bharat Makhwana" }
        ]';
       return $results;
    }
}
