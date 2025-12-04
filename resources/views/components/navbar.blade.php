<nav class="navbar">
    <div class="container">
        <div class="navbar-wrapper">
            <div class="navbar-brand">
                <a href="/">
                    <x-logo />
                </a>
            </div>

            <button class="navbar-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="navbar-menu" id="navMenu">
                <a href="/" class="navbar-link {{ request()->is('/') ? 'active' : '' }}">
                    {{ __('website.nav.home') }}
                </a>
                <a href="/about" class="navbar-link {{ request()->is('about') ? 'active' : '' }}">
                    {{ __('website.nav.about') }}
                </a>
                <a href="/solutions" class="navbar-link {{ request()->is('solutions') ? 'active' : '' }}">
                    {{ __('website.nav.solutions') }}
                </a>
                <a href="/products" class="navbar-link {{ request()->is('products') ? 'active' : '' }}">
                    {{ __('website.nav.products') }}
                </a>
                <a href="/projects" class="navbar-link {{ request()->is('projects') ? 'active' : '' }}">
                    {{ __('website.nav.projects') }}
                </a>
                <a href="/news" class="navbar-link {{ request()->is('news') ? 'active' : '' }}">
                    {{ __('website.nav.news') }}
                </a>
                <a href="/services" class="navbar-link {{ request()->is('services') ? 'active' : '' }}">
                    {{ __('website.nav.services') }}
                </a>
                <a href="/gallery" class="navbar-link {{ request()->is('gallery') ? 'active' : '' }}">
                    {{ __('website.nav.gallery') }}
                </a>
                <a href="/contact" class="navbar-link {{ request()->is('contact') ? 'active' : '' }}">
                    {{ __('website.nav.contact') }}
                </a>
                
                <x-language-switcher />
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.querySelector('.navbar');
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    // Scroll effect for navbar
    let lastScroll = 0;
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 100) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });
    
    // Mobile menu toggle
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
            document.body.style.overflow = navMenu.classList.contains('active') ? 'hidden' : '';
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideNav = navMenu.contains(event.target);
            const isClickOnToggle = navToggle.contains(event.target);
            
            if (!isClickInsideNav && !isClickOnToggle && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
                navToggle.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
        
        // Close menu when clicking on a link
        const navLinks = navMenu.querySelectorAll('.navbar-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
                navToggle.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    }
});
</script>
