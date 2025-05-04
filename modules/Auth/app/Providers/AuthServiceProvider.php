<?php

namespace Modules\Auth\Providers;

// use Illuminate\Support\Facades\Schedule;
use Azzazkhan\ModularLaravel\Providers\ServiceProvider;
use Azzazkhan\ModularLaravel\Services\LivewireService;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

class AuthServiceProvider extends ServiceProvider
{
    const string MODULE = 'auth';

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected array $listen = [];

    /**
     * The model observers for your application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected array $observers = [];

    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected array $policies = [];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../../config/auth.php', 'auth');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'auth');

        if (is_dir($dir = __DIR__ . '/../../resources/views')) {
            $this->loadViewsFrom($dir, 'auth');
        }

        $this->app->register(RouteServiceProvider::class);

        $this->app->afterResolving(BladeCompiler::class, function () {
            LivewireService::registerForModule('auth');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (is_dir($dir = __DIR__ . '/../../resources/views/components')) {
            Blade::anonymousComponentPath($dir, 'auth');
        }

        Blade::componentNamespace('Modules\\Auth\\Views\\Components', 'auth');

        $this->bootModule();

        $this->commands([]);
    }

    /**
     * Register scheduled tasks.
     */
     protected function registerScheduledTasks(): void {
         $this->app->booted(function () {
             // Schedule::command('inspire')->daily();
         });
     }
}
