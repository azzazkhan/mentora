<?php

namespace Modules\Attachment;

use Modules\Attachment\Concerns\HasAttachments;

abstract class AttachableModelEvent
{
    public HasAttachments $model;

    public function __construct(HasAttachments $model)
    {
        $this->model = $model;
    }
}
