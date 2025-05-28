<?php

namespace App\Console\Commands\Dev;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Process\Pool;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Process;
use Laravel\Cashier\Cashier;
use Stripe\Customer;

class ResetStripeCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:reset-stripe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Stripe customer records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        while (true) {
            $customers = Cashier::stripe()->customers->all(['limit' => 100]);

            collect($customers['data'])
                ->chunk(30)
                ->each(function (Collection $chunk) {
                    Process::concurrently(function (Pool $pool) use ($chunk) {
                        $chunk->each(function (Customer $customer) use (&$pool) {
                            $pool->path(base_path())->command("php artisan dev:delete-stripe-cus {$customer->id}");
                        });
                    });
                });

            if (! $customers['has_more']) {
                break;
            }
        }

        $this->components->info('Successfully deleted Stripe customers');

        User::query()->toBase()->update(['stripe_id' => null]);
    }
}
