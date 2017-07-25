<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CASTECONCESSION extends Model
{
    protected $table = "caste_concession";

    protected $fillable = ['fee_id','caste_id','concession_amount'];
}
