<?php

namespace Modules\Auth\Enums\Permission;

use ArchTech\Enums\Values;
use Modules\Auth\Enums\Role;

enum SubmissionPermission: string
{
    use Values;

    case ListAll = 'list-all-submissions';
    case UpdateAll = 'update-all-submissions';

    case Create = 'create-submission';
    case Update = 'update-attachment';

    public static function role(Role $role)
    {
        return match ($role) {
            Role::SuperAdmin => [self::ListAll, self::UpdateAll],
            Role::Admin => [self::ListAll, self::UpdateAll],
            Role::Teacher => [],
            Role::Student => [self::Create, self::Update],
            default => [],
        };
    }
}
