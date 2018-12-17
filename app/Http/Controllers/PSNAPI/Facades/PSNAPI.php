<?php

namespace App\Http\Controllers\Facades;
namespace App\Http\Controllers\PSNAPI\Facades;
use Illuminate\Support\Facades\Facade;

class PSNAPI extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'psnapi'; }
}