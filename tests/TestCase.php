<?php

namespace JohnathanSmith\XttpLaravel\Tests;

use JohnathanSmith\XttpLaravel\XttpLaravelProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [XttpLaravelProvider::class];
    }
}
