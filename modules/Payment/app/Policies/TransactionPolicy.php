<?php

namespace Modules\Payment\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;
use Modules\Auth\Enums\Role;
use Modules\Payment\Models\Transaction;

class TransactionPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole([Role::SuperAdmin, Role::Admin])) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole([Role::SuperAdmin, Role::Admin]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        return $transaction->user()->is($user);
    }
}
