<?php

namespace Modules\Auth\Enums\Permission;

use ArchTech\Enums\Values;
use Modules\Auth\Enums\Role;

enum AttachmentPermission: string
{
    use Values;

    case ListAll = 'list-all-attachments';
    case DeleteAll = 'delete-all-attachments';

    case Create = 'create-attachment';
    case Delete = 'delete-attachment';

    public static function role(Role $role)
    {
        return match ($role) {
            Role::SuperAdmin => self::cases(),
            Role::Admin => self::cases(),
            Role::Teacher => [self::Create, self::Delete],
            Role::Student => [self::Create, self::Delete],
            default => [],
        };
    }
}
