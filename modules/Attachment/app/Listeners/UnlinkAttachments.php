<?php

namespace Modules\Attachment\Listeners;

use Modules\Attachment\AttachableModelEvent;

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
    public function handle(AttachableModelEvent $event): void
    {
        $event->model->attachments()->update([
            'attachable_type' => null,
            'attachable_id' => null,
        ]);
    }
}
