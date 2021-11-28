    <section class="bg-dark-grey text-white text-center py-16">
        <div class="container mx-auto sm:text-center px-4 lg:px-0 space-y-6 sm:w-9/12 lg:w-1/2">
            <div>
                <h1 class="font-headline text-4xl">Intresserad? Kontakta oss!</h1>
                <p>Vi skulle gärna visa er hur Billio kan hjälpa er att göra era evenemang lättare att hantera. Kontakta oss så återkommer vi med mer information.</p>

                <p><a href="mailto:hi@billio.app" class="btn btn-white">Kontakta oss</a></p>
            </div>

            <div>
                <a href="/privacy-policy">Integritetspolicy</a> -
                <a href="https://wheresmar.co" target="_blank" rel="noopener noreferrer">Made with ♥ in Linköping</a>
            </div>
        </div>
    </section>

    @include('cookie-consent::index')

    @livewireScripts
    @stack('scripts')
</body>
</html>
