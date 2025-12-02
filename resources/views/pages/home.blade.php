@extends('layouts.app')

@section('title', 'Home - ' . config('website.name'))

@section('content')

<!-- Hero Section -->
<x-hero />

<!-- About Section (Short Summary) -->
<section class="section section-about-home">
    <div class="container">
        <div class="about-home-grid">
            <div class="about-home-image">
                <img src="{{ asset('png/SG-01.png') }}" alt="SgSolar Technology">
            </div>
            <div class="about-home-content">
                <x-section-title 
                    title="About SgSolar" 
                    subtitle="Your Trusted Partner in Solar Energy"
                    :centered="false"
                />
                <p class="text-lg">{{ $data['mission'] }}</p>
                <a href="/about" class="btn btn-secondary">Learn More About Us</a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section section-products-featured bg-light">
    <div class="container">
        <x-section-title 
            title="Our Solar Water Heaters" 
            subtitle="Clean, efficient, and built to last"
        />
        
        <div class="products-grid">
            @foreach(array_slice($data['products'], 0, 4) as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        
        <div class="text-center" style="margin-top: 2rem;">
            <a href="/products" class="btn btn-primary btn-lg">View All Products</a>
        </div>
    </div>
</section>

<!-- Why Choose Solar Energy -->
<section class="section section-why-solar">
    <div class="container">
        <x-section-title 
            title="Why Choose Solar Energy?" 
            subtitle="The smart choice for your home and the planet"
        />
        
        <div class="features-grid">
            @foreach($data['why_solar'] as $reason)
                <div class="feature-card">
                    <div class="feature-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="feature-card-title">{{ $reason['title'] }}</h3>
                    <p class="feature-card-description">{{ $reason['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Why Choose SgSolar -->
<section class="section section-why-us bg-gradient">
    <div class="container">
        <x-section-title 
            title="Why Choose SgSolar?" 
            subtitle="Excellence in every installation"
        />
        
        <div class="features-grid">
            @foreach($data['why_us'] as $benefit)
                <div class="feature-card feature-card-white">
                    <div class="feature-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="feature-card-title">{{ $benefit['title'] }}</h3>
                    <p class="feature-card-description">{{ $benefit['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section section-cta">
    <div class="container">
        <div class="cta-box">
            <h2 class="cta-title">{{ $data['cta']['title'] }}</h2>
            <p class="cta-subtitle">{{ $data['cta']['subtitle'] }}</p>
            <a href="{{ $data['cta']['button_link'] }}" class="btn btn-primary btn-lg">
                {{ $data['cta']['button_text'] }}
            </a>
        </div>
    </div>
</section>

@endsection
