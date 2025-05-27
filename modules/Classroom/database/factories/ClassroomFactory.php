<?php

namespace Modules\Classroom\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Models\Classroom;
use Modules\User\Models\Teacher;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Classroom\Models\Classroom>
 */
class ClassroomFactory extends Factory
{
    protected $model = Classroom::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(Status::cases());

        return array_merge([
            'name' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => $status,
            'fee' => (fake()->numberBetween(1, 20) * 5) * 1000,

            'icon' => fake()->imageUrl(),
            'cover' => fake()->imageUrl(),
            'color' => random_hex(6),

            'teacher_id' => Teacher::factory(),
        ], $this->getAttributes($status));
    }

    protected function getAttributes(Status $status): array
    {
        $attributes = [];

        switch ($status) {
            case Status::Pending:
                $attributes = [
                    'registration_started_at' => now()->addDays(random_int(1, 3)),
                    'registration_ended_at' => now()->addDays(random_int(4, 6)),

                    'started_at' => now()->addDays(random_int(8, 20)),
                ];
                break;

            case Status::RegistrationOpen:
                $attributes = [
                    'registration_started_at' => now(),
                    'registration_ended_at' => now()->addDays(random_int(1, 10)),

                    'started_at' => now()->addDays(random_int(14, 20)),
                ];
                break;

            case Status::RegistrationClosed:
                $attributes = [
                    'registration_started_at' => now()->subDays(random_int(1, 10)),
                    'registration_ended_at' => now(),

                    'started_at' => now()->addDays(random_int(14, 20)),
                ];
                break;

            case Status::Started:
                $attributes = [
                    'registration_started_at' => now()->subDays(random_int(3, 10)),
                    'registration_ended_at' => now()->subDays(random_int(1, 2)),

                    'started_at' => now()->subHours(random_int(1, 6)),
                    'ended_at' => now()->addMonths(random_int(1, 4)),
                ];
                break;

            case Status::Ended:
                $attributes = [
                    'registration_started_at' => now()->subMonths(3)->subDays(random_int(3, 10)),
                    'registration_ended_at' => now()->subMonths(3)->subDays(random_int(1, 2)),

                    'started_at' => now()->subMonths(3),
                    'ended_at' => now()->subDays(random_int(0, 10)),
                ];
                break;

            case Status::Paused:
                $attributes = [
                    'registration_started_at' => now()->subDays(random_int(3, 10)),
                    'registration_ended_at' => now()->subDays(random_int(1, 2)),

                    'started_at' => now()->subHours(random_int(6, 24)),
                ];
                break;

            case Status::Archived:
                $attributes = [
                    'registration_started_at' => now()->subDays(random_int(3, 10)),
                    'registration_ended_at' => now()->subDays(random_int(1, 2)),

                    'started_at' => now()->subHours(random_int(6, 24)),
                ];
                break;
        }

        return $attributes;
    }
}
