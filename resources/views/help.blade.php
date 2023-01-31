@section('title', 'Hjälp | Billio')
@section('og-title', 'Hjälp | Billio')

@extends('layouts.app')

@section('content')
    <main class="container mx-auto mb-8 mt-4 px-4 text-white md:px-0">
        <h2 class="font-headline text-2xl font-medium">Hjälp</h2>
        <p>På denna sida har vi samlat några vanliga frågor. Om detta inte hjälper er så kan ni alltid kontakta oss på <a
                href="mailto:hi@billio.app">hi@billio.app</a>.</p>

        <h3 class="mt-4 font-headline text-xl">På vilka sätt kan man betala?</h3>
        <p>Vi stödjer de mest populära bank- och kreditkorten. Det inkluderar Visa, Mastercard, och American Express. Tänk
            på att ert bank- eller kreditkort måste vara öppet för internetköp för att det ska fungera. Om ni inte kan
            betala med betala med bank- eller kreditkort hänvisar vi att kontakta arrangören för evenemanget.</p>

        <p>Inom kort kommer det dessutom att vara möjligt att betala med Swish. <a href="mailto:hi@billio.app">Kontakta
                oss</a> för att veta mer.</p>

        <h3 class="mt-4 font-headline text-xl">Är det säkert att betala med kort hos Billio?</h3>
        <p>Ja, det är helt säkert att betala med bank- och kreditkort hos Billio. Alla uppkopplingar mellan vår plattform
            och betalningssystem är krypterade. Det betyder att dina uppgifter aldrig skickas i klartext. Vi lagrar dessutom
            inga betaluppgifter hos oss. Ni kan läsa mer om hur vi arbetar med personuppgifter i vår <a
                href="/privacy-policy">Integritetspolicy</a>.</p>

        <h3 class="mt-4 font-headline text-xl">Varför behöver ni veta mitt personnummer för kårrabatten?</h3>
        <p>Ditt personnummer hanteras enbart när ni vill använda er kårrabatt (endast tillgängligt vid Linköpings
            Universitet). Anledningen till detta är en begränsning hos systemen som hanterar medlemskap hos kårerna. Vi gör
            vårt yttersta att skydda era personuppgifter och ert personummer används inte på något annat än att verifiera
            ert medlemskap. Ni kan läsa mer om hur vi arbetar med personuppgifter i vår <a
                href="/privacy-policy">Integritetspolicy</a>.</p>

        <h3 class="mt-4 font-headline text-xl">Jag har inte fått min biljett</h3>
        <p>Ibland kan det ta några minuter innan den kommer fram. Alternativt kan biljetten hamnat i skräpposten. Om du har
            kvar koden från bekräftelsesidan är den också gilltig som en biljett. Ni kan även <a
                href="mailto:hi@billio.app">kontakta oss</a> för att få biljetten på nytt.</p>

        <h3 class="mt-4 font-headline text-xl">Jag kan inte gå på evenemanget längre, kan jag få pengarna tillbaka?</h3>
        <p>De allra flesta biljetter kan tyvärr inte återbetalas. Du kan alltid prova att kontakta arrangören direkt, för
            att se om de kan tänka sig att godkänna ditt återköp.</p>

        <h3 class="mt-4 font-headline text-xl">Kan jag sälja min biljett vidare?</h3>
        <p>Ja, det kan du. Tänk på att informera den nya biljettinnehavaren att uppge ditt namn vid incheckning då vi har
            ingen information om vem som köpt den nya biljetten. Om ni vill ändra innehavaren av biljetten kan ni <a
                href="mailto:hi@billio.app">kontakta oss</a> så hjälper vi till med det.</p>

        <p>Inom kort kommer det dessutom att vara möjligt att sälja vidare er biljett via Billio. <a
                href="mailto:hi@billio.app">Kontakta oss</a> för att veta mer.</p>

        <a href="mailto:hi@billio.app" class="btn btn-pink mt-4">Jag behöver fortfarande hjälp!</a>
    </main>
@endsection
