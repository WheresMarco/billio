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
            <form id="payment-form" action="/event/luciafesten/party/info">
                @csrf
                <h4>Steg 1 av 3</h4>
                <h2>Välj platser</h2>

                <p>Du har valt tre <strong>"{{$ticketType->name}}"</strong>-biljetter för <strong>{{$event->name}}</strong>. Välj dina platser nedan. I nästa steg får du fylla i vilka som ska ha biljetterna. <strong><a href="#">Ändra biljetttyp eller antal</a></strong>.</p>

                <br style="clear: both;">

                <img src="{{ URL::to('/img/temppicker.png') }}" style="max-width: 100%;">

                <div>
                    <input id="submit" type="submit" class="pink" value='Gå vidare' />
                    <br style="clear: both;">
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
