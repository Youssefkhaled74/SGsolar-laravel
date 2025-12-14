@extends('layouts.app')

@section('title', __('website.products.solar_lights.title'))

@section('content')
<!-- Products Hero -->
<section class="products-hero">
    <div class="container">
        <h1 class="section-title">{{ __('website.products.solar_lights.title') }}</h1>
        <p class="section-subtitle">{{ __('website.products.solar_lights.description') }}</p>
        <div class="hero-divider"></div>
    </div>
</section>

<!-- Solar Lights Category -->
<section class="products-section">
    <div class="container">
        <div class="product-category">
            <div class="category-header">
                <div class="category-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h2 class="category-title">{{ __('website.products.solar_lights.title') }}</h2>
                <p class="category-description">{{ __('website.products.solar_lights.description') }}</p>
            </div>

            <div class="products-grid">
                @foreach(__('website.products.solar_lights.items') as $product)
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

                        <div class="product-actions">
                            @if(isset($product['datasheet']))
                            <a href="{{ asset('datasheets/' . $product['datasheet']) }}" class="btn-product btn-download-pdf" download>
                                <i class="fas fa-file-pdf"></i>
                                {{ __('website.products.download_pdf') }}
                            </a>
                            @endif
                            
                            <button class="btn-product btn-view-more" onclick="openProductModal({{ $loop->index }})">
                                <i class="fas fa-info-circle"></i>
                                {{ __('website.products.view_more') }}
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Product Details Modal -->
<div id="productModal" class="product-modal">
    <div class="modal-content-product">
        <span class="close-modal" onclick="closeProductModal()">&times;</span>
        <div class="modal-body-product">
            <div class="modal-product-image">
                <img id="modalProductImage" src="" alt="">
            </div>
            <div class="modal-product-details">
                <h2 id="modalProductName"></h2>
                <p id="modalProductPower" class="modal-product-power"></p>
                <p id="modalProductDescription" class="modal-product-desc"></p>
                
                <div class="modal-section">
                    <h3><i class="fas fa-cogs"></i> {{ __('website.products.specifications') }}</h3>
                    <ul id="modalProductFeatures" class="modal-features-list"></ul>
                </div>
                
                <div class="modal-section" id="modalTechnicalSpecs" style="display: none;">
                    <h3><i class="fas fa-clipboard-list"></i> {{ __('website.products.technical_specs') }}</h3>
                    <div id="modalSpecsList" class="specs-grid"></div>
                </div>
                
                <div class="modal-section" id="modalWarranty" style="display: none;">
                    <h3><i class="fas fa-shield-alt"></i> {{ __('website.products.warranty') }}</h3>
                    <p id="modalWarrantyText"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const productsData = @json(__('website.products.solar_lights.items'));

function openProductModal(index) {
    const product = productsData[index];
    const modal = document.getElementById('productModal');
    
    document.getElementById('modalProductImage').src = product.image;
    document.getElementById('modalProductImage').alt = product.name;
    document.getElementById('modalProductName').textContent = product.name;
    document.getElementById('modalProductPower').textContent = product.power || '';
    document.getElementById('modalProductDescription').textContent = product.description;
    
    // Features
    const featuresList = document.getElementById('modalProductFeatures');
    featuresList.innerHTML = '';
    product.features.forEach(feature => {
        const li = document.createElement('li');
        li.innerHTML = `<i class="fas fa-check-circle"></i> ${feature}`;
        featuresList.appendChild(li);
    });
    
    // Technical Specs (if available)
    if (product.specs) {
        document.getElementById('modalTechnicalSpecs').style.display = 'block';
        const specsList = document.getElementById('modalSpecsList');
        specsList.innerHTML = '';
        Object.entries(product.specs).forEach(([key, value]) => {
            specsList.innerHTML += `<div class="spec-item"><strong>${key}:</strong> ${value}</div>`;
        });
    }
    
    // Warranty (if available)
    if (product.warranty) {
        document.getElementById('modalWarranty').style.display = 'block';
        document.getElementById('modalWarrantyText').textContent = product.warranty;
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeProductModal() {
    const modal = document.getElementById('productModal');
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Close modal on outside click
window.onclick = function(event) {
    const modal = document.getElementById('productModal');
    if (event.target === modal) {
        closeProductModal();
    }
}
</script>
@endsection
