<?php

namespace Modules\Auth;

use BackedEnum;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Modules\Auth\Enums\Permission as PermissionGroup;
use Modules\Auth\Enums\Role;
use Spatie\Permission\Models\Role as SpatieRole;

class Permission
{
    /**
     * Get all defined permissions.
     *
     * @return list<\BackedEnum>
     */
    public static function all(): array
    {
        $permissions = [];

        foreach (static::groups() as $class) {
            $permissions = array_merge($permissions, call_user_func([$class, 'cases']));
        }

        return $permissions;
    }

    /**
     * Get all defined permission names.
     *
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(fn(BackedEnum $permission) => $permission->value, static::all());
    }

    /**
     * Get permissions for specified role/roles.
     *
     * @param \Modules\User\Enums\Role|\Spatie\Permission\Models\Role|iterable|string $roles
     * @return list<\BackedEnum>
     */
    public static function forRole(Role|SpatieRole|iterable|string $roles): array
    {
        /** @var list<\BackedEnum> $permissions */
        $permissions = [];
        $groups = static::groups();

        foreach (Arr::wrap($roles) as $role) {
            /** @var \Modules\User\Enums\Role $role */
            $role = match (true) {
                $role instanceof SpatieRole => Role::from($role->name),
                is_string($role) => Role::from($role),
                $role instanceof Role => $role,
                default => throw new InvalidArgumentException('Invalid value for [role] provided!'),
            };

            foreach ($groups as $group) {
                $permissions = array_merge(
                    $permissions,
                    call_user_func([$group, 'role'], $role)
                );
            }
        }

        return $permissions;
    }

    /**
     * Get FQNs for all permission groups.
     *
     * @return list<string>
     */
    protected static function groups(): array
    {
        return [
            'announcement' => PermissionGroup\AnnouncementPermission::class,
            'assignment' => PermissionGroup\AssignmentPermission::class,
            'attachment' => PermissionGroup\AttachmentPermission::class,
            'classroom' => PermissionGroup\ClassroomPermission::class,
            'submission' => PermissionGroup\SubmissionPermission::class,
            'user' => PermissionGroup\UserPermission::class,
        ];
    }
}
