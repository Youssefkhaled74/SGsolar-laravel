@extends('layouts.app')

@section('title', __('website.solutions.solar_energy.hybrid.name') . ' - ' . __('website.company_name'))

@section('content')
<!-- Page Hero -->
<section class="projects-hero">
    <div class="container">
        <h1 class="section-title">{{ __('website.solutions.solar_energy.hybrid.name') }}</h1>
        <p class="section-subtitle">{{ __('website.solutions.solar_energy.hybrid.subtitle') }}</p>
        <div class="hero-divider"></div>
    </div>
</section>

<!-- Content Section -->
<section class="section">
    <div class="container">
        <div class="content-wrapper" style="max-width: 900px; margin: 0 auto;">
            <div class="solution-intro">
                <p class="lead-text">{{ __('website.solutions.solar_energy.hybrid.intro') }}</p>
            </div>
            
            <div class="solution-section">
                <h3 class="solution-heading"><i class="fas fa-cogs"></i> {{ __('website.solutions.solar_energy.hybrid.how_it_works') }}</h3>
                <ul class="solution-list">
                    @foreach(__('website.solutions.solar_energy.hybrid.steps') as $step)
                    <li><i class="fas fa-check-circle"></i> {{ $step }}</li>
                    @endforeach
                </ul>
            </div>
            
            <div class="solution-section">
                <h3 class="solution-heading"><i class="fas fa-star"></i> {{ __('website.solutions.solar_energy.hybrid.benefits_title') }}</h3>
                <ul class="solution-list">
                    @foreach(__('website.solutions.solar_energy.hybrid.benefits') as $benefit)
                    <li><i class="fas fa-check-circle"></i> {{ $benefit }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section section-cta">
    <div class="container">
        <div class="cta-box">
            <h2 class="cta-title">{{ __('website.cta.title') }}</h2>
            <p class="cta-subtitle">{{ __('website.cta.subtitle') }}</p>
            <a href="/contact" class="btn btn-primary btn-lg">
                {{ __('website.cta.button') }}
            </a>
        </div>
    </div>
</section>
@endsection
