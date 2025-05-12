<?php

namespace Modules\Classroom\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\Role;
use Modules\Classroom\Models\Classroom;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classroom::all()->each(function (Classroom $classroom) {
            $students = User::query()->role(Role::Student)->limit(10)->inRandomOrder()->get();

            if (fake()->boolean(40)) {
                $classroom->pendingStudents()->attach($students->take(4));
                $classroom->enrolledStudents()->attach($students->skip(4)->take(6), ['enrolled_at' => now()]);
            } else {
                $classroom->enrolledStudents()->attach($students, ['enrolled_at' => now()]);
            }
        });
    }
}
