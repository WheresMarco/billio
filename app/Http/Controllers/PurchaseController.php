<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Controllers\CheckStudentController;

use App\Models\TicketType;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\Modifier;
use App\Models\Nin;

class PurchaseController extends Controller
{
    public function info($eventSlug, $ticketType)
    {
        // Get cart from session
        $cart = session()->get('cart');

        // If cart is empty redirect to event page
        if (!$cart) {
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Din köptid har gått ut, vänligen försök igen.');
        }

        $ticketType = TicketType::where('slug', $ticketType)->first();

        if (! $ticketType) {
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Den här biljettypen finns inte.');
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
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Din köptid har gått ut, vänligen försök igen.');
        }

        // Get total from session
        $total = session()->get('total');

        // Get clientSecret from session
        $client_secret = session()->get('client_secret');

        // Get ticket type
        $ticketType = TicketType::where('slug', $ticketType)->first();

        if (! $ticketType) {
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Den här biljettypen finns inte. Försök igen.');
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

    public function confirmation(Request $request)
    {
        // Empty cart in session
        session()->forget('cart');

        // Remove client secret from session
        session()->forget('client_secret');

        // Remove total from session
        session()->forget('total');

        return view('event.purchase.confirmation', ['stripe_id' => $request->payment_intent]);
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
            return redirect()->back()->with('error', 'Den här biljettypen finns inte.');
        }

        // Check if user is trying to buy more tickets than per person limit
        if ($ticketType->limit_person > 0 && $request->quantity > $ticketType->limit_person) {
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Du kan bara köpa ' . $ticketType->limit_person . ' biljetter per person.');
        }

        // Get the event
        $event = $ticketType->event->first();

        // Check if the event is sold out
        if ($event->sold_out) {
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Det här evenemanget är slutsålt.');
        }

        // Check if the ticket type is sold out
        if ($ticketType->sold_out) {
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Den här biljettypen är utsåld.');
        }

        // Create tickets with status pending based on quantity
        $tickets = $ticketType->tickets()->createMany(
            array_fill(0, $request->quantity, [
                'event_id' => $event->id,
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
        ray($request->all());

        // Validate the request
        $this->validate($request, [
            'event_id'       => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'tickets.*'      => 'array:firstName,lastName,email,modifiers,nin'
        ]);

        // Get the ticket type
        $ticketType = TicketType::find($request->ticket_type_id);

        // Get the event
        $event = $ticketType->event->first();

        // Get cart from session
        $cart = $request->session()->get('cart', []);

        // If cart is empty redirect to event page
        if (! $cart) {
            return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Din köptid har gått ut, vänligen försök igen.');
        }

        // Loop through tickets
        foreach ($request->tickets as $key => $ticket) {
            // Check if ticket exists in cart
            if (isset($cart[$key])) {
                // Check nin
                if (isset($ticket['nin'])) {
                    // Check if nin is valid
                    $valid = (new CheckStudentController())->isStudentMember($ticket['nin']);

                    if (! $valid) {
                        return redirect()->back()->with('error', 'Personnumret du matade in är inte en kårmedlem.')->withInput();
                    }

                    // Add ticket modifier to array
                    $ticket['modifiers'][] = 'union-discount';

                    // Remove first two numbers if there is.
                    $nin  = str_replace('-', '', $ticket['nin']);
                    if (12 === strlen($nin)) {
                        $nin = substr($nin, 2);
                    }

                    // Get Nin from database
                    $nin = Nin::where('nin', $nin)->first();

                    // Update nin with ticket id
                    $nin->update([
                        'ticket_id' => $cart[$key]->id
                    ]);
                }

                // Get ticket from database
                $databaseTicket = Ticket::find($cart[$key]->id);

                // If no ticket is found, redirect to event page
                if (! $databaseTicket) {
                    return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Din köptid har gått ut, vänligen försök igen.');
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

                // Loop over all modfiers and save on ticket
                if (isset($ticket['modifiers'])) {
                    foreach ($ticket['modifiers'] as $ticketModifier) {
                        $modifier = Modifier::where([['ticket_type_id', $cart[$key]->ticket_type->id], ['slug', $ticketModifier ]])->first();
                        $cart[$key]->modifiers()->save($modifier);
                    }
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

            // Calculate modifiers price
            $modifiers = $ticket->modifiers->all();
            if ($modifiers) {
                foreach ($modifiers as $modfier) {
                    $price = $price + $modfier->delta;
                }
            }

            // Update ticket with price
            $ticket->update([
                'price' => $price
            ]);

            // Add price to total
            $total += $price;
        }

        // If total is 0 redirect to event page. No free tickets!
        if ($total <= 0) {
            return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Något har gått fel, vänligen försök igen.');
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
            return redirect()->back()->with('error', 'Kunde inte skapa betalning, vänligen försök igen.');
        }

        // Loop over cart and create a row in transaction table
        foreach ($cart as $ticket) {
            // Create a transaction
            $transaction = Transaction::create([
                'user_id'   => $ticket->user_id,
                'ticket_id' => $ticket->id,
                'amount'    => $total,
                'stripe_id' => $paymentIntent['id'],
            ]);

            // Check if transaction was created
            if (! $transaction) {
                return redirect()->back()->with('error', 'Kunde inte skapa transaktion, vänligen försök igen.');
            }
        }

        return $paymentIntent['client_secret'];
    }
}
