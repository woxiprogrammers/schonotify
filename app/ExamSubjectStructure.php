<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamSubjectStructure extends Model
{
    protected $table = "exam_subject_structure";

    protected $fillable = array('class_id','body_id','subject_name');
}
