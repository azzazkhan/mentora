<?php

namespace Modules\Assignment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Assignment\Models\Assignment;
use Modules\Classroom\Models\Classroom;
use Modules\User\Models\Teacher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Assignment\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

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
            'due_date' => fake()->dateTimeBetween('now', '+1 month'),
            'classroom_id' => Classroom::factory(),
        ];
    }
}
