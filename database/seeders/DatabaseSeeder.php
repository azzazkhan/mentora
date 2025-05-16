<?php

namespace Database\Seeders;

use App\Console\Commands\Setup\CreateRolesAndPermissions;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Modules\Announcement\Database\Seeders\AnnouncementSeeder;
use Modules\Assignment\Database\Seeders\AssignmentSeeder;
use Modules\Assignment\Database\Seeders\SubmissionSeeder;
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
        Artisan::call('cache:clear');
        Artisan::call(CreateRolesAndPermissions::class);

        $this->call([
            UserSeeder::class,
            ClassroomSeeder::class,
            EnrollmentSeeder::class,
            AnnouncementSeeder::class,
            AssignmentSeeder::class,
            SubmissionSeeder::class,
        ]);
    }
}
