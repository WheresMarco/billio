{{-- @section('title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', URL::asset($event->share_image)) --}}

@extends('layouts.app')

@section('content')
<main>
    <div class="wrapper">
        <div class="purchase">
            <div class="purchase-error" id="payment-error"></div>

            <form id="payment-form">
                @csrf
                <h4>Steg 2 av 2</h4>
                <h2>Betalning</h2>

                <p>Du har valt två (2) <strong>"TYP"</strong>-biljett för <strong>EVENT</strong> den <strong>11 december 2021</strong>. Det kommer att totalt kosta <strong>XXX SEK</strong>. <a href="#">Ändra någonting</a>.</p>

                <hr>

                <label for="firstName">Förnamn</label>
                <input type="text" id="firstName" placeholder="Kalle" />

                <label for="lastName">Efternamn</label>
                <input type="text" id="lastName" placeholder="Kula" />

                <label for="email">E-postadress för kvittot</label>
                <input type="text" id="email" placeholder="kalle@kula.se"/>

                <br style="clear: both;">

                <div wire:ignore id="payment-element"></div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>

                <br style="clear: both;">
                <input id="terms" type="checkbox" /> <label for="terms">Jag godkänner de <a href="/terms" target="_blank">allmänna villkoren</a>.</label>

                <div>
                    <div class="spinner hidden" id="spinner"></div>

                    <input id="submit" type="submit" class="pink" value='Köp biljett för 100 SEK' />
                    <span id="stripe-smallprint" class="smallprint">Köpet hanteras säkert genom <a href="https://stripe.com" target="_blank" rel="noopener noreferrer">Stripe</a> och dina betaluppgifter<br> är aldrig tillgängliga för <a href="https://billio.app" target="_blank" rel="noopener noreferrer">Billio</a> eller <a href='#' target="_blank" rel="noopener noreferrer">EVENT</a>.</span>

                    <br style="clear: both;">
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{env('STRIPE_PUBLIC_KEY')}}')

        let elements;

        // The items the customer wants to buy
        const items = [{ id: "xl-tshirt" }];

        initialize();
        checkStatus();

        document.querySelector("#payment-form").addEventListener("submit", handleSubmit);

        // Fetches a payment intent and captures the client secret
        async function initialize() {
            const { clientSecret } = await fetch(window.location.href, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value
                },
                body: JSON.stringify({ items }),
            }).then((r) => r.json());

            elements = stripe.elements({ clientSecret });

            const paymentElement = elements.create("payment");
            paymentElement.mount("#payment-element");
        }

        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);

            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: window.location.href + '/confirmation',
                    receipt_email: document.getElementById("email").value,
                    payment_method_data: {
                        billing_details: {
                            name: document.getElementById("firstName").value + " " + document.getElementById("lastName").value,
                            email: document.getElementById("email").value,
                        }
                    },
                },
            });

            // This point will only be reached if there is an immediate error when
            // confirming the payment. Otherwise, your customer will be redirected to
            // your `return_url`. For some payment methods like iDEAL, your customer will
            // be redirected to an intermediate site first to authorize the payment, then
            // redirected to the `return_url`.
            if (error.type === "card_error" || error.type === "validation_error") {
                showMessage(error.message);
            } else {
                showMessage("An unexpected error occured.");
            }

            setLoading(false);
        }

        // Fetches the payment intent status after payment submission
        async function checkStatus() {
            const clientSecret = new URLSearchParams(window.location.search).get(
                "payment_intent_client_secret"
            );

            if (!clientSecret) {
                return;
            }

            const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

            switch (paymentIntent.status) {
                case "succeeded":
                showMessage("Payment succeeded!");
                break;
                case "processing":
                showMessage("Your payment is processing.");
                break;
                case "requires_payment_method":
                showMessage("Your payment was not successful, please try again.");
                break;
                default:
                showMessage("Something went wrong.");
                break;
            }
        }

        // ------- UI helpers -------
        function showMessage(messageText) {
            const messageContainer = document.querySelector("#payment-error");

            messageContainer.textContent = messageText;

            setTimeout(function () {
                messageContainer.classList.add("hidden");
                messageText.textContent = "";
            }, 4000);
        }

        // Show a spinner on payment submission
        function setLoading(isLoading) {
            if (isLoading) {
                // Disable the button and show a spinner
                document.querySelector("#submit").disabled = true;
                document.querySelector("#spinner").classList.remove("hidden");
            } else {
                document.querySelector("#submit").disabled = false;
                document.querySelector("#spinner").classList.add("hidden");
            }
        }
    </script>
@endpush
