<?php

namespace Modules\Assignment\Enums\Submission;

use App\Concerns\Enum\Resolvable;
use ArchTech\Enums\Values;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status: string implements HasLabel, HasColor
{
    use Values, Resolvable;

    case Pending = 'pending'; // Not turned-in yet
    case Missing = 'missing'; // Missing  (past due date)
    case TurnedIn = 'turned-in'; // Turned-in for submission
    case Locked = 'locked'; // Turned-in (past due date)
    case Processing = 'processing'; // Queued up processing
    case Finalized = 'finalized'; // Processed

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Missing => 'Missing',
            self::TurnedIn => 'Turned In',
            self::Locked => 'Locked',
            self::Processing => 'Processing',
            self::Finalized => 'Finalized',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Missing => 'danger',
            self::TurnedIn => 'success',
            self::Locked => 'danger',
            self::Processing => 'warning',
            self::Finalized => 'success',
        };
    }
}
