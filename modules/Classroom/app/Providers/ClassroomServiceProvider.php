<?php

namespace Modules\Classroom\Providers;

// use Illuminate\Support\Facades\Schedule;
use Azzazkhan\ModularLaravel\Providers\ServiceProvider;
use Azzazkhan\ModularLaravel\Services\LivewireService;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

class ClassroomServiceProvider extends ServiceProvider
{
    const string MODULE = 'classroom';

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
        $this->mergeConfigFrom(__DIR__ . '/../../config/classroom.php', 'classroom');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'classroom');

        if (is_dir($dir = __DIR__ . '/../../resources/views')) {
            $this->loadViewsFrom($dir, 'classroom');
        }

        $this->app->register(RouteServiceProvider::class);

        $this->app->afterResolving(BladeCompiler::class, function () {
            LivewireService::registerForModule('classroom');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (is_dir($dir = __DIR__ . '/../../resources/views/components')) {
            Blade::anonymousComponentPath($dir, 'classroom');
        }

        Blade::componentNamespace('Modules\\Classroom\\Views\\Components', 'classroom');

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
