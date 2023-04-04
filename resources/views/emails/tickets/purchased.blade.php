@component('mail::message', ['event' => $event, 'orgName' => $orgName, 'orgEmail' => $orgEmail, 'orgAddress' => $orgAddress, 'name' => $name, 'ticketType' => $ticketType, 'ticketCode' => $ticketCode, 'modifiers' => $modifiers])
{{-- Header --}}
@slot('header')
@component('mail::header')
@endcomponent
@endslot

{{-- Body --}}
# Här är din biljett till {{ $event }}

Hej! Det här brevet är din "{{ $ticketType }}"-biljett till {{ $event }}.@if ($occurrence !== '') Tillfället du har valt är {{ $occurrence }}.@endif

**Var god och notera att innehållet i det är brevet är en giltig biljett. Håll det hemligt.**

@if(!$modifiers->isEmpty())
## Du har valt följande
@foreach($modifiers as $modifier => $modifierValue)
- {{ $modifierValue->name }}
@endforeach
@endif

Du kan komma in på {{ $event }} på följande sätt:

- Visa QR-koden nedan tillsammans med en giltig identitetshandling.
- Ange biljettkoden **{{ $ticketCode }}** tillsammans med en giltig identitetshandling.

![{{ $ticketCode }}](https://qrcode.tec-it.com/API/QRCode?quietzone=3&backcolor=fff&data={{ $ticketCode }} "{{ $ticketCode }}")

Var god och kontakta **{{ $orgName }}** på **{{ $orgEmail }}** om du har några frågor om evenemanget.

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
Du får det här mailet för att du har köpt en biljett till {{ $event }} genom det moderna biljettsystemet Billio. Om du har några frågor var god och kontakta {{ $orgName }} på {{ $orgEmail }}.
{{ $orgAddress }}
@endcomponent
@endslot
@endcomponent


