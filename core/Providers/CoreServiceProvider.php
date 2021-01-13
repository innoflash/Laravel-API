<?php

namespace Core\Providers;

use Core\Concerns\RegistersValidationRules;
use Core\Loaders\ProvidersLoader;
use Core\Validators\FacebookLinkValidator;
use Core\Validators\InstagramLinkValidator;
use Core\Validators\TwitterLinkValidator;
use Core\Validators\YoutubeLinkValidator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    use RegistersValidationRules;

    /**
     * System validators.
     * @var array
     */
    private array $validationRules = [
        FacebookLinkValidator::class,
        InstagramLinkValidator::class,
        TwitterLinkValidator::class,
        YoutubeLinkValidator::class,
    ];

    /**
     * System services.
     * @var array
     */
    private array $services = [];

    /**
     * Register any application services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        
        $this->registerModulesMainProviders();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerValidationRules();

        $this->registerServices();

        $this->registerObservers();
    }

    /**
     * Registers the observers when app not in console.
     */
    private function registerObservers()
    {
        //register and global observers.
    }

    /**
     * Registers modules MainServiceProviders
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function registerModulesMainProviders()
    {
        $providersLoader = $this->app->make(ProvidersLoader::class);

        foreach (self::getModulesDirs() as $module) {
            if (File::isDirectory($module)) {
                $providersLoader->loadMainProvidersFromComponent($module);
            }
        }
    }

    /**
     * Register system services.
     */
    protected function registerServices()
    {
        foreach ($this->services as $service) {
            $this->app->singleton($service);
        }
    }

    /**
     * Fetches the modules.
     * @return array
     */
    public static function getModulesDirs()
    {
        return File::directories(app_path());
    }
}
