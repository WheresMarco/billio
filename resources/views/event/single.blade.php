@section('title', $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', Storage::url($event->share_image))

@extends('layouts.app')

@section('content')
    <main x-data="{ activeTab: 'om-evenemanget' }" class="px-4 xl:px-0">
        <div class="container mx-auto pb-8">
            <div class="grid grid-cols-1 gap-y-4 md:grid-cols-3 md:gap-4">
                <div class="col-span-2">
                    <img src={{ Storage::url($event->hero_image) }} alt="" class="rounded-md">

                    <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 text-white md:hidden">
                        <h1 class="relative font-headline text-2xl text-white">{{ $event->name }}</h1>
                    </div>

                    <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 text-white md:hidden">
                        <h4 class="-mb-2 font-headline font-semibold">Datum</h4>
                        <p>{{ $event->date_from ? $event->date_from->format('d/m - Y') : '' }} -
                            {{ $event->date_to ? $event->date_to->format('d/m - Y') : '' }}</p>

                        <h4 class="-mb-2 pt-2 font-headline font-semibold">Plats</h4>
                        <p>{{ $event->location }}</p>

                        <h4 class="-mb-2 pt-2 font-headline font-semibold">Arrangör</h4>
                        <p>{{ $event->organisation->title }} ({{ $event->organisation->email }})</p>
                    </div>

                    @if ($event->getDescription() && $event->getDescription()->count() > 1)
                        <div class="mt-4">
                            @foreach ($event->getDescription() as $content)
                                <a @click="activeTab = '{{ Str::slug($content->title, '-') }}'"
                                    class="btn mr-2 mb-2 bg-light-grey md:mb-0"
                                    :class="{ 'btn-pink': activeTab === '{{ Str::slug($content->title, '-') }}' }">{{ $content->title }}</a>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 text-white">
                        @if ($event->getDescription() && $event->getDescription()->count() > 0)
                            @foreach ($event->getDescription() as $content)
                                <div :class="{ 'active': activeTab === '{{ Str::slug($content->title, '-') }}' }"
                                    x-show="activeTab === '{{ Str::slug($content->title, '-') }}'">
                                    {{ Illuminate\Mail\Markdown::parse($content->content) }}
                                </div>
                            @endforeach
                        @else
                            {{ Illuminate\Mail\Markdown::parse($event->description) }}
                        @endif
                    </div>

                    <!-- List out donation goals -->
                    @if ($donation_goals)
                        <div x-show="activeTab === 'donera'">
                            @if ($next_donation_goal)
                                <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 pb-0 text-white md:hidden">
                                    <h4 class="mb-2 font-headline font-semibold">Donationer</h4>

                                    <div class="flex justify-between">
                                        <p class="font-medium">0 kr</p>
                                        <p class="font-medium">{{ number_format($next_donation_goal->amount, 0, ',', ' ') }} kr</p>
                                    </div>

                                    <div class="h-2.5 w-full rounded-full bg-white">
                                        <div class="h-2.5 rounded-full bg-pink"
                                            style="width: {{ $next_donation_goal->percentage }}%"></div>
                                    </div>
                                    <p class="text-center text-gray-200">{{ $next_donation_goal->percentage }}% av nivå
                                        {{ $next_donation_goal->key + 1 }} uppnådd.</p>
                                    </p>
                                </div>
                            @endif

                            <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 text-white">
                                <h2 class="relative font-headline text-2xl text-white">Donationsnivåer</h2>
                                <p class="mb-2">Totalt insamlat: {{ number_format($donations_amount, 0, ',', ' ') }} kr</p>

                                <ul>
                                    @foreach ($donation_goals as $donationGoal)
                                        <li
                                            class="@if ($donationGoal->amount <= $donations_amount) bg-green-600 @endif mb-2 rounded-md border border-gray-600 p-4">
                                            <span class="text-xl">{{ number_format($donationGoal->amount, 0, ',', ' ') }}
                                                kr</span><br>{{ $donationGoal->goal }}
                                        </li>
                                    @endforeach
                                </ul>

                                <h3 class="relative mt-4 -mb-2 font-headline text-xl text-white">Donera valfritt belopp</h3>
                                <form action="/event/{{ $event->slug }}/donate" method="post">
                                    @csrf
                                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                                    <input type="number" name="amount" value="100" min="10" max="10000"
                                        class="mr-1 w-1/4 rounded-md border-gray-300 bg-transparent shadow-sm focus:border-blue focus:ring focus:ring-blue focus:ring-opacity-50 sm:w-1/5">
                                    <button type="submit" class="btn btn-pink mt-4">Donera</button>
                                </form>

                                <p class="mt-2 text-grey">Vid belopp över 10 000 kr hänvisar vi att kontakta arrangören för
                                    att
                                    hantera
                                    donationen.</p>
                            </div>
                        </div>
                    @endif

                    <div x-show="activeTab != 'donera'">
                        @if (count($event->ticket_types) > 0)
                            <h1 class="relative mt-4 -mb-2 font-headline text-2xl text-white" id="tickets">Biljetter</h1>
                        @endif

                        @foreach ($event->ticket_types as $ticketType)
                            <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 text-white">
                                @include('includes.ticket-type', $ticketType)
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="rounded-md border border-gray-600 bg-light-grey p-4 text-white">
                        <h1 class="relative font-headline text-2xl text-white">{{ $event->name }}</h1>
                    </div>

                    <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 text-white">
                        <h4 class="-mb-2 font-headline font-semibold">Datum</h4>
                        <p>{{ $event->date_from ? $event->date_from->format('d/m - Y') : '' }} -
                            {{ $event->date_to ? $event->date_to->format('d/m - Y') : '' }}</p>

                        <h4 class="-mb-2 pt-2 font-headline font-semibold">Plats</h4>
                        <p>{{ $event->location }}</p>

                        <h4 class="-mb-2 pt-2 font-headline font-semibold">Arrangör</h4>
                        <p>{{ $event->organisation->title }} ({{ $event->organisation->email }})</p>
                    </div>

                    @if ($next_donation_goal)
                        <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 text-white">
                            <h4 class="mb-2 font-headline font-semibold">Donationer</h4>

                            <div class="flex justify-between">
                                <p class="font-medium">0 kr</p>
                                <p class="font-medium">{{ number_format($next_donation_goal->amount, 0, ',', ' ') }} kr</p>
                            </div>

                            <div class="h-2.5 w-full rounded-full bg-white">
                                <div class="h-2.5 rounded-full bg-pink"
                                    style="width: {{ $next_donation_goal->percentage }}%"></div>
                            </div>
                            <p class="text-center text-gray-200">{{ $next_donation_goal->percentage }}% av nivå
                                {{ $next_donation_goal->key + 1  }} uppnådd.</p>
                            <p>Detta evenemang har olika donationsnivåer. Läs mer om dessa under fliken "Donera".</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
