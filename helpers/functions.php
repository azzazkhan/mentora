<?php

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

if (!function_exists('carbon')) {
    /**
     * Returns a new Carbon instance.
     * Please see the testing aids section (specifically static::setTestNow())
     * for more on the possibility of this constructor returning a test instance.
     *
     * @param  DateTimeInterface|string|null  $time
     * @param  DateTimeZone|string|null  $tz
     * @throws InvalidFormatException
     */
    function carbon(DateTimeInterface|string|null $time = null, DateTimeZone|string|null $tz = null): Carbon
    {
        return new Carbon($time, $tz);
    }
}

if (!function_exists('random_hex')) {
    /**
     * Creates a new hexadecimal string.
     *
     * @return string
     */
    function random_hex(int $length = 8): string
    {
        $length = clamp(1, $length, 15);

        return Str::upper(str_pad(dechex(rand(0x00000000, 16 ** $length - 1)), $length, 0, STR_PAD_LEFT));
    }
}

if (!function_exists('slugify')) {
    /**
     * An extension of `Str::slug` with extended dictionary and `Str::words`
     * for limit the string.
     *
     * @param  string  $title
     * @param  string  $separator
     * @param  string  $language
     * @param  array<string, string>  $dictionary
     * @param  int  $words
     * @return string
     */
    function slugify(string $title, string $separator = '-', string $language = 'en', array $dictionary = [], int $words = 5,)
    {
        $dictionary = array_merge(['@' => 'at', '&' => 'and'], $dictionary);

        $title = $words > 0 ? Str::words($title, $words, '') : $title;

        return Str::slug($title, $separator, $language, $dictionary);
    }
}

if (!function_exists('extract_array')) {
    /**
     * Extracts specified keys from provided array if they exist.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string>  $keys
     * @return array<string, mixed>
     */
    function extract_array(array $data, array $keys): array
    {
        $result = [];

        foreach ($keys as $key) {
            // Only string keys are allowed
            if (!$key || !is_string($key)) {
                continue;
            }

            // Key names ending with exclamation (key1!) will not be checked
            // for nullish values
            $nulls = substr($key, -1) == "!";

            // Remove the exclamation mark (if added)
            $keyName = $nulls ? substr($key, 0, strlen($key) - 1) : $key;

            // The specified key should be included in the data and should not
            // be null (if not omitted)
            if (isset($data[$keyName]) && ($nulls || !is_null($key))) {
                $result[$keyName] = $data[$keyName];
            }
        }

        return $result;
    }
}

if (!function_exists('array_remove')) {
    /**
     * Removes the specified elements from the numeric arrays.
     *
     * @param  mixed  $keys
     * @param  array  $array
     */
    function array_remove(mixed $keys, array $array): array
    {
        $result = [];

        foreach ($array as $value) {
            // If provided (single) key matches skip this iteration
            if (!is_array($keys) && $keys == $value) {
                continue;
            }

            // If provided keys is an array of keys loop through each key
            if (is_array($keys)) {
                // If a key matches the value skip the outer loop iteration
                foreach ($keys as $key) {
                    if ($key == $value) {
                        continue 2;
                    }
                }
            }

            $result[] = $value;
        }

        return $result;
    }
}

if (!function_exists('prefix_table')) {
    /**
     * Adds table prefix to specified column name(s).
     *
     * @param  \Illuminate\Database\Eloquent\Model|string|class-string  $table
     * @param  string|array  $columns
     * @param  bool  $wrap
     * @return array
     */
    function prefix_table(Model|string $table, string|array $columns, bool $wrap = false): array
    {
        $table = match (true) {
            $table instanceof Model => $table->getTable(),
            class_exists($table) => resolve($table)->getTable(),
            default => $table,
        };

        $columns = Arr::wrap($columns);

        return array_map(function (mixed $column) use ($table, $wrap) {
            if (!is_string($column)) {
                return $column;
            }

            return $wrap ? "`{$table}`.`{$column}`" : "{$table}.{$column}";
        }, $columns);
    }
}

if (! function_exists('get_columns')) {
    /**
     * Get columns for specified model/table.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string|class-string  $model
     * @param  array<string>  $only
     * @param  array<string>  $except
     * @param  bool  $prefix
     * @return array<string>
     */
    function get_columns(
        Model|string $model,
        array $only = [],
        array $except = [],
        bool $prefix = false
    ): array {
        $table = match (true) {
            $model instanceof Model => $model->getTable(),
            class_exists($model) => resolve($model)->getTable(),
            default => $model,
        };

        $columns = collect(
            Cache::get(
                sprintf('%s.columns', $table),
                fn() => Schema::getColumnListing($table),
                now()->addSecond(),
            )
        );

        $only = collect($only)->map(fn(string $column) => Str::squish($column))->filter();
        $except = collect($except)->map(fn(string $column) => Str::squish($column))->filter();

        return $columns
            ->when($only->isNotEmpty(), function (Collection $columns) use (&$only) {
                return $columns->filter(fn(string $column) => $only->contains($column));
            })
            ->when($except->isNotEmpty(), function (Collection $columns) use (&$except) {
                return $columns->filter(fn(string $column) => !$except->contains($column));
            })
            ->when($prefix, function (Collection $columns) use ($table) {
                return $columns->map(fn(string $column) => "{$table}.{$column}");
            })
            ->all();
    }
}

if (!function_exists('str_limit')) {
    /**
     * Limits the provided string to specific number of characters.
     *
     * @param  string  $string
     * @param  int  $limit
     * @param  string  $end
     * @return string
     */
    function str_limit(string $string, int $limit, $end = ''): string
    {
        return Str::limit($string, $limit, $end);
    }
}

if (!function_exists('get_classname')) {
    /**
     * Extracts the actual class name from provided FQN class name (if class exists).
     *
     * @param  class-string|object  $class
     * @return string
     */
    function get_classname(string|object $class): string
    {
        $classname = is_string($class) ? $class : get_class($class);

        return class_exists($classname) ? last(explode('\\', $classname)) : $classname;
    }
}

if (! function_exists('clamp')) {
    /**
     * Clamps the value between specified limits.
     *
     * @param  float|int  $min
     * @param  float|int  $default
     * @param  float|int  $max
     * @return float|int
     */
    function clamp(float|int $min, float|int $default, float|int $max): float|int
    {
        $min = min($min, $max);
        $max = max($min, $max);

        return $default < $min ? $min : ($default > $max ? $max : $default);
    }
}
