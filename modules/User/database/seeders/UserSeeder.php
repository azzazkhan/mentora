<?php

namespace Modules\User\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Auth\Enums\Role;

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
        User::factory()->count(5)->create()->each(fn(User $user) => $user->assignRole(Role::Instructor));
        User::factory()->count(20)->create()->each(fn(User $user) => $user->assignRole(Role::Student));
    }
}
