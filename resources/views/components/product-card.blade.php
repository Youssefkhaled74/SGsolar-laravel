@props(['product'])

<div class="product-card">
    <div class="product-card-image">
        @php
            $img = $product['image'] ?? '';
            $isExternal = $img && preg_match('/^https?:\/\//i', $img);
            
            // Get translation keys
            $nameKey = $product['name_key'] ?? '';
            $descKey = $product['description_key'] ?? '';
            $featuresKey = $product['features_key'] ?? '';
            $price = $product['price'] ?? null;
            $currency = $product['currency'] ?? 'EGP';
        @endphp
        @if($isExternal)
            <img src="{{ $img }}" alt="{{ $nameKey ? __('website.' . $nameKey) : '' }}">
        @else
            <img src="{{ asset($img) }}" alt="{{ $nameKey ? __('website.' . $nameKey) : '' }}">
        @endif
        @if($price)
            <div class="product-price-badge">
                <span class="price-amount">{{ $price }}</span>
                <span class="price-currency">{{ $currency }}</span>
            </div>
        @endif
    </div>
    <div class="product-card-content">
        <h3 class="product-card-title">{{ $nameKey ? __('website.' . $nameKey) : '' }}</h3>
        <p class="product-card-description">{{ $descKey ? __('website.' . $descKey) : '' }}</p>
        
        @if($featuresKey && __('website.' . $featuresKey))
            <ul class="product-card-features">
                @foreach(__('website.' . $featuresKey) as $feature)
                    <li>
                        <svg class="feature-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ $feature }}
                    </li>
                @endforeach
            </ul>
        @endif
        
        <div class="product-card-footer">
            @if($price)
                <div class="product-price-main">
                    <span class="price-label">{{ __('website.price') }}</span>
                    <span class="price-value">{{ $price }} <small>{{ $currency }}</small></span>
                </div>
            @endif
            <a href="/contact" class="btn btn-primary btn-block product-cta">{{ __('website.get_quote') }}</a>
        </div>
    </div>
</div>
