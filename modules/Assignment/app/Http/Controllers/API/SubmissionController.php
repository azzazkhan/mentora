<?php

namespace Modules\Assignment\Http\Controllers\API;

use Modules\Assignment\Http\Controllers\Controller;
use Modules\Assignment\Http\Requests\CreateSubmissionRequest;
use Modules\Assignment\Http\Requests\UpdateSubmissionRequest;
use Modules\Assignment\Models\Assignment;
use Modules\Assignment\Http\Resources\SubmissionResource;
use Modules\Assignment\Models\Submission;

class SubmissionController extends Controller
{
    /**
     * Get the submissions for specified assignment.
     */
    public function index(Assignment $assignment)
    {
        $submissions = $assignment->submissions()->paginate();

        return SubmissionResource::collection($submissions);
    }

    /**
     * Submit a new submission for specified assignment.
     */
    public function store(CreateSubmissionRequest $request, Assignment $assignment)
    {
        $submission = $assignment->submissions()->create($request->validated());

        return new SubmissionResource($submission);
    }

    /**
     * Get the details of a specified submission.
     */
    public function show(Submission $submission)
    {
        return new SubmissionResource($submission);
    }

    /**
     * Update the specified submission.
     */
    public function update(UpdateSubmissionRequest $request, Submission $submission)
    {
        $submission->update($request->validated());

        return new SubmissionResource($submission);
    }
}
