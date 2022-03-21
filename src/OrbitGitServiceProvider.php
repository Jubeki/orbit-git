<?php

declare(strict_types=1);

namespace Jubeki\OrbitGit;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Jubeki\OrbitGit\Listeners\ProcessGitTransaction;
use Jubeki\OrbitGit\OrbitGitManager;
use Orbit\Events\OrbitalCreated;
use Orbit\Events\OrbitalDeleted;
use Orbit\Events\OrbitalForceDeleted;
use Orbit\Events\OrbitalUpdated;

class OrbitGitServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/orbit-git.php', 'orbit-git');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/orbit-git.php' => config_path('orbit-git.php'),
            ], 'orbit-git:config');
        }

        if ($this->app['config']->get('orbit-git.enabled')) {
            Event::listen(OrbitalCreated::class, [ProcessGitTransaction::class, 'commit']);
            Event::listen(OrbitalUpdated::class, [ProcessGitTransaction::class, 'commit']);
            Event::listen(OrbitalDeleted::class, [ProcessGitTransaction::class, 'commit']);
            Event::listen(OrbitalForceDeleted::class, [ProcessGitTransaction::class, 'commit']);
        }
    }
}
