<?php

namespace Modules\Attachment\Providers;

use Azzazkhan\ModularLaravel\Services\RoutingService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $router = app(RoutingService::class);

        // Only load web routes if enabled
        if (file_exists($path = __DIR__ . '/../../routes/web.php')) {
            $router->registerWebRoutes(function () use ($path) {
                Route::prefix('attachments')
                    ->name('attachment::')
                    ->group($path);
            });
        }

        // Only load API routes if enabled
        if (file_exists($path = __DIR__ . '/../../routes/api.php')) {
            $router->registerApiRoutes(function () use ($path) {
                Route::prefix('attachments')
                    ->name('attachment::api.')
                    ->group($path);
            });
        }
    }
}
