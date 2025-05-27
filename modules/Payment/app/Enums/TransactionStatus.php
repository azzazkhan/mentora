<?php

namespace Modules\Payment\Enums;

use App\Concerns\Enum\Resolvable;
use ArchTech\Enums\Values;

enum TransactionStatus: string
{
    use Values, Resolvable;

    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Expired = 'expired';
}
