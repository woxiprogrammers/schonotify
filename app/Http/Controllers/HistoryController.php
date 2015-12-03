<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
{
    public function __construct()
    {
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
        return json_encode($par);
    }
}
