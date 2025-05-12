<?php

namespace Modules\Classroom\Enums;

use ArchTech\Enums\Values;
use App\Concerns\Enum\Resolvable;
use App\Contracts\HasLabel;

enum Status: string implements HasLabel
{
    use Values, Resolvable;

    case Pending = 'pending';
    case RegistrationOpen = 'reg-open';
    case RegistrationClosed = 'reg-closed';
    case Started = 'started';
    case Ended = 'ended';
    case Paused = 'paused';
    case Archived = 'archived';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::RegistrationOpen => 'Registration Open',
            self::RegistrationClosed => 'Registration Closed',
            self::Started => 'Started',
            self::Ended => 'Ended',
            self::Paused => 'Paused',
            self::Archived => 'Archived',
        };
    }
}
