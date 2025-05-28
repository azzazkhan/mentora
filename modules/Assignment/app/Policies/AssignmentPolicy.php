<?php

namespace Modules\Assignment\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;
use Modules\Assignment\Models\Assignment;
use Modules\Auth\Enums\Role;
use Modules\Classroom\Models\Classroom;

class AssignmentPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole([Role::SuperAdmin, Role::Admin])) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole([Role::SuperAdmin, Role::Admin, Role::Teacher]);
    }

    /**
     * Determine whether the user can list any models.
     */
    public function list(User $user, Classroom $classroom)
    {
        if ($user->hasRole(Role::Student)) {
            return $classroom
                ->enrolledStudents()
                ->wherePivot('user_id', $user->getKey())
                ->exists();
        }

        return $classroom->teacher()->is($user->teacher);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Assignment $assignment)
    {
        if ($assignment->archived) {
            return Response::denyAsNotFound();
        }

        if ($user->hasRole(Role::Student)) {
            return $assignment
                ->classroom
                ->enrolledStudents()
                ->wherePivot('user_id', $user->getKey())
                ->exists();
        }

        return $assignment->teacher->is($user->teacher);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Classroom $classroom = null)
    {
        if (! $classroom) {
            return true;
        }

        return $classroom->teacher()->is($user->teacher);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assignment $assignment)
    {
        if ($assignment->archived) {
            return Response::denyAsNotFound();
        }

        return $assignment->teacher->is($user->teacher);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assignment $assignment)
    {
        if ($assignment->archived) {
            return Response::denyAsNotFound();
        }

        return $assignment->teacher->is($user->teacher);
    }
}
