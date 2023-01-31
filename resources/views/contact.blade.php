@section('title', 'Kontakta oss | Billio')
@section('og-title', 'Kontakta oss | Billio')

@extends('layouts.app')

@section('content')
    <main class="container mx-auto mb-8 mt-4 px-4 md:px-0 text-white">
        <h2 class="font-headline text-2xl font-medium">Kontakta oss</h2>
        <p>Funderar du över något? Tveka inte att kontakta oss via e-post. Vi gör vårt yttersta för att svara på alla dina frågor. Det kan gälla evenemang, biljetter, betalning, returer, byten, eller frågor om själva Billio. Några frågor finns det redan svar på under <a href="/help">Hjälp</a>-sidan. Kika gärna in där innan du kontaktar oss.</p>

        <p><a href="mailto:hi@billio.app" class="btn btn-pink">Skicka e-post till hi@billio.app</a></p>
    </main>
@endsection
