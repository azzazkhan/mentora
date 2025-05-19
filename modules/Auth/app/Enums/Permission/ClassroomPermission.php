<?php

namespace Modules\Auth\Enums\Permission;

use ArchTech\Enums\Values;
use Modules\Auth\Enums\Role;

enum ClassroomPermission: string
{
    use Values;

    case List = 'list-all-classrooms';
    case Create = 'create-classroom';
    case Update = 'update-all-classrooms';
    case Archive = 'archive-all-classrooms';
    case Restore = 'restore-all-classrooms';

    case Enroll = 'enroll-in-classroom';

    public static function role(Role $role)
    {
        return match ($role) {
            Role::SuperAdmin => [self::List, self::Create, self::Update, self::Archive, self::Restore],
            Role::Admin => [self::List, self::Create, self::Update, self::Archive, self::Restore],
            Role::Teacher => [self::List],
            Role::Student => [self::List],
            default => [],
        };
    }
}
