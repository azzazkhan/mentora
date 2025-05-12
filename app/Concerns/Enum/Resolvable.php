<?php

namespace App\Concerns\Enum;

use Illuminate\Support\Arr;

trait Resolvable
{
    /**
     * Resolve the enum either from instance or case value.
     *
     * @param  static|string|int  $value
     * @param  bool  $strict
     * @return ($strict is true ? static : static|null)
     */
    public static function resolve(self|string $value, bool $strict = false)
    {
        if ($value instanceof static) {
            return $value;
        }

        return $strict ? static::from($value) : static::tryFrom($value);
    }

    /**
     * Check if the enum is one of the given values.
     *
     * @param  mixed  $values
     * @return bool
     */
    public function is(mixed $values): bool
    {
        foreach (Arr::wrap($values) as $value) {
            if (self::resolve($value) === $this) {
                return true;
            }
        }

        return false;
    }
}
