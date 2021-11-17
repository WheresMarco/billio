<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Billio - Det moderna biljettsystemet')</title>
    <meta name="description" content="@yield('description', 'Vill du sälja biljetter till ditt nästa evenemang? Med Billio får du ett komplett system från försäljning till check-in. Med en kraftfull och snabb tjänst som kan hantera evenemang av alla storlekar.')">

    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@yield('og-title', 'Billio - Det moderna biljettsystemet')" />
    <meta property="og:description" content="@yield('og-content', 'Vill du sälja biljetter till ditt nästa evenemang? Med Billio får du ett komplett system från försäljning till check-in. Med en kraftfull och snabb tjänst som kan hantera evenemang av alla storlekar.')" />
    <meta property="og:image" content="@yield('og-image', asset('img/billio-share.jpg'))" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/5c53f02145.js" crossorigin="anonymous"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129583569-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-129583569-1');
    </script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" data-turbolinks-track="true">

    <livewire:styles>
</head>
<body>
    {{-- <div class="message-bar">
        <p>Du har låst upp "Fest"-biljett för Luciafesten med koden "luciageneraler".</p>
    </div> --}}

    <header class="header">
        <div class="wrapper">
            <nav class="main-nav">
                <ul>
                    <li><a href="#">{{ __('header.resend_ticket') }}</a></li>
                    <li><a href="#">{{ __('header.help') }}</a></li>
                    {{-- <li class="language-picker"><a href="#"><i class="fas fa-language"></i></a></li> --}}
                </ul>
            </nav>

            <h1 class="logo">
                <a href="/">
                    <span class="screen-reader-text">Billio</span>
                    <svg width="257px" height="105px" viewBox="0 0 257 105"><defs><linearGradient x1="-101.418908%" y1="59.3215754%" x2="140.525396%" y2="59.3215754%" id="linearGradient-1"><stop stop-color="#EE4864" offset="0%"></stop><stop stop-color="#F6854E" offset="100%"></stop></linearGradient><linearGradient x1="-64.4709498%" y1="50%" x2="513.863882%" y2="50%" id="linearGradient-2"><stop stop-color="#EE4864" offset="0%"></stop><stop stop-color="#F6854E" offset="100%"></stop></linearGradient><linearGradient x1="-64.4709498%" y1="50%" x2="513.863882%" y2="50%" id="linearGradient-3"><stop stop-color="#EE4864" offset="0%"></stop><stop stop-color="#F6854E" offset="100%"></stop></linearGradient></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><text id="Billio" fill="url(#linearGradient-1)" font-family="Inter-Medium, Inter" font-size="85" font-weight="400"><tspan x="60" y="82.4">Billio</tspan></text><g id="Icon" transform="translate(0.000000, 20.000000)" fill-rule="nonzero"><path d="M55.2738409,0.440630007 L45.1086815,0.440630007 C45.1086815,0.440630007 45.1086815,0.440630007 45.1086815,0.440630007 C43.9579087,0.440630007 43.1907269,1.24484549 43.1907269,2.45116872 C43.1907269,4.86381517 41.2727723,6.87435388 38.9712267,6.87435388 C38.9712267,6.87435388 38.9712267,6.87435388 38.9712267,6.87435388 C38.0122494,6.87435388 37.2450676,6.47224614 36.4778858,6.07013839 L35.1353175,1.44589936 C34.7517266,0.440630007 33.7927493,-0.162531606 32.833772,0.038522265 L22.8604081,2.85327646 C21.9014308,3.2553842 21.3260444,4.26065355 21.5178399,5.26592291 C22.0932263,7.47751549 20.9424535,9.89016194 18.640908,10.6943774 C16.5311579,11.297539 14.0378169,10.0912158 13.4624305,7.67856936 C13.0788396,6.67330001 12.1198623,6.07013839 11.160885,6.27119226 L1.37931656,9.28700033 C0.420339258,9.68910807 -0.155047123,10.6943774 0.0367483376,11.6996468 L15.9557715,67.5926229 C16.147567,68.3968384 16.9147488,69 17.8737261,69 C18.0655216,69 18.2573171,69 18.4491125,69 L28.230681,65.9841919 C29.1896583,65.5820842 29.7650447,64.5768148 29.5732492,63.5715455 C28.9978628,61.3599529 30.1486356,58.9473065 32.4501811,58.143091 C34.5599312,57.5399294 37.0532721,58.7462526 37.6286585,61.158899 C38.0122494,62.1641684 38.9712267,62.76733 39.930204,62.5662761 L43.1907269,61.5610068 C43.1907269,61.7620606 43.3825223,61.9631145 43.5743178,61.9631145 C43.9579087,62.3652223 44.3414996,62.5662761 44.916886,62.5662761 L55.0820454,62.5662761 C55.0820454,62.5662761 55.0820454,62.5662761 55.0820454,62.5662761 C56.2328182,62.5662761 57,61.7620606 57,60.5557374 L57,2.25011485 C57,1.24484549 56.2328182,0.440630007 55.2738409,0.440630007 Z M31.2994083,54.5241213 C27.6552946,55.7304445 25.3537491,59.1483603 25.5455445,62.9683839 L19.2162944,64.9789226 L15.3803851,51.7093671 L17.2983398,51.1062055 C17.8737261,50.9051516 18.0655216,50.30199 17.8737261,49.8998823 C17.6819307,49.2967206 17.1065443,49.0956668 16.7229534,49.2967206 L14.8049988,49.8998823 L4.44804392,13.1070239 L10.7772941,11.0964852 C12.1198623,13.5091316 14.8049988,15.3186165 17.6819307,15.3186165 C18.4491125,15.3186165 19.2162944,15.1175626 19.9834762,14.9165087 C23.6275899,13.7101855 25.9291355,10.2922697 25.73734,6.47224614 L32.0665902,4.46170743 L42.423545,41.2545658 C41.8481586,41.4556197 41.6563632,42.0587813 41.8481586,42.460889 C42.0399541,42.8629968 42.423545,43.2651045 42.8071359,43.2651045 C42.8071359,43.2651045 42.9989314,43.2651045 42.9989314,43.2651045 L46.8348406,56.53466 L44.3414996,57.3388755 C44.3414996,57.3388755 44.3414996,57.3388755 44.3414996,57.3388755 C44.3414996,57.3388755 44.3414996,57.3388755 44.3414996,57.3388755 L40.5055904,58.5451987 C38.5876358,55.1272829 34.7517266,53.5188519 31.2994083,54.5241213 Z M53.1640908,58.7462526 L50.8625453,58.7462526 C50.8625453,58.7462526 50.8625453,58.7462526 50.8625453,58.7462526 C51.0543407,58.3441448 51.2461362,57.7409832 51.0543407,57.1378216 L37.820454,10.6943774 C38.2040449,10.6943774 38.5876358,10.8954313 38.9712267,10.8954313 C38.9712267,10.8954313 38.9712267,10.8954313 38.9712267,10.8954313 C42.6153405,10.8954313 45.8758633,8.28173097 46.6430452,4.46170743 L53.3558863,4.46170743 L53.1640908,58.7462526 Z" id="Shape" fill="url(#linearGradient-2)"></path><path d="M24.6695652,46.0661366 L20.7043478,47.1663354 C20.0782609,47.3497018 19.8695652,47.8998012 20.0782609,48.2665341 C20.2869565,48.6332671 20.7043478,49 21.1217391,49 C21.1217391,49 21.3304348,49 21.3304348,49 L25.2956522,47.8998012 C25.9217391,47.7164348 26.1304348,47.1663354 25.9217391,46.7996024 C25.9217391,46.0661366 25.2956522,45.8827701 24.6695652,46.0661366 Z" id="Shape" fill="url(#linearGradient-3)"></path><path d="M30.6695652,44.047994 L26.7043478,45.1549963 C26.0782609,45.3394966 25.8695652,45.8929978 26.0782609,46.2619985 C26.2869565,46.6309993 26.7043478,47 27.1217391,47 C27.1217391,47 27.3304348,47 27.3304348,47 L31.2956522,45.8929978 C31.9217391,45.7084974 32.1304348,45.1549963 31.9217391,44.7859955 C31.7130435,44.2324944 31.0869565,43.8634936 30.6695652,44.047994 Z" id="Shape" fill="url(#linearGradient-3)"></path><path d="M38.8634361,42.0661366 L34.845815,43.1663354 C34.2114537,43.1663354 34,43.7164348 34,44.2665341 C34.2114537,44.6332671 34.6343612,45 35.0572687,45 C35.0572687,45 35.2687225,45 35.2687225,45 L39.2863436,43.8998012 C39.9207048,43.7164348 40.1321586,43.1663354 39.9207048,42.7996024 C39.9207048,42.0661366 39.4977974,41.8827701 38.8634361,42.0661366 Z" id="Shape" fill="url(#linearGradient-3)"></path></g></g></svg>
                </a>
            </h1>
        </div>
    </header>
