<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamClassStructureRelation extends Model
{
    protected $table ='exam_class_structure_relation';

    protected $fillable = [ 'exam_subject_id','class_id' ];

    public function ExamSubStructureRelation()
    {
        return $this->belongsTo('App\ExamSubSubjectStructure','exam_subject_id');
    }
}
