<?php

namespace Modules\Assignment\Http\Controllers\API;

use Modules\Assignment\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Assignment\Http\Requests\CreateAssignmentRequest;
use Modules\Assignment\Http\Requests\ListAssignmentsRequest;
use Modules\Assignment\Http\Requests\UpdateAssignmentRequest;
use Modules\Assignment\Http\Resources\AssignmentResource;
use Modules\Assignment\Models\Assignment;
use Modules\Classroom\Models\Classroom;

class AssignmentController extends Controller
{
    /**
     * Show all the assignments for the specified classroom.
     */
    public function index(ListAssignmentsRequest $request, Classroom $classroom)
    {
        // $status = $request->string('status');

        $assignments = $classroom
            ->assignments()
            // ->when($status, function ($query) use ($status) {
            //     // return match ($status) {
            //     //     'pending' => $query->where('status', Status::Pending),
            //     //     'completed' => $query->where('status', Status::Completed),
            //     //     default => $query,
            //     // };
            // })
            ->paginate(10);

        return AssignmentResource::collection($assignments);
    }

    /**
     * Create a new assignment in the specified classroom.
     */
    public function store(CreateAssignmentRequest $request, Classroom $classroom)
    {
        $assignment = $classroom->assignments()->create($request->validated());

        return new AssignmentResource($assignment);
    }

    /**
     * Get the specified assignment.
     */
    public function show(Assignment $assignment)
    {
        return new AssignmentResource($assignment);
    }

    /**
     * Update the specified assignment.
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        $assignment->update(array_merge($request->validated(), [
            'edited' => true,
        ]));

        return new AssignmentResource($assignment);
    }

    /**
     * Delete the specified assignment.
     */
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();

        return response()->json(null, 204);
    }
}
