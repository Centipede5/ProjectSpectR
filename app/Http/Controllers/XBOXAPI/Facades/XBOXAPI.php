<?php

namespace App\Http\Controllers\Facades;
namespace App\Http\Controllers\XBOXAPI\Facades;
use Illuminate\Support\Facades\Facade;

class XBOXAPI extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'xboxapi'; }
}