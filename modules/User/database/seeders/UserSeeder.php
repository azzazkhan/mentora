<?php

namespace Modules\User\Database\Seeders;

use App\Console\Commands\Dev\ResetStripeCustomers;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Process\Pool;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;
use Laravel\Cashier\Cashier;
use Modules\Auth\Enums\Role;
use Modules\User\Models\Teacher;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Artisan::call(ResetStripeCustomers::class);

        User::withoutEvents(function () {
            User::factory()
                ->create([
                    'name' => 'Administrator',
                    'email' => 'admin@example.com',
                ])
                ->assignRole(Role::SuperAdmin);

            User::factory()->count(2)->create()->each(fn(User $user) => $user->assignRole(Role::Admin));

            User::factory()
                ->count(10)
                ->has(Teacher::factory())
                ->create()
                ->each(fn(User $user) => $user->assignRole(Role::Teacher));

            User::factory()
                ->count(50)
                ->create()
                ->each(fn(User $user) => $user->assignRole(Role::Student))
                ->chunk(10);
        });

        User::role(Role::Student)->chunk(20, function (Collection $chunk) {
            Process::concurrently(function (Pool $pool) use ($chunk) {
                $chunk->each(function (User $customer) use (&$pool) {
                    $pool->path(base_path())->command("php artisan dev:sync-stripe {$customer->id}");
                });
            });
        });
    }

    protected function deleteStripeCustomers(): void
    {
        if (! config('cashier.enabled')) {
            return;
        }

        while (true) {
            $customers = Cashier::stripe()->customers->all(['limit' => 100]);

            foreach ($customers['data'] as $customer) {
                Cashier::stripe()->customers->delete($customer['id']);
            }

            if (! $customers['has_more']) {
                break;
            }
        }
    }
}
