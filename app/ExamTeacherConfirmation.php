<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamTeacherConfirmation extends Model
{
    protected $table = "exam_teacher_confirmation";

    protected $fillable = array('teacher_id','class_id','exam_structure_id','status','remark');
}
