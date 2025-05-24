<?php

namespace Modules\Assignment\Http\Controllers\API;

use App\Enums\Pagination;
use Modules\Assignment\Enums\Submission\Status;
use Modules\Assignment\Http\Controllers\Controller;
use Modules\Assignment\Http\Requests\CreateSubmissionRequest;
use Modules\Assignment\Http\Requests\ListSubmissionsRequest;
use Modules\Assignment\Http\Requests\ShowSubmissionRequest;
use Modules\Assignment\Http\Requests\UpdateSubmissionRequest;
use Modules\Assignment\Models\Assignment;
use Modules\Assignment\Http\Resources\SubmissionResource;
use Modules\Assignment\Models\Submission;

class SubmissionController extends Controller
{
    /**
     * Get the submissions for specified assignment.
     */
    public function index(ListSubmissionsRequest $request, Assignment $assignment)
    {
        $query = $assignment->submissions()->with(['user', 'attachments']);

        return SubmissionResource::collection(paginate($query, type: Pagination::Cursor));
    }

    /**
     * Get the details of a specified submission.
     */
    public function show(
        ShowSubmissionRequest $request,
        Assignment $assignment,
        Submission $submission
    ) {
        return new SubmissionResource($submission->load(['user', 'attachments']));
    }

    /**
     * Update the specified submission.
     */
    public function update(
        UpdateSubmissionRequest $request,
        Assignment $assignment,
        Submission $submission
    ) {
        if ($submission->user()->is($request->user())) {
            if ($submission->status->isNot([Status::Pending, Status::TurnedIn, Status::Missing])) {
                abort(403);
            }

            if (
                $submission->status->is(Status::Missing)
                && $submission->assignment->due_date->isPast()
                && ! $submission->assignment->allow_late
            ) {
                abort(403);
            }
        }

        abort(406);


        $submission->update($request->validated());

        return new SubmissionResource($submission->load(['user', 'attachments']));
    }
}
