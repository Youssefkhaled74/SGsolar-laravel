<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Company Info -->
            <div class="footer-column">
                <x-logo />
                <p class="footer-description">{{ config('website.slogan') }}</p>
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
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    @foreach(config('website.footer.quick_links') as $link)
                        <li><a href="{{ $link['url'] }}">{{ $link['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-column">
                <h4 class="footer-title">Contact Us</h4>
                <ul class="footer-contact">
                    <li>
                        <i class="fas fa-phone"></i>
                        <a href="tel:{{ config('website.contact.phone') }}">{{ config('website.contact.phone') }}</a>
                    </li>
                    <li>
                        <i class="fab fa-whatsapp"></i>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', config('website.contact.whatsapp')) }}" target="_blank" rel="noopener">WhatsApp</a>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:{{ config('website.contact.email') }}">{{ config('website.contact.email') }}</a>
                    </li>
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ config('website.contact.address') }}</span>
                    </li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="footer-column">
                <h4 class="footer-title">Stay Updated</h4>
                <p class="footer-text">Get the latest news on solar technology and special offers.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Your email address" class="newsletter-input">
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <p>{{ config('website.footer.copyright') }}</p>
        </div>
    </div>
</footer>
