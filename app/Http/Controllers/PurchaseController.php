<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TicketType;

class PurchaseController extends Controller
{
    public function info($eventSlug, $ticketType)
    {
        $ticketType = TicketType::where('slug', $ticketType)->first();

        if (! $ticketType) {
            return redirect('/');
        }

        $event = $ticketType->event->first();

        return view('event.purchase.info', [
            'event' => $event,
            'ticketType' => $ticketType
        ]);
    }

    public function selectSeating($eventSlug, $ticketType)
    {
        $ticketType = TicketType::where('slug', $ticketType)->first();

        if (! $ticketType) {
            return redirect('/');
        }

        $event = $ticketType->event->first();

        return view('event.purchase.seating', [
            'event' => $event,
            'ticketType' => $ticketType
        ]);
    }

    public function payment()
    {
        return view('event.purchase.payment');
    }

    public function confirmation()
    {
        return view('event.purchase.confirmation');
    }

    public function createPaymentIntent()
    {

        // TODO Create a pending ticket in database.

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

        // TODO Save ticket secret in ticket object and clear unused ones after 10 min.

        return $output;
    }
}
