@section('title', $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', Storage::url($event->share_image))

@extends('layouts.app')

@section('content')
    <main x-data="{ activeTab: 0 }">
        <div class="h-60 bg-cover bg-center sm:h-96" style="background-image: url({{ Storage::url($event->hero_image) }});">
        </div>

        <div class="bg-dark-grey">
            <div class="container mx-auto pt-4 pb-4">
                <h1 class="font-headline text-4xl text-white">{{ $event->name }}</h1>
                <div class="mb-2 grid grid-cols-2 sm:mb-0 md:grid-cols-3">
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
        </div>
        </div>

        @if ($event->getDescription() && $event->getDescription()->count() > 1)
            <div class="bg-gray-100">
                <div class="container mx-auto pb-4 pt-4">
                    @foreach ($event->getDescription() as $contentKey => $content)
                        <a @click="activeTab = {{ $contentKey }}" class="btn"
                            :class="{ 'btn-pink': activeTab === {{ $contentKey }} }">{{ $content->title }}</a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="container mx-auto mt-8 px-4 pb-10 lg:px-0">
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

        <hr>

        <div class="container mx-auto">
            <section class="space-y-8 px-4 py-8 pb-12 md:grid md:grid-cols-2 md:space-y-0 md:space-x-8 lg:px-0">
                @foreach ($event->ticket_types as $ticketType)
                    @include('includes.ticket-type', $ticketType)
                @endforeach
            </section>
        </div>
    </main>
@endsection
