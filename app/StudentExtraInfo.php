<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentExtraInfo extends Model
{
    protected $table = "students_extra_info";
    protected $fillable = ['grn','birth_place','nationality','religion','caste','category','communication_address','aadhar_number','blood_group','mother_tongue','other_language','highest_standard','academic_to','academic_from'];
}
