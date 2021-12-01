@section('title', $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', Storage::url($event->share_image))

@extends('layouts.app')

@section('content')
<main>
    <div class="h-60 sm:h-96 bg-cover bg-center" style="background-image: url({{Storage::url($event->hero_image)}});"></div>

    <div class="container mx-auto px-4 lg:px-0 pb-10">
        <h1 class="font-headline text-4xl text-pink pt-8">{{$event->name}}</h1>

        <div x-data="{ closed: true }">
            <div :class="{ 'description small': closed === true }">{{ Illuminate\Mail\Markdown::parse($event->description) }}</div>

            <a @click="closed = false" x-show="closed" class="btn btn-grey">Läs mer om evenemanget</a>
        </div>
    </div>

    <div class="bg-gray-100">
        <div class="container mx-auto md:grid md:grid-cols-2 md:space-x-8 px-4 lg:px-0 py-8 sm:py-4">
            <div class="grid grid-cols-2 md:grid-cols-3 mb-2 sm:mb-0">
                <div>
                    <h4 class="text-grey font-semibold"><x-heroicon-s-clock class="inline-block h-4 relative" style="margin-top: -2px;" /> Datum</h4>
                    <span class="text-grey">{{$event->event_dates[0]->date_from->format('d/m - Y')}}</span>
                </div>

                <div>
                    <h4 class="text-grey font-semibold"><x-heroicon-s-location-marker class="inline-block h-4 relative" style="margin-top: -3px;" /> Plats</h4>
                    <span class="text-grey">{{$event->event_dates[0]->location}}</span>
                </div>

                <div class="mt-2 sm:mt-0">
                    <h4 class="text-grey font-semibold"><x-heroicon-s-user-group class="inline-block h-4 relative" style="margin-top: -3px;" /> Värd</h4>
                    <span class="text-grey">{{$event->organisation->title}}</span>
                </div>
            </div>

            <div class="mt-4 sm:mt-0 sm:flex sm:justify-end sm:items-center">
                <a href="mailto:{{$event->organisation->email}}" class="btn btn-grey mr-2 text-center w-full sm:w-auto mb-2 sm:mb-0">Kontakta värden</a>
                <a href="{{$event->organisation->url}}" target="_blank" rel="noopener noreferrer" class="btn btn-grey text-center w-full sm:w-auto">Besök värdens webbplats</a>
            </div>
        </div>
    </div>

    <div class="container mx-auto">
        @if(count($event->ticket_types) > 0)
            <div class="bg-pink text-white px-4 sm:px-8 py-2 rounded-md my-4 mt-8 text-center mx-4 lg:mx-0">Observera att du behöver ett giltigt Covidpass för att kunna delta på {{$event->name}}.</div>
        @endif

        <section class="md:grid md:grid-cols-2 space-y-8 md:space-y-0 md:space-x-8 px-4 lg:px-0 py-4 pb-12">
            @foreach ($event->ticket_types as $ticketType)
                @include('includes.ticket-type', $ticketType)
            @endforeach
        </section>
    </div>
</main>
@endsection
