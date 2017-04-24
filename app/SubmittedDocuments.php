<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubmittedDocuments extends Model
{
    protected $table="documents_submitted";
    protected $fillable = ['student_id','submitted_documents'];
}
