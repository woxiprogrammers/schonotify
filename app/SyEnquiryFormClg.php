<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SyEnquiryFormClg extends Model
{
    protected $table = "Sy_Enquiry_Form_Clg";

    protected $fillable = [
        'form_no','medium','first_name','middle_name','last_name','marks_obtained',
        'outOf_marks','percentage','board','caste','country','state','category','examination_year','date','mobile',
        'address','email','class_applied','diff_category','ssc_certificate','hsc_certificate','caste_certificate'];
}
