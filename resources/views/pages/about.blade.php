@extends('layouts.app')

@section('title', 'About Us - ' . config('website.name'))

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">About SgSolar</h1>
        <p class="page-subtitle">Leading the way in solar water heating solutions</p>
    </div>
</section>

<!-- Company Mission -->
<section class="section">
    <div class="container">
        <div class="about-grid">
            <div class="about-content">
                <x-section-title 
                    title="Our Mission" 
                    :centered="false"
                />
                <p class="text-lg">{{ $data['about']['mission_extended'] }}</p>
            </div>
            <div class="about-image">
                <img src="{{ asset($data['about']['image']) }}" alt="SgSolar Mission">
            </div>
        </div>
    </div>
</section>

<!-- Our Story -->
<section class="section bg-light">
    <div class="container">
        <div class="about-grid reverse">
            <div class="about-image">
                <img src="{{ asset('png/SG-03.png') }}" alt="SgSolar Story">
            </div>
            <div class="about-content">
                <x-section-title 
                    title="Our Story" 
                    :centered="false"
                />
                <p class="text-lg">{{ $data['about']['story'] }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Technology -->
<section class="section">
    <div class="container">
        <x-section-title 
            title="Our Technology" 
            subtitle="Advanced solar thermal systems for maximum efficiency"
        />
        <div class="technology-content">
            <p class="text-lg text-center" style="max-width: 900px; margin: 0 auto;">
                {{ $data['about']['technology'] }}
            </p>
        </div>
    </div>
</section>

<!-- Solar Benefits -->
<section class="section section-benefits bg-gradient">
    <div class="container">
        <x-section-title 
            title="Benefits of Solar Water Heating" 
            subtitle="Why solar thermal technology makes sense"
        />
        
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">💰</div>
                <h3>Reduce Energy Costs</h3>
                <p>Save up to 70% on water heating expenses with free solar energy.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">🌍</div>
                <h3>Protect the Environment</h3>
                <p>Zero emissions and reduced carbon footprint for a cleaner planet.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">⚡</div>
                <h3>Energy Independence</h3>
                <p>Less reliance on grid electricity and fossil fuel-based heating.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">🔧</div>
                <h3>Low Maintenance</h3>
                <p>Durable systems designed for years of trouble-free operation.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">☀️</div>
                <h3>All-Season Performance</h3>
                <p>Efficient heating even during cloudy days with advanced insulation.</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">📈</div>
                <h3>Increase Property Value</h3>
                <p>Solar installations boost home value and appeal to eco-conscious buyers.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section section-cta">
    <div class="container">
        <div class="cta-box">
            <h2 class="cta-title">Ready to Go Solar?</h2>
            <p class="cta-subtitle">Contact us today for a free consultation and quote.</p>
            <a href="/contact" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </div>
</section>

@endsection
