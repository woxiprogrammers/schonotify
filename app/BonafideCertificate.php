<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonafideCertificateTable extends Model
{
    protected $table = "bonafide_certificate_table";

    protected $fillable = ['grn','created_date','taluka','district','from_date','to_date'];
}
