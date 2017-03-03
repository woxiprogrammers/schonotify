<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function showAttendance()
    {
        return view('attendanceHistory');
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
    public function getAttendance($par)
    {
        if($par=="2014-15")
        {
            $results='[
                    {
                        "months":["june","jul","aug","sept","oct","nov","dec","jan","feb","mar","apr"],
                        "present":[23,17,20,23,19,27,23,19,18,21,12],
                        "absent":[3,2,0,3,3,2,0,1,1,2,3]
                    }
                  ]';
        }
        if($par=="2013-14")
        {
            $results='[
                    {
                        "months":["june","jul","aug","sept","oct","nov","dec","jan"],
                        "present":[23,18,20,23,19,21,25,19],
                        "absent":[3,2,0,3,3,2,0,1]
                    }
                  ]';
        }
        if($par=="2012-13")
        {
            $results='[
                    {
                        "months":["june","jul","aug","sept","oct","nov","dec","jan"],
                        "present":[13,19,22,20,24,23,24,21],
                        "absent":[4,1,3,4,3,2,3,2]
                    }
                  ]';
        }
        if($par=="2012-13")
        {
            $results='[
                    {
                        "months":["june","jul","aug","sept","oct","nov","dec"],
                        "present":[23,20,21,23,19,21,25],
                        "absent":[3,2,0,3,3,2,0]
                    }
                  ]';
        }
        if($par=="2011-12")
        {
            $results='[
                    {
                        "months":["june","jul","aug","sept","oct","nov","dec"],
                        "present":[23,19,20,23,19,21,25],
                        "absent":[3,2,0,3,3,2,0]
                    }
                  ]';
        }
        if($par=="2010-11")
        {
            $results='[
                    {
                        "months":["june","jul","aug","sept","oct","nov","dec"],
                        "present":[23,19,18,23,19,21,25],
                        "absent":[3,2,0,3,3,2,0]
                    }
                  ]';
        }

        return $results;
    }

    public function showResults()
    {
        return view('resultsHistory');
    }
}
