@if (count($tickets) < 1)
    <div wire:poll.keep-alive="pollForFinishedTicket()">
        <style>
        .loader {
            border-top-color: #d052a5;
            -webkit-animation: spinner 1.5s linear infinite;
            animation: spinner 1.5s linear infinite;
        }

        @-webkit-keyframes spinner {
            0% {
            -webkit-transform: rotate(0deg);
            }
            100% {
            -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            0% {
            transform: rotate(0deg);
            }
            100% {
            transform: rotate(360deg);
            }
        }
        </style>
        <div class="flex items-center justify-center">
        <div
            class="loader mb-8 h-32 w-32 rounded-full border-8 border-t-8 border-gray-200 ease-linear"
        ></div>
        </div>
        <h2 class="font-headline text-center text-6xl text-white mb-4">Arbetar...</h2>
        <p class="text-white text-center">Om sidan inte har uppdaterats på fem minuter var god <a href="mailto:hi@billio.app">kontakta oss</a>.</p>
    </div>
@else
    <div class="text-white">
        <h2 class="text-center font-headline text-4xl font-medium sm:text-6xl sm:leading-tight">Allt klart!</h2>

        <p>Du har nu {{count($tickets)}} <strong>"{{$tickets[0]->ticket_type->name}}"</strong>-@if(count($tickets) > 1)biljetter @else biljett @endif till <strong>{{$tickets[0]->event->name}}</strong>. @if(count($tickets) > 1)Dessa biljetter med tillhörande koder har även skickats till e-postadresserna som ni angav. @else Denna biljett med tillhörande kod har även skickats till e-postadressen som ni angav. @endif</p>

        @if(count($tickets) > 1)<h3 class="font-headline mt-4 text-2xl">Era biljetter</h3>@endif

        @foreach ($tickets as $ticket)
            @include('includes.ticket', $ticket)
        @endforeach

        <p class="hidden">
            <a href="{{$calender_link->ics()}}" class="btn btn-orange ics-link" download="event.ics">Lägg till i din kalender</a>
            <a href="{{$calender_link->google()}}" class="btn btn-orange orange" target="_blank">Lägg till i din Google Kalender</a>
        </p>

        <p class="text-grey">Var god och kontakta {{$tickets[0]->event->organisation->title}} på <a href='mailto:{{$tickets[0]->event->organisation->email}}'>{{$tickets[0]->event->organisation->email}}</a> om du har några frågor om evenemanget. Vid biljettfrågor kontakta <a href="/contact">Billio</a>.</p>
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
