<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Billio - Det moderna biljettsystemet')</title>
    <meta name="description" content="@yield('description', 'Vill du sälja biljetter till ditt nästa evenemang? Med Billio får du ett komplett system från försäljning till check-in. Med en kraftfull och snabb tjänst som kan hantera evenemang av alla storlekar.')">

    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('og-title', 'Billio - Det moderna biljettsystemet')" />
    <meta property="og:description" content="@yield('og-content', 'Vill du sälja biljetter till ditt nästa evenemang? Med Billio får du ett komplett system från försäljning till check-in. Med en kraftfull och snabb tjänst som kan hantera evenemang av alla storlekar.')" />
    <meta property="og:image" content="@yield('og-image', asset('img/billio-share.jpg'))" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/5c53f02145.js" crossorigin="anonymous" defer></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129583569-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-129583569-1');
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" data-turbolinks-track="true">

    @livewireStyles
</head>
<body>
    @if (session('error'))
        <div class="bg-blue h-10 text-white flex items-center">
            <p class="container mx-auto text-center">{{ session('error') }}</p>
        </div>
    @endif

    <header class="bg-dark-grey text-white h-20">
        <div class="container mx-auto flex flex-row justify-between items-center">
            <h1>
                <a href="/">
                    <img src="https://via.placeholder.com/300x100" class="h-16" />
                </a>
            </h1>

            <nav>
                <ul>
                    <li class="hover:bg-orange h-full inline-block"><a href="/help">{{ __('header.help') }}</a></li>
                    <li class="language-picker"><a href="#"><i class="fas fa-language"></i></a></li>
                </ul>
            </nav>
        </div>
    </header>
