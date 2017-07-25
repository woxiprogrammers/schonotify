<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeInstallments extends Model
{
    protected $table = "fee_installments";

    protected $fillable = ['fee_id','installment_id','particulars_id','amount'];
}
