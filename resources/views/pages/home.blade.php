@extends('layouts.app')

@section('title', __('website.nav.home') . ' - ' . __('website.company_name'))

@section('content')

<!-- Hero Section -->
<x-hero />

<!-- About Section (Short Summary) -->
<section class="section section-about-home">
    <div class="container">
        <div class="about-home-grid">
            <div class="about-home-image scroll-slide-left">
                <img src="{{ asset('images/aboutus.png') }}" alt="{{ config('website.name') }} - Solar Installation Team">
            </div>
            <div class="about-home-content scroll-slide-right">
                <x-section-title 
                    title="{{ __('website.about.title') }}" 
                    subtitle="{{ __('website.about.subtitle') }}"
                    :centered="false"
                />
                <p class="text-lg">{{ __('website.mission') }}</p>
                <a href="/about" class="btn btn-secondary">{{ __('website.about.learn_more') }}</a>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose SgSolar -->
<section class="section section-why-us bg-gradient">
    <div class="container">
        <div class="scroll-fade">
            <x-section-title 
                title="{{ __('website.why_us.title') }}" 
                subtitle="{{ __('website.why_us.subtitle') }}"
            />
        </div>
        
        <div class="features-grid">
            @foreach($data['why_us'] as $key)
                <div class="feature-card feature-card-white scroll-animate">
                    <div class="feature-card-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="feature-card-title">{{ __('website.why_us.' . $key . '.title') }}</h3>
                    <p class="feature-card-description">{{ __('website.why_us.' . $key . '.description') }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="section stats-section">
    <div class="container">
        <div class="stats-grid">
            @foreach(__('website.about.stats') as $stat)
            <div class="stat-card scroll-animate">
                <div class="stat-icon">
                    <i class="fas {{ $stat['icon'] }}"></i>
                </div>
                <div class="stat-number">
                    <span class="counter" data-target="{{ $stat['number'] }}">0</span><span class="stat-suffix">{{ $stat['suffix'] }}</span>
                </div>
                <div class="stat-label">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Product Categories Selector -->
<section class="section section-product-cats">
    <div class="container">
        <div class="scroll-fade">
            <x-section-title 
                title="{{ __('website.products.title') }}"
                subtitle="{{ __('website.products.subtitle') }}"
            />
        </div>

        <div class="category-selector-grid">
            <a href="{{ route('products.swh') }}" class="product-card">
                <div class="product-card-image">
                    <img src="{{ asset('icons/icons/heater.png') }}" alt="{{ __('website.products.swh.title') }}">
                    <div class="product-card-overlay">
                        <span class="product-view-btn">{{ __('website.products.view_all') }}</span>
                    </div>
                </div>
                <div class="product-card-body">
                    <h3 class="product-card-title">{{ __('website.products.swh.title') }}</h3>
                    <p class="product-card-description">{{ __('website.products.swh.description') }}</p>
                </div>
            </a>

            <a href="{{ route('products.lights') }}" class="product-card">
                <div class="product-card-image">
                    <img src="{{ asset('icons/icons/light.png') }}" alt="{{ __('website.products.solar_lights.title') }}">
                    <div class="product-card-overlay">
                        <span class="product-view-btn">{{ __('website.products.view_all') }}</span>
                    </div>
                </div>
                <div class="product-card-body">
                    <h3 class="product-card-title">{{ __('website.products.solar_lights.title') }}</h3>
                    <p class="product-card-description">{{ __('website.products.solar_lights.description') }}</p>
                </div>
            </a>

            <a href="{{ route('products.panels') }}" class="product-card">
                <div class="product-card-image">
                    <img src="{{ asset('icons/icons/on grid.png') }}" alt="{{ __('website.products.solar_panels.title') }}">
                    <div class="product-card-overlay">
                        <span class="product-view-btn">{{ __('website.products.view_all') }}</span>
                    </div>
                </div>
                <div class="product-card-body">
                    <h3 class="product-card-title">{{ __('website.products.solar_panels.title') }}</h3>
                    <p class="product-card-description">{{ __('website.products.solar_panels.description') }}</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Solutions Banner Section -->
<section class="section section-solutions-banner" style="background-color: #1a5f3a;">
    <div class="container">
        <div class="scroll-fade" style="color: white;">
            <div class="section-title text-center" style="color: white;">
                <h2 class="section-title-main" style="color: white;">{{ __('website.solutions.title') }}</h2>
                <p class="section-title-subtitle" style="color: white;">{{ __('website.solutions.subtitle') }}</p>
            </div>
        </div>
        
        <div class="banner-grid">
            <a href="/solutions/on-grid" class="banner-item scroll-animate">
                <img src="{{ asset('icons/icons/on grid.png') }}" alt="{{ __('website.solutions.banner_labels.on_grid') }}">
                <span>{{ __('website.solutions.banner_labels.on_grid') }}</span>
            </a>
            <a href="/solutions/off-grid" class="banner-item scroll-animate">
                <img src="{{ asset('icons/icons/off grid.png') }}" alt="{{ __('website.solutions.banner_labels.off_grid') }}">
                <span>{{ __('website.solutions.banner_labels.off_grid') }}</span>
            </a>
            <a href="/solutions/pumping" class="banner-item scroll-animate">
                <img src="{{ asset('icons/icons/pump.png') }}" alt="{{ __('website.solutions.banner_labels.pump') }}">
                <span>{{ __('website.solutions.banner_labels.pump') }}</span>
            </a>
            <a href="/solutions/swh" class="banner-item scroll-animate">
                <img src="{{ asset('icons/icons/heater.png') }}" alt="{{ __('website.solutions.banner_labels.solar_heater') }}">
                <span>{{ __('website.solutions.banner_labels.solar_heater') }}</span>
            </a>
            <a href="/products/lights" class="banner-item scroll-animate">
                <img src="{{ asset('icons/icons/light.png') }}" alt="{{ __('website.solutions.banner_labels.solar_light') }}">
                <span>{{ __('website.solutions.banner_labels.solar_light') }}</span>
            </a>
        </div>
    </div>
</section>

<!-- Latest News Section -->
<section class="section section-latest-news">
    <div class="container">
        <div class="scroll-fade">
            <x-section-title 
                title="{{ __('website.latest_news.title') }}" 
                subtitle="{{ __('website.latest_news.subtitle') }}"
            />
        </div>
        
        @php
            $allArticles = __('website.news.articles');
            $latestArticle = $allArticles[0];
        @endphp
        
        <div class="news-single-wrapper">
            <article class="news-card-featured scroll-animate">
                <div class="news-card-header">
                    <div class="news-icon">
                        <i class="{{ $latestArticle['icon'] }}"></i>
                    </div>
                    <div class="news-meta">
                        <span class="news-category">{{ $latestArticle['category'] }}</span>
                        <span class="news-date">{{ $latestArticle['date'] }}</span>
                    </div>
                </div>
                
                <div class="news-content">
                    <h2 class="news-title">{{ $latestArticle['title'] }}</h2>
                    <p class="news-excerpt">{{ $latestArticle['excerpt'] }}</p>
                    
                    @if(isset($latestArticle['highlights']) && count($latestArticle['highlights']) > 0)
                    <div class="news-highlights">
                        @foreach($latestArticle['highlights'] as $highlight)
                        <div class="highlight-item">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ $highlight }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </article>
        </div>
        
        <div class="text-center" style="margin-top: 3rem;">
            <a href="/news" class="btn btn-primary btn-lg">
                {{ __('website.latest_news.view_all') }}
                <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
            </a>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section class="section section-portfolio">
    <div class="container">
        <div class="scroll-fade">
            <x-section-title 
                title="{{ __('website.portfolio.title') }}" 
                subtitle="{{ __('website.portfolio.subtitle') }}"
            />
        </div>
        
        <div class="projects-grid">
            @php
                $allProjects = __('website.projects.items');
                $randomProjects = collect($allProjects)->random(min(3, count($allProjects)));
            @endphp
            
            @foreach($randomProjects as $index => $project)
            <div class="project-card scroll-animate">
                <div class="project-image-wrapper">
                    <img src="{{ $project['image'] }}" alt="{{ $project['title'] }}" class="project-image">
                    <div class="project-overlay">
                        <div class="project-overlay-content">
                            <h3 class="project-overlay-title">{{ $project['title'] }}</h3>
                            <p class="project-overlay-location">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $project['location'] }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="project-info">
                    <h3 class="project-title">{{ $project['title'] }}</h3>
                    <p class="project-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $project['location'] }}
                    </p>
                    <div class="project-meta">
                        <span class="project-type">
                            <i class="fas fa-tag"></i>
                            {{ $project['type'] }}
                        </span>
                        <span class="project-capacity">
                            <i class="fas fa-bolt"></i>
                            {{ $project['capacity'] }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center" style="margin-top: 3rem;">
            <a href="/projects" class="btn btn-primary btn-lg">
                {{ __('website.portfolio.view_all') }}
                <i class="fas fa-arrow-right" style="margin-left: 0.5rem;"></i>
            </a>
        </div>
    </div>
</section>

@include('partials.home-feedback', ['feedbacks' => config('website.testimonials', [])])

<!-- Call to Action -->
<section class="section section-cta">
    <div class="container">
        <div class="cta-box scroll-scale">
            <h2 class="cta-title">{{ __('website.cta.title') }}</h2>
            <p class="cta-subtitle">{{ __('website.cta.subtitle') }}</p>
            <a href="/contact" class="btn btn-primary btn-lg">
                {{ __('website.cta.button') }}
            </a>
        </div>
    </div>
</section>

<script>
// Statistics Counter Animation
document.addEventListener('DOMContentLoaded', function() {
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        let animated = false;
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !animated) {
                    animated = true;
                    animateCounters();
                }
            });
        });
        
        observer.observe(statsSection);
        
        function animateCounters() {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;
                
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };
                
                updateCounter();
            });
        }
    }
});
</script>

