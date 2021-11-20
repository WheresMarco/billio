    <section class="footer about-us">
        <div class="wrapper">
            <div class="footer-intro">
                <h1>{{ __('footer.header') }}</h1>
                <p>{{ __('footer.copy') }}</p>

                <p><a href="mailto:hi@billio.app" class="faux-button white">{{ __('footer.contact_us') }}</a></p>
            </div>

            <div class="footer-copy">
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
