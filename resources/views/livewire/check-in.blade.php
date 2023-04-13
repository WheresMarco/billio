<div x-data="{ qr: false }">
    <div class="flex justify-between mb-2 mt-2 px-2 xl:px-0">
        <div>
            <select wire:model="event" class="text-black w-full lg:w-auto rounded-md">
                <option value="">Välj evenemang</option>
                @foreach ($events as $event)
                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                @endforeach
            </select>
            <input type="text" id="search-field" wire:model="search" placeholder="Sök namn, e-post, eller biljettkod"
                class="text-black rounded-md mt-2 lg:mt-0 w-full lg:w-auto">
        </div>

        <button id="toggle-qr"
            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md ml-2 md:ml-0 w-full lg:w-auto"
            x-on:click="qr = ! qr;">
            Toggla QR-scannern
        </button>
    </div>

    <div id="video-container" class="mt-2" x-show="qr">
        <video id="qr-video" playsinline class="rounded-md w-full max-h-64"></video>
    </div>

    <div wire:loading.class.delay="opacity-30">
        @forelse ($tickets as $ticket)
            <div class="grid lg:grid-cols-2 border-t border-b border-gray-600 bg-light-grey shadow-md mb-4 p-4 mt-4">
                <div>
                    <strong>{{ $ticket->user->name }}</strong><br>
                    {{ $ticket->ticket_type->name }} ({{ $ticket->ticket_code }}) <br>
                    @if ($ticket->occurrence)
                        <span class="text-sm">{{ $ticket->occurrence->date_from->format('Y-m-d H:i') }} till
                            {{ $ticket->occurrence->date_to->format('Y-m-d H:i') }}</span>
                    @endif
                    <div class="text-sm">
                        {{ $ticket->user->email }} <br>
                        @if ($ticket->modifiers)
                            @foreach ($ticket->modifiers as $modifier)
                                {{ $modifier->name }},{{ ' ' }}
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="lg:flex lg:justify-end mt-2 lg:mt-0">
                    <div class="text-center">
                        @if ($ticket->status == 'utilized')
                            <button wire:click="changeStatus({{ $ticket->id }}, 'unused')"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md w-full">
                                Ångra
                            </button><br>
                            <span
                                class="text-sm text-gray-400 mt-2 inline-block">({{ $ticket->checked_in_at ? 'Checkades in ' . $ticket->checked_in_at : 'Inte incheckad' }})</span>
                        @else
                            <button wire:click="changeStatus({{ $ticket->id }}, 'utilized')"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md w-full">
                                Checka in
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-white text-center text-xl mt-4">
                @if ($currentEvent == 0)
                    Inga biljetter hittades. Har du valt ett evenemang?
                @else
                    Inga biljetter hittades. Kontrollera att du har skrivit rätt på biljettkoden, namnet, eller e-postadressen.
                @endif
            </div>
        @endforelse

        <div class="text-white px-2">
            {{ $tickets->links() }}
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ mix('js/qr.js') }}"></script>
@endpush
