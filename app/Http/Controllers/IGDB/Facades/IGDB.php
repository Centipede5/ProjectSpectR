<?php

namespace App\Http\Controllers\Facades;
namespace App\Http\Controllers\IGDB\Facades;
use Illuminate\Support\Facades\Facade;

class IGDB extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'igdb'; }
}