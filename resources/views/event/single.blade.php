@section('title', $event->name . ' | Billio')
@section('description', $event->excerpt)
@section('og-title', $event->name . ' | Billio')
@section('og-content', $event->excerpt)
@section('og-image', Storage::url($event->share_image))

@extends('layouts.app')

@section('content')
    <main x-data="{ activeTab: 0 }">
        <div class="container mx-auto pb-8">
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2">
                    <img src={{ Storage::url($event->hero_image) }} alt="" class="rounded-md">

                    @if ($event->getDescription() && $event->getDescription()->count() > 1)
                        <div class="mt-4">
                            @foreach ($event->getDescription() as $contentKey => $content)
                                <a @click="activeTab = {{ $contentKey }}" class="btn mr-2 bg-light-grey"
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
                        <h1 class="relative mt-4 -mb-2 font-headline text-2xl text-white">Biljetter</h1>
                    @endif

                    @foreach ($event->ticket_types as $ticketType)
                        <div class="mt-4 rounded-md border border-gray-600 bg-light-grey p-4 text-white">
                            @include('includes.ticket-type', $ticketType)
                        </div>
                    @endforeach
                </div>

                <div>
                    <div class="rounded-md border border-gray-600 bg-light-grey text-white">
                        <div class="p-4">
                            <h1 class="relative pb-2 font-headline text-2xl text-white">{{ $event->name }}</h1>

                            <h4 class="-mb-2 font-headline font-semibold">Datum</h4>
                            <p>{{ $event->date_from ? $event->date_from->format('d/m - Y') : '' }} -
                                {{ $event->date_to ? $event->date_to->format('d/m - Y') : '' }}</p>

                            <h4 class="-mb-2 pt-2 font-headline font-semibold">Plats</h4>
                            <p>{{ $event->location }}</p>

                            <h4 class="-mb-2 pt-2 font-headline font-semibold">Arrangör</h4>
                            <p>{{ $event->organisation->title }}<br><a href="#" class="font-medium">Kontakta
                                    arrangören</a></p>
                        </div>
                    </div>

                    <div class="mt-4 rounded-md border border-gray-600 bg-light-grey text-white">
                        <div class="p-4">
                            <h4 class="font-headline font-semibold mb-2">Donationer</h4>

                            <div class="flex justify-between">
                                <p class="font-medium">0 kr</p>
                                <p class="font-medium">1 000 kr</p>
                            </div>

                            <div class="h-2.5 w-full rounded-full bg-white">
                                <div class="bg-pink h-2.5 rounded-full" style="width: 45%"></div>
                            </div>
                            <p class="text-center text-gray-200">45% av första nivån uppnådd.</p>
                            <p>Detta evenemang har olika donationsnivåer. Läs mer om dessa <a href="#">här</a>.</p>
                        </div>
                    </div>

                    <iframe class="mt-4 rounded-md"
                        style="height: 300px; filter: grayscale(100%) invert(92%) contrast(83%);"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3241.6693059716295!2d139.72709271565213!3d35.66051838019914!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188b770913970d%3A0xccc3467fcb15b353!2zR29vZ2xl5ZCI5ZCM5Lya56S-44O75YWt5pys5pyo44Kq44OV44Kj44K5!5e0!3m2!1sja!2sjp!4v1589376190362!5m2!1sja!2sjp"
                        width="100%" height="324" frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </main>
@endsection
