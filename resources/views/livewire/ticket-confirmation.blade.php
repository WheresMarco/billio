@if ($tickets->count() < 1)
    <div class="confirmation" wire:poll.keep-alive="pollForFinishedTicket()">
        ADD LOADER HERE
        <h2>Laddar...</h2>
    </div>
@else
    <div class="confirmation">
        <h2>Tack!</h2>

        <p>Nu har ni {{$tickets->count()}} <strong>"TICKET NAME"</strong>-@if($tickets->count() > 1)biljetter @else biljett @endif för <strong>EVENT NAME</strong>. Dessa biljeter med tillhörande koder har även skickats till e-postadresserna som ni angav.</p>

        <p><strong>Var god att notera att innehållet på den här sidan och i e-postbreven är giltiga som biljetter. Håll det hemligt.</strong></p>

        <h3>Vid evenmanget</h3>
        <p><strong>Kom ihåg att det är krav på Covidpass för att komma in på EVENT NAME.</strong></p>

        <p>Du kan kan komma in på evenemanget genom följande metoder:</p>
        <ul>
            <li>Visa QR-koden nedan (eller från ditt mail) tillsammans med en giltig identitetshandling.</li>
            <li>Visa biljettkoden nedan (eller från ditt mail) tillsammans med en giltig identitetshandling.</li>
        </ul>

        <h3>Era biljetter</h3>
        @foreach ($tickets as $ticket)
            @include('includes.ticket', $ticket)
        @endforeach

        <br style="clear: both;" />
        <br style="clear: both;" />

        <p>Var god och kontakta ORG NAME på <a href='#'>ORG EMAIL</a> om du har några frågor om evenemanget.</p>
    </div>
@endif
