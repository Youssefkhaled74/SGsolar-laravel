<section class="hero" style="background-image: url('{{ asset(config('website.hero.background_image')) }}');">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">{{ __('website.hero.title') }}</h1>
            <p class="hero-subtitle">{{ __('website.hero.subtitle') }}</p>
            <div class="hero-actions">
                <a href="/contact" class="btn btn-primary btn-lg">
                    {{ __('website.hero.cta') }}
                </a>
                <a href="/contact" class="btn btn-outline btn-lg">
                    {{ __('website.contact_us') }}
                </a>
            </div>
        </div>
    </div>
</section>
