<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodyDetails extends Model
{
    protected $table = 'body_details';

    protected $fillable = ['logo_name','email','contact_number','address','body_id','footer_message','header_message'];
}
