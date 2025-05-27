<?php

namespace Modules\User\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if (config('cashier.enabled')) {
            $user->createOrGetStripeCustomer();
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if (config('cashier.enabled') && $user->hasStripeId()) {
            $user->syncStripeCustomerDetails();
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        if (config('cashier.enabled') && $user->hasStripeId()) {
            $user->asStripeCustomer()->delete();
        }
    }
}
