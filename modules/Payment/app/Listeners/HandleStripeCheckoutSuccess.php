<?php

namespace Modules\Payment\Listeners;

use Laravel\Cashier\Events\WebhookReceived;
use Modules\Payment\Enums\TransactionStatus;
use Modules\Payment\Models\Transaction;

class HandleStripeCheckoutSuccess
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
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            $session = $event->payload['data']['object']['id'];

            /** @var \Modules\Payment\Models\Transaction $transaction */
            $transaction = Transaction::query()->where('session', $session)->first();

            if ($transaction) {
                $transaction->update(['status' => TransactionStatus::Completed]);

                $transaction->enrollment()->update(['enrolled_at' => now()]);
            }
        }
    }
}
