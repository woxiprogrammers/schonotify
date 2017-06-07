<?php
namespace App\Http\Controllers;
use App\EnquiryForm;
use App\EnquiryFormClg;
use App\category_types;
use App\diff_categories;
use App\ExtraCategories;
use App\CasteCategories;
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
            $categories=category_types::get()->toArray();
            $extra_categories=ExtraCategories::get()->toarray();
            return view('admin.enquiryCreate')->with(compact('categories','extra_categories'));
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
          $data = $request->all();
          $now = Carbon::now();
          $bodyEnquiryCount = (EnquiryFormClg:: select('id')->count())+1;
          $enquiryId = $now->year."-".str_pad($bodyEnquiryCount,4,"0",STR_PAD_LEFT);
          $data['form_no'] = $enquiryId;
          $data['medium'] = $data['medium'];
          $data['first_name'] = $data['first_name'];
          $data['middle_name'] = $data['middle_name'];
          $data['last_name'] = $data['last_name'];
          $data['marks_obtained'] = $data['marks_obtained'];
          $data['outOf_marks'] = $data['outOf_marks'];
          $data['percentage'] = ($data['marks_obtained'] / $data['outOf_marks'])*100;
          $data['examination_year'] = $data['examination_year'];
          $data['board'] = $data['board'];
          $data['state'] = $data['state'];
          $data['email'] = $data['email'];
          $data['diff_category'] = $data['diff_categories'];
          $data['caste'] = $data['caste'];
          $data['category'] = $data['category'];
          $data['date'] = date('d/m/Y');
          $data['mobile'] = $data['mobile_number'];
          $data['address'] = $data['address'];
          $data['class_applied'] = $data['class_applied'];
          $newEnquiry = EnquiryFormClg::create($data);
          $newEnquiry['category'] = CasteCategories::where('slug',$newEnquiry['category'])->pluck('caste_category');
          $newEnquiry['diff_category'] = ExtraCategories::where('slug',$newEnquiry['diff_category'])->pluck('categories');
          TCPDF::AddPage();
          TCPDF::writeHTML(view('enquiry-pdf')->with(compact('newEnquiry'))->render());
          TCPDF::Output("First Year Waiting List Form ".date('Y-m-d_H_i_s').".pdf", 'D');
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
          $categories=category_types::get()->toArray();
          $extra_categories=ExtraCategories::get()->toarray();
          return view('admin.enquiryCreateWithoutLogin')->with(compact('categories','extra_categories'));
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
            $now = Carbon::now();
            $bodyEnquiryCount = (EnquiryFormClg:: select('id')->count())+1;
            $enquiryId = $now->year."-".str_pad($bodyEnquiryCount,4,"0",STR_PAD_LEFT);
            $data['form_no'] = $enquiryId;
            $data['medium'] = $data['medium'];
            $data['first_name'] = $data['first_name'];
            $data['middle_name'] = $data['middle_name'];
            $data['last_name'] = $data['last_name'];
            $data['marks_obtained'] = $data['marks_obtained'];
            $data['outOf_marks'] = $data['outOf_marks'];
            $data['percentage'] = ($data['marks_obtained'] / $data['outOf_marks'])*100;
            $data['examination_year'] = $data['examination_year'];
            $data['board'] = $data['board'];
            $data['state'] = $data['state'];
            $data['caste'] = $data['caste'];
            $data['email'] = $data['email'];
            $data['diff_category'] = $data['diff_categories'];
            $data['category'] = $data['category'];
            $data['date'] = date('d/m/Y');
            $data['mobile'] = $data['mobile_number'];
            $data['address'] = $data['address'];
            $data['class_applied'] = $data['class_applied'];
            $newEnquiry = EnquiryFormClg::create($data);
            $newEnquiry['category'] = CasteCategories::where('slug',$newEnquiry['category'])->pluck('caste_category');
            $newEnquiry['diff_category'] = ExtraCategories::where('slug',$newEnquiry['diff_category'])->pluck('categories');
            TCPDF::AddPage();
            TCPDF::writeHTML(view('enquiry-pdf')->with(compact('newEnquiry'))->render());
            TCPDF::Output("First Year Waiting List Form ".date('Y-m-d_H_i_s').".pdf", 'D');
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
            $enquiryData = EnquiryFormClg::orderBy('id','DESC')->get()->toArray();
            $masterEnquiry = array();
            foreach($enquiryData as $enquiry){
                $now = Carbon::now();
                $enquiryDetailView = "/edit-enquiry/".$enquiry['id'];
                $enquiry['form_no'] = $enquiry['form_no'];
                $enquiry['action'] = "<a href ='$enquiryDetailView'>View</a>";
                $enquiry['result']= $enquiry['final_status'];
                $enquiry['first_name'] = $enquiry['first_name'];
                $enquiry['last_name'] = $enquiry['last_name'];
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
            $categories=category_types::get()->toArray();
            $enquiryInfo = EnquiryFormClg::where('id',$enquiryId)->first();
            $extra_categories=ExtraCategories::get()->toarray();
            return view('admin.enquiry.enquiry-edit')->with(compact('enquiryInfo','categories','extra_categories'));
        }catch (\Exception $e){
            Log::critical('exception:'.$e->getMessage());
            abort(500,$e->getMessage());
        }
    }
    public function editEnquiry(Request $request){
        try{
        $enquiryData = $request->all();
            $enquiryData['address'] = ltrim($enquiryData['address']);
            $enquiryData['medium'] = trim($enquiryData['medium']);
            $enquiryData['first_name'] = trim($enquiryData['first_name']);
            $enquiryData['middle_name'] = trim($enquiryData['middle_name']);
            $enquiryData['last_name'] = trim($enquiryData['last_name']);
            $enquiryData['marks_obtained'] = $enquiryData['marks_obtained'];
            $enquiryData['outOf_marks'] = $enquiryData['outOf_marks'];
            $enquiryData['board'] = $enquiryData['board'];
            $enquiryData['state'] = $enquiryData['state'];
            $enquiryData['caste'] = $enquiryData['caste'];
            $enquiryData['email'] = $enquiryData['email'];
            $enquiryData['diff_category'] = $enquiryData['diff_category'];
            $enquiryData['category'] = $enquiryData['category'];
            $enquiryData['caste'] = $enquiryData['caste'];
            $enquiryData['examination_year'] = $enquiryData['examination_year'];
            $enquiryData['mobile'] = $enquiryData['mobile'];
            if(!empty($enquiryData['final_status'])){
            $enquiryData['final_status'] = $enquiryData['final_status'];
            }
            $enquiryInfo = EnquiryFormClg::where('id',$enquiryData['id'])->update($enquiryData);
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
            TCPdf::Output("First Year Waiting List Form ".date('Y-m-d_H_i_s').".pdf", 'D');
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
