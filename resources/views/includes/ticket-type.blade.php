<form action="/event/{{$event->slug}}/{{$ticketType->slug}}" method="post" class="ticket-type">
    @csrf
    <input type="hidden" name="ticket_type_id" value="{{$ticketType->id}}">

    <img src="{{ URL::to('/img/icons/ticket.svg') }}" class="svg-icon">

    <h3>{{$ticketType->name}}<br /><small>{{$ticketType->price}} SEK</small></h3>
    <p>{{$ticketType->description}}</p>

    <label style="font-weight: bold;">Antal biljetter</label><br style="clear: both;">
    <input type="number" name="quantity" id="quantity" placeholder="1" style="width: 120px; height: 43px; margin-right: 10px; margin-top: 10px; float:left;">

    @if ( $ticketType->active && ! $ticketType->soldOut )
        <input type="submit" class="faux-button pink" value='Köp tre "{{$ticketType->name}}"-biljetter' />
    @else
        <button class="faux-button pink disabled">Inte tillgänglig</button>
    @endif
</form>
