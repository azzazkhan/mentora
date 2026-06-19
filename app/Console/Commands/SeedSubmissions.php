<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Modules\Assignment\Enums\Submission\Status;
use Modules\Assignment\Models\Assignment;
use Modules\Assignment\Models\Submission;
use Modules\Attachment\Events\AttachmentCreated;
use Modules\Attachment\Models\Attachment;

class SeedSubmissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-submissions {assignment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! str($this->argument('assignment'))->isUuid()) {
            $this->error('Assignment must be a valid UUID');
            return;
        }

        $assignment = Assignment::where('uuid', $this->argument('assignment'))->first();

        if (! $assignment) {
            $this->error('Assignment not found');
            return;
        }

        // $assignment->submissions()->delete();

        // return;

        $this->info('Seeding submissions for assignment: ' . $assignment->title);

        $classroom = $assignment->classroom;

        $classroom->enrolledStudents()->take(10)->each(function (User $student) use ($assignment) {
            if ($submission = $assignment->submissions()->where('user_id', $student->id)->first()) {
                $this->info('Submission already exists for student: ' . $student->name);

                return $submission;
            }

            $this->info('Seeding submission for student: ' . $student->name);

            $submission = new Submission([
                'grade' => random_int(5, 10) * 10,
                'status' => Status::TurnedIn,
                'is_late' => false,
                'submitted_at' => now(),
            ]);

            $submission->user()->associate($student);
            $submission->assignment()->associate($assignment);
            $submission->save();

            Attachment::factory()
                ->count(random_int(1, 3))
                ->for($submission, 'attachable')
                ->for($student, 'user')
                ->create()
                ->each(function (Attachment $attachment) {
                    event(new AttachmentCreated($attachment));
                });
        });

        $this->info('Submissions seeded successfully');
    }
}
