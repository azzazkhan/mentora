<?php

namespace Modules\User\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\Role;
use Modules\User\Models\Teacher;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
            ])
            ->assignRole(Role::SuperAdmin);

        User::factory()->count(2)->create()->each(fn(User $user) => $user->assignRole(Role::Admin));

        User::factory()
            ->count(10)
            ->has(Teacher::factory())
            ->create()
            ->each(fn(User $user) => $user->assignRole(Role::Teacher));

        User::factory()->count(50)->create()->each(fn(User $user) => $user->assignRole(Role::Student));
    }
}
