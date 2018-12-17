<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = 'games';

    public function getReleaseDateNaAttribute () {
        return date("F d", strtotime($this->attributes['release_date']));
    }
}
