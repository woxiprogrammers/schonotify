<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function homeworkListing()
    {
        return view('homeworkListing');
    }

    public function detailedHomework()
    {
        return view('detailedHomework');
    }

    public function createHomework()
    {
        return view('createHomework');
    }
}
