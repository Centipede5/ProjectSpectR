<?php

namespace App\Http\Controllers\Facades;
namespace App\Http\Controllers\NINAPI\Facades;
use Illuminate\Support\Facades\Facade;

class NINAPI extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'ninapi'; }
}