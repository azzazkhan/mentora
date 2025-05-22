<?php

namespace Modules\Announcement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Announcement\Models\Announcement;
use Modules\Classroom\Models\Classroom;
use Modules\User\Models\Teacher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Announcement\Models\Announcement>
 */
class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->realText(random_int(100, 500)),
            'edited' => fake()->boolean(20),
            'classroom_id' => Classroom::factory(),
        ];
    }
}
