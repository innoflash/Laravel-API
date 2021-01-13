<?php

namespace Core\Abstracts;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

abstract class CoreEventServiceProvider extends ServiceProvider
{
    /**
     * The events and listeners for the module.
     * @return array
     */
    protected abstract function listen(): array;

    public function boot()
    {
        $this->listen = $this->listen();
        parent::boot();
    }
}
