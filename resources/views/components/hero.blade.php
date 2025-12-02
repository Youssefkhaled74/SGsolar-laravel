<section class="hero" style="background-image: url('{{ asset(config('website.hero.background_image')) }}');">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">{{ config('website.hero.title') }}</h1>
            <p class="hero-subtitle">{{ config('website.hero.subtitle') }}</p>
            <div class="hero-actions">
                <a href="{{ config('website.hero.cta_link') }}" class="btn btn-primary btn-lg">
                    {{ config('website.hero.cta_text') }}
                </a>
                <a href="/contact" class="btn btn-outline btn-lg">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</section>
