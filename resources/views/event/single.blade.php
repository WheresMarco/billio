@extends('layouts.app')

@section('content')
<main>
    <div class="event-image" style="background-image: url(https://placehold.it/1000x1000);"></div>

    <div class="wrapper">
        <section class="event">
            <div class="event-content">
                <h1>Event name</h1>

                <div class="description small">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptates nulla hic praesentium voluptatem quod ipsa, illo possimus obcaecati nihil eius voluptate dolorem ratione quaerat ut ipsam iusto nisi exercitationem veniam?</p>
                </div>


                <button class="description-read-more">Läs mer om evenemanget</button>
            </div>
        </section>
    </div>

    <br style="clear: both;">

    <div class="event-meta">
        <div class="wrapper">
            <div class="event-meta-item">
                <h4>Datum</h4>
                <span>12/12 - 2020</span>
            </div>

            <div class="event-meta-item">
                <h4>Plats</h4>
                <span>Plats</span>
            </div>

            <div class="event-meta-item">
                <h4>Värd</h4>
                <span>Värd</span>
            </div>

            <div class="event-meta-item links">
                <a href="#" class="faux-button">Kontakta värden</a>
                <a href="" target="_blank" rel="noopener noreferrer" class="faux-button">Besök värdens webbplats</a>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <section class="tickets">
            <div class="ticket-type">
                <img src="{{ URL::to('/img/icons/ticket.svg') }}" class="svg-icon">

                <h3>Ticket type name<br /><small>132 SEK</small></h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus eum hic nulla nemo, facere modi alias culpa, inventore tenetur dolorem similique ut molestiae itaque, vel quasi soluta quos amet facilis.</p>

                <a href="/event/fest" class="faux-button pink">Köp en ”ticket type”-biljett</a>
            </div>
        </section>

        <br style="clear: both;">
    </div>
</main>
@endsection
