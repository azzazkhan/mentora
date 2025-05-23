<?php

namespace Modules\Assignment\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Assignment\Events\AssignmentCreated;
use Modules\Assignment\Models\Submission;

class CreateSubmissions implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AssignmentCreated $event): void
    {
        $assignment = $event->assignment;

        $assignment
            ->classroom
            ->enrolledStudents()
            ->each(function (User $student) use ($assignment) {
                $submission = new Submission();
                $submission->user()->associate($student);
                $submission->assignment()->associate($assignment);
                $submission->save();
            });
    }
}
