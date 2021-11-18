<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TicketType;

class PurchaseController extends Controller
{
    public function info($eventSlug, $ticketType)
    {
        // Get cart from session
        $cart = session()->get('cart');

        // If cart is empty redirect to event page
        if (!$cart) {
            return redirect()->route('event', ['eventSlug' => $eventSlug]);
        }

        $ticketType = TicketType::where('slug', $ticketType)->first();

        if (! $ticketType) {
            return redirect()->route('event', ['eventSlug' => $eventSlug]);
        }

        $event = $ticketType->event->first();

        return view('event.purchase.info', [
            'cart'       => $cart,
            'event'      => $event,
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
        // TODO When emptying the cart remove the pending tickets from the database to free them up
        $request->session()->forget('cart');

        // Get the ticket type
        $ticketType = TicketType::find($request->ticket_type_id);

        // Redirect to the event page if the ticket type doesn't exist
        if (! $ticketType) {
            return redirect()->back()->with('error', 'Ticket type does not exist.');
        }

        // Check if user is trying to buy more tickets than per person limit
        if ($ticketType->limit_person > 0 && $request->quantity > $ticketType->limit_person) {
            return redirect()->back()->with('error', 'You can only buy ' . $ticketType->limit_person . ' tickets per person.');
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
                'event_id' => $event->id,
                'user_id'  => 1, // TODO Change to null when bug fix.
                'price'    => 0,
                'status'   => 'pending'
            ])
        );

        // Get cart from session
        $cart = $request->session()->get('cart', []);

        // Add item to cart
        $cart = $tickets;

        // Store cart back in session
        $request->session()->put('cart', $cart);

        // TODO Depending on seating or not, redirect to the appropriate page

        return redirect('/event/' . $event->slug . '/' . $ticketType->slug . '/info');
    }

    public function updateCartWithTicketInfo(Request $request)
    {
        echo '<pre>';
        var_dump($request->all());
        die();
        // TODO Validate the request


        // TODO Create a payment intent

        // TODO Redirect to payment page

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
