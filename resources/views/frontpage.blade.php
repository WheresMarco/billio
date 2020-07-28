@extends('layouts.app')

@section('content')
<section class="frontpage-hero">
    <div class="wrapper">
        <section class="frontpage-hero-branding">
            <h1>Säg farväl till det jobbiga med att sälja biljetter</h1>
            <p>Vill ni sälja biljetter till ditt nästa evenemang? Med Billio får ni ett komplett system från försäljning till check-in. Med en kraftfull och snabb tjänst som kan hantera evenemang av alla storlekar.</p>

            <a href="mailto:hi@billio.app" class="faux-button pink">Kontakta oss</a> <a href="/#app-info" class="faux-button orange">Läs mer</a>
        </section>
    </div>
</section>

<main>
    <section id="upcoming-events" class="upcoming-events">
        <div class="wrapper">
            @foreach ($events as $event)
                @if ($event->upcoming())
                    <section class="event-preview">
                        <div class="event-preview-image" style="background-image: url({{URL::asset($event->excerpt_image)}});"></div>

                        <div class="event-preview-content">
                            <h1><a href="/event/{{$event->slug}}">{{$event->name}}</a></h1>
                            <p>{{$event->excerpt}}</p>

                            <div class="event-preview-meta">
                                <div class="event-preview-meta-item">
                                    <h4>Datum</h4>
                                    <span>{{$event->event_dates[0]->date_from->format('d/m - Y')}}</span>
                                </div>

                                <div class="event-preview-meta-item">
                                    <h4>Värd</h4>
                                    <span>{{$event->organisation->title}}</span>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @endforeach

            @foreach ($events as $event)
                @if ($event->upcoming() === false)
                    <section class="event-preview old">
                        <div class="event-preview-content">
                            <h1><a href="/event/{{$event->slug}}">{{$event->name}}</a></h1>

                            <div class="event-preview-meta">
                                <div class="event-preview-meta-item">
                                    <h4>Datum</h4>
                                    <span>{{$event->event_dates[0]->date_from}}</span>
                                </div>

                                <div class="event-preview-meta-item">
                                    <h4>Värd</h4>
                                    <span>{{$event->organisation->title}}</span>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @endforeach
        </div>

        <br style="clear: both;">
    </section>

    <div class="wrapper">
        <section id="app-info" class="app-promo">
            <div class="app-promo-box">
                <img src="{{ URL::to('/img/icons/leaf.svg') }}" class="svg-icon">
                <h3>Enkelt</h3>
                <p>När du säljer biljetter med Billio får ni en egen sida för ditt evenemang. Med möjligheten att sälja olika biljettyper, biljettillägg, variationer så som kostalternativ, och mycket mer.</p>

                <p>Med Billio får ni även möjligheten att skapa upp förköpslänkar som gör det möjligt att bjuda in personer att köpa biljetter före alla andra. Tillsammans med det här och flera andra funktioner gör det Billio till det moderna biljettsystemet.</p>
            </div>

            <div class="app-promo-box image">
                <img src="{{ URL::to('/img/eventpage.png') }}">
            </div>
        </section>

        <br style="clear: both;">
    </div>

    <section id="app-info" class="app-info">
        <div class="wrapper">
            <div class="app-info-box">
                <img src="{{ URL::to('/img/icons/spark.svg') }}" class="svg-icon">
                <h3>Låga avgifter</h3>
                <p>Med Billio betalar ni endast en låg avgift för varje biljett som säljs och inget mer. Det är allt - inga dolda kostnader! Och om era biljetter är gratis kostar inte tjänsten något att använda. Smidigt, eller hur?</p>
            </div>

            <div class="app-info-box">
                <img src="{{ URL::to('/img/icons/leaf.svg') }}" class="svg-icon">
                <h3>Flexibelt</h3>
                <p>Vill ni sälja mer än biljetter? Med Billio kan ni sälja merchandise och andra tillägg för biljetten. Genom det kommer ni ha pengarna på ditt konto före evenemanget och reducera kontanthanteringen.</p>
            </div>

            <div class="app-info-box">
                <img src="{{ URL::to('/img/icons/lifebuoy.svg') }}" class="svg-icon">
                <h3>Säkert</h3>
                <p>All betalning hanteras av en säker tredjepart, och det garanterar att inga betaluppgifter någonsin sparas hos oss. Billio driftas även på en säker server som kontrolleras rutinmässigt efter säkerhetsluckor.</p>
            </div>
        </div>
    </section>

    <div class="wrapper">
        <br style="clear: both;">
        <section id="app-info" class="app-promo">
            <div class="app-promo-box image">
                <img src="{{ URL::to('/img/checkout.png') }}">
            </div>

            <div class="app-promo-box">
                <img src="{{ URL::to('/img/icons/spark.svg') }}" class="svg-icon">
                <h3>Smidigt</h3>
                <p>Att köpa en biljett ska max ta några minuter. Med Billio är hela köpprocessen optimerad till att vara så snabb och smidig som möjligt för era gäster.</p>

                <p>Sen när era gäster är på plats scannar dom en QR-kod för att komma in. Borta är tiden då det var långa köer för att komma in.</p>
            </div>
        </section>

        <br style="clear: both;">
    </div>
</main>
@endsection
