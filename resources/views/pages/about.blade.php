@extends('layouts.app')

@section('title', __('website.about.title'))

@section('content')
<!-- About Hero Section -->
<section class="about-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="section-title">{{ __('website.about.title') }}</h1>
            <div class="hero-divider"></div>
        </div>
    </div>
</section>

<!-- Company Introduction -->
<section class="about-intro">
    <div class="container">
        <div class="intro-content">
            <div class="intro-text">
                <p>{{ __('website.about.intro') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="vision-mission">
    <div class="container">
        <div class="vm-grid">
            <!-- Vision Card -->
            <div class="vm-card vision-card">
                <div class="vm-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3 class="vm-title">{{ __('website.about.vision_title') }}</h3>
                <p class="vm-text">{{ __('website.about.vision_text') }}</p>
            </div>

            <!-- Mission Card -->
            <div class="vm-card mission-card">
                <div class="vm-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 class="vm-title">{{ __('website.about.mission_title') }}</h3>
                <p class="vm-text">{{ __('website.about.mission_text') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Counter Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            @foreach(__('website.about.stats') as $stat)
            <div class="stat-card">
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

<!-- Why Choose Us -->
<section class="why-choose">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">{{ __('website.about.why_choose_title') }}</h2>
            <h3 class="section-subtitle">{{ __('website.about.why_choose_subtitle') }}</h3>
            <p class="section-intro">{{ __('website.about.why_choose_intro') }}</p>
        </div>

        <div class="guarantees-grid">
            @foreach(__('website.about.guarantees') as $index => $guarantee)
            <div class="guarantee-card">
                <div class="guarantee-icon">
                    <i class="fas {{ $guarantee['icon'] }}"></i>
                </div>
                <div class="guarantee-content">
                    <h4 class="guarantee-title">{{ $guarantee['title'] }}</h4>
                    <p class="guarantee-subtitle">{{ $guarantee['subtitle'] }}</p>
                    <p class="guarantee-description">{{ $guarantee['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animated Counter
    const counters = document.querySelectorAll('.counter');
    const speed = 200;
    let hasAnimated = false;

    const animateCounters = () => {
        if (hasAnimated) return;
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const increment = target / speed;
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.textContent = Math.ceil(current);
                    setTimeout(updateCounter, 1);
                } else {
                    counter.textContent = target;
                }
            };

            updateCounter();
        });
        
        hasAnimated = true;
    };

    // Intersection Observer for counter animation
    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                }
            });
        }, { threshold: 0.5 });

        observer.observe(statsSection);
    }
});
</script>
@endsection
