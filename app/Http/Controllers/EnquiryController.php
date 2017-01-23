<?php

namespace App\Http\Controllers;

use App\EnquiryForm;
use App\User;
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

    public function viewEnquiryListing(){
        try{
            return view('admin.enquiry_listing');
        }catch(\Exception $e){
            $data = [

                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }

    }

    public function viewEnquiryListingDetails(){
        try{
            return view('admin.enquiry_form_details');
        }catch(\Exception $e){
            $data = [

                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }

    }

    public function viewEnquiryListingData(Request $request){
        $dataEnq = EnquiryForm::all();
        $data['data'] = $dataEnq;
        return response()->json($data,200);
    }

    public function storeEnquiryForm(Request $request){
        try{$data = $request->all();

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
            $enquiryData = EnquiryForm::orderBy('id','ASC')->get()->toArray();
            $masterEnquiry = array();
            foreach($enquiryData as $enquiry){
                $now = Carbon::now();
                $enquiryId = $now->year."-".str_pad($enquiry['id'],4,"0",STR_PAD_LEFT);
                $enquiryDetailView = "/edit-enquiry/".$enquiry['id'];
                $enquiry['form_no'] = $enquiryId;
                $enquiry['action'] = "<a href ='$enquiryDetailView'>View</a>";
                $enquiry['result']= $enquiry['final_status'];
                $enquiry['name'] = $enquiry['student_first_name'].' '.$enquiry['student_last_name'];
                array_push($masterEnquiry,$enquiry);
            }
            return view('admin.enquiry.listing')->with(compact('masterEnquiry'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }


    public function enquiryListing(Request $request){
        try{

            $enquiryData = EnquiryForm::all();
            return view('admin.enquiry.listing')->with('results',$enquiryData);
            /*if($enquiryData !=null){
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
            }*/
        }catch(\Exception $e){
            $records = $e->getMessage();
        }
        return response()->json($records);
    }


    public function editEnquiryView(Request $request,$enquiryId){
        try{
            $enquiryInfo = EnquiryForm::where('id',$enquiryId)->first();
            $interviewUser = User::whereIn('role_id',[1,2])->get();
            return view('admin.enquiry.enquiry-edit')->with(compact('enquiryInfo','interviewUser'));
        }catch (\Exception $e){
            Log::critical('exception:'.$e->getMessage());
            abort(500,$e->getMessage());

        }
    }

    public function editEnquiry(Request $request,$enquiryId){
        try{

            $enquiryData = $request->all();
            $enquiry = EnquiryForm::findOrFail($enquiryId);
            $enquiryInfo = $enquiry->update($enquiryData);
            return redirect('edit-enquiry/'.$enquiryId);
        }catch (\Exception $e){
            Log::critical('exception:'.$e->getMessage());
            abort(500,$e->getMessage());

        }
    }
}
