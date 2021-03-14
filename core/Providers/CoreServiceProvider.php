<?php

namespace Core\Providers;

use Core\Loaders\ProvidersLoader;
use Illuminate\Support\Facades\File;
use Dev\Providers\MainServiceProvider;
use Illuminate\Support\ServiceProvider;
use Core\Validators\TwitterLinkValidator;
use Core\Validators\YoutubeLinkValidator;
use Core\Validators\FacebookLinkValidator;
use Core\Services\DefaultUserQueryService;
use Core\Concerns\RegistersValidationRules;
use Core\Validators\InstagramLinkValidator;
use Core\Repositories\DefaultUserRepository;
use Core\Services\DefaultUserCommandService;
use Core\Contracts\Services\UserQueryService;
use Core\Contracts\Repositories\UserRepository;
use Core\Contracts\Services\UserCommandService;

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
        $this->app->register(MainServiceProvider::class); //register dev.

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

        $this->registerUserRepository();
    }

    private function registerUserRepository()
    {
        $this->app->bind(UserRepository::class, DefaultUserRepository::class);
        $this->app->bind(UserQueryService::class, DefaultUserQueryService::class);
        $this->app->bind(UserCommandService::class, DefaultUserCommandService::class);
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
