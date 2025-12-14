@extends('layouts.app')

@section('title', __('website.solutions.lighting.title') . ' - ' . __('website.company_name'))

@section('content')
<!-- Page Hero -->
<section class="projects-hero">
    <div class="container">
        <h1 class="section-title">{{ __('website.solutions.lighting.title') }}</h1>
        <p class="section-subtitle">{{ __('website.solutions.title') }}</p>
        <div class="hero-divider"></div>
    </div>
</section>

<!-- Content Section -->
<section class="section">
    <div class="container">
        <div class="content-wrapper" style="max-width: 900px; margin: 0 auto;">
            <div class="solution-intro">
                <h2 class="solution-title">{{ __('website.solutions.solar_lights.title') }}</h2>
                <p class="lead-text">{{ __('website.solutions.solar_lights.intro') }}</p>
            </div>
            
            <div class="solution-section">
                <h3 class="solution-heading"><i class="fas fa-cubes"></i> {{ __('website.solutions.solar_lights.components_title') }}</h3>
                <ul class="solution-list">
                    @foreach(__('website.solutions.solar_lights.components') as $component)
                    <li><i class="fas fa-check-circle"></i> {{ $component }}</li>
                    @endforeach
                </ul>
            </div>
            
            <div class="solution-section">
                <h3 class="solution-heading"><i class="fas fa-layer-group"></i> {{ __('website.solutions.solar_lights.categories_title') }}</h3>
                
                @foreach(__('website.solutions.solar_lights.categories') as $category)
                <div class="type-card">
                    <h4 class="type-title">{{ $category['name'] }}</h4>
                    <div class="type-detail">
                        <strong>{{ __('website.solutions.solar_lights.usage') }}:</strong>
                        <p>{{ $category['usage'] }}</p>
                    </div>
                    <div class="type-detail">
                        <strong>{{ __('website.solutions.solar_lights.features') }}:</strong>
                        <p>{{ $category['features'] }}</p>
                    </div>
                </div>
                @endforeach
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
