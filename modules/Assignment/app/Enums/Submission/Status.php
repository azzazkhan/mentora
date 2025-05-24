<?php

namespace Modules\Assignment\Enums\Submission;

use App\Concerns\Enum\Resolvable;
use ArchTech\Enums\Values;

enum Status: string
{
    use Values, Resolvable;

    case Pending = 'pending'; // Not turned-in yet
    case Missing = 'missing'; // Missing  (past due date)
    case TurnedIn = 'turned-in'; // Turned-in for submission
    case Locked = 'locked'; // Turned-in (past due date)
    case Processing = 'processing'; // Queued up processing
    case Finalized = 'finalized'; // Processed
}
