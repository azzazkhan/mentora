<?php

namespace Modules\Payment\Enums;

use App\Concerns\Enum\Resolvable;
use ArchTech\Enums\Values;
use Filament\Support\Contracts\HasColor;

enum TransactionStatus: string implements HasColor
{
    use Values, Resolvable;

    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Expired = 'expired';

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Completed => 'success',
            self::Cancelled => 'danger',
            self::Expired => 'gray',
        };
    }
}
