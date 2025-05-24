<?php

namespace Modules\Assignment\Providers;

// use Illuminate\Support\Facades\Schedule;
use Azzazkhan\ModularLaravel\Providers\ServiceProvider;
use Azzazkhan\ModularLaravel\Services\LivewireService;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Modules\Assignment\Events\AssignmentCreated;
use Modules\Assignment\Events\AssignmentDeleted;
use Modules\Assignment\Listeners\CreateSubmissions;
use Modules\Assignment\Models\Assignment;
use Modules\Assignment\Models\Submission;
use Modules\Assignment\Policies\AssignmentPolicy;
use Modules\Assignment\Policies\SubmissionPolicy;
use Modules\Attachment\Listeners\UnlinkAttachments;

class AssignmentServiceProvider extends ServiceProvider
{
    const string MODULE = 'assignment';

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected array $listen = [
        AssignmentCreated::class => [CreateSubmissions::class],
        AssignmentDeleted::class => [UnlinkAttachments::class],
    ];

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
        Assignment::class => AssignmentPolicy::class,
        Submission::class => SubmissionPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../../config/assignment.php', 'assignment');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'assignment');

        if (is_dir($dir = __DIR__ . '/../../resources/views')) {
            $this->loadViewsFrom($dir, 'assignment');
        }

        $this->app->register(RouteServiceProvider::class);

        $this->app->afterResolving(BladeCompiler::class, function () {
            LivewireService::registerForModule('assignment');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (is_dir($dir = __DIR__ . '/../../resources/views/components')) {
            Blade::anonymousComponentPath($dir, 'assignment');
        }

        Blade::componentNamespace('Modules\\Assignment\\Views\\Components', 'assignment');

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
