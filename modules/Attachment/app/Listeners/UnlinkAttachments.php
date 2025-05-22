<?php

namespace Modules\Attachment\Listeners;

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
        $event->model->attachments()->update([
            'attachable_type' => null,
            'attachable_id' => null,
        ]);
    }
}
