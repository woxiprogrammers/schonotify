<?php

namespace App\Http\Controllers\SyEnquiry;

use App\CasteCategories;
use App\category_types;
use App\EnquiryForm;
use App\EnquiryFormClg;
use App\ExtraCategories;
use App\SyEnquiryFormClg;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class EnquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
    }
    public function viewEnquiryList(){
        try{
            $classname = Input::get('classname');
            $status = Input::get('status');
            $user = Auth::User();

            if ($status != "null") {
                $enquiryData = SyEnquiryFormClg::where('class_applied',$classname)
                    ->where('final_status',$status)->orderBy('id','DESC')->get()->toArray();
                if ($status == 'pass') {
                    $status = 'Approve';
                } else {
                    $status = 'Disapprove';
                }
            } else {
                $enquiryData = SyEnquiryFormClg::where('class_applied',$classname)
                    ->where('final_status', NULL)->orderBy('id','DESC')->get()->toArray();
                $status = 'Unapprove';
            }

            $masterEnquiry = array();
            foreach($enquiryData as $enquiry){
                $now = Carbon::now();
                $enquiryDetailView = "/syEnquiry/edit-enquiry/".$enquiry['id'];
                $enquiry['form_no'] = $enquiry['form_no'];
                $enquiry['action'] = "<a href ='$enquiryDetailView'>View</a>";
                $enquiry['result']= $enquiry['final_status'];
                $enquiry['first_name'] = $enquiry['first_name'];
                $enquiry['last_name'] = $enquiry['last_name'];
                array_push($masterEnquiry,$enquiry);
            }
            return view('admin.enquiry.SyEnquiry.listing')->with(compact('masterEnquiry','classname', 'status'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }
    public function viewEnquiryForm(){
        try{
            //$categories=category_types::get()->toArray();
            //$extra_categories=ExtraCategories::get()->toarray();
            $categories=category_types::select('caste_category as name','slug')->get()->toArray();
            return view('admin.enquiry.SyEnquiry.syEnquiryCreate')->with(compact('categories'));
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
            $data = $request->except('ssc_certificate','hsc_certificate','caste_certificate');
            $now = Carbon::now();
            $bodyEnquiryCount = (SyEnquiryFormClg:: select('id')->count())+1;
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
            $data['category'] = $data['category'];
            $data['date'] = date('d/m/Y');
            $data['mobile'] = $data['mobile_number'];
            $data['address'] = $data['address'];
            $data['class_applied'] = $data['class_applied'];
            $newEnquiry = SyEnquiryFormClg::create($data);
            $enquiryFormFolderPath = public_path().env('SY_ENQUIRY_FORM_UPLOAD');
            $formFolderName = sha1($newEnquiry->id);
            if($request->hasFile('ssc_certificate')){
                $formUploadPath = $enquiryFormFolderPath.DIRECTORY_SEPARATOR.$formFolderName;
                if(!file_exists($formUploadPath)){
                    File::makeDirectory($formUploadPath, $mode = 0777, true, true);
                }
                $extension = $request->file('ssc_certificate')->getClientOriginalExtension();
                $filename = sha1('SSC_CERTIFICATE_'.$newEnquiry->id).'.'.$extension;
                $request->file('ssc_certificate')->move($formUploadPath,$filename);
                SyEnquiryFormClg::where('id', $newEnquiry->id)->update(['ssc_certificate' => $filename]);
            }
            if($request->hasFile('hsc_certificate')){
                $formUploadPath = $enquiryFormFolderPath.DIRECTORY_SEPARATOR.$formFolderName;
                if(!file_exists($formUploadPath)){
                    File::makeDirectory($formUploadPath, $mode = 0777, true, true);
                }
                $extension = $request->file('hsc_certificate')->getClientOriginalExtension();
                $filename = sha1('HSC_CERTIFICATE_'.$newEnquiry->id).'.'.$extension;
                $request->file('hsc_certificate')->move($formUploadPath,$filename);
                SyEnquiryFormClg::where('id', $newEnquiry->id)->update(['hsc_certificate' => $filename]);
            }
            if($request->hasFile('caste_certificate')){
                $formUploadPath = $enquiryFormFolderPath.DIRECTORY_SEPARATOR.$formFolderName;
                if(!file_exists($formUploadPath)){
                    File::makeDirectory($formUploadPath, $mode = 0777, true, true);
                }
                $extension = $request->file('caste_certificate')->getClientOriginalExtension();
                $filename = sha1('CASTE_CERTIFICATE_'.$newEnquiry->id).'.'.$extension;
                $request->file('caste_certificate')->move($formUploadPath,$filename);
                SyEnquiryFormClg::where('id', $newEnquiry->id)->update(['caste_certificate' => $filename]);
            } else {
                SyEnquiryFormClg::where('id', $newEnquiry->id)->update(['caste_certificate' => NULL]);
            }

            $newEnquiry['category'] = CasteCategories::where('slug',$newEnquiry['category'])->pluck('caste_category');
            TCPDF::AddPage();
            TCPDF::writeHTML(view('enquiry-pdf')->with(compact('newEnquiry'))->render());
            TCPDF::Output("Second Year Waiting List Form ".date('Y-m-d_H_i_s').".pdf", 'D');
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
            $categories=category_types::select('caste_category as name','slug')->get()->toArray();
            return view('admin.enquiry.SyEnquiry.enquiryCreateWithoutLogin')->with(compact('categories'));
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
            $data = $request->except('ssc_certificate','hsc_certificate','caste_certificate');
            $now = Carbon::now();
            $bodyEnquiryCount = (SyEnquiryFormClg:: select('id')->count())+1;
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
            $data['category'] = $data['category'];
            $data['date'] = date('d/m/Y');
            $data['mobile'] = $data['mobile_number'];
            $data['address'] = $data['address'];
            $data['class_applied'] = $data['class_applied'];
            $newEnquiry = SyEnquiryFormClg::create($data);
            $enquiryFormFolderPath = public_path().env('SY_ENQUIRY_FORM_UPLOAD');
            $formFolderName = sha1($newEnquiry->id);
            if($request->hasFile('ssc_certificate')){
                $formUploadPath = $enquiryFormFolderPath.DIRECTORY_SEPARATOR.$formFolderName;
                if(!file_exists($formUploadPath)){
                    File::makeDirectory($formUploadPath, $mode = 0777, true, true);
                }
                $extension = $request->file('ssc_certificate')->getClientOriginalExtension();
                $filename = sha1('SSC_CERTIFICATE_'.$newEnquiry->id).'.'.$extension;
                $request->file('ssc_certificate')->move($formUploadPath,$filename);
                SyEnquiryFormClg::where('id', $newEnquiry->id)->update(['ssc_certificate' => $filename]);
            }
            if($request->hasFile('hsc_certificate')){
                $formUploadPath = $enquiryFormFolderPath.DIRECTORY_SEPARATOR.$formFolderName;
                if(!file_exists($formUploadPath)){
                    File::makeDirectory($formUploadPath, $mode = 0777, true, true);
                }
                $extension = $request->file('hsc_certificate')->getClientOriginalExtension();
                $filename = sha1('HSC_CERTIFICATE_'.$newEnquiry->id).'.'.$extension;
                $request->file('hsc_certificate')->move($formUploadPath,$filename);
                SyEnquiryFormClg::where('id', $newEnquiry->id)->update(['hsc_certificate' => $filename]);
            }
            if($request->hasFile('caste_certificate')){
                $formUploadPath = $enquiryFormFolderPath.DIRECTORY_SEPARATOR.$formFolderName;
                if(!file_exists($formUploadPath)){
                    File::makeDirectory($formUploadPath, $mode = 0777, true, true);
                }
                $extension = $request->file('caste_certificate')->getClientOriginalExtension();
                $filename = sha1('CASTE_CERTIFICATE_'.$newEnquiry->id).'.'.$extension;
                $request->file('caste_certificate')->move($formUploadPath,$filename);
                SyEnquiryFormClg::where('id', $newEnquiry->id)->update(['caste_certificate' => $filename]);
            } else {
                SyEnquiryFormClg::where('id', $newEnquiry->id)->update(['caste_certificate' => NULL]);
            }
            $newEnquiry['category'] = CasteCategories::where('slug',$newEnquiry['category'])->pluck('caste_category');
            TCPDF::AddPage();
            TCPDF::writeHTML(view('enquiry-pdf')->with(compact('newEnquiry'))->render());
            TCPDF::Output("Second Year Waiting List Form ".date('Y-m-d_H_i_s').".pdf", 'D');
            return Redirect::back();
        }catch(\Exception $e){
            $data = [
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }
    }
    public function enquiryListing(Request $request){
        try{
            $enquiryData = EnquiryForm::all();
            return view('admin.enquiry.SyEnquiry.listing')->with('results',$enquiryData);
        }catch(\Exception $e){
            $records = $e->getMessage();
        }
        return response()->json($records);
    }
    public function getCheckEnquiryView($schoolSlug =NULL){
        try{
            return view('registration.syRegistration.check-enquiry')->with(compact('schoolSlug'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }
    public function checkEnquiry(Request $request){
        try{
            $body_id = NULL;
            if($request->bodySlug == 'gis'){
                $body_id = 1 ;
            }elseif($request->bodySlug == 'gems'){
                $body_id = 2 ;
            }
            if($body_id != NULL){
                $enquiryCount = EnquiryForm::where('final_status','pass')->where('enquiry_number',$request->enquiry_number)->where('body_id',$body_id)->count();
                if($enquiryCount == 1){
                    return 'true';
                } else {
                    return 'false';
                }
            }else{
                return 'false';
            }
        }catch(\Exception $e){
            $data = [
                'input_params' => $request->all(),
                'action' => 'Check student enquiry',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }
    }
    public function redirectToRegistration(Request $request){
        try{
            $enquiryInfo = SyEnquiryFormClg::where('form_no',$request->enquiry_number)->first();
            return view('registration.syRegistration.download-admission-form')->with(compact('enquiryInfo'));
        }catch(\Exception $e){
            $data = [
                'input_params' => $request->all(),
                'action' => 'redirect To Registration',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }
    }
    public function printAdmissionForm($enquiryNumber){
        try{
            $newEnquiry = SyEnquiryFormClg::where('id',$enquiryNumber)->first();
            TCPDF::AddPage();
            TCPDF::writeHTML(view('enquiry-pdf')->with(compact('newEnquiry','studentExtraInfo','studentFamilyInfo','studentSiblings','previousSchool','studentSpecialAptitudes','studentHobbies','documents','studentDocuments'))->render());
            TCPDF::Output("Second Year Waiting List Form ".date('Y-m-d_H_i_s').".pdf", 'D');
        }catch(\Exception $e){
            $data = [
                'action' => 'print Admission Form',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }
    }
    public function editEnquiryView(Request $request,$enquiryId){
        try{
            $categories=category_types::get()->toArray();
            $enquiryInfo = SyEnquiryFormClg::where('id',$enquiryId)->first();
            $extra_categories=ExtraCategories::get()->toarray();
            return view('admin.enquiry.SyEnquiry.enquiry-edit')->with(compact('enquiryInfo','categories','extra_categories'));
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
            $enquiryData['diff_category'] = NULL;
            $enquiryData['category'] = $enquiryData['category'];
            $enquiryData['caste'] = $enquiryData['caste'];
            $enquiryData['examination_year'] = $enquiryData['examination_year'];
            $enquiryData['mobile'] = $enquiryData['mobile'];
            if(!empty($enquiryData['final_status'])){
                $enquiryData['final_status'] = $enquiryData['final_status'];
            }
            $enquiryInfo = SyEnquiryFormClg::where('id',$enquiryData['id'])->update($enquiryData);
            $message = 'Enquiry Updated successfully';
            $request->session()->flash('message-success', $message);
            return redirect('/syEnquiry/manage/?classname=SYBCOM&status=pass');
        }catch (\Exception $e){
            Log::critical('exception:'.$e->getMessage());
            abort(500,$e->getMessage());
        }
    }
}
