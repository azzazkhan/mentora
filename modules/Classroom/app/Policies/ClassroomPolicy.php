<?php

namespace Modules\Classroom\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;
use Modules\Auth\Enums\Role;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Models\Classroom;
use Modules\User\Models\Teacher;

class ClassroomPolicy
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
    public function view(User $user, Classroom $classroom): bool
    {
        return true;

        // Teacher can view classrooms assigned to them
        if ($user->hasRole(Role::Teacher)) {
            return $classroom->teacher()->is($user->teacher);
        }

        // Open classrooms can be accessible by anyone
        if ($classroom->status->is([Status::Pending, Status::RegistrationOpen])) {
            return true;
        }

        // Only enrolled students can view closed classrooms
        return $classroom->students()->wherePivot('user_id', $user->getKey())->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Classroom $classroom): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Classroom $classroom): bool
    {
        return $user->hasAnyRole([Role::SuperAdmin, Role::Admin])
            && $classroom->students()->count() == 0;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Classroom $classroom): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Classroom $classroom): bool
    {
        return false;
    }
}
