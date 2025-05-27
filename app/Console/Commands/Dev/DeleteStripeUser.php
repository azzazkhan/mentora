<?php

namespace App\Console\Commands\Dev;

use App\Exceptions\UnreportableException;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DeleteStripeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:delete-stripe {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes the Stripe customer account for given user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! config('cashier.enabled')) {
            $this->components->error('Laravel Cashier integration is disabled');

            return 1;
        }

        $key = $this->argument('user');

        $column = match (true) {
            Str::isUuid($key) => 'uuid',
            filter_var($key, FILTER_VALIDATE_EMAIL) => 'email',
            is_numeric($key) => 'id',
            default => throw new UnreportableException('Invalid user identifier provided'),
        };

        $user = User::query()->where($column, $key)->first();

        if (! $user) {
            $this->components->error('The user with specified identifier does not exists');

            return 1;
        }

        if (! $user->hasStripeId()) {
            $this->components->info('The user does not have a linked Stripe customer account');

            return 1;
        }

        $user->asStripeCustomer()->delete();

        $user->stripe_id = null;
        $user->save();

        $this->components->info("Delete Stripe customer for {$user->name}");
    }
}
