<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('website.slogan') }}">
    <title>@yield('title', __('website.company_name') . ' - ' . __('website.slogan'))</title>
    
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
        <a href="{{ config('website.social.facebook') }}" 
           target="_blank" 
           class="facebook-btn" 
           title="Facebook">
            <i class="fab fa-facebook-f"></i>
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
    
    @yield('extra-scripts')
</body>
</html>
