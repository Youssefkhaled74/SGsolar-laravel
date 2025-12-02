@props(['product'])

<div class="product-card">
    <div class="product-card-image">
        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}">
    </div>
    <div class="product-card-content">
        <h3 class="product-card-title">{{ $product['name'] }}</h3>
        <p class="product-card-description">{{ $product['description'] }}</p>
        
        @if(isset($product['features']) && count($product['features']) > 0)
            <ul class="product-card-features">
                @foreach($product['features'] as $feature)
                    <li>
                        <svg class="feature-icon" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ $feature }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
