@extends('layouts.app')

@section('content')
<main>
    <div class="event-image" style="background-image: url({{URL::asset($event->hero_image)}});"></div>

    <div class="wrapper">
        <section class="event">
            <div class="event-content">
                <h1>{{$event->name}}</h1>

                <div class="description small">
                    {{ Illuminate\Mail\Markdown::parse($event->description) }}
                </div>

                <button class="description-read-more">Läs mer om evenemanget</button>
            </div>
        </section>
    </div>

    <br style="clear: both;">

    <div class="event-meta">
        <div class="wrapper">
            <div class="event-meta-item">
                <h4>Datum</h4>
                <span>{{$event->event_dates[0]->date_from->format('d/m - Y')}}</span>
            </div>

            <div class="event-meta-item">
                <h4>Plats</h4>
                <span>{{$event->event_dates[0]->location}}</span>
            </div>

            <div class="event-meta-item">
                <h4>Värd</h4>
                <span>{{$event->organisation->title}}</span>
            </div>

            <div class="event-meta-item links">
                <a href="mailto:{{$event->organisation->email}}" class="faux-button">Kontakta värden</a>
                <a href="{{$event->organisation->url}}" target="_blank" rel="noopener noreferrer" class="faux-button">Besök värdens webbplats</a>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <section class="tickets">
            @foreach ($event->ticket_types as $ticketType)
                <div class="ticket-type">
                    <img src="{{ URL::to('/img/icons/ticket.svg') }}" class="svg-icon">

                    <h3>{{$ticketType->name}}<br /><small>{{$ticketType->price}} SEK</small></h3>
                    <p>{{$ticketType->description}}</p>

                    @if ( $ticketType->active && ! $ticketType->soldOut() )
                        <a href="/{{$event->slug}}/{{$ticketType->slug}}" class="faux-button pink">Köp en "{{$ticketType->name}}"-biljett</a>
                    @else
                        <button class="faux-button pink disabled">Inte tillgänglig</button>
                    @endif
                </div>
            @endforeach
        </section>

        <br style="clear: both;">
    </div>
</main>
@endsection
