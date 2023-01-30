<div class="my-4 grid grid-cols-8 sm:gap-6 p-4 border border-dashed mb-4 rounded-md">
    <div class="col-span-full sm:col-span-3">
        <img src="https://qrcode.tec-it.com/API/QRCode?quietzone=3&backcolor=fff&data={{$ticket->ticket_code}}" />
    </div>

    <div class="col-span-full sm:col-span-5">
        <h3 class="font-headline text-2xl">{{$ticket->user->name}}</h3>
        <p>{{$ticket->user->email}}</p>

        <hr>

        @if (!$ticket->modifiers->isEmpty())
            <h4 class="font-headline text-xl">Tillval</h4>
            <ul class="mb-2 list-disc">
                @foreach ($ticket->modifiers as $modifier)
                    <li class="ml-4">{{$modifier->name}}</li>
                @endforeach
            </ul>
        @endif

        <h4 class="font-headline text-xl">Biljettkod</h4>
        <span>{{$ticket->ticket_code}}</span>
    </div>
</div>
