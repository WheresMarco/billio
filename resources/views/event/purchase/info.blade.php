@section('title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', Storage::url($event->share_image))

@extends('layouts.app')

@section('content')
    <main class="container mx-auto py-8 px-4 md:w-2/3 lg:w-1/3">
        <form action="/event/{{ $event->slug }}/{{ $ticketType->slug }}/info" method="post">
            @csrf
            <input type="hidden" name="ticket_type_id" value="{{ $ticketType->id }}">
            <input type="hidden" name="event_id" value="{{ $event->id }}">

            <h4 class="font-headline font-semibold text-grey">Steg 1 av 2</h4>
            <h2 class="font-headline text-3xl">Ange biljettuppgifter</h2>

            <p>Du har valt {{ count($cart) }} <strong>"{{ $ticketType->name }}"</strong>-@if (count($cart) > 1)
                    biljetter
                @else
                    biljett
                @endif för <strong>{{ $event->name }}</strong>. Vänligen skriv in uppgifterna för
                vardera biljett.</p>

            @include('includes.countdown')

            @foreach ($cart as $key => $item)
                <div class="my-4 rounded-md border p-5 shadow-xl" x-data="{ tickets{{ $key }}karmedlem: false }">
                    @if (count($cart) > 1)
                        <h3 class="mb-2 font-headline text-2xl">Biljett #{{ $key + 1 }}</h3>
                    @endif

                    <div class="grid sm:grid-cols-2 sm:space-x-2">
                        <label class="block">
                            <span class="text-gray-700">Förnamn</span>
                            <input type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50"
                                id="firstName" name="tickets[{{ $key }}][firstName]" placeholder="Anna"
                                value="{{ old('tickets[' . $key . '][firstName]') }}" required>
                        </label>

                        <label class="mt-4 block sm:mt-0">
                            <span class="text-gray-700">Efternamn</span>
                            <input type="text"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50"
                                id="lastName" name="tickets[{{ $key }}][lastName]" placeholder="Andersson"
                                value="{{ old('tickets[' . $key . '][lastName]') }}" required>
                        </label>
                    </div>

                    <label class="mt-4 block sm:mt-2">
                        <span class="text-gray-700">E-postadress</span>
                        <input type="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50"
                            id="email" name="tickets[{{ $key }}][email]" placeholder="anna@andersson.se"
                            value="{{ old('tickets[' . $key . '][email]') }}" required>
                    </label>

                    @if (count($ticketType->modifiers) > 0)
                        <hr>
                        <div class="mt-4">
                            <ul class="space-y-2">
                                <li>
                                    <label class="text-gray-700">Relation till LiTHe Blås</label>
                                    <select name="cars" id="cars"
                                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50">
                                        <option value="volvo">Gamling</option>
                                        <option value="saab">Gamlings +1</option>
                                        <option value="mercedes">Balkesterperson</option>
                                        <option value="audi">Övrig</option>
                                    </select>
                                </li>

                                <li>
                                    <label class="text-gray-700">Jag var aktiv</label>
                                    <input type="text"
                                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50" />
                                </li>

                                <li>
                                    <label class="text-gray-700">Specialkost</label>
                                    <input type="text"
                                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50" />
                                </li>

                                <li>
                                    <label class="text-gray-700">Jag önskar sitta bredvid</label>
                                    <input type="text"
                                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50" />
                                </li>

                                <li>
                                    <label class="text-gray-700">Dryckespreferens</label>
                                    <select name="cars" id="cars"
                                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50">
                                        <option value="volvo">Öl</option>
                                        <option value="saab">Rött vin</option>
                                        <option value="mercedes">Vitt vin</option>
                                        <option value="audi">Alkoholfritt</option>
                                    </select>
                                </li>

                                <br>
                                <hr><br>

                                @foreach ($ticketType->modifiers as $modifier)
                                    @if (!$modifier->hidden)
                                        <li class="rounded-md bg-gray-100 p-2 leading-relaxed">
                                            <input
                                                class="cursor-pointer rounded border-gray-300 text-pink shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50 focus:ring-offset-0"
                                                id='tickets[{{ $key }}][modifiers][{{ $modifier->slug }}]'
                                                name="tickets[{{ $key }}][modifiers][]"
                                                value='{{ $modifier->slug }}' data-delta='{{ $modifier->delta }}'
                                                type="checkbox" />
                                            <label for='tickets[{{ $key }}][modifiers][{{ $modifier->slug }}]'
                                                class="cursor-pointer">
                                                <strong>{{ $modifier->name }}</strong>
                                                @if ($modifier->delta != 0)
                                                    <span class="ml-2 font-bold text-grey">{{ $modifier->delta }}
                                                        SEK</span>
                                                @endif
                                            </label>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                Lorem Ipsum has been the industry's standard dummy text ever since the
                                                1500s, when an unknown printer took a galley of type and scrambled it to
                                                make a type specimen book.</p>
                                        </li>
                                    @endif
                                @endforeach

                                @if ($ticketType->check_student)
                                    <li class="rounded-md bg-gray-100 p-2 leading-relaxed">
                                        <input
                                            class="cursor-pointer rounded border-gray-300 text-pink shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50 focus:ring-offset-0"
                                            id='tickets[{{ $key }}][modifiers][karmedlem]' value='true'
                                            data-delta='-20' type="checkbox"
                                            x-model="tickets{{ $key }}karmedlem" />
                                        <label for='tickets[{{ $key }}][modifiers][karmedlem]'
                                            class="cursor-pointer">
                                            Jag är kårmedlem <span class="ml-2 font-bold text-grey">-20 SEK</span>
                                        </label>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    @if ($ticketType->check_student)
                        <div x-show="tickets{{ $key }}karmedlem">
                            <div class="mt-2">
                                <p>Om biljettmottagaren är medlem i LinTek, Consensus, eller Stuff kan hen få kårrabatt.
                                    Mata in hens personnummer nedan och tryck på verifiera för att få rabatten.</p>

                                <div class="flex flex-row">
                                    <input type="text" id="nin" name="tickets[{{ $key }}][nin]"
                                        placeholder="Valfritt"
                                        class="mr-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50"
                                        value="{{ old('tickets[' . $key . '][nin]') }}" />
                                    {{-- <input type="button" id="nin-verify" class='btn btn-blue' value="Validera" /> --}}
                                </div>
                                <span class="mt-2 inline-block text-sm text-grey">Skriv in ditt personnummer i formatet
                                    ÅÅMMDD-XXXX.</span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="flex justify-between">
                <a href="/event/{{ $event->slug }}/?clearcart" class="btn btn-grey">Avbryt</a>
                <input id="submit" type="submit" class="btn btn-pink" value='Gå vidare till betalning' />
            </div>
        </form>
    </main>
@endsection
