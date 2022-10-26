@section('title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', Storage::url($event->share_image))

@extends('layouts.app')

@section('content')
    <main class="container mx-auto py-8 px-4 md:w-2/3 lg:w-1/3">
        <form action="/event/{{ $event->slug }}/{{ $ticketType->slug }}/info" method="post">
            @csrf
            <input type="hidden" name="ticket_type_id" value="{{ $ticketType->id }}">
            <input type="hidden" name="event_id" value="{{ $event->id }}">

            <h4 class="font-headline text-grey font-semibold">Steg 1 av 3</h4>
            <h2 class="font-headline text-3xl">Välj platser</h2>

            <p>Du har valt tre <strong>"{{ $ticketType->name }}"</strong>-biljetter för
                <strong>{{ $event->name }}</strong>. Välj dina platser nedan. I nästa steg får du fylla i vilka som ska ha
                biljetterna. <strong><a href="#">Ändra biljetttyp eller antal</a></strong>.
            </p>

            <br style="clear: both;">

            <img src="{{ URL::to('/img/temppicker.png') }}" style="max-width: 100%;">

            <div class="flex justify-between">
                <a href="/event/{{ $event->slug }}/?clearcart" class="btn btn-grey">Avbryt</a>
                <input id="submit" type="submit" class="btn btn-pink" value='Gå vidare till betalning' />
            </div>
        </form>
    </main>
@endsection
