<?php

namespace Modules\Assignment\Enums;

use ArchTech\Enums\Values;

enum Status: string
{
    use Values;

    case Pending = 'pending';
    case Completed = 'completed';
}
