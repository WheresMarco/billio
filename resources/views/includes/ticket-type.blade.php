<form action="/event/{{ $event->slug }}/{{ $ticketType->slug }}" method="post">
    <div>
        @csrf
        <input type="hidden" name="ticket_type_id" value="{{ $ticketType->id }}">

        <x-heroicon-o-ticket class="h-12 text-pink" />

        <h3 class="mt-2 font-headline text-2xl font-medium">{{ $ticketType->name }}</h3>
        <h4 class="text-base font-medium">{{ $ticketType->price }} kr</h4>

        <p>{{ $ticketType->description }}</p>
    </div>

    <div>
        @if ($ticketType->active && !$ticketType->soldOut)
            <label class="mb-2 inline-block font-bold">Antal biljetter:</label><br>
            <input
                class="mr-1 w-1/4 rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50 sm:w-1/5"
                type="number" name="quantity" id="quantity" value="1" min="1"
                max="{{ $ticketType->limit_person }}" required>
            <input type="submit" class="btn btn-pink" value='Gå vidare' />
        @else
            @if ($ticketType->soldOut)
                <div class="btn btn-grey btn-disabled mt-1">Slutsålt</div>
            @else
                <div class="btn btn-grey btn-disabled mt-1">Inte tillgänglig</div>
            @endif
        @endif
    </div>
</form>
