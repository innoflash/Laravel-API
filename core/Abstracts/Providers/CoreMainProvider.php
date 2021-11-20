<?php

namespace Core\Abstracts\Providers;

use Illuminate\Support\ServiceProvider;
use Core\Concerns\RegistersValidationRules;

abstract class CoreMainProvider extends ServiceProvider
{
    use RegistersValidationRules;

    /**
     * Services to be injected into the DIC.
     * @var array
     */
    protected array $services = [];

    protected array $bindingServices = [];

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

        $this->registerBindingServices();
    }

    /**
     * Binds services to their implementations.
     */
    protected function registerBindingServices(): void
    {
        foreach ($this->bindingServices as $interface => $service) {
            $this->app->singleton($interface, $service);
        }
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
