<?php

namespace Core\Abstracts\Providers;

use Core\Concerns\RegistersValidationRules;
use Illuminate\Support\ServiceProvider;

abstract class CoreMainProvider extends ServiceProvider
{
    use RegistersValidationRules;

    /**
     * Services to be injected into the DIC.
     * @var array
     */
    protected array $services = [];

    /**
     * Module rules.
     * @var array
     */
    protected array $validationRules = [];

    public function register()
    {
        parent::register();
    }

    public function boot()
    {
        $this->registerServices();

        $this->registerValidationRules();
    }

    /**
     * Registers system services.
     */
    protected function registerServices()
    {
        foreach ($this->services as $service) {
            $this->app->singleton($service);
        }
    }
}
