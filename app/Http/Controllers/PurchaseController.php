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

    public function addToCart(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Empty cart when adding to cart
        $request->session()->forget('cart');

        // Get the ticket type
        $ticketType = TicketType::find($request->ticket_type_id);

        // Redirect to the event page if the ticket type doesn't exist
        if (! $ticketType) {
            return redirect()->back()->with('error', 'Ticket type does not exist.');
        }

        // Get the event
        $event = $ticketType->event->first();

        // Check if the event is sold out
        if ($event->sold_out) {
            return redirect()->back()->with('error', 'This event is sold out.');
        }

        // Check if the ticket type is sold out
        if ($ticketType->sold_out) {
            return redirect()->back()->with('error', 'This ticket type is sold out.');
        }

        // Create tickets with status pending based on quantity
        $tickets = $ticketType->tickets()->createMany(
            array_fill(0, $request->quantity, [
                'status' => 'pending'
            ])
        );

        // Get cart from session
        $cart = $request->session()->get('cart', []);

        // Add item to cart
        $cart[] = $tickets;

        // Store cart back in session
        $request->session()->put('cart', $cart);

        return redirect('/event/' . $event->eventSlug . '/' . $request->ticketType . '/info');
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
            'description'   => 'Luciafesten - 3X TICKET NAME',
            'metadata'      => ['ticket_id' => 123],
        ]);

        $output = [
            'clientSecret' => $paymentIntent['client_secret'],
        ];

        // TODO Save ticket secret in ticket object and clear unused ones after 10 min.

        return $output;
    }
}
