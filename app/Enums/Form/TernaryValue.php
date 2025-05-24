<?php

namespace App\Enums\Form;

use App\Contracts\HasLabel;

enum TernaryValue: string implements HasLabel
{
    case Include = 'include';
    case Exclude = 'exclude';
    case Only = 'only';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Include => 'Include',
            self::Exclude => 'Exclude',
            self::Only => 'Only',
        };
    }
}
