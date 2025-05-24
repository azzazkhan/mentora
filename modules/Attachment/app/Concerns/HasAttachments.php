<?php

namespace Modules\Attachment\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Attachment\Models\Attachment;

trait HasAttachments
{
    /**
     * Get the attachments for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany<Attachment>
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
