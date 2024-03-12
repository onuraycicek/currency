<?php

namespace Onuraycicek\Currency\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Onuraycicek\Currency\Currency
 */
class Currency extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Onuraycicek\Currency\Currency::class;
    }
}