<!-- Our Partners Section -->
<section class="section section-partners">
    <div class="container">
        <div class="scroll-fade">
            <x-section-title 
                title="{{ __('website.partners.title') }}" 
                subtitle="{{ __('website.partners.subtitle') }}"
            />
        </div>
        
        <div class="partners-slider-container">
            <button class="slider-btn slider-btn-prev" onclick="movePartnersSlider(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="partners-slider-wrapper">
                <div class="partners-slider" id="partnersSlider">
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/jinko-solar-logo.jpg') }}" alt="Jinko Solar"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/logo-ja-solar2.png') }}" alt="JA Solar"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/LONGi-solar.jpg') }}" alt="LONGi Solar"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/znshine-solar-logo.png') }}" alt="Znshine Solar"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/hwawei.png') }}" alt="Huawei"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/shnider.png') }}" alt="Schneider"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/abb.png') }}" alt="ABB"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/chint_1615152722__50818.original.png') }}" alt="Chint"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/Logo_Legrand_SA.svg.png') }}" alt="Legrand"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/Bticino-logo.jpg') }}" alt="BTicino"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/2560px-Lafarge_(Unternehmen)_logo.svg.png') }}" alt="Lafarge"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/nrea.png') }}" alt="NREA"></div>
                    <div class="partner-slide"><img src="{{ asset('Our Partner logo/final-volca-logo-01.png') }}" alt="Volca"></div>
                </div>
            </div>
            
            <button class="slider-btn slider-btn-next" onclick="movePartnersSlider(1)">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<style>
