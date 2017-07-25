<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionTypes extends Model
{
    protected $table="transaction_types";
    protected $fillable = ['transaction_type','slug'];
}
