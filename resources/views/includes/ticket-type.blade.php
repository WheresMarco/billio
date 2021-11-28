<form action="/event/{{$event->slug}}/{{$ticketType->slug}}" method="post">
    @csrf
    <input type="hidden" name="ticket_type_id" value="{{$ticketType->id}}">

    <x-heroicon-o-ticket class="h-12 text-pink" />

    <h3 class="font-headline text-2xl mt-2 font-medium">{{$ticketType->name}}</h3>
    <h4 class="text-base font-medium">{{$ticketType->price}} SEK</h4>

    <p>{{$ticketType->description}}</p>

    <label class="font-bold mb-2 inline-block">Antal biljetter:</label><br>
    <input class="rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50" type="number" name="quantity" id="quantity" value="1" min="1" max="{{$ticketType->limit_person}}" required>

    @if ( $ticketType->active && ! $ticketType->soldOut )
        <input type="submit" class="btn btn-pink" value='Gå vidare' />
    @else
        <button class="faux-button pink disabled">Inte tillgänglig</button>
    @endif
</form>
