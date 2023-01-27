    <section class="bg-dark-grey text-grey">
        <div class="container flex justify-between mx-auto border-t border-gray-600 py-8">
            <div class="flex space-x-8">
            <a href="/privacy-policy">Integritetspolicy</a>
            <a href="/help">Hjälp</a>
            <a href="/contact">Kontakta oss</a>
            </div>
            <a href="https://wheresmar.co" target="_blank" rel="noopener noreferrer" class="font-normal">Made with <span class="text-pink">♥</span>
                in Linköping</a>
        </div>
    </section>

    @include('cookie-consent::index')

    @livewireScripts
    @stack('scripts')
    </body>

    </html>
