@extends('layouts.app')

@section('title', __('website.nav.home') . ' - ' . __('website.company_name'))

@section('content')

<!-- Hero Section -->
<x-hero />

<!-- About Section (Short Summary) -->
<section class="section section-about-home">
    <div class="container">
        <div class="about-home-grid">
            <div class="about-home-image scroll-slide-left">
                <img src="{{ asset('png/SG-01.png') }}" alt="SgSolar Technology">
            </div>
            <div class="about-home-content scroll-slide-right">
                <x-section-title 
                    title="{{ __('website.about.title') }}" 
                    subtitle="{{ __('website.about.subtitle') }}"
                    :centered="false"
                />
                <p class="text-lg">{{ __('website.mission') }}</p>
                <a href="/about" class="btn btn-secondary">{{ __('website.about.learn_more') }}</a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section section-products-featured bg-light">
    <div class="container">
        <div class="scroll-fade">
            <x-section-title 
                title="{{ __('website.products.title') }}" 
                subtitle="{{ __('website.products.subtitle') }}"
            />
        </div>
        
        <div class="products-grid">
            @foreach(array_slice($data['products'], 0, 3) as $product)
                <div class="scroll-animate">
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>
        
        <div class="text-center scroll-scale" style="margin-top: 2rem;">
            <a href="/products" class="btn btn-primary btn-lg">{{ __('website.products.view_all') }}</a>
        </div>
    </div>
</section>

<!-- Why Choose Solar Energy -->
<section class="section section-why-solar">
    <div class="container">
        <div class="scroll-fade">
            <x-section-title 
                title="{{ __('website.why_solar.title') }}" 
                subtitle="{{ __('website.why_solar.subtitle') }}"
            />
        </div>
        
        <div class="features-grid">
            @foreach($data['why_solar'] as $key)
                <div class="feature-card scroll-animate">
                    <div class="feature-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="feature-card-title">{{ __('website.why_solar.' . $key . '.title') }}</h3>
                    <p class="feature-card-description">{{ __('website.why_solar.' . $key . '.description') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose SgSolar -->
<section class="section section-why-us bg-gradient">
    <div class="container">
        <div class="scroll-fade">
            <x-section-title 
                title="{{ __('website.why_us.title') }}" 
                subtitle="{{ __('website.why_us.subtitle') }}"
            />
        </div>
        
        <div class="features-grid">
            @foreach($data['why_us'] as $key)
                <div class="feature-card feature-card-white scroll-animate">
                    <div class="feature-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="feature-card-title">{{ __('website.why_us.' . $key . '.title') }}</h3>
                    <p class="feature-card-description">{{ __('website.why_us.' . $key . '.description') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section section-cta">
    <div class="container">
        <div class="cta-box scroll-scale">
            <h2 class="cta-title">{{ __('website.cta.title') }}</h2>
            <p class="cta-subtitle">{{ __('website.cta.subtitle') }}</p>
            <a href="/contact" class="btn btn-primary btn-lg">
                {{ __('website.cta.button') }}
            </a>
        </div>
    </div>
</section>

@endsection
