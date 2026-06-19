<?php

namespace Modules\Payment\Providers;

// use Illuminate\Support\Facades\Schedule;
use Azzazkhan\ModularLaravel\Providers\ServiceProvider;
use Azzazkhan\ModularLaravel\Services\LivewireService;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Cashier\Events\WebhookReceived;
use Modules\Payment\Listeners\HandleStripeCheckout;
use Modules\Payment\Listeners\HandleStripeCheckoutFailure;
use Modules\Payment\Listeners\HandleStripeCheckoutSuccess;
use Modules\Payment\Models\Transaction;
use Modules\Payment\Policies\TransactionPolicy;

class PaymentServiceProvider extends ServiceProvider
{
    const string MODULE = 'payment';

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected array $listen = [
        WebhookReceived::class => [
            HandleStripeCheckoutSuccess::class,
            HandleStripeCheckoutFailure::class
        ],
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
        // Transaction::class => TransactionPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../../config/payment.php', 'payment');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'payment');

        if (is_dir($dir = __DIR__ . '/../../resources/views')) {
            $this->loadViewsFrom($dir, 'payment');
        }

        $this->app->register(RouteServiceProvider::class);

        $this->app->afterResolving(BladeCompiler::class, function () {
            LivewireService::registerForModule('payment');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (is_dir($dir = __DIR__ . '/../../resources/views/components')) {
            Blade::anonymousComponentPath($dir, 'payment');
        }

        Blade::componentNamespace('Modules\\Payment\\Views\\Components', 'payment');

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
