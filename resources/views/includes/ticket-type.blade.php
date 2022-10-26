<form action="/event/{{$event->slug}}/{{$ticketType->slug}}" method="post">
    @csrf
    <input type="hidden" name="ticket_type_id" value="{{$ticketType->id}}">

    <x-heroicon-o-ticket class="text-pink h-12" />

    <h3 class="font-headline mt-2 text-2xl font-medium">{{$ticketType->name}}</h3>
    <h4 class="text-base font-medium">{{$ticketType->price}} SEK</h4>

    <p>{{$ticketType->description}}</p>

    @if ( $ticketType->active && ! $ticketType->soldOut )
        <label class="mb-2 inline-block font-bold">Antal biljetter:</label><br>
        <input class="focus:border-blue focus:ring-blue mr-1 w-1/4 rounded-md border-gray-300 shadow-sm focus:ring focus:ring-opacity-50 sm:w-1/5" type="number" name="quantity" id="quantity" value="1" min="1" max="{{$ticketType->limit_person}}" required>
        <input type="submit" class="btn btn-pink" value='Gå vidare' />
    @else
        @if ($ticketType->soldOut)
            <div class="btn btn-grey btn-disabled mt-1">Slutsålt</div>
        @else
            <div class="btn btn-grey btn-disabled mt-1">Inte tillgänglig</div>
        @endif
    @endif
</form>
