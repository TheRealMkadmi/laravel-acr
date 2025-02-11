<?php

namespace TheRealMkadmi\LaravelAcr\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TheRealMkadmi\LaravelAcr\LaravelAcr
 */
class LaravelAcr extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \TheRealMkadmi\LaravelAcr\LaravelAcr::class;
    }
}
