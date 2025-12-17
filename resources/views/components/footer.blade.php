<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Company Info -->
            <div class="footer-column">
                <x-logo />
                <p class="footer-description">{{ __('website.slogan') }}</p>
                <div class="footer-social">
                    @foreach(config('website.social') as $platform => $url)
                        @if($url)
                            <a href="{{ $url }}" class="social-link" aria-label="{{ ucfirst($platform) }}" target="_blank" rel="noopener">
                                <i class="fab fa-{{ $platform }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-column">
                <h4 class="footer-title">{{ __('website.footer.quick_links') }}</h4>
                <ul class="footer-links">
                    <li><a href="/">{{ __('website.nav.home') }}</a></li>
                    <li><a href="/about">{{ __('website.nav.about') }}</a></li>
                    <li><a href="/products">{{ __('website.nav.products') }}</a></li>
                    <li><a href="/services">{{ __('website.nav.services') }}</a></li>
                    <li><a href="/gallery">{{ __('website.nav.gallery') }}</a></li>
                    <li><a href="/contact">{{ __('website.nav.contact') }}</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-column">
                <h4 class="footer-title">{{ __('website.footer.contact_us') }}</h4>
                <ul class="footer-contact">
                    <li>
                        <i class="fas fa-phone"></i>
                        <div>
                            <a href="tel:{{ config('website.contact.phone') }}">{{ config('website.contact.phone') }}</a>
                            @if(config('website.contact.phone2'))
                            <br>
                            <a href="tel:{{ config('website.contact.phone2') }}">{{ config('website.contact.phone2') }}</a>
                            @endif
                        </div>
                    </li>
                    <li>
                        <i class="fab fa-whatsapp"></i>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', config('website.contact.whatsapp')) }}" target="_blank" rel="noopener">{{ config('website.contact.whatsapp') }}</a>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:{{ config('website.contact.email') }}">{{ config('website.contact.email') }}</a>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <a href="{{ config('website.contact.maps_link') }}" target="_blank" rel="noopener noreferrer">{{ config('website.contact.address') }}</a>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="footer-column">
                <h4 class="footer-title">{{ __('website.footer.stay_updated') }}</h4>
                <p class="footer-text">{{ __('website.footer.newsletter_text') }}</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="{{ __('website.footer.email_placeholder') }}" class="newsletter-input">
                    <button type="submit" class="btn btn-primary">{{ __('website.footer.subscribe') }}</button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <p>{{ __('website.footer.copyright') }}</p>
        </div>
    </div>
</footer>
