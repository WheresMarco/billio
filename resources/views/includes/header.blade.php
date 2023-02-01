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
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129583569-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-129583569-1');
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" data-turbolinks-track="true">

    @livewireStyles
</head>

<body class="box-border bg-dark-grey">
    @if (session('error'))
        <div class="flex h-10 items-center bg-pink text-white">
            <p class="container mx-auto text-center">{{ session('error') }}</p>
        </div>
    @endif

    @if (session('access_code'))
        <div class="flex items-center bg-blue text-white px-4">
            <p class="container mx-auto md:text-center">Du har låst upp biljetterna för <strong>{{ session('access_code_event') }}</strong>.</p>
        </div>
    @endif

    <header class="">
        <div class="container mx-auto flex justify-between px-4 pb-4 pt-4 align-middle text-white lg:px-0">
            <div class="md:flex flex-row items-center">
                <h1>
                    <a href="/" class="block w-28">
                        <svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 257 105">
                            <path
                                d="M67.486 82.4h22.336c14.61 0 20.647-7.124 20.647-16.42 0-9.78-6.762-15.093-12.436-15.455v-.604c5.312-1.449 10.021-4.95 10.021-12.919 0-9.055-6.037-16.42-18.956-16.42H67.486V82.4Zm7.486-6.64V54.267h15.213c8.09 0 13.16 5.433 13.16 11.712 0 5.433-3.743 9.78-13.523 9.78h-14.85Zm0-28.012V27.222h14.126c8.21 0 11.832 4.347 11.832 9.78 0 6.52-5.312 10.746-12.074 10.746H74.972ZM121.803 82.4h7.124V36.036h-7.124V82.4Zm3.622-54.09c2.777 0 5.071-2.174 5.071-4.83 0-2.657-2.294-4.83-5.071-4.83-2.777 0-5.071 2.173-5.071 4.83 0 2.656 2.294 4.83 5.071 4.83Zm23.673-7.728h-7.124V82.4h7.124V20.582Zm20.17 0h-7.123V82.4h7.123V20.582ZM182.316 82.4h7.123V36.036h-7.123V82.4Zm3.622-54.09c2.777 0 5.071-2.174 5.071-4.83 0-2.657-2.294-4.83-5.071-4.83-2.777 0-5.071 2.173-5.071 4.83 0 2.656 2.294 4.83 5.071 4.83Zm35.384 55.056c12.557 0 21.008-9.538 21.008-23.906 0-14.489-8.451-24.027-21.008-24.027-12.557 0-21.009 9.538-21.009 24.027 0 14.368 8.452 23.906 21.009 23.906Zm0-6.4c-9.538 0-13.885-8.21-13.885-17.506 0-9.297 4.347-17.628 13.885-17.628s13.885 8.33 13.885 17.628c0 9.297-4.347 17.507-13.885 17.507ZM55.274 20.44H45.109c-1.151 0-1.918.805-1.918 2.011 0 2.413-1.918 4.423-4.22 4.423-.959 0-1.726-.402-2.493-.804l-1.343-4.624c-.383-1.005-1.342-1.609-2.301-1.408l-9.974 2.815c-.959.402-1.534 1.408-1.342 2.413.575 2.212-.576 4.624-2.877 5.428-2.11.604-4.603-.603-5.179-3.015-.383-1.006-1.342-1.609-2.301-1.408l-9.782 3.016C.42 29.689-.155 30.694.037 31.7l15.919 55.893c.192.804.959 1.407 1.918 1.407h.575l9.782-3.016c.959-.402 1.534-1.407 1.342-2.412-.575-2.212.576-4.625 2.877-5.429 2.11-.603 4.603.603 5.179 3.016.383 1.005 1.342 1.608 2.301 1.407l3.26-1.005c0 .201.193.402.384.402.384.402.768.603 1.343.603h10.165c1.15 0 1.918-.804 1.918-2.01V22.25c0-1.005-.767-1.81-1.726-1.81ZM31.299 74.525c-3.644 1.206-5.945 4.624-5.753 8.444l-6.33 2.01L15.38 71.71l1.918-.603c.576-.2.768-.804.576-1.206-.192-.603-.767-.804-1.151-.603l-1.918.603L4.448 33.107l6.33-2.01c1.342 2.412 4.027 4.222 6.904 4.222.767 0 1.534-.201 2.302-.403 3.644-1.206 5.945-4.624 5.753-8.444l6.33-2.01 10.356 36.793c-.575.2-.767.804-.575 1.206.192.402.575.804.96.804h.19l3.837 13.27-2.493.804-3.836 1.206c-1.918-3.418-5.754-5.026-9.207-4.02Zm21.865 4.222h-2.302c.192-.402.384-1.005.192-1.608L37.821 30.694c.383 0 .767.201 1.15.201 3.644 0 6.905-2.613 7.672-6.433h6.713l-.192 54.284Z"
                                fill="#FFF" />
                            <path
                                d="m24.67 66.066-3.966 1.1c-.626.184-.834.734-.626 1.1.209.367.626.734 1.044.734h.208l3.966-1.1c.626-.184.834-.734.626-1.1 0-.734-.626-.917-1.252-.734ZM30.67 64.048l-3.966 1.107c-.626.184-.834.738-.626 1.107.209.369.626.738 1.044.738h.208l3.966-1.107c.626-.184.834-.738.626-1.107-.209-.553-.835-.922-1.252-.738ZM38.863 62.066l-4.017 1.1c-.634 0-.846.55-.846 1.1.212.367.634.734 1.057.734h.212l4.017-1.1c.635-.184.846-.734.635-1.1 0-.734-.423-.917-1.058-.734Z"
                                fill="#FFF" />
                        </svg>
                    </a>
                </h1>

                <nav class="md:ml-5">
                    <ul class="flex gap-4 md:gap-6 mt-2 md:mt-1.5 -ml-2 md:-ml-0">
                        <li><a class="hover:bg-slate-700 hover:transition-all inline-block hover:no-underline px-2 py-1 rounded-md" href="/about">Om Billio</a></li>
                        <li><a class="hover:bg-slate-700 hover:transition-all inline-block hover:no-underline px-2 py-1 rounded-md" href="/help">Hjälp</a></li>
                        <li><a class="hover:bg-slate-700 hover:transition-all inline-block hover:no-underline px-2 py-1 rounded-md" href="/contact">Kontakta oss</a></li>
                    </ul>
                </nav>
            </div>

            <div class="items-center mt-1.5 hidden"><a href="/my-account" class="btn btn-white">Mina Sidor</a></div>
        </div>
    </header>
