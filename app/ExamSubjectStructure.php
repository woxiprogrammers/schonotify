<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamSubjectStructure extends Model
{
    protected $table = "exam_subject_structure";

    protected $fillable = array('body_id','subject_name');

    public function ExamSubSubjectStructure(){
        return $this->belongsTo('App\ExamSubSubjectStructure','subject_id');
    }
}
