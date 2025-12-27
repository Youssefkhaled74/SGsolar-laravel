@extends('layouts.app')

@section('title', __('website.products.swh.title'))

@section('content')
    <!-- Products Hero -->
    <section class="products-hero">
        <div class="container">
            <h1 class="section-title">{{ __('website.products.swh.title') }}</h1>
            <p class="section-subtitle">{{ __('website.products.swh.description') }}</p>
            <div class="hero-divider"></div>
        </div>
    </section>

    <!-- SWH Category -->
    <section class="products-section">
        <div class="container">
            <div class="product-category">
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-fire"></i>
                    </div>
                    <h2 class="category-title">{{ __('website.products.swh.title') }}</h2>
                    <p class="category-description">{{ __('website.products.swh.description') }}</p>
                </div>

                <div class="products-grid">
                    @foreach (__('website.products.swh.items') as $product)
                        <div class="product-card">
                            <div class="product-image">
                                <img src="{{ asset(ltrim($product['image'], '/')) }}" alt="{{ $product['name'] }}"
                                    onerror="handleImageError(this)">
                                @if (isset($product['badge']))
                                    <span class="product-badge">{{ $product['badge'] }}</span>
                                @endif
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">{{ $product['name'] }}</h3>
                                
                                @if(isset($product['capacity']))
                                    <p class="product-capacity"><i class="fas fa-tint"></i> {{ $product['capacity'] }}</p>
                                @endif
                                
                                <p class="product-description">
                                    {{ Str::limit($product['description'], 150, '...') }}
                                </p>

                                <ul class="product-features">
                                    @foreach (array_slice($product['features'], 0, 3) as $feature)
                                        <li><i class="fas fa-check"></i> {{ Str::limit($feature, 80, '...') }}</li>
                                    @endforeach
                                </ul>

                                <div class="product-actions">
                                    <button class="btn-product btn-view-more"
                                        onclick="openProductModal({{ $loop->index }})">
                                        <i class="fas fa-info-circle"></i>
                                        {{ __('website.products.view_more') }}
                                    </button>
                                    
                                    @if (isset($product['datasheet']))
                                        <button class="btn-product btn-download-pdf"
                                            onclick="showDownloadForm('{{ $product['datasheet'] }}', '{{ $product['name'] }}')">
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

    <!-- Product Details Modal -->
    <div id="productModal" class="product-modal">
        <div class="modal-content-product">
            <span class="close-modal" onclick="closeProductModal()">&times;</span>
            <div class="modal-body-product">
                <div class="modal-product-image">
                    <img id="modalProductImage" src="" alt="" onerror="handleImageError(this)">
                    <span id="modalProductBadge" class="product-badge" style="display: none;"></span>
                </div>
                <div class="modal-product-details">
                    <h2 id="modalProductName"></h2>
                    <p id="modalProductDescription" class="modal-product-desc"></p>

                    <div class="modal-section">
                        <h3><i class="fas fa-cogs"></i> {{ __('website.products.specifications') }}</h3>
                        <ul id="modalProductFeatures" class="modal-features-list"></ul>
                    </div>

                    <!-- Certifications Section -->
                    <div class="modal-section" id="modalCertifications" style="display: none;">
                        <h3><i class="fas fa-certificate"></i> <span id="modalCertificationsTitle"></span></h3>
                        <ul id="modalCertificationsList" class="modal-features-list"></ul>
                    </div>

                    <!-- Technical Specs Section -->
                    <div class="modal-section" id="modalTechnicalSpecs" style="display: none;">
                        <h3><i class="fas fa-clipboard-list"></i> <span id="modalSpecsTitle"></span></h3>
                        <ul id="modalSpecsList" class="modal-features-list"></ul>
                    </div>

                    <!-- Warranty Section -->
                    <div class="modal-section" id="modalWarranty" style="display: none;">
                        <h3><i class="fas fa-shield-alt"></i> <span id="modalWarrantyTitle"></span></h3>
                        <ul id="modalWarrantyList" class="modal-features-list"></ul>
                    </div>

                    <!-- Ideal For Section -->
                    <div class="modal-section" id="modalIdealFor" style="display: none;">
                        <h3><i class="fas fa-star"></i> <span id="modalIdealForTitle"></span></h3>
                        <ul id="modalIdealForList" class="modal-features-list"></ul>
                    </div>

                    <!-- Download Datasheet Button in Modal -->
                    <div class="modal-actions" id="modalDatasheetSection" style="display: none;">
                        <button id="modalDatasheetBtn" class="btn-product btn-download-pdf"
                            onclick="showDownloadFormFromModal()">
                            <i class="fas fa-file-pdf"></i>
                            {{ __('website.products.download_datasheet') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Download Form Modal -->
    <div id="downloadFormModal" class="product-modal" style="display: none;">
        <div class="modal-content-product" style="max-width: 600px;">
            <span class="close-modal" onclick="closeDownloadForm()">&times;</span>
            <div class="modal-body-product" style="display: block; padding: 30px;">
                <h2 style="color: #0C2D1C; margin-bottom: 10px; text-align: center;">
                    {{ __('website.contact.get_in_touch') }}</h2>
                <p style="color: #6B7280; text-align: center; margin-bottom: 30px;">
                    {{ __('website.contact.have_questions') }}</p>

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

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
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

    .success-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 2rem;
    }

    .success-icon svg {
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

    .error-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 2rem;
    }

    .error-icon svg {
        width: 100%;
        height: 100%;
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
        const productsData = @json(__('website.products.swh.items'));

        function openProductModal(index) {
            const product = productsData[index];
            const modal = document.getElementById('productModal');

            // Basic Info
            const imagePath = product.image.startsWith('/') ? product.image.substring(1) : product.image;
            document.getElementById('modalProductImage').src = '{{ asset('') }}/' + imagePath;
            document.getElementById('modalProductImage').alt = product.name;
            document.getElementById('modalProductName').textContent = product.name;
            document.getElementById('modalProductDescription').textContent = product.description;

            // Badge
            const badgeElement = document.getElementById('modalProductBadge');
            if (product.badge && badgeElement) {
                badgeElement.textContent = product.badge;
                badgeElement.style.display = 'block';
            } else if (badgeElement) {
                badgeElement.style.display = 'none';
            }

            // Features
            const featuresList = document.getElementById('modalProductFeatures');
            featuresList.innerHTML = '';
            product.features.forEach(feature => {
                const li = document.createElement('li');
                li.innerHTML = `<i class="fas fa-check-circle"></i> ${feature}`;
                featuresList.appendChild(li);
            });

            // Datasheet Link
            if (product.datasheet) {
                document.getElementById('modalDatasheetSection').style.display = 'block';
                document.getElementById('modalDatasheetBtn').setAttribute('data-datasheet', product.datasheet);
                document.getElementById('modalDatasheetBtn').setAttribute('data-product-name', product.name);
            } else {
                document.getElementById('modalDatasheetSection').style.display = 'none';
            }

            // Read More Sections
            if (product.read_more) {
                const readMore = product.read_more;

                // Certifications
                if (readMore.certifications) {
                    document.getElementById('modalCertifications').style.display = 'block';
                    document.getElementById('modalCertificationsTitle').textContent = readMore.certifications.title;
                    const certList = document.getElementById('modalCertificationsList');
                    certList.innerHTML = '';
                    readMore.certifications.content.forEach(cert => {
                        const li = document.createElement('li');
                        li.innerHTML = `<i class="fas fa-award"></i> ${cert}`;
                        certList.appendChild(li);
                    });
                } else {
                    document.getElementById('modalCertifications').style.display = 'none';
                }

                // Technical Specifications
                if (readMore.specifications) {
                    document.getElementById('modalTechnicalSpecs').style.display = 'block';
                    document.getElementById('modalSpecsTitle').textContent = readMore.specifications.title;
                    const specsList = document.getElementById('modalSpecsList');
                    specsList.innerHTML = '';
                    readMore.specifications.content.forEach(spec => {
                        const li = document.createElement('li');
                        li.innerHTML = `<i class="fas fa-tools"></i> ${spec}`;
                        specsList.appendChild(li);
                    });
                } else {
                    document.getElementById('modalTechnicalSpecs').style.display = 'none';
                }

                // Warranty
                if (readMore.warranty) {
                    document.getElementById('modalWarranty').style.display = 'block';
                    document.getElementById('modalWarrantyTitle').textContent = readMore.warranty.title;
                    const warrantyList = document.getElementById('modalWarrantyList');
                    warrantyList.innerHTML = '';
                    readMore.warranty.content.forEach(warranty => {
                        const li = document.createElement('li');
                        li.innerHTML = `<i class="fas fa-shield-alt"></i> ${warranty}`;
                        warrantyList.appendChild(li);
                    });
                } else {
                    document.getElementById('modalWarranty').style.display = 'none';
                }

                // Ideal For
                if (readMore.ideal_for) {
                    document.getElementById('modalIdealFor').style.display = 'block';
                    document.getElementById('modalIdealForTitle').textContent = readMore.ideal_for.title;
                    const idealForList = document.getElementById('modalIdealForList');
                    idealForList.innerHTML = '';
                    readMore.ideal_for.content.forEach(use => {
                        const li = document.createElement('li');
                        li.innerHTML = `<i class="fas fa-check"></i> ${use}`;
                        idealForList.appendChild(li);
                    });
                } else {
                    document.getElementById('modalIdealFor').style.display = 'none';
                }
            } else {
                // Hide all read_more sections if not available
                document.getElementById('modalCertifications').style.display = 'none';
                document.getElementById('modalTechnicalSpecs').style.display = 'none';
                document.getElementById('modalWarranty').style.display = 'none';
                document.getElementById('modalIdealFor').style.display = 'none';
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

        // Handle image loading errors
        function handleImageError(img) {
            console.error('Image failed to load:', img.src);
            img.style.display = 'none';
            const placeholder = document.createElement('div');
            placeholder.className = 'image-placeholder';
            placeholder.textContent = '??';
            img.parentElement.appendChild(placeholder);
        }

        // Download Form Functions
        function showDownloadForm(datasheet, productName) {
            document.getElementById('downloadDatasheet').value = datasheet;
            document.getElementById('downloadProductName').value = productName;
            document.getElementById('downloadFormModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function showDownloadFormFromModal() {
            const btn = document.getElementById('modalDatasheetBtn');
            const datasheet = btn.getAttribute('data-datasheet');
            const productName = btn.getAttribute('data-product-name');
            closeProductModal();
            showDownloadForm(datasheet, productName);
        }

        function closeDownloadForm() {
            document.getElementById('downloadFormModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function submitDownloadForm(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const data = {
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                subject: formData.get('subject'),
                product: formData.get('product_name'),
                datasheet: formData.get('datasheet')
            };

            // Show loading state
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';

            // Send to server
            fetch('{{ route('download.request') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Server returned non-JSON response');
                }
                
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'حدث خطأ في الإرسال');
                    });
                }
                return response.json();
            })
            .then(result => {
                if (result.success) {
                    closeDownloadForm();
                    showSuccessAlert('تم بنجاح!', 'شكراً لك! تم حفظ بياناتك وسيتم التحميل الآن...');
                    
                    setTimeout(() => {
                        const datasheetPath = document.getElementById('downloadDatasheet').value;
                        window.open('{{ asset('datasheets') }}/' + datasheetPath, '_blank');
                    }, 1500);
                    
                    event.target.reset();
                } else {
                    showErrorAlert('حدث خطأ', 'حدث خطأ، يرجى المحاولة مرة أخرى');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorAlert('خطأ في الاتصال', 'حدث خطأ في الاتصال، يرجى المحاولة مرة أخرى');
            });
        }

        // Close download form on outside click
        window.addEventListener('click', function(event) {
            const downloadModal = document.getElementById('downloadFormModal');
            if (event.target === downloadModal) {
                closeDownloadForm();
            }
        });

        // Success Alert Functions
        function showSuccessAlert(title, message) {
            const alert = document.getElementById('successAlert');
            document.getElementById('successTitle').textContent = title;
            document.getElementById('successMessage').textContent = message;
            alert.style.display = 'flex';
            
            // Auto close after 5 seconds
            setTimeout(() => {
                closeSuccessAlert();
            }, 5000);
        }

        function closeSuccessAlert() {
            const alert = document.getElementById('successAlert');
            if (alert) {
                alert.style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => {
                    alert.style.display = 'none';
                    alert.style.animation = '';
                }, 300);
            }
        }

        // Error Alert Functions
        function showErrorAlert(title, message) {
            const alert = document.getElementById('errorAlert');
            document.getElementById('errorTitle').textContent = title;
            document.getElementById('errorMessage').textContent = message;
            alert.style.display = 'flex';
        }

        function closeErrorAlert() {
            const alert = document.getElementById('errorAlert');
            if (alert) {
                alert.style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => {
                    alert.style.display = 'none';
                    alert.style.animation = '';
                }, 300);
            }
        }

        // Close alerts on clicking overlay
        document.getElementById('successAlert')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeSuccessAlert();
            }
        });

        document.getElementById('errorAlert')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeErrorAlert();
            }
        });
    </script>
@endsection
