<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;
use Laravel\Cashier\Cashier;
use Throwable;

class DeleteStripeCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:delete-stripe-cus {customer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Stripe customer record';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $customer = $this->argument('customer');

        try {
            Cashier::stripe()->customers->delete($customer);

            $this->components->info("Successfully deleted customer {$customer}");
        } catch (Throwable) {
            $this->components->error("An error occurred while deleting customer {$customer}");

            return 1;
        }
    }
}
