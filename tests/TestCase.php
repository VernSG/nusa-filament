<?php

namespace Vernsg\NusaFilament\Tests;

use Creasi\Nusa\ServiceProvider as NusaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Vernsg\NusaFilament\NusaFilamentServiceProvider;

class TestCase extends Orchestra
{
    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            NusaServiceProvider::class,
            NusaFilamentServiceProvider::class,
        ];
    }
}
