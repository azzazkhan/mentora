<?php

namespace Modules\Livestream\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Classroom\Models\Classroom;
use Modules\Livestream\Models\Livestream;

class LivestreamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classroom::query()->each(function (Classroom $classroom) {
            Livestream::factory()->count(3)->for($classroom)->create();
        });
    }
}
