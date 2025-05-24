<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Modules\Announcement\Database\Seeders\AnnouncementSeeder;
use Modules\Assignment\Database\Seeders\AssignmentSeeder;
use Modules\Assignment\Database\Seeders\SubmissionSeeder;
use Modules\Auth\Console\Commands\SyncRolesAndPermissions;
use Modules\Classroom\Database\Seeders\ClassroomSeeder;
use Modules\Classroom\Database\Seeders\EnrollmentSeeder;
use Modules\User\Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->cleanup();

        $this->call([
            UserSeeder::class,
            ClassroomSeeder::class,
            EnrollmentSeeder::class,
            AnnouncementSeeder::class,
            AssignmentSeeder::class,
            SubmissionSeeder::class,
        ]);
    }

    public static function cleanup()
    {
        Artisan::call('cache:clear');
        Artisan::call(SyncRolesAndPermissions::class);

        Storage::deleteDirectory('attachments');
        Storage::deleteDirectory('avatars');
    }
}
