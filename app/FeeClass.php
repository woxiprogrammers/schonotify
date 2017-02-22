<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeClass extends Model
{
    protected $table = "fee_classes";

    protected $fillable = ['fee_id','class_id','amount'];
}
