<?php

namespace App\Console\Commands\Setup;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\Auth\Enums;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:create-roles-and-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates required roles and permissions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        collect(Enums\Permission::values())
            ->map(function (string $name) {
                return rescue(fn() => Permission::create(['name' => $name]), false);
            })
            ->filter()
            ->whenEmpty(fn() => $this->components->info('No new permissions created'))
            ->whenNotEmpty(function (Collection $permissions) {
                $this->components->info("Successfully created {$permissions->count()} permissions");
            });

        collect(Enums\Role::values())
            ->map(function (string $name) {
                return rescue(fn() => Role::create(['name' => $name]), false);
            })
            ->filter()
            ->whenEmpty(fn() => $this->components->info('No new roles created'))
            ->whenNotEmpty(function (Collection $roles) {
                $this->components->info("Successfully created {$roles->count()} roles");
                $this->newLine();
            })
            ->each(function (Role $role) {
                $permissions = collect(Enums\Role::from($role->name)->getPermissions());

                $role->givePermissionTo($permissions);

                $this->components->info("Assigned {$permissions->count()} permissions to {$role->name}");
            });
    }
}
