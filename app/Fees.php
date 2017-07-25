<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    protected $table = "fees";

    protected $fillable=['fee_name','total_amount','year'];
}
