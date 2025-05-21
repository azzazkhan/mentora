<?php

namespace App\Enums\Form;

use App\Contracts\HasLabel;

enum BinaryValue: string implements HasLabel
{
    case Yes = 'true';
    case No = 'false';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Yes => 'Yes',
            self::No => 'No',
        };
    }
}
