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

<!-- Download Form Modal -->
<div id="downloadFormModal" class="product-modal" style="display: none;">
    <div class="modal-content-product" style="max-width: 600px;">
        <span class="close-modal" onclick="closeDownloadForm()">&times;</span>
        <div class="modal-body-product" style="display: block; padding: 30px;">
            <h2 style="color: #0C2D1C; margin-bottom: 10px; text-align: center;">{{ __('website.contact.get_in_touch') }}</h2>
            <p style="color: #6B7280; text-align: center; margin-bottom: 30px;">{{ __('website.contact.have_questions') }}</p>

            <form id="downloadForm" onsubmit="submitDownloadForm(event)">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; color: #0C2D1C; font-weight: 600; margin-bottom: 8px;">
                        <i class="fas fa-user"></i> {{ __('website.contact.full_name') }}
                    </label>
                    <input type="text" name="name" required
                        style="width: 100%; padding: 12px; border: 2px solid #E5E7EB; border-radius: 8px; font-size: 14px;"
                        placeholder="{{ __('website.contact.full_name') }}">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; color: #0C2D1C; font-weight: 600; margin-bottom: 8px;">
                        <i class="fas fa-phone"></i> {{ __('website.contact.phone_number') }}
                    </label>
                    <input type="tel" name="phone" required
                        style="width: 100%; padding: 12px; border: 2px solid #E5E7EB; border-radius: 8px; font-size: 14px;"
                        placeholder="{{ __('website.contact.phone_number') }}">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; color: #0C2D1C; font-weight: 600; margin-bottom: 8px;">
                        <i class="fas fa-tag"></i> {{ __('website.contact.subject') }}
                    </label>
                    <input type="text" name="subject" required readonly
                        style="width: 100%; padding: 12px; border: 2px solid #E5E7EB; border-radius: 8px; font-size: 14px; background: #F9FAFB;"
                        value="تحميل كتالوج">
                </div>

                <input type="hidden" name="datasheet" id="downloadDatasheet">
                <input type="hidden" name="product_name" id="downloadProductName">

                <button type="submit" class="btn-product btn-download-pdf"
                    style="width: 100%; padding: 15px; font-size: 16px; margin-top: 10px;">
                    <i class="fas fa-download"></i> {{ __('website.products.download_pdf') }}
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Success Alert Modal -->
<div class="success-overlay" id="successAlert" style="display: none;">
    <div class="success-modal">
        <div class="success-icon">
            <svg viewBox="0 0 52 52">
                <circle cx="26" cy="26" r="25" fill="none"/>
                <path fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>
        <h2 id="successTitle">تم بنجاح!</h2>
        <p id="successMessage">شكراً لك! تم حفظ بياناتك وسيتم التحميل الآن...</p>
        <button onclick="closeSuccessAlert()" class="close-alert-btn">حسناً</button>
    </div>
</div>

<!-- Error Alert Modal -->
<div class="success-overlay" id="errorAlert" style="display: none;">
    <div class="success-modal">
        <div class="error-icon">
            <svg viewBox="0 0 52 52">
                <circle cx="26" cy="26" r="25" fill="none"/>
                <path fill="none" d="M16 16 36 36 M36 16 16 36"/>
            </svg>
        </div>
        <h2 id="errorTitle">حدث خطأ</h2>
        <p id="errorMessage">حدث خطأ في الاتصال، يرجى المحاولة مرة أخرى</p>
        <button onclick="closeErrorAlert()" class="close-alert-btn error-btn">حسناً</button>
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
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(227, 160, 0, 0.3);
    font-family: 'Cairo', sans-serif;
}

.close-alert-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(227, 160, 0, 0.5);
}

.close-alert-btn.error-btn {
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.close-alert-btn.error-btn:hover {
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.5);
}

@media (max-width: 768px) {
    .success-modal {
        margin: 1rem;
        padding: 2rem;
    }
    
    .success-modal h2 {
        font-size: 1.5rem;
    }
}
</style>

<script>
function showDownloadForm(datasheet, productName) {
    document.getElementById('downloadDatasheet').value = datasheet;
    document.getElementById('downloadProductName').value = productName;
    document.getElementById('downloadFormModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeDownloadForm() {
    document.getElementById('downloadFormModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

function submitDownloadForm(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData);
    
    fetch('{{ route('download.request') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeDownloadForm();
            showSuccessAlert();
            
            setTimeout(() => {
                const datasheetPath = document.getElementById('downloadDatasheet').value;
                window.open('{{ asset('datasheets') }}/' + datasheetPath, '_blank');
            }, 1500);
            
            event.target.reset();
        } else {
            closeDownloadForm();
            showErrorAlert(data.message || 'حدث خطأ في الاتصال');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        closeDownloadForm();
        showErrorAlert('حدث خطأ في الاتصال، يرجى المحاولة مرة أخرى');
    });
}

function showSuccessAlert() {
    document.getElementById('successAlert').style.display = 'flex';
}

function closeSuccessAlert() {
    document.getElementById('successAlert').style.display = 'none';
}

function showErrorAlert(message) {
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('errorAlert').style.display = 'flex';
}

function closeErrorAlert() {
    document.getElementById('errorAlert').style.display = 'none';
}

// Close modal on outside click
window.onclick = function(event) {
    const downloadModal = document.getElementById('downloadFormModal');
    if (event.target === downloadModal) {
        closeDownloadForm();
    }
}
</script>
@endsection
