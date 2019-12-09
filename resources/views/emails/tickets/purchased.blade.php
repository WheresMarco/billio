@component('mail::message', ['event' => $event, 'orgName' => $orgName, 'orgEmail' => $orgEmail, 'orgAddress' => $orgAddress, 'name' => $name, 'ticketType' => $ticketType, 'ticketCode' => $ticketCode, 'modifiers' => $modifiers, 'qrPath' => $qrPath])
{{-- Header --}}
@slot('header')
@component('mail::header', ['logo' => $logo])
@endcomponent
@endslot

{{-- Body --}}
# Här är din biljett till {{ $event }}

Hej {{ $name }}! Det här mailet bekräftar ditt köp av en biljett av typen "{{ $ticketType }}" till {{ $event }}.

**Var god och notera att innehållet i det är mailet är en giltig biljett. Håll det hemligt.**

@if(!$modifiers->isEmpty())
## Du har valt följande
@foreach($modifiers as $modifier => $modifierValue)
* {{ $modifierValue->name }}
@endforeach
@endif

## Vid evenemanget
Du kan kan komma in på evenemanget på följande sätt:

* Visa QR-koden nedan.
* Visa biljettkoden **{{ $ticketCode }}** tillsammans med en giltig identitetshandling.

![{{ $ticketCode }}](https://qrcode.tec-it.com/API/QRCode?data={{ $ticketCode }} "{{ $ticketCode }}")

Var god och kontakta **{{ $orgName }}** på **{{ $orgEmail }}** om du har några frågor om evenemanget.

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
Du får det här mailet för att du har köpt en biljett till {{ $event }} genom att använda det moderna biljettsystemet Billio. Om du har några frågor var god och kontakta {{ $orgName }} på {{ $orgEmail }}.
{{ $orgAddress }}
@endcomponent
@endslot
@endcomponent


