<?php

namespace Modules\Payment\Enums;

use ArchTech\Enums\Values;

enum TransactionStatus: string
{
    use Values;

    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Expired = 'expired';
}
