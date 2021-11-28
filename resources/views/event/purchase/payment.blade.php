@section('title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', URL::asset($event->share_image))

@extends('layouts.app')

@section('content')
<main class="container mx-auto py-8 px-4 md:w-2/3 lg:w-1/3" x-data="{termsAccepted: false}">
    <div class="purchase-error hidden" id="payment-error"></div>

    <form id="payment-form">
        @csrf
        <h4 class="font-headline font-semibold text-grey">Steg 2 av 2</h4>
        <h2 class="font-headline text-3xl">Betalning</h2>

        <p>Du har valt {{count($cart)}} <strong>"{{$ticketType->name}}"</strong>-@if(count($cart) > 1)biljetter @else biljett @endif för <strong>{{$event->name}}</strong>. Det kommer att kosta {{$total}} SEK.</p>

        @include('includes.countdown')

        <hr>

        <div class="grid grid-cols-2 space-x-2">
            <label class="block">
                <span class="text-gray-700">Förnamn</span>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50" id="firstName" name="firstNamen" placeholder="Anna" required>
            </label>

            <label class="block">
                <span class="text-gray-700">Efternamn</span>
                <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50" id="lastName" name="lastName" placeholder="Andersson" required>
            </label>
        </div>

        <label class="block mt-4">
            <span class="text-gray-700">E-postadress att skicka kvittot till</span>
            <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50" id="email" name="email" placeholder="anna@andersson.se" required>
        </label>

        <hr>

        <div id="payment-element"></div>

        <div class="py-4">
            <input id="terms" class="rounded border-gray-300 text-pink shadow-sm focus:border-blue focus:ring focus:ring-offset-0 focus:ring-blue focus:ring-opacity-50 cursor-pointer" type="checkbox" x-model="termsAccepted" /> <label for="terms">Jag godkänner de <a href="/terms" class="font-medium" target="_blank">allmänna villkoren</a>.</label>
        </div>

        <div class="flex justify-between">
            <span class="text-xs text-grey mt-1">Köpet hanteras säkert genom <a href="https://stripe.com" class="font-bold hover:text-black" target="_blank" rel="noopener noreferrer">Stripe</a> och dina betaluppgifter<br> är aldrig tillgängliga för <a href="https://billio.app" class="font-bold hover:text-black" target="_blank" rel="noopener noreferrer">Billio</a> eller <a href='{{$event->organisation->url}}' class="font-bold hover:text-black" target="_blank" rel="noopener noreferrer">{{$event->organisation->title}}</a>.</span>

            <input x-bind:disabled="!termsAccepted" id="submit" type="submit" class="btn btn-pink" value='Köp biljett för {{$total}} SEK' />
        </div>
    </form>
</main>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{env('STRIPE_PUBLIC_KEY')}}')

        let elements;

        initialize();
        checkStatus();

        document.querySelector("#payment-form").addEventListener("submit", handleSubmit);

        // Fetches a payment intent and captures the client secret
        async function initialize() {
            elements = stripe.elements({clientSecret: '{{$client_secret}}'});

            const paymentElement = elements.create("payment");
            paymentElement.mount("#payment-element");
        }

        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);

            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: window.location.origin + '/event/{{$event->slug}}/{{$ticketType->slug}}/confirmation',
                    receipt_email: document.getElementById("email").value,
                    payment_method_data: {
                        billing_details: {
                            name: document.getElementById("firstName").value + " " + document.getElementById("lastName").value,
                            email: document.getElementById("email").value,
                        }
                    },
                },
            });

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

            messageContainer.classList.remove("hidden");
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
                console.log('Fix spinner');
            } else {
                console.log('Stop spinner');
            }
        }
    </script>
@endpush
