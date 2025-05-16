<?php

namespace Modules\Assignment\Http\Controllers\API;

use Modules\Assignment\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Assignment\Http\Requests\UpdateSubmissionRequest;
use Modules\Assignment\Http\Resources\SubmissionResource;
use Modules\Assignment\Models\Assignment;
use Modules\Assignment\Models\Submission;

class MySubmissionController extends Controller
{
    /**
     * Get the assignment submission details for current user.
     */
    public function show(Request $request, Assignment $assignment)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $submission = $assignment
            ->submissions()
            ->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
            })
            ->firstOrFail();

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
