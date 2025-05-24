<?php

namespace Modules\User\Listeners;

use Illuminate\Auth\Events\Registered;
use Modules\Auth\Enums\Role;

class AssignUserRole
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        /** @var \App\Models\User $user */
        $user = $event->user;

        $user->assignRole(Role::Student);
    }
}
