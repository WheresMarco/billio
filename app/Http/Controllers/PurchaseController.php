<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TicketType;

class PurchaseController extends Controller
{
    public function single($eventSlug, $ticketType)
    {
        $ticketType = TicketType::where('slug', $ticketType)->first();

        if (! $ticketType) {
            return redirect('/');
        }

        $event = $ticketType->event->first();

        return view('event.purchase.single', [
            'event' => $event,
            'ticketType' => $ticketType
        ]);
    }

    public function confirmation()
    {
        return view('event.purchase.confirmation');
    }

    public function createPaymentIntent()
    {
        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe::paymentIntents()->create([
            'amount' => 1000,
            'currency' => 'sek',
            'payment_method_types' => [
                'card'
            ],
        ]);

        $output = [
            'clientSecret' => $paymentIntent['client_secret'],
        ];

        return $output;
    }
}
