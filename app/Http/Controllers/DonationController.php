<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'event_id' => 'required',
            'amount' => 'required|integer|min:1',
        ]);

        // Empty cart before adding to cart
        $cart = session()->get('cart');
        session()->forget('cart');

        // If no event is found redirect to frontpage
        if (!$event = Event::find($request->event_id)) {
            return redirect('/')->with('error', 'Kunde inte hitta evenemang.');
        }

        // If amount is under 10 redirect to event page
        if ($request->amount < 10) {
            return redirect('/event/' . $event->slug)->with('error', 'Donationen måste vara minst 10 kr.');
        }

        // Create donation
        $donation = Donation::create([
            'user_id' => 1,
            'event_id' => $event->id,
            'amount' => $request->amount,
        ]);

        // Store cart back in session
        $request->session()->put('cart', $donation);

        // Create a payment intent
        $client_secret = $this->createPaymentIntent($donation, $event);

        // Store payment intent in session
        $request->session()->put('client_secret', $client_secret);

        // Redirect to payment page
        return redirect('/event/' . $event->slug . '/donate/payment');
    }

    /**
     * Create a payment intent to be used on payment page.
     *
     * @param [type] $cart
     * @return void
     */
    public function createPaymentIntent($donation, $event)
    {
        // If no cart redirect to frontpage
        if (!$donation) {
            return redirect('/')->with('error', 'Något gick fel. Försök igen.');
        }

        // Get the orginization for the event
        $organisation = $event->organisation;

        // Get the Stripe platform secret key
        $secret_key = $organisation->stripe_secret_key;

        // If no secret key is found redirect to event page
        if (!$secret_key) {
            return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Något gick fel. Vänligen försök igen.');
        }

        // Set the Stripe API key for this org.
        \Stripe::setApiKey($secret_key);

        // Create a PaymentIntent with amount and currency
        $paymentIntent = \Stripe::paymentIntents()->create([
            'amount' => $donation->amount,
            'currency' => 'sek',
            'payment_method_types' => [
                'card',
            ],
            'description' => $event->name . ' - Donation',
            'metadata' => [
                'donation' => true,
                'donation_id' => $donation->id,
            ],
        ]);

        // Check if payment intent was created
        if (!$paymentIntent) {
            return redirect()->route('event', ['eventSlug' => $event->slug])->with('error', 'Kunde inte skapa betalning, vänligen försök igen.');
        }

        // Create a transaction
        $transaction = Transaction::create([
            'user_id' => 1,
            'purchase_id' => $donation->id,
            'amount' => $donation->amount,
            'stripe_id' => $paymentIntent['id'],
            'access_code' => null,
            'purchase_type' => 'donation',
        ]);

        // Check if transaction was created
        if (!$transaction) {
            return redirect()->back()->with('error', 'Kunde inte skapa transaktion, vänligen försök igen.');
        }

        return $paymentIntent['client_secret'];
    }

    public function payment($eventSlug)
    {
        // If cart is empty redirect to event page
        if (!$cart = session()->get('cart')) {
            return redirect()->route('event', ['eventSlug' => $eventSlug])->with('error', 'Något gick fel, vänligen försök igen.');
        }

        // If no event is found redirect to frontpage
        if (!$event = Event::where('slug', $eventSlug)->first()) {
            return redirect('/')->with('error', 'Kunde inte hitta evenemang.');
        }

        // Get clientSecret from session
        $client_secret = session()->get('client_secret');

        return view('event.donate.payment', [
            'total'         => $cart->amount,
            'client_secret' => $client_secret,
            'stripe_public_key' => $event->organisation->stripe_public_key,
            'cart'          => $cart,
            'event'         => $event,
        ]);
    }

    public function confirmation(Request $request)
    {
        // Empty cart in session
        session()->forget('cart');

        // Remove client secret from session
        session()->forget('client_secret');

        return view('event.donate.confirmation', ['stripe_id' => $request->payment_intent]);
    }
}
