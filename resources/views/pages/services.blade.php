@extends('layouts.app')

@section('title', 'Our Services - ' . config('website.name'))

@section('content')

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">Our Services</h1>
        <p class="page-subtitle">Comprehensive solar water heating solutions</p>
    </div>
</section>

<!-- Services Grid -->
<section class="section">
    <div class="container">
        <x-section-title 
            title="What We Offer" 
            subtitle="From installation to maintenance, we've got you covered"
        />
        
        <div class="services-grid">
            @foreach($data['services'] as $service)
                <div class="service-card">
                    <div class="service-card-image">
                        <img src="{{ asset($service['icon']) }}" alt="{{ $service['name'] }}">
                    </div>
                    <div class="service-card-content">
                        <h3 class="service-card-title">{{ $service['name'] }}</h3>
                        <p class="service-card-description">{{ $service['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Our Process -->
<section class="section bg-light">
    <div class="container">
        <x-section-title 
            title="Our Installation Process" 
            subtitle="Simple, professional, and hassle-free"
        />
        
        <div class="process-timeline">
            <div class="process-step">
                <div class="process-number">1</div>
                <h3 class="process-title">Free Consultation</h3>
                <p class="process-description">We assess your needs, property layout, and hot water requirements.</p>
            </div>
            
            <div class="process-step">
                <div class="process-number">2</div>
                <h3 class="process-title">Custom Quote</h3>
                <p class="process-description">Receive a detailed quote with no hidden costs or surprises.</p>
            </div>
            
            <div class="process-step">
                <div class="process-number">3</div>
                <h3 class="process-title">Professional Installation</h3>
                <p class="process-description">Our certified technicians install your system with precision and care.</p>
            </div>
            
            <div class="process-step">
                <div class="process-number">4</div>
                <h3 class="process-title">Testing & Training</h3>
                <p class="process-description">We test the system thoroughly and show you how to operate it.</p>
            </div>
            
            <div class="process-step">
                <div class="process-number">5</div>
                <h3 class="process-title">Ongoing Support</h3>
                <p class="process-description">Enjoy peace of mind with our warranty and maintenance services.</p>
            </div>
        </div>
    </div>
</section>

<!-- Service Guarantee -->
<section class="section">
    <div class="container">
        <x-section-title 
            title="Our Service Guarantee" 
            subtitle="Your satisfaction is our priority"
        />
        
        <div class="guarantees-grid">
            <div class="guarantee-card">
                <div class="guarantee-icon">✓</div>
                <h3>Certified Technicians</h3>
                <p>All installations performed by trained and certified professionals.</p>
            </div>
            <div class="guarantee-card">
                <div class="guarantee-icon">⏰</div>
                <h3>On-Time Service</h3>
                <p>We respect your time with punctual arrivals and efficient work.</p>
            </div>
            <div class="guarantee-card">
                <div class="guarantee-icon">🛡️</div>
                <h3>Quality Assurance</h3>
                <p>Every installation backed by comprehensive warranties.</p>
            </div>
            <div class="guarantee-card">
                <div class="guarantee-icon">💬</div>
                <h3>Clear Communication</h3>
                <p>Stay informed every step of the way with transparent updates.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section section-cta bg-gradient">
    <div class="container">
        <div class="cta-box">
            <h2 class="cta-title">Ready to Get Started?</h2>
            <p class="cta-subtitle">Book your free consultation today and start saving on energy costs.</p>
            <a href="/contact" class="btn btn-primary btn-lg">Schedule Consultation</a>
        </div>
    </div>
</section>

@endsection
