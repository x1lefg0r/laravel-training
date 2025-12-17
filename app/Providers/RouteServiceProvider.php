<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            // !!! ЭТОТ БЛОК ОТВЕЧАЕТ ЗА ЗАГРУЗКУ API.PHP !!!
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Загрузка web.php (если он нужен)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}