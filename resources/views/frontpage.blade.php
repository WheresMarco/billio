@extends('layouts.app')

@section('content')
<div class="bg-dark-grey pt-16 pb-24 text-white sm:pt-32 sm:pb-40">
    <div class="container mx-auto space-y-6 px-4 sm:w-9/12 sm:text-center lg:w-2/5 lg:px-0">
        <h1 class="font-headline text-4xl font-medium sm:text-5xl sm:leading-tight">Säg farväl till det jobbiga med att sälja biljetter</h1>
        <p class="sm:text-xl">Vill ni sälja biljetter till ert nästa evenemang? Med Billio får ni ett komplett system från försäljning till incheckning. Med ett kraftfullt och snabbt system som kan hantera evenemang av alla dess storlekar, som dessutom är enkelt att använda.</p>

        <p class="space-x-2"><a href="mailto:hi@billio.app" class="btn btn-pink">Kom igång med Billio</a> <a href="/#app-info" class="btn btn-orange">Läs mer</a></p>
    </div>
</div>

<main>
    <div class="bg-gray-100">
        <div class="container mx-auto space-y-6 py-16 px-4 lg:px-0">
            @foreach ($events as $event)
                @if ($event->upcoming())
                    <div class="grid grid-cols-1 rounded-md bg-white sm:grid-cols-8 sm:gap-6">
                        <a href="/event/{{$event->slug}}" class="rounded-tl-md rounded-tr-md bg-cover sm:col-span-3 sm:rounded-bl-md sm:rounded-tr-none" style="background-image: url({{Storage::url($event->excerpt_image)}}); min-height: 230px;"></a>

                        <div class="p-4 pr-10 sm:col-span-5 sm:py-12 sm:pl-0">
                            <h1><a href="/event/{{$event->slug}}" class="font-headline text-pink text-3xl font-normal">{{$event->name}}</a></h1>
                            <p class="pb-4 pt-2"><a href="/event/{{$event->slug}}" class="font-normal">{{$event->excerpt}}</a></p>

                            <div class="border-grey-100 grid grid-cols-2 border-t-2 py-4">
                                <div>
                                    <h4 class="text-grey font-semibold"><x-heroicon-s-clock class="relative inline-block h-4" style="margin-top: -2px;" /> Datum</h4>
                                    <span class="text-grey">{{$event->event_dates[0]->date_from->format('d/m - Y')}}</span>
                                </div>

                                <div>
                                    <h4 class="text-grey font-semibold"><x-heroicon-s-user-group class="relative inline-block h-4" style="margin-top: -3px;" /> Värd</h4>
                                    <span class="text-grey">{{$event->organisation->title}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            @foreach ($events as $event)
                @if ($event->upcoming() === false)
                    <div class="group grid grid-cols-1 rounded-md bg-white transition duration-300 ease-in-out sm:grid-cols-8">
                        <h1 class="font-headline text-grey group-hover:text-pink self-center justify-self-start pl-4 pt-4 text-3xl sm:col-span-3 sm:pt-0 sm:pl-8"><a class="font-normal" href="/event/{{$event->slug}}">{{$event->name}}</a></h1>

                        <div class="grid grid-cols-2 p-4 sm:col-span-5 sm:p-0 sm:py-6">
                            <div>
                                <h4 class="text-grey font-semibold group-hover:text-black"><x-heroicon-s-clock class="relative inline-block h-4" style="margin-top: -2px;" /> Datum</h4>
                                <span class="text-grey group-hover:text-black">{{$event->event_dates[0]->date_from->format('d/m - Y')}}</span>
                            </div>

                            <div>
                                <h4 class="text-grey font-semibold group-hover:text-black"><x-heroicon-s-user-group class="relative inline-block h-4" style="margin-top: -3px;" /> Värd</h4>
                                <span class="text-grey group-hover:text-black">{{$event->organisation->title}}</span>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="container mx-auto grid py-16 sm:grid-cols-2 sm:space-x-4" id="app-info">
        <div class="mt-3 px-4 md:px-0 md:pl-4 lg:pl-0">
            <x-heroicon-o-sparkles class="text-pink h-12" />
            <h3 class="font-headline pt-2 text-4xl">Anpassat för ert evenemang</h3>
            <p>När ni säljer biljetter med Billio får ni en egen sida för ert evenemang, med möjligheten att sälja olika biljettyper, biljettillägg, variationer (så som kostalternativ), och mycket mer.</p>

            <p>Med Billio får ni även möjligheten att skapa upp förköpslänkar som gör det möjligt att bjuda in personer att köpa biljetter före alla andra. Eller vill ni sälja förköp fysiskt och sedan importera in det i systemet? Det går också!</p>

            <p>Tillsammans med det här och flera andra funktioner gör det Billio till det moderna biljettsystemet.</p>

            <p class="mt-4 rounded-md bg-gray-100 p-4">
                <strong>Anordnar ni ert evenemang vid Linköpings Universitet?</strong><br> Nu har Billio stöd för Kårrabatter! <a href="mailto:hi@billio.app">Kontakta oss</a> för att höra mer om hur vi kan få Billio att fungera för er.
            </p>
        </div>

        <img src="{{ URL::to('/img/eventpage.jpg') }}" class="w-full md:pr-4 lg:pr-0">
    </div>

    <div class="bg-gray-100 py-16">
        <div class="container mx-auto space-y-4 px-4 md:grid md:grid-cols-3 md:space-y-0 md:space-x-8 lg:px-0">
            <div>
                <x-heroicon-o-lightning-bolt class="text-orange h-12" />
                <h3 class="font-headline pt-2 text-2xl font-medium">Låga avgifter</h3>
                <p>Med Billio betalar ni endast en låg avgift för varje biljett som säljs och inget mer. Inga dolda kostnader! Och om era biljetter är gratis kostar inte Billio något att använda. Smidigt, eller hur?</p>
            </div>

            <div>
                <x-heroicon-o-view-grid-add class="text-blue h-12" />
                <h3 class="font-headline pt-2 text-2xl font-medium">Flexibelt</h3>
                <p>Vill ni sälja mer än bara biljetter? Med Billio kan ni sälja merchandise och andra tillägg för biljetten. Genom det kommer ni att ha pengarna på ert konto före evenemanget och reducera er kontanthantering.</p>
            </div>

            <div>
                <x-heroicon-o-shield-check class="text-pink h-12" />
                <h3 class="font-headline pt-2 text-2xl font-medium">Säkert</h3>
                <p>All betalning hanteras av en säker tredjepart, och det garanterar att inga betaluppgifter någonsin sparas hos oss. Billio driftas även på en säker server som rutinmässigt kontrolleras efter säkerhetsluckor.</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto grid py-16 sm:grid-cols-2 sm:space-x-4">
        <img src="{{ URL::to('/img/checkout.jpg') }}" class="w-full md:pl-4 lg:pl-0">

        <div class="mt-3 px-4 md:px-0 md:pr-4 lg:pl-0">
            <x-heroicon-o-emoji-happy class="text-pink h-12" />
            <h3 class="font-headline pt-2 text-4xl">Smidigt hela vägen</h3>
            <p>Att köpa en biljett ska ta max några minuter. Med Billio är hela köpprocessen optimerad till att vara så snabb och smidig som möjligt för era gäster.</p>

            <p>Sedan när era gäster är på plats scannar dom en QR-kod för att komma in. Borta är tiden då det var långa köer för att komma in.</p>

            <p><a href="mailto:hi@billio.app" class="btn btn-pink">Kom igång med Billio</a></p>
        </div>
    </div>
</main>
@endsection
