    <section class="bg-dark-grey py-16 text-white sm:text-center">
        <div class="container mx-auto space-y-6 px-4 sm:w-9/12 sm:text-center lg:w-3/5">
            <div class="space-y-2">
                <h1 class="font-headline text-4xl">Intresserad? Kontakta oss!</h1>
                <p>Vi gärna visa hur Billio kan hjälpa er att göra era evenemang lättare att hantera.<br>Kontakta oss så återkommer vi med mer information.</p>

                <p><a href="mailto:hi@billio.app" class="btn btn-white">Kontakta oss</a></p>
            </div>

            <div>
                <a href="/privacy-policy" class="font-normal">Integritetspolicy</a> |
                <a href="/help" class="font-normal">Hjälp</a> |
                <a href="https://wheresmar.co" target="_blank" rel="noopener noreferrer" class="font-normal">Made with ♥ in Linköping</a>
            </div>
        </div>
    </section>

    @include('cookie-consent::index')

    @livewireScripts
    @stack('scripts')
</body>
</html>
