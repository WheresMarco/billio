<?php

namespace App\Http\Controllers;

use App\Models\Modifier;
use App\Models\Nin;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\TicketCustomField;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Occurrence;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Empty cart before adding to cart
        $cart = session()->get('cart');

        collect($cart)->map(function ($ticket) {
            return Ticket::find($ticket['id'])->where('status', 'hold')->delete();
        });

        session()->forget('cart');

        // Redirect to the event page if the ticket type doesn't exist
        if (!$ticketType = TicketType::find($request->ticket_type_id)) {
            return redirect()->back()->with('error', 'Den här biljettypen finns inte.');
        }

        // If no event is found redirect to frontpage
        if (!$event = $ticketType->event) {
            return redirect('/')->with('error', 'Kunde inte hitta evenemang.');
        }

        // Check if user is trying to buy more tickets than per person limit
        if ($ticketType->limit_person > 0 && $request->quantity > $ticketType->limit_person) {
            return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Du kan bara köpa ' . $ticketType->limit_person . ' biljetter per person.');
        }

        // Check if the event is sold out
        if ($event->sold_out) {
            return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Det här evenemanget är slutsålt.');
        }

        // Check if the ticket type is sold out
        if ($ticketType->sold_out) {
            return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Den här biljettypen är slutsåld.');
        }

        // Create tickets with status pending based on quantity
        $tickets = $ticketType->tickets()->createMany(
            array_fill(0, $request->quantity, [
                'event_id' => $event->id,
                'price' => 0,
                'status' => 'hold',
            ])
        );

        // Get cart from session
        $cart = $request->session()->get('cart', []);

        // Add item to cart
        $cart = $tickets;

        // Store cart back in session
        $request->session()->put('cart', $cart);

        // Redirect to ticket info page
        return redirect('/event/' . $event->slug . '/' . $ticketType->slug . '/info');
    }

    public function info($eventSlug, $ticketType)
    {
        // If cart is empty redirect to event page
        if (!$cart = session()->get('cart')) {
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Din köptid har gått ut, vänligen försök igen.');
        }

        // If no ticket type is set redirect to event page
        if (!$ticketType = TicketType::where('slug', $ticketType)->first()) {
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Den här biljettypen finns inte.');
        }

        // If no event is found redirect to frontpage
        if (!$event = $ticketType->event) {
            return redirect('/')->with('error', 'Kunde inte hitta evenemang.');
        }

        return view('event.purchase.info', [
            'cart' => $cart,
            'event' => $event,
            'ticketType' => $ticketType,
        ]);
    }

    /**
     * Update the cart with ticket information from checkout flow.
     *
     * @param  Request  $request
     * @return void
     */
    public function updateCartWithTicketInfo(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'event_id' => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'tickets.*.firstName' => 'required|string',
            'tickets.*.lastName' => 'required|string',
            'tickets.*.email' => 'required|email',
            'tickets.*.nin' => 'nullable|digits:10',
            'tickets.*.occurrence_id' => 'nullable|exists:occurrences,id',
        ]);

        // Get the ticket type
        $ticketType = TicketType::find($request->ticket_type_id);

        // If no event is found redirect to frontpage
        if (!$event = $ticketType->event) {
            return redirect('/')->with('error', 'Kunde inte hitta evenemang.');
        }

        // If cart is empty redirect to event page
        if (!$cart = $request->session()->get('cart', [])) {
            return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Din köptid har gått ut, vänligen försök igen.');
        }

        // Check if the cart has the same amount of tickets as the request
        if (count($cart) !== count($request->tickets)) {
            return redirect()->back()->with('error', 'Något gick fel. Vänligen försök igen.')->withInput();
        }

        // Loop through tickets
        foreach ($request->tickets as $key => $ticket) {
            // Check if ticket exists in cart, else continue
            if (!isset($cart[$key])) {
                continue;
            }

            // Check nin
            if (isset($ticket['nin'])) {
                // Check if nin is valid
                if (!(new CheckStudentController())->isStudentMember($ticket['nin'])) {
                    return redirect()->back()->with('error', 'Personnumret du matade in är inte en kårmedlem.')->withInput();
                }

                // Add ticket modifier to array
                $ticket['modifiers'][] = 'union-discount';

                // Remove first two numbers if there is.
                $nin = str_replace('-', '', $ticket['nin']);
                if (12 === strlen($nin)) {
                    $nin = substr($nin, 2);
                }

                // Get Nin from database
                $nin = Nin::where('nin', $nin)->first();

                // Update nin with ticket id
                $nin->update([
                    'ticket_id' => $cart[$key]->id,
                ]);
            }

            // Get ticket from database. If no ticket is found, redirect to event page
            if (!$databaseTicket = Ticket::find($cart[$key]->id)) {
                return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Din köptid har gått ut, vänligen försök igen.');
            }

            // Check if valid email
            if (!filter_var($ticket['email'], FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->with('error', 'E-postadressen du matade in är inte giltig.')->withInput();
            }

            // Get user by email. If user doesn't exist create one
            if (!$user = User::where('email', $ticket['email'])->first()) {
                $user = User::create([
                    'name' => $ticket['firstName'] . ' ' . $ticket['lastName'],
                    'email' => $ticket['email'],
                    'password' => bcrypt(Str::random(10)),
                ]);
            }

            // Get occurrence by id and check that the limit hasn't been reached
            if (isset($ticket['occurrence_id'])) {
                $occurrence = Occurrence::find($ticket['occurrence_id']);

                // Check if the limit has been reached
                if ($occurrence->isSoldOut) {
                    return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Detta tillfälle är tyvärr uppbokat.');
                }

                // Update ticket with occurrence id
                $cart[$key]->occurrence_id = $occurrence->id;
            }

            // Loop over all modifiers and save on ticket
            if (isset($ticket['modifiers'])) {
                // Remove all modifiers from ticket before adding them again
                $databaseTicket->modifiers()->detach();

                foreach ($ticket['modifiers'] as $ticketModifier) {
                    $modifier = Modifier::where([['slug', $ticketModifier]])->first();
                    $cart[$key]->modifiers()->save($modifier);
                }
            }

            // Loop over all custom fields and save on ticket
            if (isset($ticket['custom_fields'])) {
                foreach ($ticket['custom_fields'] as $name => $value) {
                    // Check if custom field exists
                    $customField = TicketCustomField::where([['ticket_id', $cart[$key]->id], ['name', $name]])->first();

                    // If custom field doesn't exist, create it
                    if (!$customField) {
                        $cart[$key]->customFields()->create([
                            'name' => $name,
                            'value' => $value,
                        ]);
                    } else {
                        // Update custom field
                        $customField->update([
                            'value' => $value,
                        ]);
                    }
                }
            }

            // Update ticket
            $cart[$key]->update([
                'user_id' => $user->id,
                'status' => 'awaiting_payment',
            ]);
        }

        // Store cart back in session
        $request->session()->put('cart', $cart);

        // Create a payment intent
        $client_secret = $this->createPaymentIntent($cart, $event);

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
    public function createPaymentIntent($cart, $event)
    {
        // If no cart redirect to frontpage
        if (!$cart) {
            return redirect('/')->with('error', 'Något gick fel. Försök igen.');
        }

        // Define the total price
        $total = 0;

        // Loop through the tickets and calculate total price, also get modifiers price
        foreach ($cart as $ticket) {
            // Get the ticket type. If no ticket type is found redirect to the event page
            if (!$ticketType = TicketType::find($ticket->ticket_type_id)) {
                return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Något gick fel. Vänligen försök igen.');
            }

            $ticket_total = 0;

            // Get modifiers price
            $modifiersPrice = 0;
            foreach ($ticket->modifiers as $modifier) {
                $modifiersPrice += $modifier->delta;
            }

            // Add ticket price and modifiers price to total
            $total = $total + $ticketType->price + $modifiersPrice;
            $ticket_total = $ticketType->price + $modifiersPrice;

            // Add ticket uuid to array
            $ticketUuids[] = $ticket->uuid;

            // Update ticket with total
            $ticket->update([
                'price' => $ticket_total,
            ]);
        }

        // If total is 10 redirect to event page. No free tickets! And nothing under Stripes minimum.
        if ($total <= 10) {
            return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Något gick fel. Vänligen försök igen.');
        }

        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe::paymentIntents()->create([
            'amount' => $total,
            'currency' => 'sek',
            'payment_method_types' => [
                'card',
            ],
            'description' => $event->name . ' - ' . count($cart) . 'x ' . $ticketType->name,
            'metadata' => [
                'tickets' => implode(',', $ticketUuids),
            ],
        ]);

        // Check if payment intent was created
        if (!$paymentIntent) {
            return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Kunde inte skapa betalning, vänligen försök igen.');
        }

        // Loop over cart and create a row in transaction table
        foreach ($cart as $ticket) {
            // Create a transaction
            $transaction = Transaction::create([
                'user_id' => $ticket->user_id,
                'purchase_id' => $ticket->id,
                'amount' => $total,
                'stripe_id' => $paymentIntent['id'],
                'access_code' => session()->get('access_code') ?? null,
                'purchase_type' => 'ticket',
            ]);

            // Check if transaction was created
            if (!$transaction) {
                return redirect()->back()->with('error', 'Kunde inte skapa transaktion, vänligen försök igen.');
            }
        }

        return $paymentIntent['client_secret'];
    }

    public function payment($eventSlug, $ticketType)
    {
        // If cart is empty redirect to event page
        if (!$cart = session()->get('cart')) {
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Din köptid har gått ut, vänligen försök igen.');
        }

        // If no ticket type is set redirect to event page
        if (!$ticketType = TicketType::where('slug', $ticketType)->first()) {
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Den här biljettypen finns inte. Försök igen.');
        }

        // If no event is found redirect to frontpage
        if (!$event = $ticketType->event) {
            return redirect('/');
        }

        // Get clientSecret from session
        $client_secret = session()->get('client_secret');

        // Calculate total price
        $total = 0;
        foreach ($cart as $ticket) {
            $total += $ticket->price;
        }

        return view('event.purchase.payment', [
            'total'         => $total,
            'client_secret' => $client_secret,
            'cart'          => $cart,
            'event'         => $event,
            'ticketType'    => $ticketType,
        ]);
    }

    public function confirmation(Request $request)
    {
        // Empty cart in session
        session()->forget('cart');

        // Remove client secret from session
        session()->forget('client_secret');

        return view('event.purchase.confirmation', ['stripe_id' => $request->payment_intent]);
    }
}
