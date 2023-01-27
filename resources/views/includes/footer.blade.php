    <section class="bg-dark-grey py-8 border-t border-gray-600 text-grey">
        <div class="container mx-auto flex space-x-8">
            <a href="/privacy-policy">Integritetspolicy</a>
            <a href="/help">Hjälp</a>
            <a href="mailto:hi@billio.app">Kontakta oss</a>
            <a href="https://wheresmar.co" target="_blank" rel="noopener noreferrer" class="font-normal">Made with ♥
                in Linköping</a>
        </div>
    </section>

    @include('cookie-consent::index')

    @livewireScripts
    @stack('scripts')
    </body>

    </html>
