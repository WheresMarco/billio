<div class="ticket-type">
    <img src="{{ URL::to('/img/icons/ticket.svg') }}" class="svg-icon">

    <h3>{{$ticketType->name}}<br /><small>{{$ticketType->price}} SEK</small></h3>
    <p>{{$ticketType->description}}</p>

    <label style="font-weight: bold;">Antal biljetter</label><br style="clear: both;">
    <input type="number" value="3" style="width: 120px; height: 43px; margin-right: 10px; margin-top: 10px; float:left;">

    @if ( $ticketType->active && ! $ticketType->soldOut )
        <a href="/event/{{$event->slug}}/{{$ticketType->slug}}/info" class="faux-button pink" style="margin-top: 10px;">Köp tre "{{$ticketType->name}}"-biljetter</a>
    @else
        <button class="faux-button pink disabled">Inte tillgänglig</button>
    @endif
</div>
