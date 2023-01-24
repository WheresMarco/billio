@extends('layouts.app')

@section('content')
<section class="bg-gray-100 h-32">
    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nihil eligendi illo nesciunt neque deleniti atque odio voluptatibus consequatur cupiditate placeat culpa, doloribus, tenetur non doloremque voluptatum quidem eveniet hic obcaecati?
</section>

<main class="container mx-auto py-8 px-4 md:w-2/3 lg:w-1/3">
    <livewire:ticket-confirmation :stripe_id="$stripe_id" :tickets=[]>
</main>
@endsection
