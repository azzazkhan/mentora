<?php

namespace Modules\Announcement\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;
use Modules\Announcement\Models\Announcement;
use Modules\Auth\Enums\Role;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Models\Classroom;

class AnnouncementPolicy
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
    public function viewAny(User $user, Classroom $classroom = null): bool
    {
        if (! $classroom) {
            return true;
        }

        if ($user->hasRole([Role::SuperAdmin, Role::Admin])) {
            return true;
        }

        if ($classroom->teacher()->is($user->teacher)) {
            return true;
        }

        return $classroom->enrolledStudents()->wherePivot('user_id', $user->getKey())->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Announcement $announcement): bool
    {
        if ($user->hasRole(Role::Student)) {
            return $announcement
                ->classroom
                ->enrolledStudents()
                ->wherePivot('user_id', $user->getKey())
                ->exists();
        }

        return $announcement->classroom->teacher()->is($user->teacher);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Classroom $classroom = null): bool
    {
        if (! $classroom) {
            return true;
        }

        if ($user->hasAnyRole([Role::SuperAdmin, Role::Admin])) {
            return true;
        }

        return $classroom->teacher()->is($user->teacher)
            && $classroom->status->is([Status::Started, Status::Paused]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Announcement $announcement): bool
    {
        if ($user->hasAnyRole([Role::SuperAdmin, Role::Admin])) {
            return true;
        }

        return $announcement->classroom->teacher()->is($user->teacher);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Announcement $announcement): bool
    {
        if ($user->hasAnyRole([Role::SuperAdmin, Role::Admin])) {
            return true;
        }

        return $announcement->classroom->teacher()->is($user->teacher);
    }
}
