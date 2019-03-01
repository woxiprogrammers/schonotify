<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 27/2/19
 * Time: 3:38 PM
 */

namespace App\Http\Controllers\ExamEvaluation;

use App\Batch;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExamEvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }

    public function createFeeStructureView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('exam_evaluation.createQuestionPaper')->with(compact('batches','user'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function getEnterMarksView(){
        try{
            $user = Auth::user();
            $file = env('ABOUT_US_IMAGE_UPLOAD').'/'.'sample.pdf';
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('exam_evaluation.enterMarks')->with(compact('batches','file','user'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

}