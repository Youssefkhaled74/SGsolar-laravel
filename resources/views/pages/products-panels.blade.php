@extends('layouts.app')

@section('title', __('website.products.solar_panels.title'))

@section('content')
<!-- Products Hero -->
<section class="products-hero">
    <div class="container">
        <h1 class="section-title">{{ __('website.products.solar_panels.title') }}</h1>
        <p class="section-subtitle">{{ __('website.products.solar_panels.description') }}</p>
        <div class="hero-divider"></div>
    </div>
</section>

<!-- Solar Panels Category -->
<section class="products-section">
    <div class="container">
        <div class="product-category">
            <div class="category-header">
                <div class="category-icon">
                    <i class="fas fa-solar-panel"></i>
                </div>
                <h2 class="category-title">{{ __('website.products.solar_panels.title') }}</h2>
                <p class="category-description">{{ __('website.products.solar_panels.description') }}</p>
            </div>

            <div class="products-grid">
                @php
                    $arItems = \Lang::get('website.products.solar_panels.items', [], 'ar');
                @endphp
                @foreach(__('website.products.solar_panels.items') as $product)
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                        @if(isset($product['badge']))
                        <span class="product-badge">{{ $product['badge'] }}</span>
                        @endif
                    </div>
                    <div class="product-info">
                        <h3 class="product-name">{{ $product['name'] }}</h3>
                        <p class="product-power">{{ $product['power'] ?? '' }}</p>
                        <p class="product-description">{{ $product['description'] }}</p>
                        
                        <ul class="product-features">
                            @foreach($product['features'] as $feature)
                            <li><i class="fas fa-check"></i> {{ $feature }}</li>
                            @endforeach
                        </ul>

                        @if(isset($product['datasheet']))
                        <a href="{{ asset('datasheets/' . $product['datasheet']) }}" class="btn-download" download>
                            <i class="fas fa-download"></i>
                            {{ __('website.products.download_datasheet') }}
                        </a>
                        @endif

                        @php
                            $catalog = $arItems[$loop->index]['catalog'] ?? null;
                        @endphp
                        @if($catalog)
                        <a href="{{ asset('catalogs/ar/' . $catalog) }}" class="btn-download btn-catalog" download>
                            <i class="fas fa-file-pdf"></i>
                            {{ __('website.products.download_catalog') }}
                        </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
