@extends('layouts.app')

@section('title', 'Gallery - ' . config('website.name'))

@section('content')

<!-- Page Header -->
<section class="page-header bg-gradient">
    <div class="container">
        <h1 class="page-title">Our Gallery</h1>
        <p class="page-subtitle">See our solar water heaters in action</p>
    </div>
</section>

<!-- Gallery Grid -->
<section class="section">
    <div class="container">
        <x-section-title 
            title="Our Work" 
            subtitle="Real installations, real results"
        />
        
        <div class="gallery-grid">
            @foreach($data['gallery'] as $index => $image)
                <div class="gallery-item" onclick="openLightbox({{ $index }})">
                    @if(str_starts_with($image, 'http'))
                        <img src="{{ $image }}" alt="SgSolar Installation {{ $index + 1 }}">
                    @else
                        <img src="{{ asset($image) }}" alt="SgSolar Installation {{ $index + 1 }}">
                    @endif
                    <div class="gallery-overlay">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                        </svg>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Statistics -->
<section class="section bg-light">
    <div class="container">
        <x-section-title 
            title="Our Impact" 
            subtitle="Numbers that speak for themselves"
        />
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">500+</div>
                <div class="stat-label">Installations</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">98%</div>
                <div class="stat-label">Customer Satisfaction</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">15+</div>
                <div class="stat-label">Years Experience</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">70%</div>
                <div class="stat-label">Average Energy Savings</div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section section-cta">
    <div class="container">
        <div class="cta-box">
            <h2 class="cta-title">Want to Be Our Next Success Story?</h2>
            <p class="cta-subtitle">Let's discuss how we can help you achieve energy independence.</p>
            <a href="/contact" class="btn btn-primary btn-lg">Contact Us Today</a>
        </div>
    </div>
</section>

<!-- Lightbox -->
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close">&times;</span>
    <img class="lightbox-content" id="lightbox-img">
    <div class="lightbox-prev" onclick="event.stopPropagation(); changeImage(-1)">&#10094;</div>
    <div class="lightbox-next" onclick="event.stopPropagation(); changeImage(1)">&#10095;</div>
</div>

@endsection

@section('extra-scripts')
<script>
let currentImageIndex = 0;
const images = @json($data['gallery']);

function openLightbox(index) {
    currentImageIndex = index;
    document.getElementById('lightbox').style.display = 'flex';
    updateLightboxImage();
}

function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
}

function changeImage(direction) {
    currentImageIndex += direction;
    if (currentImageIndex < 0) currentImageIndex = images.length - 1;
    if (currentImageIndex >= images.length) currentImageIndex = 0;
    updateLightboxImage();
}

function updateLightboxImage() {
    const img = document.getElementById('lightbox-img');
    const currentImage = images[currentImageIndex];
    // Check if URL is external
    if (currentImage.startsWith('http')) {
        img.src = currentImage;
    } else {
        img.src = '{{ asset('') }}' + currentImage;
    }
}

// Close lightbox on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') changeImage(-1);
    if (e.key === 'ArrowRight') changeImage(1);
});
</script>
@endsection
