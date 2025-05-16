<?php

namespace Modules\Assignment\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Assignment\Models\Assignment;
use Modules\Classroom\Models\Classroom;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classroom::query()->with('teacher')->each(function (Classroom $classroom) {
            Assignment::factory()
                ->count(3)
                ->for($classroom)
                ->for($classroom->teacher)
                ->create();
        });
    }
}
