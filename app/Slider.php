<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'slider_slug', 'slide_title', 'slide_description' , 'button_text', 'image', 'order', 'active', 'start_date', 'end_date'
    ];
}
