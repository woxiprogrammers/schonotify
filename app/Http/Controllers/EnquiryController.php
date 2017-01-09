<?php

namespace App\Http\Controllers;

use App\EnquiryForm;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPdf;
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
        //$this->middleware('auth', ['except' => 'viewEnquiryFormWithoutLogin','storeEnquiryFormWithoutLogin']);

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

    public function viewEnquiryFormWithoutLogin(){
        try{
            return view('admin.enquiryCreateWithoutLogin');
        }catch(\Exception $e){
            $data = [

                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }

    }

    public function storeEnquiryFormWithoutLogin(Request $request){
        try{
            $data = $request->all();
            $currentTime = Carbon::now();
            $dob = str_replace('/', '-', $data['dob']);
            $data['dob'] = date('Y-m-d', strtotime($dob));
            $data['created_at'] = $currentTime;
            $data['updated_at'] = $currentTime;
            $newEnquiry = EnquiryForm::create($data);
            //return redirect('/new-student-enquiry')->with('message', 'Success!');
            TCPdf::AddPage();
            //TCPDF::Write(0, 'Hello World');
            TCPdf::writeHTML(view('enquiry-pdf')->render());
            TCPdf::Output("Invoice".date('Y-m-d_H_i_s').".pdf", 'D');
            //return view('backend.common.pdf.invoice')->with(compact('order','orderNo','seller','sellerAddress','customerAddress','product','brand','unitPrice','taxPrice','orderDate','sellerBankDetails','invoiceId','invoice','invoiceCreatedDate','orderDateChangeFormat'));

        }catch(\Exception $e){
            $data = [
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }
    }
}
