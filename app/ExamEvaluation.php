<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamEvaluation extends Model
{
    protected $table = 'exam_evaluation';

    protected $fillable = ['exam_name','slug','status'];
}
