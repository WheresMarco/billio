    <section class="bg-dark-grey text-white text-center py-16">
        <div class="container mx-auto sm:text-center px-4 lg:px-0 space-y-6 sm:w-9/12 lg:w-1/2">
            <div>
                <h1 class="font-headline text-4xl">{{ __('footer.header') }}</h1>
                <p>{{ __('footer.copy') }}</p>

                <p><a href="mailto:hi@billio.app" class="btn btn-white">{{ __('footer.contact_us') }}</a></p>
            </div>

            <div>
                <span>
                    <a href="/privacy-policy">{{ __('footer.privacy_policy') }}</a> -
                    <a href="https://wheresmar.co" target="_blank" rel="noopener noreferrer">{{ __('footer.made_in') }}</a>
                </span>
            </div>
        </div>
    </section>

    @include('cookie-consent::index')

    @livewireScripts
    @stack('scripts')
</body>
</html>
