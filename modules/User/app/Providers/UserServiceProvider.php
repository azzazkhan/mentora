<?php

namespace Modules\User\Providers;

// use Illuminate\Support\Facades\Schedule;
use Azzazkhan\ModularLaravel\Providers\ServiceProvider;
use Azzazkhan\ModularLaravel\Services\LivewireService;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

class UserServiceProvider extends ServiceProvider
{
    const string MODULE = 'user';

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
        $this->mergeConfigFrom(__DIR__ . '/../../config/user.php', 'user');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'user');

        if (is_dir($dir = __DIR__ . '/../../resources/views')) {
            $this->loadViewsFrom($dir, 'user');
        }

        $this->app->register(RouteServiceProvider::class);

        $this->app->afterResolving(BladeCompiler::class, function () {
            LivewireService::registerForModule('user');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (is_dir($dir = __DIR__ . '/../../resources/views/components')) {
            Blade::anonymousComponentPath($dir, 'user');
        }

        Blade::componentNamespace('Modules\\User\\Views\\Components', 'user');

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
