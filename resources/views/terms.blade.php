@section('title', 'Allmänna villkor | Billio')
@section('og-title', 'Allmänna villkor | Billio')

@extends('layouts.app')

@section('content')
<main class="container mx-auto py-8 px-4 md:w-2/3 lg:w-1/3">
    <h2 class="font-headline text-4xl">Allmänna villkor</h2>
    <p class="bg-gray-100 rounded-md p-4 my-4">
        Den här sidan är enbart tillgänglig på engelska.
    </p>

    <p>Your tickets will be delivered electronically to your email and displayed on this website within a few seconds from your purchase.</p>

    <p>The purchase amount will be withdrawn immediately from the card supplied.</p>

    <p>Your purchase from (and agreement with) the event organizer is protected
    by applicable Swedish law, which (in conjunction with Billio's terms)
    has the following important implications:</p>

    <ul class="list-disc">
        <li class="ml-4">Once your tickets has been delivered to you, <strong>you cannot withdraw your purchase</strong>. You are free to resell or give away the ticket, however.</li>
        <li class="ml-4">Your tickets are personal, meaning that <strong>you may have to identify yourself</strong> using valid passport, national identification card, driver's license or student identification card in order to utilize the tickets.</li>
    </ul>
</main>
@endsection
