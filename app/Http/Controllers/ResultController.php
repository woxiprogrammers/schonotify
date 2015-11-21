<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function showResults()
    {
        return view('showResults');
    }
   public function examResults()
   {
       $str='{
         "unit test": [
         {
            "Marathi":"50","English":"70","History":"60","Maths":"80","Geography":"70"
         }
         ],
         "class test": [
         {
            "Marathi":"51","English":"71","History":"61","Maths":"81","Geography":"71"
         }
         ],
         "mid test": [
         {
            "Marathi":"52","English":"72","History":"62","Maths":"82","Geography":"72"
         }
         ],
         "final test": [
         {
            "Marathi":"53","English":"73","History":"63","Maths":"83","Geography":"73"
         }
         ]
         }';

        return $str;
   }
}
