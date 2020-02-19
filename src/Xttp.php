<?php

namespace JohnathanSmith\XttpLaravel;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \JohnathanSmith\XttpLaravel\XttpLaravel
 */
class Xttp extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xttp';
    }
}
