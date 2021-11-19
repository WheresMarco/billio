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

            <form action="/event/{{$event->slug}}/{{$ticketType->slug}}/info" method="post">
                @csrf
                <input type="hidden" name="ticket_type_id" value="{{$ticketType->id}}">
                <input type="hidden" name="event_id" value="{{$event->id}}">

                <h4>Steg 1 av 2</h4>
                <h2>Ange biljettuppgifter</h2>

                <p>Du har valt {{count($cart)}} <strong>"{{$ticketType->name}}"</strong>-@if(count($cart) > 1)biljetter @else biljett @endif för <strong>{{$event->name}}</strong>. Vänligen skriv in uppgifterna för vardera biljett.</p>

                <p><strong>Vi har reserverat biljetterna i XX minuter och XX sekunder till.</strong></p>

                <br style="clear: both;">

                @foreach ($cart as $key => $item)
                    <div class="ticket" style="padding: 20px; box-shadow: 0 .5rem 2rem 0 rgba(0,0,0,.1);">
                        @if (count($cart) > 1)
                            <h3>Biljett #{{$key + 1}}</h3>
                        @endif

                        <div class="firstNameContainer">
                            <label for="firstName">Förnamn</label>
                            <input type="text" id="firstName" name="tickets[{{$key}}][firstName]" placeholder="Förnamn" />
                        </div>

                        <div class="lastNameContainer">
                            <label for="lastName">Efternamn</label>
                            <input type="text" id="lastName" name="tickets[{{$key}}][lastName]" placeholder="Efternamn" />
                        </div>

                        <label for="email">E-postadress</label>
                        <input type="text" id="email" name="tickets[{{$key}}][email]" placeholder="E-postadress"/>

                        <h4>Tillval</h4>
                        @if (count($ticketType->modifiers) > 0)
                            <div class="modifiers">
                                <ul>
                                    @foreach ($ticketType->modifiers as $modifier)
                                        <li>
                                            <input class="faux-radio-checkbox faux-checkbox" id='{{$modifier->slug}}' name="tickets[{{$key}}][modifier][]" value='{{$modifier->slug}}' data-delta='{{$modifier->delta}}' type="checkbox" />
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
                    <a href="/event/{{$event->slug}}/" class="faux-button grey" style="line-height: 2.1rem; margin-top: 10px;">Avbryt</a>
                    <br style="clear: both;">
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
// TODO Add countdown
</script>
@endpush
