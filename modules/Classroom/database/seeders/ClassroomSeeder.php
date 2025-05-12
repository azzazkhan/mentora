<?php

namespace Modules\Classroom\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Classroom\Models\Classroom;
use Modules\User\Models\Teacher;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::all()->each(function (Teacher $teacher) {
            Classroom::factory()->count(random_int(1, 3))->for($teacher)->create();
        });
    }
}
