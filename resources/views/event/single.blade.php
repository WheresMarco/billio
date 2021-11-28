@section('title', $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', URL::asset($event->share_image))

@extends('layouts.app')

@section('content')
<main>
    <div class="h-60 sm:h-96 bg-cover bg-center" style="background-image: url({{URL::asset($event->hero_image)}});"></div>

    <div class="container mx-auto px-4 lg:px-0 pb-10">
        <h1 class="font-headline text-4xl text-pink pt-8">{{$event->name}}</h1>

        <div x-data="{ closed: true }">
            <div :class="{ 'description small': closed === true }">{{ Illuminate\Mail\Markdown::parse($event->description) }}</div>

            <a @click="closed = false" x-show="closed" class="btn">Läs mer om evenemanget</a>
        </div>
    </div>

    <div class="bg-gray-100">
        <div class="container mx-auto md:grid md:grid-cols-2 md:space-x-8 px-4 lg:px-0 py-4">
            <div class="md:grid md:grid-cols-3">
                <div>
                    <h4 class="text-grey font-semibold"><x-heroicon-s-clock class="inline-block h-4" /> Datum</h4>
                    <span class="text-grey">{{$event->event_dates[0]->date_from->format('d/m - Y')}}</span>
                </div>

                <div>
                    <h4 class="text-grey font-semibold"><x-heroicon-s-location-marker class="inline-block h-4" /> Plats</h4>
                    <span class="text-grey">{{$event->event_dates[0]->location}}</span>
                </div>

                <div>
                    <h4 class="text-grey font-semibold"><x-heroicon-s-user-group class="inline-block h-4" /> Värd</h4>
                    <span class="text-grey">{{$event->organisation->title}}</span>
                </div>
            </div>

            <div>
                <a href="mailto:{{$event->organisation->email}}" class="btn">Kontakta värden</a>
                <a href="{{$event->organisation->url}}" target="_blank" rel="noopener noreferrer" class="btn">Besök värdens webbplats</a>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        @if(count($event->ticket_types) > 0)
            <div class="bg-pink text-white px-8 py-2 rounded-md my-4 mt-8 text-center mx-4 lg:mx-0">Observera att du behöver ett giltigt Covidpass för att kunna delta på {{$event->name}}.</div>
        @endif

        <section class="md:grid md:grid-cols-2 md:space-x-8 px-4 lg:px-0 py-4 pb-12">
            @foreach ($event->ticket_types as $ticketType)
                @include('includes.ticket-type', $ticketType)
            @endforeach
        </section>
    </div>
</main>
@endsection
