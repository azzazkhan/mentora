<?php

namespace App\Enums;

enum Pagination: string
{
    case Basic = 'basic';
    case Simple = 'simple';
    case Cursor = 'cursor';
}
