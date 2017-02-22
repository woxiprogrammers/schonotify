<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeConcessionTypes extends Model
{
    protected $table = "fee_concession_types";

    protected $fillable = ['fee_id','fee_concession_types'];
}
