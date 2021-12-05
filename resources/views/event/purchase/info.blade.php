@section('title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $ticketType->name . '-biljett - ' . $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', Storage::url($event->share_image))

@extends('layouts.app')

@section('content')
<main class="container mx-auto py-8 px-4 md:w-2/3 lg:w-1/3">
    <div class="bg-pink text-white px-2 sm:px-8 py-2 rounded-md mb-8 text-center sm:mx-4 lg:mx-0">Observera att du behöver ett giltigt Covidpass för att kunna delta på {{$event->name}}.</div>

    <form action="/event/{{$event->slug}}/{{$ticketType->slug}}/info" method="post">
        @csrf
        <input type="hidden" name="ticket_type_id" value="{{$ticketType->id}}">
        <input type="hidden" name="event_id" value="{{$event->id}}">

        <h4 class="font-headline font-semibold text-grey">Steg 1 av 2</h4>
        <h2 class="font-headline text-3xl">Ange biljettuppgifter</h2>

        <p>Du har valt {{count($cart)}} <strong>"{{$ticketType->name}}"</strong>-@if(count($cart) > 1)biljetter @else biljett @endif för <strong>{{$event->name}}</strong>. Vänligen skriv in uppgifterna för vardera biljett.</p>

        @include('includes.countdown')

        @foreach ($cart as $key => $item)
            <div class="p-5 shadow-xl border rounded-md my-4" x-data="{ tickets{{$key}}karmedlem: false }">
                @if (count($cart) > 1)
                    <h3 class="font-headline text-2xl mb-2">Biljett #{{$key + 1}}</h3>
                @endif

                <div class="grid sm:grid-cols-2 sm:space-x-2">
                    <label class="block">
                        <span class="text-gray-700">Förnamn</span>
                        <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50" id="firstName" name="tickets[{{$key}}][firstName]" placeholder="Anna" value="{{ old('tickets[' . $key .'][firstName]') }}" required>
                    </label>

                    <label class="block mt-4 sm:mt-0">
                        <span class="text-gray-700">Efternamn</span>
                        <input type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50" id="lastName" name="tickets[{{$key}}][lastName]" placeholder="Andersson" value="{{ old('tickets[' . $key .'][lastName]') }}" required>
                    </label>
                </div>

                <label class="block mt-4 sm:mt-2">
                    <span class="text-gray-700">E-postadress</span>
                    <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50" id="email" name="tickets[{{$key}}][email]" placeholder="anna@andersson.se" value="{{ old('tickets[' . $key .'][email]') }}" required>
                </label>

                @if (count($ticketType->modifiers) > 0)
                    <div class="mt-4">
                        <ul class="space-y-2">
                            @foreach ($ticketType->modifiers as $modifier)
                                @if (! $modifier->hidden)
                                    <li class="bg-gray-100 p-2 leading-relaxed rounded-md">
                                        <input class="rounded border-gray-300 text-pink shadow-sm focus:border-blue focus:ring focus:ring-offset-0 focus:ring-blue focus:ring-opacity-50 cursor-pointer" id='tickets[{{$key}}][modifiers][{{$modifier->slug}}]' name="tickets[{{$key}}][modifiers][]" value='{{$modifier->slug}}' data-delta='{{$modifier->delta}}' type="checkbox" />
                                        <label for='tickets[{{$key}}][modifiers][{{$modifier->slug}}]' class="cursor-pointer">
                                            {{$modifier->name}} @if ($modifier->delta != 0)<span class="text-grey ml-2 font-bold">{{$modifier->delta}} SEK</span>@endif
                                        </label>
                                    </li>
                                @endif
                            @endforeach

                            @if ($ticketType->check_student)
                                <li class="bg-gray-100 p-2 leading-relaxed rounded-md">
                                    <input class="rounded border-gray-300 text-pink shadow-sm focus:border-blue focus:ring focus:ring-offset-0 focus:ring-blue focus:ring-opacity-50 cursor-pointer" id='tickets[{{$key}}][modifiers][karmedlem]' value='true' data-delta='-20' type="checkbox" x-model="tickets{{$key}}karmedlem" />
                                    <label for='tickets[{{$key}}][modifiers][karmedlem]' class="cursor-pointer">
                                        Jag är kårmedlem <span class="text-grey ml-2 font-bold">-20 SEK</span>
                                    </label>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif

                @if ($ticketType->check_student)
                    <div x-show="tickets{{$key}}karmedlem">
                        <div class="mt-2">
                            <p>Om biljettmottagaren är medlem i LinTek, Consensus, eller Stuff kan hen få kårrabatt. Mata in hens personnummer nedan och tryck på verifiera för att få rabatten.</p>

                            <div class="flex flex-row">
                                <input type="text" id="nin" name="tickets[{{$key}}][nin]" placeholder="Valfritt" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50 mr-2" value="{{ old('tickets[' . $key .'][nin]') }}" />
                                {{-- <input type="button" id="nin-verify" class='btn btn-blue' value="Validera" /> --}}
                            </div>
                            <span class="text-grey text-sm mt-2 inline-block">Skriv in ditt personnummer i formatet ÅÅMMDD-XXXX.</span>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach

        <div class="flex justify-between">
            <a href="/event/{{$event->slug}}/?clearcart" class="btn btn-grey">Avbryt</a>
            <input id="submit" type="submit" class="btn btn-pink" value='Gå vidare till betalning' />
        </div>
    </form>
</main>
@endsection
