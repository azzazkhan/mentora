<?php

namespace Modules\Announcement\Providers;

// use Illuminate\Support\Facades\Schedule;
use Azzazkhan\ModularLaravel\Providers\ServiceProvider;
use Azzazkhan\ModularLaravel\Services\LivewireService;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Modules\Announcement\Events\AnnouncementDeleted;
use Modules\Announcement\Models\Announcement;
use Modules\Announcement\Policies\AnnouncementPolicy;
use Modules\Attachment\Listeners\UnlinkAttachments;

class AnnouncementServiceProvider extends ServiceProvider
{
    const string MODULE = 'announcement';

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected array $listen = [
        AnnouncementDeleted::class => [UnlinkAttachments::class],
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
        Announcement::class => AnnouncementPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../../config/announcement.php', 'announcement');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'announcement');

        if (is_dir($dir = __DIR__ . '/../../resources/views')) {
            $this->loadViewsFrom($dir, 'announcement');
        }

        $this->app->register(RouteServiceProvider::class);

        $this->app->afterResolving(BladeCompiler::class, function () {
            LivewireService::registerForModule('announcement');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (is_dir($dir = __DIR__ . '/../../resources/views/components')) {
            Blade::anonymousComponentPath($dir, 'announcement');
        }

        Blade::componentNamespace('Modules\\Announcement\\Views\\Components', 'announcement');

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
