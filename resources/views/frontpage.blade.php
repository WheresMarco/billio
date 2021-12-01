@extends('layouts.app')

@section('content')
<div class="bg-dark-grey text-white pt-16 pb-24 sm:pt-32 sm:pb-40">
    <div class="container mx-auto sm:text-center px-4 lg:px-0 space-y-6 sm:w-9/12 lg:w-2/5">
        <h1 class="text-4xl sm:text-5xl sm:leading-tight font-medium font-headline">Säg farväl till det jobbiga med att sälja biljetter</h1>
        <p class="sm:text-xl">Vill ni sälja biljetter till ert nästa evenemang? Med Billio får ni ett komplett system från försäljning till incheckning. Med ett kraftfullt och snabbt system som kan hantera evenemang av alla dess storlekar, som dessutom är enkelt att använda.</p>

        <p class="space-x-2"><a href="mailto:hi@billio.app" class="btn btn-pink">Kom igång med Billio</a> <a href="/#app-info" class="btn btn-orange">Läs mer</a></p>
    </div>
</div>

<main>
    <div class="bg-gray-100">
        <div class="container mx-auto py-16 space-y-6 px-4 lg:px-0">
            @foreach ($events as $event)
                @if ($event->upcoming())
                    <div class="bg-white rounded-md grid grid-cols-1 sm:grid-cols-8 sm:gap-6">
                        <a href="/event/{{$event->slug}}" class="sm:col-span-3 bg-cover rounded-tl-md sm:rounded-bl-md rounded-tr-md sm:rounded-tr-none" style="background-image: url({{Storage::url($event->excerpt_image)}}); min-height: 230px;"></a>

                        <div class="sm:col-span-5 p-4 sm:py-12 sm:pl-0 pr-10">
                            <h1><a href="/event/{{$event->slug}}" class="font-headline text-3xl text-pink font-normal">{{$event->name}}</a></h1>
                            <p class="pb-4 pt-2"><a href="/event/{{$event->slug}}" class="font-normal">{{$event->excerpt}}</a></p>

                            <div class="border-t-2 border-grey-100 grid grid-cols-2 py-4">
                                <div>
                                    <h4 class="text-grey font-semibold"><x-heroicon-s-clock class="inline-block h-4 relative" style="margin-top: -2px;" /> Datum</h4>
                                    <span class="text-grey">{{$event->event_dates[0]->date_from->format('d/m - Y')}}</span>
                                </div>

                                <div>
                                    <h4 class="text-grey font-semibold"><x-heroicon-s-user-group class="inline-block h-4 relative" style="margin-top: -3px;" /> Värd</h4>
                                    <span class="text-grey">{{$event->organisation->title}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @foreach ($events as $event)
                @if ($event->upcoming() === false)
                    <div class="group bg-white rounded-md grid grid-cols-1 sm:grid-cols-8 transition duration-300 ease-in-out">
                        <h1 class="sm:col-span-3 justify-self-start pl-4 pt-4 sm:pt-0 sm:pl-8 self-center font-headline text-3xl text-grey group-hover:text-pink"><a class="font-normal" href="/event/{{$event->slug}}">{{$event->name}}</a></h1>

                        <div class="sm:col-span-5 p-4 sm:p-0 sm:py-6 grid grid-cols-2">
                            <div>
                                <h4 class="text-grey font-semibold group-hover:text-black"><x-heroicon-s-clock class="inline-block h-4 relative" style="margin-top: -2px;" /> Datum</h4>
                                <span class="text-grey group-hover:text-black">{{$event->event_dates[0]->date_from->format('d/m - Y')}}</span>
                            </div>

                            <div>
                                <h4 class="text-grey font-semibold group-hover:text-black"><x-heroicon-s-user-group class="inline-block h-4 relative" style="margin-top: -3px;" /> Värd</h4>
                                <span class="text-grey group-hover:text-black">{{$event->organisation->title}}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="container mx-auto grid sm:grid-cols-2 py-16 sm:space-x-4" id="app-info">
        <div class="px-4 md:px-0 md:pl-4 lg:pl-0 mt-3">
            <x-heroicon-o-sparkles class="text-pink h-12" />
            <h3 class="font-headline text-4xl pt-2">Anpassat för ert evenemang</h3>
            <p>När ni säljer biljetter med Billio får ni en egen sida för ert evenemang, med möjligheten att sälja olika biljettyper, biljettillägg, variationer (så som kostalternativ), och mycket mer.</p>

            <p>Med Billio får ni även möjligheten att skapa upp förköpslänkar som gör det möjligt att bjuda in personer att köpa biljetter före alla andra. Eller vill ni sälja förköp fysiskt och sedan importera in det i systemet? Det går också!</p>

            <p>Tillsammans med det här och flera andra funktioner gör det Billio till det moderna biljettsystemet.</p>

            <p class="bg-gray-100 rounded-md p-4 mt-4">
                <strong>Anordnar ni ert evenemang vid Linköpings Universitet?</strong><br> Nu har Billio stöd för Kårrabatter! <a href="mailto:hi@billio.app">Kontakta oss</a> för att höra mer om hur vi kan få Billio att fungera för er.
            </p>
        </div>

        <img src="{{ URL::to('/img/eventpage.png') }}" class="w-full md:pr-4 lg:pr-0">
    </div>

    <div class="bg-gray-100 py-16">
        <div class="container mx-auto md:grid md:grid-cols-3 space-y-4 md:space-y-0 md:space-x-8 px-4 lg:px-0">
            <div>
                <x-heroicon-o-lightning-bolt class="text-orange h-12" />
                <h3 class="font-headline font-medium text-2xl pt-2">Låga avgifter</h3>
                <p>Med Billio betalar ni endast en låg avgift för varje biljett som säljs och inget mer. Inga dolda kostnader! Och om era biljetter är gratis kostar inte Billio något att använda. Smidigt, eller hur?</p>
            </div>

            <div>
                <x-heroicon-o-view-grid-add class="h-12 text-blue" />
                <h3 class="font-headline font-medium text-2xl pt-2">Flexibelt</h3>
                <p>Vill ni sälja mer än bara biljetter? Med Billio kan ni sälja merchandise och andra tillägg för biljetten. Genom det kommer ni att ha pengarna på ert konto före evenemanget och reducera er kontanthantering.</p>
            </div>

            <div>
                <x-heroicon-o-shield-check class="h-12 text-pink" />
                <h3 class="font-headline font-medium text-2xl pt-2">Säkert</h3>
                <p>All betalning hanteras av en säker tredjepart, och det garanterar att inga betaluppgifter någonsin sparas hos oss. Billio driftas även på en säker server som rutinmässigt kontrolleras efter säkerhetsluckor.</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto grid sm:grid-cols-2 py-16 sm:space-x-4">
        <img src="{{ URL::to('/img/checkout.png') }}" class="w-full md:pl-4 lg:pl-0">

        <div class="px-4 md:px-0 md:pr-4 lg:pl-0 mt-3">
            <x-heroicon-o-emoji-happy class="h-12 text-pink" />
            <h3 class="font-headline text-4xl pt-2">Smidigt hela vägen</h3>
            <p>Att köpa en biljett ska ta max några minuter. Med Billio är hela köpprocessen optimerad till att vara så snabb och smidig som möjligt för era gäster.</p>

            <p>Sedan när era gäster är på plats scannar dom en QR-kod för att komma in. Borta är tiden då det var långa köer för att komma in.</p>

            <p><a href="mailto:hi@billio.app" class="btn btn-pink">Kom igång med Billio</a></p>
        </div>
    </div>
</main>
@endsection
