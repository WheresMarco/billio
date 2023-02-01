@section('title', $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', Storage::url($event->share_image))

@extends('layouts.app')

@section('content')
    <main x-data="{ activeTab: 0 }" class="px-4 md:px-0">
        <div class="container mx-auto pb-8">
            <div class="grid grid-cols-1 gap-y-4 md:grid-cols-3 md:gap-4">
                <div class="col-span-2">
                    <img src={{ Storage::url($event->hero_image) }} alt="" class="rounded-md">

                    <div class="rounded-md border border-gray-600 bg-light-grey p-4 mt-4 text-white md:hidden">
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
                            @foreach ($event->getDescription() as $contentKey => $content)
                                <a @click="activeTab = {{ $contentKey }}" class="btn mr-2 mb-2 bg-light-grey md:mb-0"
                                    :class="{ 'btn-pink': activeTab === {{ $contentKey }} }">{{ $content->title }}</a>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 text-white">
                        @if ($event->getDescription() && $event->getDescription()->count() > 0)
                            @foreach ($event->getDescription() as $contentKey => $content)
                                <div :class="{ 'active': activeTab === {{ $contentKey }} }"
                                    x-show="activeTab === {{ $contentKey }}">
                                    {{ Illuminate\Mail\Markdown::parse($content->content) }}
                                </div>
                            @endforeach
                        @else
                            {{ Illuminate\Mail\Markdown::parse($event->description) }}
                        @endif
                    </div>

                    @if (count($event->ticket_types) > 0)
                        <h1 class="relative mt-4 -mb-2 font-headline text-2xl text-white" id="tickets">Biljetter</h1>
                    @endif

                    @foreach ($event->ticket_types as $ticketType)
                        <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 text-white">
                            @include('includes.ticket-type', $ticketType)
                        </div>
                    @endforeach
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

                    <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 text-white hidden">
                        <h4 class="mb-2 font-headline font-semibold">Donationer</h4>

                        <div class="flex justify-between">
                            <p class="font-medium">0 kr</p>
                            <p class="font-medium">1 000 kr</p>
                        </div>

                        <div class="h-2.5 w-full rounded-full bg-white">
                            <div class="h-2.5 rounded-full bg-pink" style="width: 45%"></div>
                        </div>
                        <p class="text-center text-gray-200">45% av första nivån uppnådd.</p>
                        <p>Detta evenemang har olika donationsnivåer. Läs mer om dessa <a href="#">här</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
