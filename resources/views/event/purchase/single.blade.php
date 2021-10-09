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

                <p>Du har valt två (2) <strong>"{{$ticketType->name}}"</strong>-biljetter för <strong>{{$event->name}}</strong>. Det kommer att kosta <strong>{{$ticketType->price}} SEK</strong>. Dom är nu reserverade i 10 minuter för att du ska hinna att betala dom.</p>

                @if (count($ticketType->modifiers) < 10) <!-- What? -->
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

                <p>Vänligen skriv uppgifterna för personerna som ska använda biljetterna. Biljetterna kommer att sedan <strong>skickas till den e-postadresserna som du fyller i</strong>.</p>

                <p>Biljett nummer ett:</p>
                <input type="text" id="email" placeholder="E-postadress" />

                <p>Biljett nummer två:</p>
                <input type="text" id="email" placeholder="E-postadress" />

                <hr />

                {{-- <livewire:check-student /> --}}

                <p>Du kan betala din biljett antingen med Swish eller med ett kontokort (Visa, Mastercard).</p>

                <p>
                    <button class="blue" style="width: 48%;">Swish</button>
                    <button class="blue" style="width: 48%; margin-left: 3%; background: rgba( 74, 144, 226, 1 ); color: #fff;">Kreditkort</button>
                </p>

                <hr>

                <label>Telefonnummer som du vill Swisha ifrån:</label>
                <input type="text" id="phoneNumber" placeholder="070 123 456 789" />

                <br style="clear: both;">
                <input id="terms" type="checkbox" /> <label for="terms">Jag godkänner de <a href="/terms" target="_blank">allmänna villkoren</a>.</label>

                <div>
                    <input id="submit" type="submit" class="pink" value='Köp biljett för {{$ticketType->price}} SEK' />
                    <span id="stripe-smallprint" class="smallprint">Köpet hanteras säkert genom <a href="https://swish.se" target="_blank" rel="noopener noreferrer">Swish</a> och dina betaluppgifter<br> är aldrig tillgängliga för <a href="https://billio.app" target="_blank" rel="noopener noreferrer">Billio</a> eller <a href='{{$event->organisation->url}}' target="_blank" rel="noopener noreferrer">{{$event->organisation->title}}</a>.</span>

                    <br style="clear: both;">
                </div>

                <hr>

                <br style="clear: both;">

                <div wire:ignore id="card-element"></div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>

                <br style="clear: both;">
                <input id="terms" type="checkbox" /> <label for="terms">Jag godkänner de <a href="/terms" target="_blank">allmänna villkoren</a>.</label>

                <div>
                    <input id="submit" type="submit" class="pink" value='Köp biljett för {{$ticketType->price}} SEK' />
                    <span id="stripe-smallprint" class="smallprint">Köpet hanteras säkert genom <a href="https://stripe.com" target="_blank" rel="noopener noreferrer">Stripe</a> och dina betaluppgifter<br> är aldrig tillgängliga för <a href="https://billio.app" target="_blank" rel="noopener noreferrer">Billio</a> eller <a href='{{$event->organisation->url}}' target="_blank" rel="noopener noreferrer">{{$event->organisation->title}}</a>.</span>

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

                }
            })
    </script>
@endpush
