<?php

namespace Modules\Announcement\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Announcement\Models\Announcement;
use Modules\Attachment\Models\Attachment;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Models\Classroom;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            Status::Started,
            Status::Ended,
            Status::Paused,
            Status::Archived,
        ];

        Classroom::query()
            ->with('teacher')
            ->ofStatus($statuses)
            ->get()
            ->each(function (Classroom $classroom) {
                Announcement::factory()
                    ->count(random_int(1, 5))
                    ->for($classroom)
                    ->has(Attachment::factory()->count(random_int(0, 3)))
                    ->create();
            });
    }
}