.section-partners {
    background: #f9fafb;
    padding: 4rem 0;
}

.partners-slider-container {
    position: relative;
    max-width: 1200px;
    margin: 3rem auto 0;
    display: flex;
    align-items: center;
    gap: 2rem;
}

.partners-slider-wrapper {
    flex: 1;
    overflow: hidden;
    border-radius: 12px;
}

.partners-slider {
    display: flex;
    transition: transform 0.5s ease;
    gap: 2rem;
}

.partner-slide {
    flex: 0 0 calc(25% - 1.5rem);
    min-width: calc(25% - 1.5rem);
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.partner-slide:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.partner-slide img {
    max-width: 100%;
    max-height: 80px;
    object-fit: contain;
    transition: all 0.3s ease;
}

.partner-slide:hover img {
    transform: scale(1.05);
}

.slider-btn {
    background: white;
    border: 2px solid #e5e7eb;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    color: #1a5f3a;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.slider-btn:hover {
    background: #1a5f3a;
    color: white;
    border-color: #1a5f3a;
    transform: scale(1.1);
}

.slider-btn:active {
    transform: scale(0.95);
}

@media (max-width: 1024px) {
    .partner-slide {
        flex: 0 0 calc(33.333% - 1.5rem);
        min-width: calc(33.333% - 1.5rem);
    }
}

@media (max-width: 768px) {
    .partners-slider-container {
        gap: 1rem;
    }
    
    .partner-slide {
        flex: 0 0 calc(50% - 1rem);
        min-width: calc(50% - 1rem);
        padding: 1.5rem;
    }
    
    .slider-btn {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .partner-slide {
        flex: 0 0 100%;
        min-width: 100%;
    }
}
</style>

<script>
let currentPartnersSlide = 0;
const partnersSlider = document.getElementById('partnersSlider');
const totalPartnersSlides = document.querySelectorAll('.partner-slide').length;
const slidesToShow = window.innerWidth > 1024 ? 4 : (window.innerWidth > 768 ? 3 : (window.innerWidth > 480 ? 2 : 1));

function movePartnersSlider(direction) {
    const maxSlide = totalPartnersSlides - slidesToShow;
    currentPartnersSlide += direction;
    
    if (currentPartnersSlide < 0) {
        currentPartnersSlide = maxSlide;
    } else if (currentPartnersSlide > maxSlide) {
        currentPartnersSlide = 0;
    }
    
    const slideWidth = partnersSlider.querySelector('.partner-slide').offsetWidth;
    const gap = 32; // 2rem in pixels
    const offset = -(currentPartnersSlide * (slideWidth + gap));
    partnersSlider.style.transform = `translateX(${offset}px)`;
}

// Auto slide every 4 seconds
setInterval(() => {
    movePartnersSlider(1);
}, 4000);
</script>

@endsection
