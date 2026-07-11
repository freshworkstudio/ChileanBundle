<?php

declare(strict_types=1);

namespace Freshwork\ChileanBundle\Tests;

use Freshwork\ChileanBundle\Laravel\ChileanBundleServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [ChileanBundleServiceProvider::class];
    }
}
