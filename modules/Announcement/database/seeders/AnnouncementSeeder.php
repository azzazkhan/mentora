<?php

namespace Modules\Announcement\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Announcement\Models\Announcement;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Models\Classroom;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classroom::query()
            ->with('teacher')
            ->ofStatus(Status::Started)
            ->get()
            ->each(function (Classroom $classroom) {
                Announcement::factory()
                    ->count(random_int(1, 5))
                    ->for($classroom)
                    ->for($classroom->teacher)
                    ->create();
            });
    }
}
