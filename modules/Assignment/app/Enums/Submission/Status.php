<?php

namespace Modules\Assignment\Enums\Submission;

use ArchTech\Enums\Values;

enum Status: string
{
    use Values;

    case Pending = 'pending';
    case TurnedIn = 'turned-in';
    case Locked = 'locked';
    case Processing = 'processing';
    case Finalized = 'finalized';
}
