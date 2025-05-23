<?php

namespace Modules\Assignment\Http\Controllers\API;

use App\Enums\Pagination;
use Modules\Assignment\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Assignment\Http\Requests\CreateAssignmentRequest;
use Modules\Assignment\Http\Requests\DeleteAssignmentRequest;
use Modules\Assignment\Http\Requests\ListAssignmentsRequest;
use Modules\Assignment\Http\Requests\ShowAssignmentRequest;
use Modules\Assignment\Http\Requests\UpdateAssignmentRequest;
use Modules\Assignment\Http\Resources\AssignmentResource;
use Modules\Assignment\Models\Assignment;
use Modules\Attachment\Models\Attachment;
use Modules\Classroom\Models\Classroom;

class AssignmentController extends Controller
{
    /**
     * Show all the assignments for the specified classroom.
     */
    public function index(ListAssignmentsRequest $request, Classroom $classroom)
    {
        // $status = $request->string('status');

        $query = $classroom
            ->assignments()
            ->with(['teacher' => ['user'], 'attachments'])
            ->where('archived', false);
        // ->when($status, function ($query) use ($status) {
        //     // return match ($status) {
        //     //     'pending' => $query->where('status', Status::Pending),
        //     //     'completed' => $query->where('status', Status::Completed),
        //     //     default => $query,
        //     // };
        // });

        return AssignmentResource::collection(paginate($query, type: Pagination::Cursor));
    }

    /**
     * Create a new assignment in the specified classroom.
     */
    public function store(CreateAssignmentRequest $request, Classroom $classroom)
    {
        $assignment = $classroom
            ->assignments()
            ->create($request->only(['title', 'description', 'due_date']));

        /** @var list<string> $attachments */
        $attachments = $request->collect('attachments')->unique()->values()->all();

        $request
            ->user()
            ->attachments()
            ->whereIn('uuid', $attachments)
            ->update([
                'attachable_type' => Assignment::class,
                'attachable_id' => $assignment->getKey()
            ]);

        return new AssignmentResource($assignment->load('attachments'));
    }

    /**
     * Get the specified assignment.
     */
    public function show(ShowAssignmentRequest $request, Assignment $assignment)
    {
        $assignment->load(['teacher' => ['user'], 'attachments']);

        return new AssignmentResource($assignment);
    }

    /**
     * Update the specified assignment.
     */
    public function update(UpdateAssignmentRequest $request, Assignment $assignment)
    {
        abort_if($assignment->archived, 404);

        $assignment->update(array_merge($request->only(['description', 'due_date']), [
            'edited' => true,
        ]));

        if ($request->has('attachments')) {
            /** @var list<string> $attachments */
            $attachments = $request->collect('attachments')->unique()->values()->all();

            // Scheduled task will auto-delete stale non-attached files
            $assignment->attachments()->whereNotIn('uuid', $attachments)->update([
                'attachable_type' => null,
                'attachable_id' => null,
            ]);

            $request
                ->user()
                ->attachments()
                ->whereIn('uuid', $attachments)
                ->update([
                    'attachable_type' => Assignment::class,
                    'attachable_id' => $assignment->getKey()
                ]);
        }

        return new AssignmentResource($assignment->load(['teacher' => ['user'], 'attachments']));
    }

    /**
     * Delete the specified assignment.
     */
    public function destroy(DeleteAssignmentRequest $request, Assignment $assignment)
    {
        $assignment->update(['archived' => true]);

        return response()->json(null, 204);
    }
}
