<?php

namespace Modules\Classroom\Http\Controllers\API;

use App\Enums\Form\TernaryValue;
use App\Enums\Pagination;
use Illuminate\Database\Eloquent\Builder;
use Modules\Classroom\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Auth\Enums\Role;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Http\Requests\ListClassroomsRequest;
use Modules\Classroom\Http\Requests\ListEnrolledClassroomsRequest;
use Modules\Classroom\Http\Resources\ClassroomResource;
use Modules\Classroom\Models\Classroom;

class ClassroomController extends Controller
{
    /**
     * Get a list of all available classrooms.
     */
    public function index(ListClassroomsRequest $request)
    {
        $user = $request->user();
        $query = Classroom::query()->with(['teacher' => ['user']]);

        // If the current user is a `teacher` then only return the classrooms
        // assigned to that teacher
        if ($user->hasRole(Role::Teacher)) {
            $query->where('teacher_id', $user->teacher->getKey());
        }

        // If the current user is a `student` then query for classrooms that
        // are open and which the current user has not already enrolled into
        if ($user->hasRole(Role::Student)) {
            $query
                ->whereDoesntHave('students', function (Builder $query) use ($user) {
                    $query->where('users.id', $user->getKey());
                })
                ->ofStatus([Status::Pending, Status::RegistrationOpen]);
        }

        return ClassroomResource::collection(paginate($query, type: Pagination::Cursor));
    }

    /**
     * Get the list of classrooms the current user is enrolled in.
     */
    public function enrolled(ListEnrolledClassroomsRequest $request)
    {
        $query = $request->user()->classrooms()->with(['teacher' => ['user']]);

        // Add query filter for including/excluding/only pending enrollments
        // from the database query
        match ($request->enum('pending', TernaryValue::class) ?? TernaryValue::Exclude) {
            TernaryValue::Only => $query->wherePivotNull('enrolled_at'),
            TernaryValue::Exclude => $query->wherePivotNotNull('enrolled_at'),
            default => $query,
        };

        return ClassroomResource::collection(paginate($query, type: Pagination::Cursor));
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        Gate::authorize('view', $classroom);

        $classroom->load(['teacher' => ['user']]);

        return new ClassroomResource($classroom);
    }
}
