@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['logo' => url('img/logo.png')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            Du får det här mailet för att du har köpt en biljett till ett evenemang genom det moderna biljettsystemet Billio. Om du har några frågor om evenemanget var god och kontakta arrangören. Övriga frågor hänvisas till hi@billio.app.
        @endcomponent
    @endslot
@endcomponent
