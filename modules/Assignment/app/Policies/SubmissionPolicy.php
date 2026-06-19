<?php

namespace Modules\Assignment\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;
use Modules\Assignment\Enums\Submission\Status;
use Modules\Assignment\Models\Assignment;
use Modules\Assignment\Models\Submission;
use Modules\Auth\Enums\Role;
use Modules\Classroom\Models\Classroom;

class SubmissionPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        return true;

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
        return true;

        return $user->hasRole([Role::SuperAdmin, Role::Admin]);
    }

    /**
     * Determine whether the user can list the model.
     */
    public function list(User $user, Assignment $assignment)
    {
        return true;

        return $assignment->teacher->is($user->teacher);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Submission $submission)
    {
        return true;

        if ($user->hasRole(Role::Student)) {
            return $submission->classroom->enrolled($user)
                && $submission->user()->is($user);
        }

        return $submission->classroom->teacher()->is($user->teacher);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Classroom $classroom)
    {
        return true;

        return $classroom->teacher()->is($user->teacher);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Submission $submission)
    {
        return true;

        if ($submission->user()->is($user)) {
            return $submission->status->is([Status::Pending, Status::TurnedIn]);
        }

        if ($submission->classroom->teacher()->is($user->teacher)) {
            return $submission->status->isNot([
                Status::Pending,
                Status::TurnedIn,
                Status::Missing,
            ]);
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Submission $submission)
    {
        return false;
    }
}
