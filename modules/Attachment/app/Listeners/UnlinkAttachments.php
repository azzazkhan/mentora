<?php

namespace Modules\Attachment\Listeners;

use InvalidArgumentException;
use Modules\Announcement\Events\AnnouncementDeleted;
use Modules\Assignment\Events\AssignmentDeleted;

class UnlinkAttachments
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
    public function handle(object $event): void
    {
        $model = match (true) {
            $event instanceof AnnouncementDeleted => $event->announcement,
            $event instanceof AssignmentDeleted => $event->assignment,
            default => throw new InvalidArgumentException('The provided event is of unexpected type'),
        };

        $model->attachments()->update([
            'attachable_type' => null,
            'attachable_id' => null,
        ]);
    }
}
