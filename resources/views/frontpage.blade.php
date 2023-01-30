@extends('layouts.app')

@section('content')
    <main>
        <div class="z-0 bg-cover px-4 pt-16 pb-24 text-white bg-blend-darken sm:pt-40 sm:pb-40 lg:px-0"
            style="background-image: url('{{ URL::to('/img/hero.jpg') }}');">
            <div class="container mx-auto space-y-6">
                <h1 class="max-w-xl font-headline text-4xl font-medium sm:text-5xl sm:leading-tight">Att sälja biljetter ska
                    vara
                    <span class="text-pink">enkelt</span>
                </h1>
                <p class="max-w-xl sm:text-xl">Nästa gång du ska sälja biljetter använd Billio. Med Billio får du ett
                    komplett
                    system från försäljning till incheckning. Ett kraftfullt och snabbt system som kan hantera evenemang av
                    alla dess storlekar. På köpet är det dessutom enkelt att använda.</p>

                <p class="space-x-2"><a href="mailto:hi@billio.app" class="btn btn-pink">Kom igång med Billio</a> <a
                        href="/#app-info" class="btn btn-white">Läs mer</a></p>
            </div>
        </div>

        <div class="container mx-auto lg:px-0 border-b py-8 mb-8 border-gray-600">
            <h2 class="relative mb-2 font-headline text-2xl text-white">Kommande evenemang</h2>

            <div class="space-y-4">
                @foreach ($events as $event)
                    @if ($event->upcoming())
                        <div
                            class="grid grid-cols-1 rounded-md border border-gray-600 bg-light-grey text-white sm:grid-cols-8 sm:gap-6">
                            <a href="/event/{{ $event->slug }}"
                                class="rounded-tl-md rounded-tr-md bg-cover bg-center sm:col-span-3 sm:rounded-bl-md sm:rounded-tr-none"
                                style="background-image: url({{ Storage::url($event->excerpt_image) }}); min-height: 230px;"></a>

                            <div class="p-4 pr-10 sm:col-span-5 sm:py-12 sm:pl-0">
                                <h1><a href="/event/{{ $event->slug }}"
                                        class="font-headline text-3xl font-normal text-pink">{{ $event->name }}</a>
                                </h1>
                                <p class="pb-4 pt-2"><a href="/event/{{ $event->slug }}"
                                        class="font-normal">{{ $event->excerpt }}</a></p>

                                <div class="border-grey-100 grid grid-cols-2 border-t-2 border-gray-600 py-4">
                                    <div>
                                        <h4 class="font-headline font-semibold text-grey">
                                            <x-heroicon-s-clock class="relative inline-block h-4"
                                                style="margin-top: -2px;" /> Datum
                                        </h4>
                                        <span
                                            class="text-grey">{{ $event->date_from ? $event->date_from->format('d/m - Y') : '' }}</span>
                                    </div>

                                    <div>
                                        <h4 class="font-headline font-semibold text-grey">
                                            <x-heroicon-s-user-group class="relative inline-block h-4"
                                                style="margin-top: -3px;" /> Värd
                                        </h4>
                                        <span class="text-grey">{{ $event->organisation->title }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <h2 class="relative mb-2 mt-8 font-headline text-2xl text-white">Tidigare evenemang</h2>

            <div class="grid grid-cols-3 gap-4">
                @foreach ($events as $event)
                    @if ($event->upcoming() === false)
                        <div
                            class="rounded-md border border-gray-600 bg-light-grey text-white p-4 opacity-50 hover:opacity-100 transition-all">
                            <a href="/event/{{ $event->slug }}"
                                class="rounded-tl-md rounded-tr-md bg-cover bg-center sm:col-span-3 sm:rounded-bl-md sm:rounded-tr-none"
                                style="background-image: url({{ Storage::url($event->excerpt_image) }}); min-height: 230px;"></a>
                            <h1
                                class="font-headline text-3xl">
                                <a class="font-normal" href="/event/{{ $event->slug }}">{{ $event->name }}</a>
                            </h1>

                            <div class="grid grid-cols-2 mt-2 hidden">
                                <div>
                                    <h4 class="font-semibold text-grey group-hover:text-black">
                                        <x-heroicon-s-clock class="relative inline-block h-4" style="margin-top: -2px;" />
                                        Datum
                                    </h4>
                                    <span
                                        class="text-grey">{{ $event->date_from ? $event->date_from->format('d/m - Y') : '' }}</span>
                                </div>

                                <div>
                                    <h4 class="font-semibold text-grey group-hover:text-black">
                                        <x-heroicon-s-user-group class="relative inline-block h-4"
                                            style="margin-top: -3px;" /> Värd
                                    </h4>
                                    <span class="text-grey group-hover:text-black">{{ $event->organisation->title }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>


        <div class="container mx-auto mb-4">
            @include('includes.bento')
        </div>
    </main>
@endsection
