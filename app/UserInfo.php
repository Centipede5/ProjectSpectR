<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $fillable = [
        'bio',
        'social_meta',
        'ip_address',
        'updated_at'
    ];
}
