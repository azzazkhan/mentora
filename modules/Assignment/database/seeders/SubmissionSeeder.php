<?php

namespace Modules\Assignment\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Assignment\Models\Assignment;
use Modules\Assignment\Models\Submission;
use Modules\Classroom\Models\Classroom;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classroom::all()->each(function (Classroom $classroom) {
            $students = $classroom->enrolledStudents()->get();

            $classroom
                ->assignments()
                ->each(function (Assignment $assignment) use ($students) {
                    $students->random(6)->each(function (User $student) use ($assignment) {
                        Submission::factory()->for($assignment)->for($student)->create();
                    });
                });
        });
    }
}
