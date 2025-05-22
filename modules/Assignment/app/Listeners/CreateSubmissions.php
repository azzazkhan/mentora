<?php

namespace Modules\Assignment\Listeners;

use App\Models\User;
use Modules\Assignment\Events\AssignmentCreated;

class CreateSubmissions
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
        $students = $assignment->classroom->enrolledStudents()->get(['users.id']);

        $assignment->submissions()->createMany(
            $students->map(fn(User $student) => [
                'user_id' => $student->id,
            ])
        );
    }
}
