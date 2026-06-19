<?php

namespace Modules\Payment\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\Role;
use Modules\Payment\Models\Transaction;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->role(Role::Student)->each(function (User $user) {
            Transaction::factory()->for($user)->create([
                'amount' => random_int(1, 10) * 5000,
                'currency' => 'PKR',
            ]);
        });
    }
}
