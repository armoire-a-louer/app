<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Reservation;
use App\Models\Transaction;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function checkout()
    {
        Reservation::reserveWaitingPayment(auth()->user());
        
        $reservations = Reservation::where('user_id', auth()->id())->whereIn('status', [Reservation::STATUS_WAITING_PAYMENT, Reservation::STATUS_PROTECTED_WAITING_PAYMENT])->get();

        $stripeSecretKey = "sk_test_51ITMg7LcoJJZyXObogUJhorUDbK4KcJtqkkWA4qmTKhSlcKcOzvRMJB8Abx3rHbckDTgNcGG3cIJf6zRaEElNkZT00gzM3YlhH";

        \Stripe\Stripe::setApiKey($stripeSecretKey);

        $product = \Stripe\Product::create([
            'name' => "Paiement Armoire à louer",
            'description' => 'Location',
        ]);

        $amount = 0;
        foreach ($reservations as $reservation) {
            $amount += $reservation->price;
        }

        $price = \Stripe\Price::create([
            'product' => $product->id,
            'unit_amount' => $amount,
            'currency' => 'eur'
        ]);

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price' => $price->id,
                'quantity' => 1
            ]],
            'mode' => 'payment',
            'success_url' => 'https://armoire-a-louer.test/',
            'cancel_url' => 'https://armoire-a-louer.test/canceled',
            'expires_at' => Carbon::now()->addMinutes(30)->timestamp
        ]);

        dd($session);

        $data = [
            'payment_intent_id' => $session->payment_intent,
            'type' => Transaction::TYPE_PAYMENT,
            'status' => Transaction::STATUS_WAITING,
            'user_id' => auth()->id(),
            'amount' => $price->unit_amount,
            'title' => $product->name
        ];

        $transaction = Transaction::create($data);

        foreach ($reservations as $reservation) {
            $reservation->transaction_id = $transaction->id;
            $reservation->save();
        }

        return Inertia::render('Checkout', [
            'payUrl' => $session->url
        ]);
    }

    public function success()
    {

    }

    public function webhook(Request $request)
    {
        $transaction =
            Transaction::
            where('payment_intent_id', $request->get('data')["object"]["id"])
            ->with([
                "reservations" => function ($q) {
                    $q->whereIn("status", [Reservation::STATUS_BASKET, Reservation::STATUS_WAITING_PAYMENT, Reservation::STATUS_PROTECTED_WAITING_PAYMENT]);
                }
            ])
            ->firstOrFail();
        $transaction->status = Transaction::STATUS_SUCCESS;
        $transaction->paid_at = Carbon::now();
        $transaction->save();

        foreach ($transaction->reservations as $reservation) {
            if ($reservation->status === Reservation::STATUS_WAITING_PAYMENT) {
                $reservation->status = Reservation::STATUS_PAID;
            } else if ($reservation->status === Reservation::STATUS_PROTECTED_WAITING_PAYMENT) {
                $reservation->status = Reservation::STATUS_PROTECTED;
            }
            $reservation->save();
        }
    }
}
