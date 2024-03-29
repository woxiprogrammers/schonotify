<?php

namespace App\Http\Controllers;

use App\Body;
use App\EnquiryForm;
use App\ParentExtraInfo;
use App\StudentDocument;
use App\StudentDocumentMaster;
use App\StudentExtraInfo;
use App\StudentFamily;
use App\StudentHobby;
use App\StudentPreviousSchool;
use App\StudentSibling;
use App\StudentSpecialAptitude;
use App\SubmittedDocuments;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;
use Elibyy\TCPDF\Facades\TCPDF;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
    }
    public function getStudentRegistrationView(Request $request,$id){
        try{
            $enquiryInfo = EnquiryForm::where('enquiry_number',$id)->first();
            return view('registration.student-registration')->with(compact('enquiryInfo'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function getCheckEnquiryView($schoolSlug =NULL){
        try{
            if($schoolSlug == 'gis' || $schoolSlug == 'gems'){
                return view('registration.check-enquiry')->with(compact('schoolSlug'));
            }else{
                return view('errors.404');
            }
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
            if($request->bodySlug == 'gis'){
                $body_id = 1 ;
                $bodyInfo = [
                            'name' => 'Ganesh International School, Chikhali',
                            'slug' => 'gis'
                ];
            }elseif($request->bodySlug == 'gems'){
                $body_id = 2 ;
                $bodyInfo = [
                    'name' => 'Ganesh English Medium School, Dapodi',
                    'slug' => 'gems'
                ];
            }
            $enquiryInfo = EnquiryForm::where('enquiry_number',$request->enquiry_number)->where('body_id',$body_id)->first();
            $userRegister = User::where('enquiry_id',$enquiryInfo['id'])->first();
            $bodies = Body::all();
            $documents = StudentDocumentMaster::all();
            if($userRegister!=null){
                return view('registration.download-admission-form')->with(compact('enquiryInfo','bodies','documents','bodyInfo'));
            }else{
                return view('registration.student-registration')->with(compact('enquiryInfo','bodies','documents'));
            }

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

    public function getStudentParents(){
        $userInformation =array();
        $userData = User::where('role_id',4)->get();
        $userList = $userData->toArray();
        foreach($userList as $user){
            $parentInfo = ParentExtraInfo::where('parent_id',$user['id'])->first();
            $parentInfo['userId'] = $user['id'];
            $userInfo['data'] = $parentInfo;
            $userInfo['value'] = $user["email"];
            array_push($userInformation,$userInfo);
        }
        return $userInformation;
    }

    public function registerStudent(Request $request)
    {
        $data = $request->all();
        $document=$request->documents;
        if(!empty($document)){
            $document=implode(",",$document);
        }
        if(!empty($data)){
            if(isset($data['dob'])){
                $dob = $data['dob'];
            }else{
                $dob = $data['mobile'];
            }
            $unique_user_string = strtolower($data['firstName'] . $data['lastName'] . $dob);
            $username = ucfirst(substr($data['firstName'], 0, 1)) . ucfirst($data['lastName']) . crc32($unique_user_string);
            $userData = new User;
            $userData->first_name = $data['firstName'];
            $userData->last_name = $data['lastName'];
            $userData->username = $username;
            $userData->password = bcrypt($data['password']);
            $userData->gender = $data['gender'];
            $userData->mobile = $data['mobile'];
            $userData->alternate_number = $data['alt_number'];
            $userData->role_id = $data['role'];
            $userData->avatar = 'default-user.jpg';
            $userData->is_active = 0;
            $userData->is_displayed = 1;
            $userData->remember_token = csrf_token().'_'.time();
            $userData->confirmation_code = str_random(30);
            $userData->body_id = $data['body'];
            $userData->created_at = Carbon::now();
            $userData->updated_at = Carbon::now();
            if($data['role_name']== 'student'){
                $userData->address = $data['address'];
                $date = str_replace('/', '-', $data['dob']);
                $userData->birth_date = date('Y-m-d', strtotime($date));
                $userData->middle_name = $data['middleName'];
                $userData->enquiry_id = $data['enquiry_id'];
                if(isset($data['division'])){
                    $userData = array_add($userData, 'division_id', $data['division']);
                }
                if(!empty($data['parent_id'])){
                    $userData = array_add($userData, 'parent_id', $data['parent_id']);
                    $parent=User::where('id',$data['parent_id'])->select('is_active')->first();
                    if($parent->is_active == 1){
                        $userData->is_active = 1;
                    }
                }else{
                    if(isset($data['parent_communication_address'])){
                        $communication_address_parent = $data['permanent_address'];
                    }else{
                        $communication_address_parent = $data['communication_address_parent'];
                    }
                    $unique_user_string = strtolower($data['father_first_name'] . $data['father_last_name'] . $data['dob']);
                    $username = ucfirst(substr($data['father_first_name'], 0, 1)) . ucfirst($data['father_last_name']) . crc32($unique_user_string);
                    $parentData= new User;
                    $parentData->first_name = $data['father_first_name'];
                    $parentData->last_name = $data['father_last_name'];
                    $parentData->middle_name = $data['father_middle_name'];
                    $parentData->username = $username;
                    $parentData->password = bcrypt($data['password']);
                    $parentData->gender = $data['gender'];
                    $parentData->address = $communication_address_parent;
                    $parentData->mobile = $data['father_contact'];
                    $parentData->email = $data['parent_name'];
                    $parentData->role_id = 4;
                    $parentData->avatar = 'default-user.jpg';
                    $parentData->is_active = 0;
                    $parentData->remember_token = csrf_token().'_'.time();
                    $parentData->confirmation_code = str_random(30);
                    $parentData->body_id = $data['body'];
                    $parentData->created_at = Carbon::now();
                    $parentData->updated_at = Carbon::now();
                    $parentData->save();
                    $parnetId = $parentData->id;
                    $familyInfo = $request->only('father_first_name','father_middle_name','father_last_name','father_occupation','father_income','father_contact','mother_first_name','mother_middle_name','mother_last_name','mother_occupation','mother_income','mother_contact','parent_email','permanent_address');
                    $familyInfo['communication_address'] = $communication_address_parent;
                    $familyInfo['parent_id'] = $parnetId;
                    $familyInfo['created_at'] = Carbon::now();
                    $familyInfo['updated_at'] = Carbon::now();
                    ParentExtraInfo::insert($familyInfo);
                    $userData = array_add($userData, 'parent_id', $parnetId);
                }
                $userData->save();
                $LastInsertId = $userData->id;

                if(isset($data['hobbies'])){
                    $hobbyInfo = array();
                    $hobbies = $data['hobbies'];
                    foreach($hobbies as $hobby){
                        if($hobby != ''){
                            $hobbyInfo['student_id'] = $LastInsertId;
                            $hobbyInfo['hobby'] = $hobby;
                            $hobbyInfo['created_at'] = Carbon::now();
                            $hobbyInfo['updated_at'] = Carbon::now();
                            StudentHobby::insert($hobbyInfo);
                        }

                    }
                }
                if(isset($data['special_aptitude'])){
                    $aptitudeInfo = array();
                    $aptitudes = $data['special_aptitude'];
                    foreach($aptitudes as $aptitude){
                        if($aptitude['test'] != '' && $aptitude != ''){
                            $aptitudeInfo['student_id'] = $LastInsertId;
                            $aptitudeInfo['special_aptitude'] = $aptitude['test'];
                            $aptitudeInfo['score'] = $aptitude['score'];
                            $aptitudeInfo['created_at'] = Carbon::now();
                            $aptitudeInfo['updated_at'] = Carbon::now();
                            StudentSpecialAptitude::insert($aptitudeInfo);
                        }
                    }
                }
                $previousSchool = $request->only('school_name','udise_no','city','medium_of_instruction','board_examination','grades');
                $previousSchool['student_id'] = $LastInsertId;
                $previousSchool['created_at'] = Carbon::now();
                $previousSchool['updated_at'] = Carbon::now();
                StudentPreviousSchool::insert($previousSchool);
                if(isset($data['sibling'])){
                    $siblingInfo = array();
                    $siblings = $data['sibling'];
                    foreach($siblings as $sibling){
                        if($sibling['name'] != '' && $sibling['age'] != ''){
                            $siblingInfo['student_id'] = $LastInsertId;
                            $siblingInfo['name'] = $sibling['name'];
                            $siblingInfo['age'] = $sibling['age'];
                            $siblingInfo['created_at'] = Carbon::now();
                            $siblingInfo['updated_at'] = Carbon::now();
                            StudentSibling::insert($siblingInfo);
                        }

                    }
                }
                if(isset($data['student_communication_address'])){
                    $student_communication_address = $data['address'];
                }else{
                    $student_communication_address = $data['communication_address'];
                }
                $extraInfo = $request->only('grn','birth_place','nationality','religion','caste','category','aadhar_number','blood_group','mother_tongue','other_language','highest_standard','academic_to','academic_from');
                $extraInfo['communication_address']=$student_communication_address;
                $extraInfo['student_id'] = $LastInsertId;
                $extraInfo['created_at'] = Carbon::now();
                $extraInfo['updated_at'] = Carbon::now();
                $enquiry_id=StudentExtraInfo::insertGetId($extraInfo);
                if(isset($document)){
                    $documentData['student_id']=$LastInsertId;
                    $documentData['submitted_documents']=$document;
                    $query=SubmittedDocuments::insert($documentData);
                }
                if(isset($data['upload_doc'])){
                    $i =1;
                    foreach($data['upload_doc'] as $doc){

                        if($doc != null){
                            $image = $doc;
                            $name = $doc->getClientOriginalName();
                            $filename = time()."_".$name;
                            $path1 = public_path('uploads/student_documents/'.$LastInsertId);
                            if (! file_exists($path1)) {
                                File::makeDirectory('uploads/student_documents/'.$LastInsertId, $mode = 0777, true, true);
                            }
                            $image->move($path1,$filename);
                            $studentDocument['document'] = $filename;
                            $studentDocument['student_id'] = $LastInsertId;
                            $studentDocument['document_id'] = $i;
                            $studentDocument['created_at'] = Carbon::now();
                            $studentDocument['updated_at'] = Carbon::now();
                            StudentDocument::insert($studentDocument);
                        }
                        $i++;
                    }
                }
            }
            return $request;
        }else{
            return "Please Insert Data";
        }
    }


    public function printAdmissionForm($enquiryNumber){
        try{
            $newEnquiry = EnquiryForm::where('id',$enquiryNumber)->with('user')->first();
            $documents = StudentDocumentMaster::all();
            $studentExtraInfo = $newEnquiry->user->studentExtraInfo;
            $studentFamilyInfo = ParentExtraInfo::where('parent_id',$newEnquiry->user->parent_id)->first();
            $parentEmail = User::where('id',$newEnquiry->user->parent_id)->first();
            $studentFamilyInfo['parent_email'] = $parentEmail['email'];
            $studentSiblings = $newEnquiry->user->StudentSibling;
            $previousSchool = $newEnquiry->user->StudentPreviousSchool;
            $studentSpecialAptitudes = $newEnquiry->user->StudentSpecialAptitude;
            $studentHobbies = $newEnquiry->user->StudentHobby;
            $studentDocuments = StudentDocument::where('student_id',$newEnquiry->user->id)->lists('document_id')->toArray();
            //return view('registration.admission-pdf')->with(compact('newEnquiry','studentExtraInfo','studentFamilyInfo','studentSiblings','previousSchool','studentSpecialAptitudes','studentHobbies','documents','studentDocuments'));
            TCPDF::AddPage();
            TCPDF::writeHTML(view('registration.admission-pdf')->with(compact('newEnquiry','studentExtraInfo','studentFamilyInfo','studentSiblings','previousSchool','studentSpecialAptitudes','studentHobbies','documents','studentDocuments'))->render());
            TCPDF::Output("Admission Form".date('Y-m-d_H_i_s').".pdf", 'D');


        }catch(\Exception $e){
            $data = [
                'action' => 'print Admission Form',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }
    }

    public function checkAadharNumber(Request $request){
        try{
            $aadharCount= StudentExtraInfo::where('aadhar_number',$request->aadhar_number)->count();
            if($aadharCount > 0){
                return 'false';
            }else{
                return 'true';
            }
        }catch(\Exception $e){
            $data = [
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }
    }

}
