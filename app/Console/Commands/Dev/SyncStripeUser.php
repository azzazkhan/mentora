<?php

namespace App\Console\Commands\Dev;

use App\Exceptions\UnreportableException;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SyncStripeUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:sync-stripe {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncs the Stripe customer account for give user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
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
            $customer = $user->createAsStripeCustomer();

            $this->components->info("New Stripe customer created {$customer->id}");
            return 0;
        }

        $customer = $user->syncStripeCustomerDetails();

        $this->components->info("Existing Stripe customer synchronized {$customer->id}");
    }
}
