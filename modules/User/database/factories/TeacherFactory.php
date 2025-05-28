<?php

namespace Modules\User\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\User\Models\Teacher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\User\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::orderedUuid(),
            'specialization' => fake()->words(random_int(1, 3), true),
            'user_id' => User::factory(),
        ];
    }
}
