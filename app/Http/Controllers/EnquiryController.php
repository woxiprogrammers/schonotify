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
use Illuminate\Support\Facades\Auth;
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
        try{
            $user = Auth::User();
            $data = $request->all();
            $currentTime = Carbon::now();
            $dob = str_replace('/', '-', $data['dob']);
            $data['dob'] = date('Y-m-d', strtotime($dob));
            $data['created_at'] = $currentTime;
            $data['updated_at'] = $currentTime;
            $data['body_id'] = $user->body_id;
            $newEnquiry = EnquiryForm::create($data);
            $now = Carbon::now();
	        $enquiry = EnquiryForm::findOrFail($newEnquiry->id);
            $bodyEnquiryCount = EnquiryForm::where('body_id',$enquiry->body_id)->count();
            $enquiryId = $now->year."-".str_pad($bodyEnquiryCount,4,"0",STR_PAD_LEFT);
            $enquiryInfo = $enquiry->update(['enquiry_number' => $enquiryId]);
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

    public function viewEnquiryFormWithoutLogin($schoolSlug=NULL){
        try{
            if($schoolSlug == 'gis' || $schoolSlug == 'gems'){
                return view('admin.enquiryCreateWithoutLogin')->with(compact('schoolSlug'));
            }else{
                return view('errors.404');
            }

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
            $now = Carbon::now();

            $enquiry = EnquiryForm::findOrFail($newEnquiry->id);
            $bodyEnquiryCount = EnquiryForm::where('body_id',$enquiry->body_id)->count();
            $enquiryId = $now->year."-".str_pad($bodyEnquiryCount,4,"0",STR_PAD_LEFT);
            $enquiryInfo = $enquiry->update(['enquiry_number' => $enquiryId]);
            TCPDF::AddPage();
            TCPDF::writeHTML(view('enquiry-pdf')->with(compact('newEnquiry','enquiryId'))->render());
            TCPDF::Output("Enquiry Form".date('Y-m-d_H_i_s').".pdf", 'D');

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
            $user = Auth::User();
          //  $userIds = User::where('body_id',$user->body_id)->whereNotNull('enquiry_id')->lists('enquiry_id');
            $enquiryData = EnquiryForm::orderBy('id','DESC')->where('body_id',$user->body_id)->get()->toArray();
            $masterEnquiry = array();
            foreach($enquiryData as $enquiry){
                $now = Carbon::now();
                $enquiryId = $now->year."-".str_pad($enquiry['id'],4,"0",STR_PAD_LEFT);
                $enquiryDetailView = "/edit-enquiry/".$enquiry['id'];
                $enquiryDetailCreateView = "/studentCreateEnquiry/".$enquiry['id'];
                $enquiry['form_no'] = $enquiry['enquiry_number'];
                $student = User::where('enquiry_id',$enquiry['id'])->first();
                $enquiry['action'] = "<a href ='$enquiryDetailView'>View</a>";
               /*if($student == null && $enquiry['final_status'] == 'pass') {
                    $enquiry['action'] = "<a href ='$enquiryDetailView'>View</a>" . " / " . "<a href ='$enquiryDetailCreateView'>Create</a>";
                } else {
                    $enquiry['action'] = "<a href ='$enquiryDetailView'>View</a>";
                }*/
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

        }catch(\Exception $e){
            $records = $e->getMessage();
        }
        return response()->json($records);
    }


    public function editEnquiryView(Request $request,$enquiryId){
        try{
            $enquiryInfo = EnquiryForm::where('id',$enquiryId)->first();
            $interviewUser = User::whereIn('role_id',[1,2])->get();
            $enquiryInfo->written_test_scheduled_on = Carbon::parse($enquiryInfo->written_test_scheduled_on)->format('d-m-Y G:i:s');
            $enquiryInfo->interview_scheduled_on = Carbon::parse($enquiryInfo->interview_scheduled_on)->format('d-m-Y h:i:s a/p');
            $enquiryInfo->dob = Carbon::parse($enquiryInfo->dob)->format('d-m-Y');
            return view('admin.enquiry.enquiry-edit')->with(compact('enquiryInfo','interviewUser'));
        }catch (\Exception $e){
            Log::critical('exception:'.$e->getMessage());
            abort(500,$e->getMessage());

        }
    }

    public function editEnquiry(Request $request,$enquiryId){
        try{
            $enquiryData = $request->all();
            $enquiryData['address'] = ltrim($enquiryData['address']);
            $enquiryData['written_test_remark'] = trim($enquiryData['written_test_remark']);
            $enquiryData['interview_remark'] = trim($enquiryData['interview_remark']);
            $enquiryData['document_remark'] = trim($enquiryData['document_remark']);
            $enquiry = EnquiryForm::findOrFail($enquiryId);
            $enquiryData['written_test_scheduled_on'] = Carbon::parse($enquiryData['written_test_scheduled_on'])->format('Y-m-d G:i:s');
            $enquiryData['interview_scheduled_on'] = Carbon::parse($enquiryData['interview_scheduled_on'])->format('Y-m-d G:i:s');
            $enquiryData['dob'] = Carbon::parse($enquiryData['dob'])->format('Y-m-d');
            $enquiryInfo = $enquiry->update($enquiryData);
            $newEnquiry = EnquiryForm::where('id',$enquiryId)->first();
            if(Session::has('enquiryId')){
                Session::put('enquiryId', $newEnquiry);
            }else{
                Session::set('enquiryId', $newEnquiry);
            }
            $message = 'Enquiry Updated successfully';
            $request->session()->flash('message-success', $message);
            return redirect('/manage');
        }catch (\Exception $e){
            Log::critical('exception:'.$e->getMessage());
            abort(500,$e->getMessage());

        }
    }


    public function printEnquiryForm($enquiryNumber){
        try{
            $now = Carbon::now();
            $newEnquiry = EnquiryForm::where('id',$enquiryNumber)->first();
            $enquiryId = $now->year."-".str_pad($enquiryNumber,4,"0",STR_PAD_LEFT);
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
}
