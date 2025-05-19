<?php

namespace Modules\Auth\Enums;

use App\Contracts\HasLabel;
use App\Models\User;
use ArchTech\Enums\Values;
use Illuminate\Support\Arr;
use Modules\Auth\Permission;
use Spatie\Permission\Models\Role as SpatieRole;

enum Role: string implements HasLabel
{
    use Values;

    case SuperAdmin = 'super-admin';
    case Admin = 'admin';
    case Teacher = 'teacher';
    case Student = 'student';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Admin => 'Admin',
            self::Teacher => 'Teacher',
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
            self::Teacher => 2,
            self::Student => 3,
        };
    }

    /**
     * Get the unique permissions associated with each role.
     *
     * @return list<\BackedEnum>
     */
    public function getPermissions(): array
    {
        return Permission::forRole($this);
    }

    /**
     * Try to resolve role from Spatie's role model.
     *
     * @param  Spatie\Permission\Models\Role  $role
     * @return \Modules\User\Enums\Role
     */
    public static function fromModel(SpatieRole $role)
    {
        return self::from($role->name);
    }

    /**
     * Try to get highest priority role for the user.
     *
     * @param  \App\Models\User|int  $user
     * @return \Modules\User\Enums\Role|null
     */
    public static function forUser(User|int $user)
    {
        $user = is_numeric($user) ? User::find($user) : $user;
        $role = $user->roles()->orderBy('priority')->first();

        return $role ? self::tryFrom($role->name) : null;
    }

    /**
     * @param  mixed  $roles
     * @return bool
     */
    public function is(mixed $roles): bool
    {
        foreach (Arr::wrap($roles) as $role) {
            $result = match (true) {
                $role instanceof self => $role->value == $this->value,
                $role instanceof SpatieRole => $role->name == $this->value,
                default => false,
            };

            if ($result) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  mixed $roles
     * @return bool
     */
    public function isNot(mixed $roles): bool
    {
        return ! $this->is($roles);
    }
}
