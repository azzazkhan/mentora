<?php

namespace Modules\Classroom\Concerns\Eloquent;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Modules\Classroom\Enums\Status;

/**
 * @property-read Status $status
 */
trait HasAttributes
{
    /**
     * Check if the classroom is in pending state.
     */
    protected function pending(): Attribute
    {
        return new Attribute(
            get: function (mixed $value, array $attributes) {
                return Status::resolve($attributes['status']) === Status::Pending;
            },
        );
    }

    /**
     * Check if the registrations for this classroom are open.
     */
    protected function registrationOpen(): Attribute
    {
        return new Attribute(
            get: function (mixed $value, array $attributes) {
                return Status::resolve($attributes['status']) === Status::RegistrationOpen;
            },
        );
    }

    /**
     * Check if the registrations for this classroom are closed.
     */
    protected function registrationClosed(): Attribute
    {
        return new Attribute(
            get: function (mixed $value, array $attributes) {
                return Status::resolve($attributes['status']) === Status::RegistrationClosed;
            },
        );
    }

    /**
     * Check if the classroom is started.
     */
    protected function started(): Attribute
    {
        return new Attribute(
            get: function (mixed $value, array $attributes) {
                return Status::resolve($attributes['status']) === Status::Started;
            },
        );
    }

    /**
     * Check if the classroom is paused.
     */
    protected function paused(): Attribute
    {
        return new Attribute(
            get: function (mixed $value, array $attributes) {
                return Status::resolve($attributes['status']) === Status::Paused;
            },
        );
    }

    /**
     * Check if the classroom is ended.
     */
    protected function ended(): Attribute
    {
        return new Attribute(
            get: function (mixed $value, array $attributes) {
                return Status::resolve($attributes['status']) === Status::Ended;
            },
        );
    }

    /**
     * Check if the classroom is in archived state.
     */
    protected function archived(): Attribute
    {
        return new Attribute(
            get: function (mixed $value, array $attributes) {
                return Status::resolve($attributes['status']) === Status::Archived;
            },
        );
    }
}
