<?php

namespace Modules\Auth\Enums;

use App\Contracts\HasLabel;
use ArchTech\Enums\Values;

enum Role: string implements HasLabel
{
    use Values;

    case SuperAdmin = 'super-admin';
    case Admin = 'admin';
    case Instructor = 'instructor';
    case Student = 'student';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Admin => 'Admin',
            self::Instructor => 'Instructor',
            self::Student => 'Student',
        };
    }

    /**
     * Get the priority order the the role (smaller number has higher priority).
     *
     * @return int
     */
    public function getPriority(): int
    {
        return match ($this) {
            self::SuperAdmin => 0,
            self::Admin => 1,
            self::Instructor => 2,
            self::Student => 3,
        };
    }

    /**
     * Get the unique permissions associated with each role.
     *
     * @return array<\Modules\Auth\Enums\Permission>
     */
    public function getPermissions(): array
    {
        return match ($this) {
            self::SuperAdmin => [],
            self::Admin => [],
            self::Instructor => [],
            self::Student => [],
        };
    }

    /**
     * Get the common permissions each role has.
     *
     * @return array<\Modules\Auth\Enums\Permission>
     */
    public function getCommonPermissions(): array
    {
        return [];
    }
}
