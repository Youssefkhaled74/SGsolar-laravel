@extends('layouts.app')

@section('title', __('website.solutions.swh.title') . ' - ' . __('website.company_name'))

@section('content')
<!-- Page Hero -->
<section class="projects-hero">
    <div class="container">
        <h1 class="section-title">{{ __('website.solutions.swh.title') }}</h1>
        <p class="section-subtitle">{{ __('website.solutions.title') }}</p>
        <div class="hero-divider"></div>
    </div>
</section>

<!-- Content Section -->
<section class="section">
    <div class="container">
        <div class="content-wrapper" style="max-width: 900px; margin: 0 auto;">
            <div class="solution-intro">
                <h2 class="solution-title">{{ __('website.solutions.swh.title') }}</h2>
                <p class="lead-text">{{ __('website.solutions.swh.intro') }}</p>
            </div>
            
            <div class="solution-section">
                <h3 class="solution-heading"><i class="fas fa-cubes"></i> {{ __('website.solutions.swh.components_title') }}</h3>
                <ul class="solution-list">
                    @foreach(__('website.solutions.swh.components') as $component)
                    <li><i class="fas fa-check-circle"></i> {{ $component }}</li>
                    @endforeach
                </ul>
            </div>
            
            <div class="solution-section">
                <h3 class="solution-heading"><i class="fas fa-layer-group"></i> {{ __('website.solutions.swh.types_title') }}</h3>
                
                @foreach(__('website.solutions.swh.types') as $type)
                <div class="type-card">
                    <h4 class="type-title">{{ $type['name'] }}</h4>
                    <div class="type-detail">
                        <strong>{{ __('website.solutions.swh.structure') }}:</strong>
                        <p>{{ $type['structure'] }}</p>
                    </div>
                    <div class="type-detail">
                        <strong>{{ __('website.solutions.swh.efficiency') }}:</strong>
                        <p>{{ $type['efficiency'] }}</p>
                    </div>
                    <div class="type-detail">
                        <strong>{{ __('website.solutions.swh.advantage') }}:</strong>
                        <p>{{ $type['advantage'] }}</p>
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
