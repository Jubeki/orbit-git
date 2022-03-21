<?php

namespace Jubeki\OrbitGit\Listeners;

use Jubeki\OrbitGit\Facades\OrbitGit;
use RyanChandler\Git\Git;

class ProcessGitTransaction
{
    public function commit($event)
    {
        /** @var \RyanChandler\Git\Git $git */
        $git = Git::open(OrbitGit::getRoot());

        if (! $git->hasChanges()) {
            return;
        }

        $git->add(config('orbit.paths.content'), [
            '--author' => "'".OrbitGit::getName().' <'.OrbitGit::getEmail().">'",
        ]);

        $git->commit(OrbitGit::getMessage($event));

        $git->push();
    }
}
