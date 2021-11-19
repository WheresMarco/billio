<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TicketType;
use App\User;
use App\Ticket;
use Illuminate\Support\Str;

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

    public function payment($eventSlug, $ticketType)
    {
        // Get cart from session
        $cart = session()->get('cart');

        // If cart is empty redirect to event page
        if (!$cart) {
            return redirect()->route('event', ['eventSlug' => $eventSlug]);
        }

        // Get total from session
        $total = session()->get('total');

        // Get clientSecret from session
        $client_secret = session()->get('client_secret');

        // Get ticket type
        $ticketType = TicketType::where('slug', $ticketType)->first();

        if (! $ticketType) {
            return redirect()->route('event', ['eventSlug' => $eventSlug]);
        }

        $event = $ticketType->event->first();

        return view('event.purchase.payment', [
            'total'         => $total,
            'client_secret' => $client_secret,
            'cart'          => $cart,
            'event'         => $event,
            'ticketType'    => $ticketType
        ]);
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
                'status'   => 'hold'
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

    /**
     * Update the cart with ticket information from checkout flow.
     *
     * @param Request $request
     * @return void
     */
    public function updateCartWithTicketInfo(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'event_id'       => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'tickets.*'      => 'array:firstName,lastName,email' // TODO Check validation.
        ]);

        // Get the ticket type
        $ticketType = TicketType::find($request->ticket_type_id);

        // Get the event
        $event = $ticketType->event->first();

        // Get cart from session
        $cart = $request->session()->get('cart', []);

        // If cart is empty redirect to event page
        if (! $cart) {
            return redirect()->route('event', ['eventSlug' => $event->slug]);
        }

        // Loop through tickets
        foreach ($request->tickets as $key => $ticket) {
            // Check if ticket exists in cart
            if (isset($cart[$key])) {
                // Get ticket from database
                $ticket = Ticket::find($cart[$key]->id);

                // If no ticket is found, redirect to event page
                if (! $ticket) {
                    return redirect()->route('event', ['eventSlug' => $event->slug]);
                }

                // Get user by email
                $user = User::where('email', $ticket['email'])->first();

                // If user doesn't exist create one
                if (! $user) {
                    $user = User::create([
                        'name' => $ticket['firstName'] . ' ' . $ticket['lastName'],
                        'email'      => $ticket['email'],
                        'password'   => bcrypt(Str::random(10))
                    ]);
                }

                // Update ticket
                $cart[$key]->update([
                    'user_id' => $user->id,
                    'status'  => 'awaiting_payment',
                ]);
            }
        }

        // Store cart back in session
        $request->session()->put('cart', $cart);

        // Create a payment intent
        $client_secret = $this->createPaymentIntent($cart);

        // Store payment intent in session
        $request->session()->put('client_secret', $client_secret);

        // Redirect to payment page
        return redirect('/event/' . $event->slug . '/' . $ticketType->slug . '/payment');
    }

    /**
     * Create a payment intent to be used on payment page.
     *
     * @param [type] $cart
     * @return void
     */
    public function createPaymentIntent($cart)
    {
        $total       = 0;
        $ticketUuids = [];
        $ticketType  = null;
        $event       = null;

        // Loop over cart
        foreach ($cart as $ticket) {
            // Add ticket id to array
            $ticketUuids[] = $ticket->uuid;

            // Get the ticket type
            $ticketType = $ticket->ticket_type->first();

            // Get the event
            $event = $ticketType->event->first();

            // Get the price
            $price = $ticketType->price;

            // TODO Calculate modifiers price

            // Add price to total
            $total += $price;
        }

        // If total is 0 redirect to event page. No free tickets!
        if ($total == 0) {
            return redirect()->route('event', ['eventSlug' => $event->slug]);
        }

        // Save total price in session
        session()->put('total', $total);

        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe::paymentIntents()->create([
            'amount' => $total,
            'currency' => 'sek',
            'payment_method_types' => [
                'card'
            ],
            'description'   => $event->name . ' - ' . count($cart) . 'x ' . $ticketType->name,
            'metadata'      => [
                'tickets' => implode(',', $ticketUuids),
            ],
        ]);

        // Check if payment intent was created
        if (! $paymentIntent) {
            return redirect()->back()->with('error', 'Could not create payment intent.');
        }

        return $paymentIntent['client_secret'];
    }
}
