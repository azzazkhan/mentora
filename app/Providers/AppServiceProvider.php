<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(! $this->app->environment('production'));

        DB::prohibitDestructiveCommands($this->app->environment('production'));
        Date::use(CarbonImmutable::class);

        Password::defaults(function () {
            $rule = Password::min(8)->letters();

            if ($this->app->environment('production')) {
                return $rule->mixedCase()->numbers()->symbols()->uncompromised();
            }

            return $rule;
        });

        JsonResource::withoutWrapping();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
