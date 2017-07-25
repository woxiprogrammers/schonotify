<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeConcessionAmount extends Model
{
    protected $table = "fee_concession_amounts";
    protected $fillable = ['fee_id','concession_type','amount'];
}
