<?php

namespace Modules\Classroom\Concerns\Eloquent;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Modules\Classroom\Enums\Status;

trait HasQueryScopes
{
    /**
     * Scope a query to only include classrooms of a given status.
     */
    #[Scope]
    protected function ofStatus(Builder $query, mixed $status): void
    {
        $values = collect($status)
            ->map(fn(mixed $status) => Status::resolve($status))
            ->filter();

        if ($values->isNotEmpty()) {
            $query->whereIn('status', $values->all());
        }
    }
}
