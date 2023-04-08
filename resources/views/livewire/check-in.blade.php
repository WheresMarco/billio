<div>
    <div class="flex justify-between">
        <div>
            <select wire:model="event" class="text-black">
                <option value="">Select event</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                @endforeach
            </select>
            <input type="text" wire:model="search" placeholder="Search name, email, or ticket code" class="text-black">
        </div>

        <button wire:click="clearSearch" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            Start QR scanner
        </button>
    </div>

    <div class="text-center hidden">
        QR-code scanner
    </div>

    <hr>

    @foreach ($tickets as $ticket)
        <div class="grid grid-cols-2 rounded-md border border-gray-600 bg-light-grey shadow-md mb-4 p-4">
            <div>
                <strong>{{ $ticket->user->name }}</strong><br>
                {{ $ticket->ticket_type->name }} ({{ $ticket->ticket_code }}) <br>
                {{ $ticket->occurrence->date_from->format('Y-m-d H:i') }} till {{ $ticket->occurrence->date_to->format('Y-m-d H:i') }} ({{ $ticket->occurrence->location }})
                <div class="text-sm">
                    {{ $ticket->user->email }} <br>
                    @if ($ticket->modifiers)
                        @foreach ($ticket->modifiers as $modifier)
                            {{ $modifier->name }},{{ ' ' }}
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="flex justify-end">
                <div>
                    @if ($ticket->status == 'utilized')
                        <button wire:click="changeStatus({{ $ticket->id }}, 'unused')"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">
                            Undo
                        </button><br>
                        <span class="text-sm text-gray-400 mt-2 inline-block">({{ $ticket->checked_in_at ? 'Checked in at ' . $ticket->checked_in_at : 'Not checked in' }})</span>
                        @else
                        <button wire:click="changeStatus({{ $ticket->id }}, 'utilized')"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">
                            Check in
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <hr>

    <div class="text-white">
        {{ $tickets->links() }}
    </div>
</div>
