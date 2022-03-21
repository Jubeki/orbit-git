<?php

namespace Jubeki\OrbitGit;

use Closure;
use Exception;
use Orbit\Events\OrbitalCreated;
use Orbit\Events\OrbitalDeleted;
use Orbit\Events\OrbitalForceDeleted;
use Orbit\Events\OrbitalUpdated;
use Illuminate\Support\Str;

class OrbitGitManager
{
    protected Closure $resolveName;

    protected Closure $resolveEmail;

    protected Closure $resolveMessage;

    protected Closure $resolveCreatedMessage;

    protected Closure $resolveDeletedMessage;

    protected Closure $resolveForceDeletedMessage;

    protected Closure $resolveUpdatedMessage;

    public function resolveNameUsing(Closure $callback)
    {
        $this->resolveName = $callback;

        return $this;
    }

    public function resolveEmailUsing(Closure $callback)
    {
        $this->resolveEmail = $callback;

        return $this;
    }

    public function resolveMessageUsing(Closure $callback)
    {
        $this->resolveMessage = $callback;

        return $this;
    }

    public function resolveCreatedMessageUsing(Closure $callback)
    {
        $this->resolveCreatedMessage = $callback;

        return $this;
    }

    public function resolveDeletedMessageUsing(Closure $callback)
    {
        $this->resolveDeletedMessage = $callback;

        return $this;
    }

    public function resolveForceDeletedMessageUsing(Closure $callback)
    {
        $this->resolveForceDeletedMessage = $callback;

        return $this;
    }

    public function resolveUpdatedMessageUsing(Closure $callback)
    {
        $this->resolveMessage = $callback;

        return $this;
    }

    public function getName(): string
    {
        if (isset($this->resolveName)) {
            return value($this->resolveName);
        }

        return config('orbit-git.name');
    }

    public function getEmail(): string
    {
        if (isset($this->resolveEmail)) {
            return value($this->resolveEmail);
        }

        return config('orbit-git.email');
    }

    public function getMessage($event): string
    {
        if($event instanceof OrbitalCreated && isset($this->resolveCreatedMessage)) {
            return value($this->resolveCreatedMessage, $event);
        }

        if($event instanceof OrbitalDeleted && isset($this->resolveDeletedMessage)) {
            return value($this->resolveDeletedMessage, $event);
        }

        if($event instanceof OrbitalForceDeleted && isset($this->resolveForceDeletedMessage)) {
            return value($this->resolveForceDeletedMessage, $event);
        }

        if($event instanceof OrbitalUpdated && isset($this->resolveUpdatedMessage)) {
            return value($this->resolveUpdatedMessage, $event);
        }

        if(isset($this->resolveMessage)) {
            return value($this->resolveMessage, $event);
        }

        return (string) Str::of(config('orbit-git.message_template'))
                ->replace('{event}', $this->getTypeOfEvent($event))
                ->replace('{model}', class_basename($event->model))
                ->replace('{primary_key}', $event->model->getKey());
    }

    public function getTypeOfEvent($event)
    {
        if($event instanceof OrbitalCreated) {
            return 'Created';
        }

        if($event instanceof OrbitalDeleted) {
            return 'Deleted';
        }

        if($event instanceof OrbitalForceDeleted) {
            return 'Force-Deleted';
        }

        if($event instanceof OrbitalUpdated) {
            return 'Updated';
        }

        throw new Exception('Could no resolve commit type of event: '.$event::class);
    }

    public function getRoot(): string
    {
        return config('orbit-git.root');
    }

    public function getBinary(): string
    {
        return config('orbit-git.binary');
    }
}
