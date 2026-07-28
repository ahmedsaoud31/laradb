<?php

namespace AhmedSaoud31\Laradb\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use AhmedSaoud31\Laradb\LaradbServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaradbServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // Setup default environment variables or database configurations here
    }
}
