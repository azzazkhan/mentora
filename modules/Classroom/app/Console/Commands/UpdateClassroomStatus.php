<?php

namespace Modules\Classroom\Console\Commands;

use Illuminate\Console\Command;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Models\Classroom;

class UpdateClassroomStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'classroom:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates classroom status prop based on timestamps';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Classroom::query()
            ->where('status', Status::Pending)
            ->where('registration_started_at', '<', now())
            ->update(['status' => Status::RegistrationOpen]);

        Classroom::query()
            ->where('status', Status::RegistrationOpen)
            ->where('registration_ended_at', '<', now())
            ->where('started_at', '<', now())
            ->update(['status' => Status::Started]);

        Classroom::query()
            ->whereIn('status', [Status::Started])
            ->where('ended_at', '<', now())
            ->update(['status' => Status::Ended]);
    }
}
