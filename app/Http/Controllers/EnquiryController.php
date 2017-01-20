<?php

namespace App\Http\Controllers;

use App\EnquiryForm;
use Carbon\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
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
            $now = Carbon::now();
            $enquiryId = $now->year."-".str_pad($newEnquiry->id,4,"0",STR_PAD_LEFT);
            TCPdf::AddPage();
            TCPdf::writeHTML(view('enquiry-pdf')->with(compact('newEnquiry','enquiryId'))->render());
            TCPdf::Output("Enquiry Form".date('Y-m-d_H_i_s').".pdf", 'D');

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
            $now = Carbon::now();
            $enquiryId = $now->year."-".str_pad($newEnquiry->id,4,"0",STR_PAD_LEFT);
            Session::flash('message-success','Student Enquiry Submitted Successfully');

            TCPDF::AddPage();
            //TCPDF::Write(0, 'Hello World');
            TCPDF::writeHTML(view('enquiry-pdf')->with(compact('newEnquiry','enquiryId'))->render());
            TCPDF::Output("Enquiry Form".date('Y-m-d_H_i_s').".pdf", 'D');
            //return view('backend.common.pdf.invoice')->with(compact('order','orderNo','seller','sellerAddress','customerAddress','product','brand','unitPrice','taxPrice','orderDate','sellerBankDetails','invoiceId','invoice','invoiceCreatedDate','orderDateChangeFormat'));

            //return redirect('/new-student-enquiry')->with('message-success');
            return Redirect::back();

        }catch(\Exception $e){
            $data = [
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }
    }

    public function viewEnquiryList(){
        try{
            return view('admin.enquiry.listing');
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }


    public function enquiryListing(Request $request){
        try{

            $enquiryData = EnquiryForm::all();

            if($enquiryData !=null){
                $iTotalRecords = EnquiryForm::count();

                $iDisplayLength = intval($request->length);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($request->start);
                $sEcho = intval($request->draw);
                $records = array();
                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;

                $status_list = array(
                    array("success" => "Pending"),
                    array("info" => "Closed"),
                    array("danger" => "On Hold"),
                    array("warning" => "Fraud")
                );
                $limitedProducts = EnquiryForm::take($iDisplayLength)->skip($iDisplayStart)->get()->toArray();
                for($j=0,$i = $iDisplayStart; $i < $end; $i++,$j++) {
                    $now = Carbon::now();
                    $enquiryId = $now->year."-".str_pad($limitedProducts[$j]['id'],4,"0",STR_PAD_LEFT);
                    $orderDetailView = "/shipment/order/view/123";
                    $records["data"][] = array(
                            '<input type="checkbox" name="id[]" value="'.$limitedProducts[$j]['id'].'">',
                        $enquiryId,
                        $limitedProducts[$j]['student_first_name'],
                        $limitedProducts[$j]['admission_to_class'],
                            "Written Exam",
                        "Interview",
                        "Documents",
                            '<a href='.$orderDetailView.' class="btn btn-sm btn-default btn-circle btn-editable"><i class="fa fa-pencil"></i> View</a>',
                        );


                }
                if (isset($request->customActionType) && $request->customActionType == "group_action") {
                    $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                    $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
                }
                $records["draw"] = $sEcho;
                $records["recordsTotal"] = $iTotalRecords;
                $records["recordsFiltered"] = $iTotalRecords;
            }else{
                $records = '';
            }
        }catch(\Exception $e){
            $records = $e->getMessage();
        }
        return response()->json($records);
    }
}
