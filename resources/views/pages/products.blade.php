@extends('layouts.app')

@section('title', __('website.products.title') . ' - ' . __('website.company_name'))

@section('content')

<!-- Page Header -->
<section class="page-header bg-gradient">
    <div class="container">
        <h1 class="page-title">{{ __('website.products.page_title') }}</h1>
        <p class="page-subtitle">{{ __('website.products.page_subtitle') }}</p>
    </div>
</section>

<!-- Products Grid -->
<section class="section">
    <div class="container">
        <x-section-title 
            title="{{ __('website.products.our_range') }}" 
            subtitle="{{ __('website.products.choose_perfect') }}"
        />
        
        <div class="products-grid products-page-grid">
            @foreach($data['products'] as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>

<!-- Product Benefits -->
<section class="section bg-light">
    <div class="container">
        <x-section-title 
            title="{{ __('website.products.why_stand_out') }}" 
            subtitle="{{ __('website.products.quality_efficiency') }}"
        />
        
        <div class="benefits-list">
            <div class="benefit-item">
                <div class="benefit-icon-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div class="benefit-content">
                    <h3>{{ __('website.products.premium_materials') }}</h3>
                    <p>{{ __('website.products.premium_materials_desc') }}</p>
                </div>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="benefit-content">
                    <h3>{{ __('website.products.max_efficiency') }}</h3>
                    <p>{{ __('website.products.max_efficiency_desc') }}</p>
                </div>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="benefit-content">
                    <h3>{{ __('website.products.long_lifespan') }}</h3>
                    <p>{{ __('website.products.long_lifespan_desc') }}</p>
                </div>
            </div>
            
            <div class="benefit-item">
                <div class="benefit-icon-box">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                    </svg>
                </div>
                <div class="benefit-content">
                    <h3>{{ __('website.products.easy_install') }}</h3>
                    <p>{{ __('website.products.easy_install_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section section-cta">
    <div class="container">
        <div class="cta-box">
            <h2 class="cta-title">{{ __('website.products.need_help') }}</h2>
            <p class="cta-subtitle">{{ __('website.products.experts_ready') }}</p>
            <a href="/contact" class="btn btn-primary btn-lg">{{ __('website.products.contact_team') }}</a>
        </div>
    </div>
</section>

@endsection
