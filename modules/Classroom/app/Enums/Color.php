<?php

namespace Modules\Classroom\Enums;

use ArchTech\Enums\Values;

enum Color: string
{
    use Values;

    case Blue = 'blue';
    case Green = 'green';
    case Pink = 'pink';
    case Orange = 'orange';
    case Cyan = 'cyan';
    case Purple = 'purple';
    case Sky = 'sky';
    case Gray = 'gray';

    public function getBackground(): string
    {
        return match ($this) {
            self::Blue => 'bg-blue-700',
            self::Green => 'bg-green-700',
            self::Pink => 'bg-pink-700',
            self::Orange => 'bg-orange-700',
            self::Cyan => 'bg-cyan-700',
            self::Purple => 'bg-purple-700',
            self::Sky => 'bg-sky-700',
            self::Gray => 'bg-gray-700',
        };
    }

    public function getText(): string
    {
        return match ($this) {
            self::Blue => 'text-blue-700',
            self::Green => 'text-green-700',
            self::Pink => 'text-pink-700',
            self::Orange => 'text-orange-700',
            self::Cyan => 'text-cyan-700',
            self::Purple => 'text-purple-700',
            self::Sky => 'text-sky-700',
            self::Gray => 'text-gray-700',
        };
    }
}
