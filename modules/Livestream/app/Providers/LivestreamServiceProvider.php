<?php

namespace Modules\Livestream\Providers;

// use Illuminate\Support\Facades\Schedule;
use Azzazkhan\ModularLaravel\Providers\ServiceProvider;
use Azzazkhan\ModularLaravel\Services\LivewireService;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Modules\Livestream\Models\Livestream;
use Modules\Livestream\Policies\LivestreamPolicy;

class LivestreamServiceProvider extends ServiceProvider
{
    const string MODULE = 'livestream';

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
    protected array $policies = [
        // Livestream::class => LivestreamPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../../config/livestream.php', 'livestream');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'livestream');

        if (is_dir($dir = __DIR__ . '/../../resources/views')) {
            $this->loadViewsFrom($dir, 'livestream');
        }

        $this->app->register(RouteServiceProvider::class);

        $this->app->afterResolving(BladeCompiler::class, function () {
            LivewireService::registerForModule('livestream');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (is_dir($dir = __DIR__ . '/../../resources/views/components')) {
            Blade::anonymousComponentPath($dir, 'livestream');
        }

        Blade::componentNamespace('Modules\\Livestream\\Views\\Components', 'livestream');

        $this->bootModule();

        $this->commands([]);
    }

    /**
     * Register scheduled tasks.
     */
    protected function registerScheduledTasks(): void
    {
        $this->app->booted(function () {
            // Schedule::command('inspire')->daily();
        });
    }
}
