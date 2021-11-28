@extends('layouts.app')

@section('content')
<main class="container mx-auto py-8 px-4 md:w-2/3 lg:w-1/3">
    <livewire:ticket-confirmation :stripe_id="$stripe_id" :tickets=[]>
</main>
@endsection
