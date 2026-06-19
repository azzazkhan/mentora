<?php

namespace Modules\Assignment\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Sleep;
use Modules\Assignment\Models\Assignment;
use Modules\Assignment\Models\Submission;
use Modules\Attachment\Models\Attachment;
use Modules\Classroom\Models\Classroom;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        return;
        // Sleep::for(10)->seconds();

        Classroom::all()->each(function (Classroom $classroom) {
            $students = $classroom->enrolledStudents()->get();

            $classroom
                ->assignments()
                ->each(function (Assignment $assignment) use ($students) {
                    $count = ceil($students->count() * random_int(4, 9) * 0.1);

                    $students->random($count)->each(function (User $student) use ($assignment) {
                        $submission = $assignment->submissions()->where('user_id', $student->getKey())->firstOrFail();

                        // Attachment::factory()
                        //     ->count(random_int(1, 3))
                        //     ->for($submission, 'attachable')
                        //     ->for($student, 'user')
                        //     ->create();
                    });
                });
        });
    }
}
