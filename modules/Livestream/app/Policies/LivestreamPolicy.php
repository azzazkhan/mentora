<?php

namespace Modules\Livestream\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;
use Modules\Auth\Enums\Role;
use Modules\Livestream\Models\Livestream;

class LivestreamPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        return true;

        if ($user->hasRole([Role::SuperAdmin, Role::Admin]) && ! in_array($ability, ['delete'])) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([Role::SuperAdmin, Role::Admin, Role::Teacher]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Livestream $livestream): bool
    {
        return match (true) {
            $user->hasRole(Role::Teacher) => $livestream->classroom->teacher()->is($user->teacher),
            $user->hasRole(Role::Student) => $livestream->classroom->enrolledStudents()->wherePivot('user_id', $user->getKey())->exists(),
            default => false,
        };
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(Role::Teacher);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Livestream $livestream): bool
    {
        return $user->hasRole(Role::Teacher) && $livestream->classroom->teacher()->is($user->teacher);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Livestream $livestream): bool
    {
        return $user->hasRole(Role::Teacher) && $livestream->classroom->teacher()->is($user->teacher);
    }
}
