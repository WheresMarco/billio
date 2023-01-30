<form action="/event/{{ $event->slug }}/{{ $ticketType->slug }}" method="post">
    <div>
        @csrf
        <input type="hidden" name="ticket_type_id" value="{{ $ticketType->id }}">

        <x-heroicon-o-ticket class="h-12 text-white float-left relative -top-0.5 mr-2" />

        <h3 class="mt-2 -mb-1 font-headline text-2xl font-medium">{{ $ticketType->name }}</h3>
        <h4 class="text-base font-medium">{{ $ticketType->price }} kr</h4>

        <p>{{ $ticketType->description }}</p>
    </div>

    <div>
        @if (($ticketType->active && !$ticketType->soldOut) || (session('access_code_event') && session('access_code_event_id') == $event->id))
            <label class="mb-2 inline-block font-bold">Antal biljetter:</label><br>
            <input
                class="mr-1 w-1/4 rounded-md border-gray-300 bg-transparent shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50 sm:w-1/5"
                type="number" name="quantity" id="quantity" value="1" min="1"
                max="{{ $ticketType->limit_person }}" required>
            <input type="submit" class="btn btn-pink" value='Välj biljett' />
        @else
            @if ($ticketType->soldOut)
                <div class="btn btn-white btn-disabled mt-1">Slutsåld</div>
            @else
                <div class="btn btn-white btn-disabled mt-1">Inte tillgänglig just nu</div>
            @endif
        @endif
    </div>
</form>
