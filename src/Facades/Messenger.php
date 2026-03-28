<?php

namespace NettSite\Messenger\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NettSite\Messenger\Messenger
 */
class Messenger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \NettSite\Messenger\Messenger::class;
    }
}
