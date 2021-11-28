@if (count($tickets) < 1)
    <div wire:poll.keep-alive="pollForFinishedTicket()">
        ADD LOADER HERE
        <h2>Laddar...</h2>
    </div>
@else
    <div>
        <h2 class="font-headline text-4xl">Tack!</h2>

        <p>Ni har nu {{count($tickets)}} <strong>"{{$tickets[0]->ticket_type->name}}"</strong>-@if(count($tickets) > 1)biljetter @else biljett @endif till <strong>{{$tickets[0]->event->name}}</strong>. @if(count($tickets) > 1)Dessa biljetter med tillhörande koder har även skickats till e-postadresserna som ni angav. @else Denna biljett med tillhörande kod har även skickats till e-postadressen som ni angav. @endif</p>

        <p><strong>Var god att notera att innehållet på den här sidan och i @if(count($tickets) > 1)e-postbreven är giltiga som biljetter. @else e-postbrevet är giltig som biljett. @endif Håll det hemligt.</strong></p>

        <p>
            <a href="{{$calender_link->ics()}}" class="btn btn-orange ics-link" download="event.ics">Lägg till i din kalender</a>
            <a href="{{$calender_link->google()}}" class="btn btn-orange orange" target="_blank">Lägg till i din Google Kalender</a>
        </p>

        <h3 class="font-headline text-2xl mt-4">Vid evenmanget</h3>
        <p><strong>Kom ihåg att det är krav på Covidpass för att komma in på {{$tickets[0]->event->name}}.</strong></p>

        <p>Du kan kan komma in på evenemanget genom följande metoder:</p>
        <ul class="list-disc">
            <li class="ml-4">Visa QR-koden nedan (eller från ditt mail) tillsammans med en giltig identitetshandling.</li>
            <li class="ml-4">Visa biljettkoden nedan (eller från ditt mail) tillsammans med en giltig identitetshandling.</li>
        </ul>

        @if(count($tickets) > 1)<h3 class="font-headline text-2xl mt-4">Era biljetter</h3>@endif

        @foreach ($tickets as $ticket)
            @include('includes.ticket', $ticket)
        @endforeach

        <p>Var god och kontakta {{$tickets[0]->event->organisation->title}} på <a href='mailto:{{$tickets[0]->event->organisation->email}}'>{{$tickets[0]->event->organisation->email}}</a> om du har några frågor om evenemanget. Vid biljettfrågor kontakta Billio på <a href="mailto:hi@billio.app">hi@billio.app</a>.</p>
    </div>
@endif

@push('scripts')
<script>
    $('a[download]').click(function (event) {
    /** @type {HTMLAnchorElement} */
    var anchor = event.target;
    var storeAsFilename = anchor.download || 'event.ics';
    download(anchor.href, storeAsFilename);
    event.preventDefault();
    });
</script>
@endpush
