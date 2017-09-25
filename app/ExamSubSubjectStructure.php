<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamSubSubjectStructure extends Model
{
    protected $table = "exam_sub_subject_structure";

    protected $fillable = array('subject_id','sub_subject_name');

    public function ExamClassStructureRelation()
    {
        return $this->hasMany('App\ExamClassStructureRelation');
    }
    public function ExamSubjectStructure()
    {
       return $this->belongsTo('App\ExamSubjectStructure','subject_id');
    }
}
