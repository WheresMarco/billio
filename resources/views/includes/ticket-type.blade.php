<form action="/event/{{ $event['slug'] }}/{{ $ticketType->slug }}" method="post">
    <div>
        @csrf
        <input type="hidden" name="ticket_type_id" value="{{ $ticketType->id }}">

        <div class="ticketTypeIcon">{!! $ticketType->icon !!}</div>

        <h3 class="mt-2 -mb-1 font-headline text-2xl font-medium">{{ $ticketType->name }}</h3>
        <h4 class="text-base font-medium">{{ number_format($ticketType->price, 0, ',', ' ') }} kr</h4>

        {{ Illuminate\Mail\Markdown::parse($ticketType->description) }}
    </div>

    <div>
        @if (($ticketType->active && !$ticketType->soldOut) || ((session('access_code_event') && session('access_code_event_id') == $event['id']) && !$ticketType->soldOut))
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
