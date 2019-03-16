<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamClassSubject extends Model
{
    protected $table = 'exam_class_subjects';

    protected $fillable = ['class_id','exam_id','subject_id'];
}
