<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodyMarqueeDetails extends Model
{
    protected $table ='body_marquee_details';

    protected $fillable = ['body_id','marquee_1','marquee_2'];
}
