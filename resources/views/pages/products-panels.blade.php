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

                        @if(isset($product['full_content']))
                        <div class="product-full-content">
                            <p>{{ $product['full_content'] }}</p>
                        </div>
                        @endif
                        
                        <div class="product-actions">
                            @if(isset($product['datasheet']))
                            <button class="btn-product btn-download-pdf" onclick="showDownloadForm('{{ $product['datasheet'] }}')">
                                <i class="fas fa-file-pdf"></i>
                                {{ __('website.products.download_pdf') }}
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Download Request Modal -->
<div class="success-overlay" id="downloadModal" style="display: none;">
    <div class="download-form-modal">
        <span class="close-modal" onclick="closeDownloadForm()">&times;</span>
        <h3 style="color: #0C2D1C; margin-bottom: 1rem;">{{ __('website.products.download_request') }}</h3>
        <p style="color: #6B7280; margin-bottom: 2rem;">{{ __('website.products.download_message') }}</p>
        <form id="downloadForm" onsubmit="submitDownloadForm(event)">
            @csrf
            <input type="hidden" id="downloadFile" name="file">
            <input type="hidden" name="product_name" id="downloadProductName">
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #374151; font-weight: 600;">{{ __('website.contact.name') }}</label>
                <input type="text" name="name" required style="width: 100%; padding: 12px; border: 2px solid #E5E7EB; border-radius: 8px; font-size: 16px;">
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #374151; font-weight: 600;">{{ __('website.contact.phone') }}</label>
                <input type="tel" name="phone" required style="width: 100%; padding: 12px; border: 2px solid #E5E7EB; border-radius: 8px; font-size: 16px;">
            </div>
            <div class="form-group" style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #374151; font-weight: 600;">{{ __('website.contact.subject') }}</label>
                <input type="text" name="subject" value="{{ __('website.products.solar_panels.title') }}" required style="width: 100%; padding: 12px; border: 2px solid #E5E7EB; border-radius: 8px; font-size: 16px;">
            </div>
            <button type="submit" class="btn-product btn-download-pdf" style="width: 100%; padding: 15px; font-size: 16px; background: linear-gradient(135deg, #FFDF41 0%, #E3A000 100%); color: #0C2D1C; border: none; border-radius: 8px; cursor: pointer; font-weight: 700;">
                <i class="fas fa-download"></i> {{ __('website.products.submit_download') }}
            </button>
        </form>
    </div>
</div>

<!-- Success Alert Modal -->
<div class="success-overlay" id="successModal" style="display: none;">
    <div class="success-modal">
        <div class="success-icon">
            <svg viewBox="0 0 52 52">
                <circle cx="26" cy="26" r="25" fill="none"/>
                <path fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>
        <h2>{{ __('website.contact.success') }}</h2>
        <p id="successMessage"></p>
        <button onclick="closeSuccessAlert()" class="close-alert-btn">{{ __('website.contact.close') ?? 'حسناً' }}</button>
    </div>
</div>

<!-- Error Alert Modal -->
<div class="success-overlay" id="errorModal" style="display: none;">
    <div class="success-modal">
        <div class="error-icon">
            <svg viewBox="0 0 52 52">
                <circle cx="26" cy="26" r="25" fill="none"/>
                <path fill="none" d="M16 16 36 36 M36 16 16 36"/>
            </svg>
        </div>
        <h2>{{ __('website.contact.error') }}</h2>
        <p id="errorMessage"></p>
        <button onclick="closeErrorAlert()" class="close-alert-btn error-btn">{{ __('website.contact.close') ?? 'حسناً' }}</button>
    </div>
</div>

<style>
.success-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.download-form-modal {
    background: white;
    padding: 2.5rem;
    border-radius: 20px;
    max-width: 500px;
    width: 90%;
    animation: slideDown 0.5s ease;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    position: relative;
}

.success-modal {
    background: white;
    padding: 3rem;
    border-radius: 20px;
    text-align: center;
    max-width: 450px;
    animation: slideDown 0.5s ease;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

@keyframes slideDown {
    from {
        transform: translateY(-100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.close-modal {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 30px;
    color: #6B7280;
    cursor: pointer;
    line-height: 1;
    transition: color 0.3s;
}

.close-modal:hover {
    color: #374151;
}

.success-icon, .error-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 2rem;
}

.success-icon svg, .error-icon svg {
    width: 100%;
    height: 100%;
}

.success-icon circle {
    stroke: #10B981;
    stroke-width: 2;
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.success-icon path {
    stroke: #10B981;
    stroke-width: 3;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.5s forwards;
}

.error-icon circle {
    stroke: #EF4444;
    stroke-width: 2;
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.error-icon path {
    stroke: #EF4444;
    stroke-width: 3;
    stroke-dasharray: 60;
    stroke-dashoffset: 60;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.5s forwards;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

.success-modal h2 {
    color: #0C2D1C;
    font-size: 1.75rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.success-modal p {
    color: #6B7280;
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.close-alert-btn {
    background: linear-gradient(135deg, #FFDF41 0%, #E3A000 100%);
    color: #0C2D1C;
    padding: 1rem 3rem;
    border: none;
    border-radius: 10px;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: transform 0.2s;
}

.close-alert-btn:hover {
    transform: scale(1.05);
}

.close-alert-btn.error-btn {
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    color: white;
}
</style>

<script>
let currentDatasheet = '';

function showDownloadForm(datasheet) {
    currentDatasheet = datasheet;
    document.getElementById('downloadFile').value = datasheet;
    document.getElementById('downloadModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeDownloadForm() {
    document.getElementById('downloadModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function closeSuccessAlert() {
    document.getElementById('successModal').style.display = 'none';
    document.body.style.overflow = 'auto';
    window.location.href = '/datasheets/' + currentDatasheet;
}

function closeErrorAlert() {
    document.getElementById('errorModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function submitDownloadForm(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    
    fetch('/download-request', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        closeDownloadForm();
        if (data.success) {
            document.getElementById('successMessage').textContent = data.message;
            document.getElementById('successModal').style.display = 'flex';
            setTimeout(() => {
                closeSuccessAlert();
            }, 2000);
        } else {
            document.getElementById('errorMessage').textContent = data.message || 'حدث خطأ، يرجى المحاولة مرة أخرى';
            document.getElementById('errorModal').style.display = 'flex';
        }
    })
    .catch(error => {
        closeDownloadForm();
        document.getElementById('errorMessage').textContent = 'حدث خطأ في الاتصال، يرجى المحاولة مرة أخرى';
        document.getElementById('errorModal').style.display = 'flex';
    });
}

window.onclick = function(event) {
    if (event.target.classList.contains('success-overlay')) {
        if (event.target.id === 'downloadModal') {
            closeDownloadForm();
        } else if (event.target.id === 'successModal') {
            closeSuccessAlert();
        } else if (event.target.id === 'errorModal') {
            closeErrorAlert();
        }
    }
}
</script>
@endsection
