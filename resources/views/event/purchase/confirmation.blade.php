@extends('layouts.app')

@section('content')
<main>
    <div class="wrapper">
        <livewire:ticket-confirmation :stripe_id="$stripe_id" :tickets=[]>
    </div>
</main>
@endsection
