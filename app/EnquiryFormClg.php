<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnquiryFormClg extends Model
{
  protected $table = "enquiry_form_clg";

  protected $fillable = [
      'form_no','medium','first_name','middle_name','last_name','marks_obtained',
      'outOf_marks','percentage','board','caste','country','state','category','examination_year','date','mobile',
      'address','email','class_applied','diff_category'];

}
