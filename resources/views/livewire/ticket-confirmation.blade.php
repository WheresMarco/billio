@if ($tickets->count() < 1)
    <div class="confirmation" wire:poll.keep-alive="pollForFinishedTicket()">
        ADD LOADER HERE
        <h2>Laddar...</h2>
    </div>
@else
    <div class="confirmation">
        <h2>Tack!</h2>

        <p>Ni har nu {{$tickets->count()}} <strong>"{{$tickets->first()[0]->ticket_type->name}}"</strong>-@if($tickets->count() > 1)biljetter @else biljett @endif till <strong>{{$tickets->first()[0]->event->name}}</strong>. @if($tickets->count() > 1)Dessa biljetter med tillhörande koder har även skickats till e-postadresserna som ni angav. @else Denna biljett med tillhörande kod har även skickats till e-postadressen som ni angav. @endif</p>

        <p><strong>Var god att notera att innehållet på den här sidan och i @if($tickets->count() > 1)e-postbreven är giltiga som biljetter. @else e-postbrevet är giltig som biljett. @endif Håll det hemligt.</strong></p>

        <br style="clear: both;" />

        <p>
            <a href="{{$calender_link->ics()}}" class="faux-button orange ics-link" download="event.ics">Lägg till det i kalendern</a>
            <a href="{{$calender_link->google()}}" class="faux-button orange" target="_blank">Lägg till det i Google Kalendern</a>
        </p>

        <br style="clear: both;" />

        <h3>Vid evenmanget</h3>
        <p><strong>Kom ihåg att det är krav på Covidpass för att komma in på {{$tickets->first()[0]->event->name}}.</strong></p>

        <p>Du kan kan komma in på evenemanget genom följande metoder:</p>
        <ul>
            <li>Visa QR-koden nedan (eller från ditt mail) tillsammans med en giltig identitetshandling.</li>
            <li>Visa biljettkoden nedan (eller från ditt mail) tillsammans med en giltig identitetshandling.</li>
        </ul>

        @if($tickets->count() > 1)<h3>Era biljetter</h3>@endif

        @foreach ($tickets as $ticket)
            @include('includes.ticket', $ticket)
        @endforeach

        <br style="clear: both;" />

        <p>Var god och kontakta {{$tickets->first()[0]->event->organisation->title}} på <a href='mailto:{{$tickets->first()[0]->event->organisation->email}}'>{{$tickets->first()[0]->event->organisation->email}}</a> om du har några frågor om evenemanget. Vid biljettfrågor kontakta Billio på <a href="mailto:hi@billio.app">hi@billio.app</a>.</p>
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
