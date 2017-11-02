<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamTerms extends Model
{
    protected $table = "exam_terms";

    protected $fillable = array('term_name','exam_structure_id');

    public function ExamSubSubjectStructure(){
        return $this->belongsTo('App\ExamSubSubjectStructure','exam_subject_id');
    }
}
