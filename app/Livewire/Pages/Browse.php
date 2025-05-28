<?php

namespace App\Livewire\Pages;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Modules\Classroom\Enums\Status;
use Modules\Classroom\Models\Classroom;
use Modules\Payment\Models\Transaction;

class Browse extends Component
{
    public Collection $classrooms;

    public function mount()
    {
        $user = Auth::user();
        $query = Classroom::query()->with(['teacher' => ['user']]);

        $query
            ->whereDoesntHave('students', function (Builder $query) use ($user) {
                $query->where('users.id', $user->getKey())->whereNotNull('enrolled_at');
            })
            ->ofStatus([Status::Pending, Status::RegistrationOpen]);

        $this->classrooms = $query->get();
    }

    public function render()
    {
        return view('livewire.pages.browse');
    }

    public function checkout(Classroom $classroom)
    {
        $user = Auth::user();
        $uuid = Str::orderedUuid();

        $checkout = $user
            ->checkoutCharge(
                $classroom->fee,
                "Class: {$classroom->name}",
                sessionOptions: [
                    'cancel_url' => URL::temporarySignedRoute(
                        'payment::checkout.failure',
                        now()->addHour(),
                        ['transaction' => $uuid],
                    ),

                    'success_url' => URL::temporarySignedRoute(
                        'payment::checkout.success',
                        now()->addHour(),
                        ['transaction' => $uuid],
                    ),
                ]
            )
            ->asStripeCheckoutSession();

        $transaction = new Transaction([
            'session' => $checkout->id,
            'amount' => $classroom->fee,
            'currency' => config('cashier.currency'),
            'expires_at' => carbon($checkout->expires_at),
        ]);

        $transaction->uuid = $uuid;
        $transaction->user()->associate($user);
        $transaction->save();

        $classroom->students()->detach($user);
        $classroom->students()->attach($user, ['transaction_id' => $transaction->id]);

        return $this->redirect($checkout->url);
    }
}
