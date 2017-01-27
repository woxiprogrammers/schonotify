<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectClassDivision extends Model
{
    protected $table = 'division_subjects';

    protected $guarded = [
        'id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
