<?php

namespace Kangangga\Starsender\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kangangga\Starsender\Starsender
 */
class Starsender extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'starsender';
    }
}
