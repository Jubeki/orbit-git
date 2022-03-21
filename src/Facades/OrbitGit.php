<?php

namespace Jubeki\OrbitGit\Facades;

use Illuminate\Support\Facades\Facade;
use Jubeki\OrbitGit\OrbitGitManager;

/**
 * @method static \Jubeki\OrbitGit\OrbitGitManager resolveNameUsing(\Closure $callback)
 * @method static \Jubeki\OrbitGit\OrbitGitManager resolveEmailUsing(\Closure $callback)
 * @method static \Jubeki\OrbitGit\OrbitGitManager resolveMessageUsing(\Closure $callback)
 * @method static \Jubeki\OrbitGit\OrbitGitManager resolveCreatedMessageUsing(\Closure $callback)
 * @method static \Jubeki\OrbitGit\OrbitGitManager resolveDeletedMessageUsing(\Closure $callback)
 * @method static \Jubeki\OrbitGit\OrbitGitManager resolveForceDeletedMessageUsing(\Closure $callback)
 * @method static \Jubeki\OrbitGit\OrbitGitManager resolveUpdatedMessageUsing(\Closure $callback)
 * @method static string getName()
 * @method static string getEmail()
 * @method static string getRoot()
 * @method static string getBinary()
 * @method static string getMessage($event)
 *
 * @see \Jubeki\OrbitGit\OrbitGitManager
 */
class OrbitGit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return OrbitGitManager::class;
    }
}
