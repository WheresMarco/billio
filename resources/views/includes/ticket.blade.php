<div class="my-4 mb-4 grid grid-cols-8 rounded-md border border-dashed p-4 sm:gap-6">
    <div class="col-span-full sm:col-span-3">
        <img src="https://qrcode.tec-it.com/API/QRCode?quietzone=3&backcolor=fff&data={{ $ticket->ticket_code }}" />
    </div>

    <div class="col-span-full sm:col-span-5">
        <h4 class="font-headline text-2xl">Biljettkod</h4>
        <span>{{ $ticket->ticket_code }}</span>

        @if ($ticket->occurrence)
            <h4 class="font-headline text-xl">Tillfälle</h4>
            <p>{{ $ticket->occurrence->date_from->format('Y-m-d H:i') }} -
                {{ $ticket->occurrence->date_to->format('Y-m-d H:i') }} ({{ $ticket->occurrence->location }})</p>
        @endif

        @if (!$ticket->modifiers->isEmpty())
            <h4 class="font-headline text-xl">Tillval</h4>
            <ul class="mb-2 list-disc">
                @foreach ($ticket->modifiers as $modifier)
                    <li class="ml-4">{{ $modifier->name }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
