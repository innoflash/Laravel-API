<?php

namespace Core\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'Core\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapModulesRoutes();
        });
    }

    /**
     * Registers modules routes.
     */
    protected function mapModulesRoutes()
    {
        foreach (CoreServiceProvider::getModulesDirs() as $module) {
            if (File::isDirectory($module . '/routes')) {
                foreach (File::allFiles($module . '/routes') as $routeFile) {
                    $kebabModuleName = $this->getModuleKebab($module);

                    Route::name($kebabModuleName . '.')
                         ->prefix('api/' . $kebabModuleName)
                         ->middleware(['api', 'auth:api', 'ministry-active'])
                         ->group($routeFile->getPathname());
                }
            }
        }
    }
    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
