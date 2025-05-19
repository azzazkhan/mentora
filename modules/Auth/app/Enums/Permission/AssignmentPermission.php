<?php

namespace Modules\Auth\Enums\Permission;

use ArchTech\Enums\Values;
use Modules\Auth\Enums\Role;

enum AssignmentPermission: string
{
    use Values;

    case Create = 'create-assignment';
    case Update = 'update-assignment';
    case Delete = 'delete-assignment';

    public static function role(Role $role)
    {
        return match ($role) {
            Role::SuperAdmin => self::cases(),
            Role::Admin => self::cases(),
            Role::Teacher => [self::Create, self::Update, self::Delete],
            Role::Student => [],
            default => [],
        };
    }
}
