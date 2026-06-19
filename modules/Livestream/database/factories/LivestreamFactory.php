<?php

namespace Modules\Livestream\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Classroom\Models\Classroom;
use Modules\Livestream\Models\Livestream;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Livestream\Models\Livestream>
 */
class LivestreamFactory extends Factory
{
    protected $model = Livestream::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'starts_at' => now(),
            'ends_at' => now()->addHours(1),
            'classroom_id' => Classroom::factory(),
        ];
    }
}
