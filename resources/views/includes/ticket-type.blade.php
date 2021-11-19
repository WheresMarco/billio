<form action="/event/{{$event->slug}}/{{$ticketType->slug}}" method="post" class="ticket-type">
    @csrf
    <input type="hidden" name="ticket_type_id" value="{{$ticketType->id}}">

    <img src="{{ URL::to('/img/icons/ticket.svg') }}" class="svg-icon">

    <h3>{{$ticketType->name}}<br /><small>{{$ticketType->price}} SEK</small></h3>
    <p>{{$ticketType->description}}</p>

    <label style="font-weight: bold;">Antal biljetter</label>
    <input type="number" name="quantity" id="quantity" placeholder="1" min="1" max="{{$ticketType->limit_person}}" required>

    @if ( $ticketType->active && ! $ticketType->soldOut )
        <input type="submit" class="faux-button pink" value='Gå vidare' />
    @else
        <button class="faux-button pink disabled">Inte tillgänglig</button>
    @endif
</form>
