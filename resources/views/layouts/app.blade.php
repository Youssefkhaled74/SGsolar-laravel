<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('website.slogan') }}">
    <title>@yield('title', __('website.company_name') . ' - ' . __('website.slogan'))</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @yield('extra-styles')
</head>
<body>
    <!-- Floating Social Buttons -->
    <div class="floating-social">
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', config('website.contact.whatsapp')) }}" 
           target="_blank" 
           class="whatsapp-btn" 
           title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="{{ route('contact') }}" 
           class="chat-btn" 
           title="{{ __('website.nav.contact') }}">
            <i class="fas fa-comments"></i>
        </a>
        <a href="tel:{{ config('website.contact.phone') }}" 
           class="call-btn" 
           title="Call Us">
            <i class="fas fa-phone"></i>
        </a>
    </div>
    
    <x-navbar />
    
    <main>
        @yield('content')
    </main>
    
    <x-footer />
    
    <!-- Scroll Animation Script -->
    <script>
        // Intersection Observer for scroll animations
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.15,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            // Observe all elements with animation classes
            const animateElements = document.querySelectorAll(
                '.scroll-animate, .scroll-slide-left, .scroll-slide-right, .scroll-fade, .scroll-scale'
            );
            
            animateElements.forEach(el => observer.observe(el));
        });
    </script>
    
    @yield('extra-scripts')
</body>
</html>
