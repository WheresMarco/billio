@section('title', $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', Storage::url($event->share_image))

@extends('layouts.app')

@section('content')
    <main class="bg-gray-100" x-data="{ activeTab: 0 }">
        <div class="container mx-auto py-8">
            <h1 class="relative pb-4 font-headline text-4xl text-pink">{{ $event->name }}</h1>

            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2">
                    <img src={{ Storage::url($event->hero_image) }} alt="" class="rounded-md">

                    @if ($event->getDescription() && $event->getDescription()->count() > 1)
                        <div class="pb-4 pt-4">
                            @foreach ($event->getDescription() as $contentKey => $content)
                                <a @click="activeTab = {{ $contentKey }}" class="btn bg-white shadow-md"
                                    :class="{ 'btn-pink': activeTab === {{ $contentKey }} }">{{ $content->title }}</a>
                            @endforeach
                        </div>
                    @endif

                    <div class="rounded-md bg-white p-4 shadow-md">
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
                </div>
                <div>
                    <div class="rounded-md bg-white p-4 shadow-md">
                        <h3 class="pt-2 font-headline text-2xl"><span class="font-medium">Biljetter</span> från 395,00 SEK
                        </h3>
                        <a href="#" class="btn btn-pink mt-4 w-full text-center">Köp biljett</a>
                    </div>

                    <div class="mt-4 rounded-md bg-white shadow-md">
                        <div class="p-4">
                            <h4 class="pt-2 font-headline text-xl font-medium">Datum</h4>
                            <p>{{ $event->date_from ? $event->date_from->format('d/m - Y') : '' }} -
                                {{ $event->date_to ? $event->date_to->format('d/m - Y') : '' }}</p>

                            <h4 class="pt-2 font-headline text-xl font-medium">Arrangör</h4>
                            <p>{{ $event->organisation->title }}</p>
                            <a href="#">Kontakta arrangören</a>

                            <h4 class="pt-2 font-headline text-xl font-medium">Plats</h4>
                            <span>{{ $event->location }}</span>
                        </div>
                        <div style="width: 100%"><iframe width="100%" height="300" frameborder="0" scrolling="no"
                                marginheight="0" marginwidth="0"
                                src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=1%20Grafton%20Street,%20Dublin,%20Ireland+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a
                                    href="https://www.maps.ie/distance-area-calculator.html">distance maps</a></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto hidden">
            <section class="space-y-8 px-4 py-12 pb-12 md:grid md:grid-cols-2 md:space-y-0 md:space-x-8 lg:px-0">
                @foreach ($event->ticket_types as $ticketType)
                    <div class=bg-white p-8 shadow-md">
                        @include('includes.ticket-type', $ticketType)
                    </div>
                @endforeach
            </section>
        </div>
    </main>
@endsection
