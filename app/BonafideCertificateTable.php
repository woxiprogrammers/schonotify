<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonafideCertificateTable extends Model
{
    protected $table = "bonafide_certificate_table";

    protected $fillable = ['grn','taluka','district','from_date','to_date'];
}
