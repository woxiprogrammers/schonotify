<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectClass extends Model
{
    protected $table = "subject_classes";

    protected $fillable = array('class_id','subject_id');
}
