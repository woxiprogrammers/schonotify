<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryForm extends Model
{
    protected $table = "enquiry_form";

    protected $fillable = [
        'guardian_first_name','guardian_middle_name','guardian_last_name','student_first_name','student_middle_name','student_last_name',
        'dob','current_class','school_name','admission_to_class','mobile_number','address','created_at','updated_at','email','written_test_scheduled_on',
        'written_test_conducted_by','written_test_status','written_test_remark','interview_scheduled_on','interview_conducted_by',
        'interview_status','interview_remark','document_status','document_remark','alt_contact_no','final_status' ];
}
