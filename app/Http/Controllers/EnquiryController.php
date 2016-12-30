<?php

namespace App\Http\Controllers;

use App\EnquiryForm;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class EnquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');

    }

    public function viewEnquiryForm(){
        try{
            return view('admin.enquiryCreate');
        }catch(\Exception $e){
            $data = [

                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }

    }

    public function storeEnquiryForm(Request $request){
        try{
            $data = $request->all();
            $currentTime = Carbon::now();
            $dob = str_replace('/', '-', $data['dob']);
            $data['dob'] = date('Y-m-d', strtotime($dob));
            $data['created_at'] = $currentTime;
            $data['updated_at'] = $currentTime;
            $newEnquiry = EnquiryForm::create($data);
            if(Session::has('enquiryId')){
                Session::put('enquiryId', $newEnquiry);
            }else{
                Session::set('enquiryId', $newEnquiry);
            }
            Session::flash('message-success','Student Enquiry Submitted Successfully');
            return redirect('/student-enquiry');
        }catch(\Exception $e){
            $data = [
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }
    }
}
