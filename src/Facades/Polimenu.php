<?php

namespace Detit\Polimenu\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Detit\Polimenu\Polimenu
 */
class Polimenu extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Detit\Polimenu\Polimenu::class;
    }
}
