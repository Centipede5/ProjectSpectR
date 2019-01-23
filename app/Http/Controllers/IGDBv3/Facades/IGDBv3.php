<?php

namespace App\Http\Controllers\Facades;
namespace App\Http\Controllers\IGDBv3\Facades;
use Illuminate\Support\Facades\Facade;

class IGDBv3 extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'igdbv3'; }
}