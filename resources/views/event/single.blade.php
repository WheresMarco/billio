@section('title', $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', Storage::url($event->share_image))

@extends('layouts.app')

@section('content')
    <main x-data="{ activeTab: 0 }" class="bg-gray-100 pt-4">
        <div class="container mx-auto rounded-md bg-dark-grey shadow-md">
            <div class="h-60 rounded-t-md bg-cover bg-center sm:h-96"
                style="background-image: url({{ Storage::url($event->hero_image) }});">
            </div>

            <h1 class="px-4 pb-2 pt-4 font-headline text-4xl text-white">{{ $event->name }}</h1>
            <div class="grid grid-cols-2 px-4 pb-4 md:grid-cols-3">
                <div>
                    <x-heroicon-s-clock class="relative inline-block h-4 fill-white" style="margin-top: -2px;" />
                    <span class="text-grey">{{ $event->date_from ? $event->date_from->format('d/m - Y') : '' }}</span>
                </div>

                <div>
                    <x-heroicon-s-location-marker class="relative inline-block h-4 fill-white" style="margin-top: -3px;" />
                    <span class="text-grey">{{ $event->location }}</span>
                </div>

                <div class="mt-2 sm:mt-0">
                    <x-heroicon-s-user-group class="relative inline-block h-4 fill-white" style="margin-top: -3px;" />
                    <span class="text-grey">{{ $event->organisation->title }}</span>
                </div>
            </div>
        </div>

        <div class="container mx-auto mt-4 rounded-md bg-white p-4 shadow-md mb-4">
            @if ($event->getDescription() && $event->getDescription()->count() > 1)
                <div class="pb-4">
                    @foreach ($event->getDescription() as $contentKey => $content)
                        <a @click="activeTab = {{ $contentKey }}" class="btn"
                            :class="{ 'btn-pink': activeTab === {{ $contentKey }} }">{{ $content->title }}</a>
                    @endforeach
                </div>
            @endif
            @if ($event->getDescription() && $event->getDescription()->count() > 1)
                @foreach ($event->getDescription() as $contentKey => $content)
                    <div class="tab-panel" :class="{ 'active': activeTab === {{ $contentKey }} }"
                        x-show="activeTab === {{ $contentKey }}">
                        {{ Illuminate\Mail\Markdown::parse($content->content) }}
                    </div>
                @endforeach
            @else
                <div x-data="{ closed: true }">
                    <div :class="{ 'description small': closed === true }">
                        {{ Illuminate\Mail\Markdown::parse($event->description) }}</div>

                    <a @click="closed = false" x-show="closed" class="btn btn-grey">Läs mer om evenemanget</a>
                </div>
            @endif
        </div>

        <div class="container mx-auto" :class="{ 'active': activeTab === 0 }" x-show="activeTab === 0">
            <section class="space-y-8 px-4 pb-4 md:grid md:grid-cols-2 md:space-y-0 md:space-x-8 lg:px-0">
                @foreach ($event->ticket_types as $ticketType)
                    <div class="rounded-md bg-white p-8 shadow-md">
                        @include('includes.ticket-type', $ticketType)
                    </div>
                @endforeach
            </section>
        </div>
    </main>
@endsection
