<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodyVisitorCounts extends Model
{
    protected $table ='visitor_counts';

    protected $fillable = ['body_id','counter'];
}
