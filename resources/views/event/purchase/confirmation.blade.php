@extends('layouts.app')

@section('content')
<main>
    <div class="wrapper">
        <div class="confirmation">
            <div>
                <div class="barloader">BARLOADER <h2>Din betalning hanteras</h2></div>
                <p>Det här kan ta några minuter. Ladda inte om sidan. Om sidan inte har uppdaterats på 5 minuter var god och kontakta oss på <a href='#'>ORG EMAIL</a>.</p>
            </div>

            <hr>

            <h2>Tack!</h2>
                <p>Du har nu en biljett till TICKETN NAME! Biljetten och alla detaljer (inklusive koden nedan) har skickats till dig (USER EMAIL).</p>

                <p><strong>Var god att notera att innehållet på den här sidan och e-postbrevet är gilltigt som en biljett. Håll det hemligt.</strong></p>

                <h3>Vid evenmanget</h3>
                <p>Du kan kan komma in på evenemanget genom följande metoder:</p>
                <ul>
                    <li>Visa QR-koden nedan (eller från ditt mail).</li>
                    <li>Visa biljettkoden <strong>TICKET CODE</strong> tillsammans med en giltig identitetshandling.</li>
                </ul>

                <div class="qr">
                    QR CODE
                </div>

                <p>Var god och kontakta ORG NAME på <a href='#'>ORG EMAIL</a> om du har några frågor om evenemanget.</p>
        </div>
    </div>
</main>
@endsection
