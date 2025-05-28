<?php

namespace Modules\Payment\Listeners;

use Modules\Payment\Enums\TransactionStatus;
use Modules\Payment\Models\Transaction;

class HandleStripeCheckoutFailure
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
    public function handle(object $event): void
    {
        if ($event->payload['type'] === 'checkout.session.expired') {
            $session = $event->payload['data']['object']['id'];

            /** @var \Modules\Payment\Models\Transaction $transaction */
            $transaction = Transaction::query()->where('session', $session)->first();

            if ($transaction) {
                $transaction->update(['status' => TransactionStatus::Expired]);

                $transaction->enrollment()->delete();
            }
        }
    }
}
