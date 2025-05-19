<?php

namespace Modules\Auth\Enums\Permission;

use ArchTech\Enums\Values;
use Modules\Auth\Enums\Role;

enum UserPermission: string
{
    use Values;

    case List = 'list-all-users';
    case Create = 'create-user';
    case Update = 'update-all-users';
    case Delete = 'delete-all-users';

    public static function role(Role $role)
    {
        return match ($role) {
            Role::SuperAdmin => self::cases(),
            Role::Admin => self::cases(),
            Role::Teacher => [],
            Role::Student => [],
            default => [],
        };
    }
}
