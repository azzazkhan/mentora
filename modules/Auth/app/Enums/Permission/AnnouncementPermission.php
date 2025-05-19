<?php

namespace Modules\Auth\Enums\Permission;

use ArchTech\Enums\Values;
use Modules\Auth\Enums\Role;

enum AnnouncementPermission: string
{
    use Values;

    case Create = 'create-announcement';
    case Update = 'update-announcement';
    case Delete = 'delete-announcement';

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
