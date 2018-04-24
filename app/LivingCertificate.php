<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LivingCertificate extends Model
{
    protected $table ="living_certificate";

    protected $fillable = ['grn','aadhar_number','last_school_attented','date_of_admission','progress','conduct','date_of_leaving','standard_in_which_studying','reason','remark'];
}
