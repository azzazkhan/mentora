<?php

namespace Modules\Auth\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Modules\Auth\Permission;
use Modules\Auth\Enums\Role;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\Models\Role as SpatieRole;

class SyncRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:sync-roles-and-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates required roles and attaches permissions';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        collect(Permission::values())
            ->map(function (string $name) {
                return rescue(fn() => SpatiePermission::create(['name' => $name]), false, report: false);
            })
            ->filter()
            ->whenEmpty(fn() => $this->components->info('No new permissions created'))
            ->whenNotEmpty(function (Collection $permissions) {
                $this->components->info("Successfully created {$permissions->count()} permissions");
            });

        collect(Role::cases())
            ->map(function (Role $role) {
                if ($model = SpatieRole::query()->where('name', $role->value)->first()) {
                    $model->update(['priority' => $role->getPriority()]);
                    return;
                }

                return SpatieRole::create(['name' => $role->value, 'priority' => $role->getPriority()]);
            })
            ->filter()
            ->whenEmpty(fn() => $this->components->info('No new roles created'))
            ->whenNotEmpty(function (Collection $roles) {
                $this->components->info("Successfully created {$roles->count()} roles");
                $this->newLine();
            });

        collect(Role::cases())
            ->map(function (Role $role) {
                $permissions = collect($role->getPermissions());

                SpatieRole::query()
                    ->where('name', $role->value)
                    ->first()
                    ->syncPermissions($permissions);

                $this->components->info("Assigned {$permissions->count()} permissions to {$role->value}");
            });
    }
}
