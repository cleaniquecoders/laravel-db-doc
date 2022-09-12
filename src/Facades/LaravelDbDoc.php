<?php

namespace Bekwoh\LaravelDbDoc\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bekwoh\LaravelDbDoc\LaravelDbDoc
 */
class LaravelDbDoc extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Bekwoh\LaravelDbDoc\LaravelDbDoc::class;
    }
}
