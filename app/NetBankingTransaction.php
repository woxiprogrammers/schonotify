<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NetBankingTransaction extends Model
{
    protected $table = 'net_banking_transactions';

    protected $fillable = ['transactions_count'];
}
