<?php

namespace CleaniqueCoders\LaravelDbDoc\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CleaniqueCoders\LaravelDbDoc\LaravelDbDoc
 */
class LaravelDbDoc extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \CleaniqueCoders\LaravelDbDoc\LaravelDbDoc::class;
    }
}
