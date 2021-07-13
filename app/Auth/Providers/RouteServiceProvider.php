<?php

namespace App\Auth\Providers;

use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        $this->configureRateLimiting();
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('system-auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email'));
        });
    }
}
