<?php

namespace Modules\Assignment\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Assignment\Enums\Submission\Status;
use Modules\Assignment\Models\Assignment;
use Modules\Assignment\Models\Submission;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Assignment\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    protected $model = Submission::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assignment_id' => Assignment::factory(),
            'user_id' => User::factory(),
        ];
    }
}
