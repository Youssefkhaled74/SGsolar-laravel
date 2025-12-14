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
                    <img src="{{ asset('images/category-swh.png') }}" alt="{{ __('website.products.swh.title') }}">
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
                    <img src="{{ asset('images/category-lights.png') }}" alt="{{ __('website.products.solar_lights.title') }}">
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
                    <img src="{{ asset('images/category-panels.png') }}" alt="{{ __('website.products.solar_panels.title') }}">
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

@endsection
