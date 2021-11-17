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
            <div class="alert-bar">Observera att du behöver ett giltigt Covidpass för att kunna delta på Luciafesten.</div>

            <form id="payment-form" action="/event/luciafesten/party/payment">
                @csrf
                <h4>Steg 1 av 2</h4>
                <h2>Ange biljettuppgifter</h2>

                <p>Du har valt tre <strong>"{{$ticketType->name}}"</strong>-biljetter för <strong>{{$event->name}}</strong>. <strong>Vi har reserverat dom i XX minuter och XX sekunder till</strong>. Vänligen skriv in uppgifterna för vardera biljett. <strong><a href="#">Ändra biljetttyp eller antal</a></strong>.</p>

                <br style="clear: both;">

                @foreach ($cart as $key => $item)
                    <div class="ticket" style="padding: 20px; box-shadow: 0 .5rem 2rem 0 rgba(0,0,0,.1);">
                        <h3>Biljett #{{$key + 1}}</h3>

                        <input type="text" id="firstName" placeholder="Förnamn" />
                        <input type="text" id="lastName" placeholder="Efternamn" />
                        <input type="text" id="email" placeholder="E-postadress"/>

                        @if (count($ticketType->modifiers) > 0)
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

                                    <li>
                                        <input class="faux-radio-checkbox faux-checkbox" id='karmedlemTEMP' value='karmedlemTEMP' data-delta='-20' type="checkbox" checked />
                                        <label for='karmedlemTEMP' class="faux-radio-checkbox-label">
                                            Jag är kårmedlem <span>-20 SEK</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        @endif

                        <br style="clear: both;">

                        <livewire:check-student />
                    </div>

                    <br style="clear: both;">
                @endforeach

                <div>
                    <input id="submit" type="submit" class="pink" value='Gå vidare till betalning' />
                    <br style="clear: both;">
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
