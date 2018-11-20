<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodyTestimonial extends Model
{
    protected $table = "body_testimonial";

    protected $fillable = ['body_id','image_name','description','is_active'];
}
