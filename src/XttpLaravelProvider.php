<?php

namespace JohnathanSmith\XttpLaravel;

use Illuminate\Support\ServiceProvider;
use JohnathanSmith\Xttp\HandlesXttp;
use JohnathanSmith\Xttp\HandlesXttpCookies;
use JohnathanSmith\Xttp\MakesXttpPending;
use JohnathanSmith\Xttp\ProcessesXttpRequests;
use JohnathanSmith\Xttp\Xttp as XttpBase;
use JohnathanSmith\Xttp\XttpCookies;
use JohnathanSmith\Xttp\XttpPending;
use JohnathanSmith\Xttp\XttpProcessor;

class XttpLaravelProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MakesXttpPending::class, XttpPending::class);

        $this->app->bind(HandlesXttpCookies::class, XttpCookies::class);

        $this->app->bind(ProcessesXttpRequests::class, XttpProcessor::class);

        $this->app->bind(HandlesXttp::class, XttpBase::class);

        $this->app->bind('xttp', XttpLaravel::class);
    }

    public function boot()
    {
    }
}
