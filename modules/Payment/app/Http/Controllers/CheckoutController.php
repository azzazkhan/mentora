<?php

namespace Modules\Payment\Http\Controllers;

use Modules\Payment\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Cashier\Cashier;
use Modules\Payment\Enums\TransactionStatus;
use Modules\Payment\Models\Transaction;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class CheckoutController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Transaction $transaction)
    {
        Gate::authorize('view', $transaction);

        if ($transaction->status->isNot(TransactionStatus::Pending)) {
            $route = route('classroom.show', $transaction->enrollment->classroom, absolute: false);

            return match ($transaction->status) {
                TransactionStatus::Completed => view('payment::checkout.success', [
                    'amount' => number_format($transaction->amount / 100),
                    'currency' => strtoupper($transaction->currency),
                    'route' => $route,
                ]),

                TransactionStatus::Cancelled, TransactionStatus::Expired => view('payment::checkout.cancelled'),

                default => abort(500),
            };
        }

        try {
            $session = Cashier::stripe()->checkout->sessions->retrieve($transaction->session);

            switch ($session->status):
                case 'open':
                    return view('payment::checkout.pending', [
                        'transaction' => $transaction,
                        'url' => $session->url,
                    ]);

                    break;

                case 'complete':
                    $route = route('classroom.show', $transaction->enrollment->classroom, absolute: false);
                    $transaction->update(['status' => TransactionStatus::Completed]);
                    $transaction->enrollment()->update(['enrolled_at' => now()]);

                    return view('payment::checkout.success', [
                        'amount' => number_format($transaction->amount / 100),
                        'currency' => strtoupper($transaction->currency),
                        'route' => $route,
                    ]);

                    break;

                case 'expired':
                    $transaction->update(['status' => TransactionStatus::Expired]);

                    // Reset enrollment so student can enroll again
                    $transaction->enrollment()->delete();

                    return view('payment::checkout.cancelled');

                    break;
            endswitch;
        } catch (ApiErrorException) {
            throw new NotFoundHttpException;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        Gate::authorize('view', $transaction);

        // TODO: Check if already completed

        $transaction->update(['status' => TransactionStatus::Cancelled]);

        // Reset enrollment so student can enroll again
        $transaction->enrollment()->delete();

        return view('payment::checkout.cancelled');
    }
}
