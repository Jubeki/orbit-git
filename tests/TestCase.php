<?php

namespace OrbitGit\Tests;

use Jubeki\OrbitGit\OrbitGitServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            OrbitGitServiceProvider::class,
        ];
    }
}
