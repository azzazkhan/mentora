<?php

namespace Modules\Payment\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Payment\Enums\TransactionStatus;
use Modules\Payment\Models\Transaction;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Payment\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'session' => Str::random(20),
            'amount' => (fake()->numberBetween(1, 20) * 5) * 1000,
            'currency' => config('cashier.currency'),
            'status' => fake()->randomElement(TransactionStatus::values()),
            'expires_at' => now()->addMinutes(random_int(1, 1000)),
            'user_id' => User::factory(),
        ];
    }
}
