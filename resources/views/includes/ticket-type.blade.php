<div class="ticket-type">
    <img src="{{ URL::to('/img/icons/ticket.svg') }}" class="svg-icon">

    <h3>{{$ticketType->name}}<br /><small>{{$ticketType->price}} SEK</small></h3>
    <p>{{$ticketType->description}}</p>

    @if ( $ticketType->active && ! $ticketType->soldOut )
        <a href="/event/{{$event->slug}}/{{$ticketType->slug}}" class="faux-button pink">Köp en "{{$ticketType->name}}"-biljett</a>
    @else
        <button class="faux-button pink disabled">Inte tillgänglig</button>
    @endif
</div>
