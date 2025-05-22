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
            $students = User::query()->role(Role::Student)->limit(30)->inRandomOrder()->get();

            if (fake()->boolean(40)) {
                $pending = random_int(4, 10);

                $classroom->pendingStudents()->attach($students->take($pending));
                $classroom->enrolledStudents()->attach($students->skip($pending), ['enrolled_at' => now()]);
            } else {
                $classroom->enrolledStudents()->attach($students, ['enrolled_at' => now()]);
            }
        });
    }
}
