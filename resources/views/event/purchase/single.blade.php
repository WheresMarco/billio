@section('title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', URL::asset($event->share_image))

@extends('layouts.app')

@section('content')
<main>
    <div class="wrapper">
        <div class="purchase">
            {{-- <div class="purchase-error">An error message.</div> --}}

            <form>
                <h2>Kassa</h2>

                <p>Du har valt en <strong>"{{$ticketType->name}}"</strong>-biljett för <strong>{{$event->name}}</strong>. Det kommer att kosta <strong>{{$ticketType->price}} SEK</strong>.</p>

                @if (count($ticketType->modifiers) > 10)
                    <div class="modifiers">
                        <ul>
                            @foreach ($ticketType->modifiers as $modifier)
                                <li>
                                    <input class="faux-radio-checkbox faux-checkbox" id='{{$modifier->slug}}' value='{{$modifier->slug}}' data-delta='{{$modifier->delta}}' type="checkbox" />
                                    <label for='{{$modifier->slug}}' class="faux-radio-checkbox-label">
                                        {{$modifier->name}} <span>{{$modifier->delta}} SEK</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <hr />

                <p>Vänligen skriv in din e-postadress som du vill att <strong>biljetten skickas till</strong>.</p>

                <input type="text" id="email" placeholder="E-postadress" />

                <hr />

                <livewire:check-student />

                <p>Vi behöver även lite mer info innan vi kan skicka din biljett till dig.</p>
                <input type="text" id="firstName" placeholder="Förnamn" />
                <input type="text" id="lastName" placeholder="Efternamn" />

                <br style="clear: both;">
                <input id="terms" type="checkbox" /> <label for="terms">Jag godkänner dom <a href="/terms" target="_blank">allmänna villkoren</a>.</label>

                <br style="clear: both;">
                <br style="clear: both;">

                <p>
                    <img src="{{ URL::to('/img/swish.png') }}" style="height: 40px;">
                    <img src="https://developer.apple.com/design/human-interface-guidelines/apple-pay/images/ApplePay-Button_2x.png" style="height: 40px; margin-left: 10px;">
                    <img src="{{ URL::to('/img/gpay.png') }}" style="height: 40px; margin-left: 10px;">
                </p>

                <div style="width: 100%; height: 3px; background: #f3f3f6; margin-top: 30px;"></div>
                <p style="text-align: center;margin-top: -13px;margin-bottom: 20px;color: grey;"><span style="background: white; padding: 0 10px;">Eller betala med kort</span></p>

                <div wire:ignore id="card-element"></div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>

                <br style="clear: both;">

                <div style="opacity: 0.2;">
                    <input id="submit" type="submit" class="pink" value='Köp biljett för {{$ticketType->price}} SEK' />
                    <span id="stripe-smallprint" class="smallprint">Köpet hanteras säkert genom <a href="https://stripe.com" target="_blank" rel="noopener noreferrer">Stripe</a> och dina<br /> kortuppgifter är aldrig tillgängliga för <a href="https://billio.app" target="_blank" rel="noopener noreferrer">Billio</a> eller <a href='{{$event->organisation->url}}' target="_blank" rel="noopener noreferrer">{{$event->organisation->title}}</a>.</span>

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
            const elements = stripe.elements()
            const cardElement = elements.create('card')

            cardElement.mount('#card-element')

            const cardHolderName = document.getElementById('card-holder-name')
            const cardButton = document.getElementById('card-button')
            const clientSecret = cardButton.dataset.secret

            cardButton.addEventListener('click', async (e) => {
                const {setupIntent, error} = await stripe.confirmCardSetup(clientSecret, {
                    payment_method: {
                        card: cardElement, billing_details: {name: cardHolderName.value},
                    },
                })

                if (error) {
                    let errorWrapper = document.getElementById('error-wrapper')
                    errorWrapper.textContent = error.error
                    console.info(error)
                } else {
                    //@this.set('paymentmethod', setupIntent.payment_method)
                }
            })
    </script>
@endpush
