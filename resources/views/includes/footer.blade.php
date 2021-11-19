    {{-- <section id="contact-us" class="footer">
        <div class="wrapper">
            <div class="footer-intro">
                <h1>{{ __('footer.header') }}</h1>
                <p>{{ __('footer.copy') }}</p>
            </div>

            <form class="contact-form">
                <div class="contact-form-left">
                    <input type="text" placeholder="Name (*)" name="contact_company" id="contact_company" />
                    <input type="text" placeholder="Email (*)" name="contact_company" id="contact_company" />
                </div>

                <div class="contact-form-right">
                    <textarea name="contact_message" id="contact_message" placeholder="Message (*)"></textarea>
                </div>

                <div class="contact-form-submit">
                    <input type="submit" value="Send Message" class="blue" />

                    <span class="gdpr">All personal details are handled confidentially.</span>
                </div>
            </form>

            <div class="footer-copy">
                <span>
                    <a href="/privacy-policy">{{ __('footer.privacy_policy') }}</a> -
                    <a href="https://status.billio.app" target="_blank" rel="noopener noreferrer">{{ __('footer.site_status') }}</a> -
                    <a href="https://wheresmar.co" target="_blank" rel="noopener noreferrer">{{ __('footer.made_in') }}</a>
                </span>
            </div>
      </div>
    </section> --}}

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

    <livewire:scripts>
    @stack('scripts')
</body>
</html>
