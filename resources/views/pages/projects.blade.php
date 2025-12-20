@extends('layouts.app')

@section('title', __('website.projects.title'))

@section('content')
<!-- Projects Hero -->
<section class="projects-hero">
    <div class="container">
        <h1 class="section-title">{{ __('website.projects.title') }}</h1>
        <p class="section-subtitle">{{ __('website.projects.subtitle') }}</p>
        <div class="hero-divider"></div>
    </div>
</section>

<!-- Projects Gallery -->
<section class="projects-gallery-section">
    <div class="container">
        <div class="projects-grid">
            @forelse($projects as $project)
            <div class="project-card" onclick="openGalleryModal({{ $loop->index }})">
                <div class="project-slider-wrapper">
                    @if(count($project['images']) > 1)
                        <div class="project-slider" id="slider-{{ $loop->index }}">
                            @foreach($project['images'] as $imageIndex => $image)
                            <div class="slide {{ $imageIndex === 0 ? 'active' : '' }}">
                                <img src="{{ asset($image) }}" alt="{{ $project['name'] }}" class="project-image">
                            </div>
                            @endforeach
                            
                            <!-- Slider Controls -->
                            <button class="slider-btn prev" onclick="event.stopPropagation(); changeSlide({{ $loop->index }}, -1)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="slider-btn next" onclick="event.stopPropagation(); changeSlide({{ $loop->index }}, 1)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                            
                            <!-- Slider Indicators -->
                            <div class="slider-indicators">
                                @foreach($project['images'] as $imageIndex => $image)
                                <span class="indicator {{ $imageIndex === 0 ? 'active' : '' }}" 
                                      onclick="event.stopPropagation(); goToSlide({{ $loop->parent->index }}, {{ $imageIndex }})"></span>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <img src="{{ asset($project['images'][0]) }}" alt="{{ $project['name'] }}" class="project-image">
                    @endif
                    
                    <!-- Hover Overlay Icon -->
                    <div class="gallery-overlay">
                        <i class="fas fa-search-plus"></i>
                    </div>
                </div>
                
                <div class="project-info">
                    <h3 class="project-title">{{ $project['name'] }}</h3>
                    <div class="project-meta">
                        <span class="project-count">
                            <i class="fas fa-images"></i>
                            {{ count($project['images']) }} {{ count($project['images']) > 1 ? __('website.projects.photos') : __('website.projects.photo') }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="no-projects">
                <i class="fas fa-folder-open"></i>
                <p>{{ __('website.projects.no_projects') }}</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Gallery Modal -->
<div class="gallery-modal" id="galleryModal">
    <div class="gallery-modal-overlay" onclick="closeGalleryModal()"></div>
    <div class="gallery-modal-content">
        <button class="gallery-modal-close" onclick="closeGalleryModal()">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="gallery-header">
            <h2 id="galleryProjectName" class="gallery-project-title"></h2>
            <div class="gallery-counter">
                <span id="currentImageNumber">1</span> / <span id="totalImages">1</span>
            </div>
        </div>
        
        <div class="gallery-slider">
            <button class="gallery-nav-btn gallery-prev" onclick="changeGallerySlide(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="gallery-image-container" id="galleryImageContainer">
                <!-- Images will be inserted here -->
            </div>
            
            <button class="gallery-nav-btn gallery-next" onclick="changeGallerySlide(1)">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        
        <div class="gallery-thumbnails" id="galleryThumbnails">
            <!-- Thumbnails will be inserted here -->
        </div>
    </div>
</div>

<style>
.projects-hero {
    background: #0C2D1C;
    padding: 4rem 0;
    text-align: center;
}

.section-title {
    font-size: 3rem;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.25rem;
    color: rgba(255, 255, 255, 0.9);
    max-width: 600px;
    margin: 0 auto 2rem;
}

.hero-divider {
    width: 80px;
    height: 4px;
    background: linear-gradient(135deg, #FFDF41 0%, #E3A000 100%);
    margin: 0 auto;
    border-radius: 2px;
}

.projects-gallery-section {
    padding: 4rem 0;
}

.projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2.5rem;
    padding: 0 1rem;
}

.project-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.project-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.project-slider-wrapper {
    position: relative;
    width: 100%;
    height: 350px;
    overflow: hidden;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #e5e7eb;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(12, 45, 28, 0.85);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 15;
}

.project-card:hover .gallery-overlay {
    opacity: 1;
}

.gallery-overlay i {
    color: #FFDF41;
    font-size: 3rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

.project-slider {
    position: relative;
    width: 100%;
    height: 100%;
}

.slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.5s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px;
}

.slide.active {
    opacity: 1;
}

.project-image {
    max-width: 85%;
    max-height: 85%;
    width: auto;
    height: auto;
    object-fit: contain;
    object-position: center;
}

.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.9);
    color: #0C2D1C;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.slider-btn:hover {
    background: #FFDF41;
    transform: translateY(-50%) scale(1.1);
}

.slider-btn.prev {
    left: 10px;
}

.slider-btn.next {
    right: 10px;
}

.slider-indicators {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 10;
}

.indicator {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    transition: all 0.3s ease;
}

.indicator.active {
    background: #FFDF41;
    width: 30px;
    border-radius: 5px;
}

.project-info {
    padding: 1.5rem;
}

.project-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #0C2D1C;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.project-meta {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    flex-wrap: wrap;
    gap: 1rem;
}

.project-count {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6B7280;
    font-size: 0.9rem;
}

.project-count i {
    color: #FFDF41;
}

.no-projects {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    color: #6B7280;
}

.no-projects i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.no-projects p {
    font-size: 1.25rem;
}

/* Gallery Modal Styles */
.gallery-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
}

.gallery-modal.active {
    display: flex;
}

.gallery-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(10px);
}

.gallery-modal-content {
    position: relative;
    width: 90%;
    max-width: 1200px;
    height: 90vh;
    background: #1a1a1a;
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    z-index: 10000;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}

.gallery-modal-close {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10001;
}

.gallery-modal-close:hover {
    background: #FFDF41;
    color: #0C2D1C;
    transform: rotate(90deg);
}

.gallery-header {
    padding: 2rem 2rem 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.gallery-project-title {
    color: white;
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0;
}

.gallery-counter {
    display: none;
}

.gallery-slider {
    flex: 1;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    overflow: hidden;
}

.gallery-image-container {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.gallery-slide {
    position: absolute;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.5s ease;
}

.gallery-slide.active {
    opacity: 1;
}

.gallery-slide img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 10px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
}

.gallery-nav-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10;
}

.gallery-nav-btn:hover {
    background: #FFDF41;
    color: #0C2D1C;
    transform: translateY(-50%) scale(1.1);
}

.gallery-prev {
    left: 20px;
}

.gallery-next {
    right: 20px;
}

.gallery-thumbnails {
    padding: 1.5rem 2rem 2rem;
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.gallery-thumbnails::-webkit-scrollbar {
    height: 8px;
}

.gallery-thumbnails::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 4px;
}

.gallery-thumbnails::-webkit-scrollbar-thumb {
    background: #FFDF41;
    border-radius: 4px;
}

.gallery-thumbnail {
    flex-shrink: 0;
    width: 100px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
    opacity: 0.5;
}

.gallery-thumbnail:hover {
    opacity: 0.8;
    transform: scale(1.05);
}

.gallery-thumbnail.active {
    border-color: #FFDF41;
    opacity: 1;
}

.gallery-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

@media (max-width: 768px) {
    .projects-gallery-section {
        padding: 2rem 0;
    }
    
    .section-title {
        font-size: 1.75rem;
    }
    
    .section-subtitle {
        font-size: 0.95rem;
    }
    
    .projects-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
        padding: 0 0.75rem;
    }
    
    .project-card {
        border-radius: 15px;
    }
    
    .project-card:hover {
        transform: translateY(-4px);
    }
    
    .project-slider-wrapper {
        height: 220px;
    }
    
    .project-image {
        max-width: 90%;
        max-height: 90%;
    }
    
    .slider-btn {
        width: 32px;
        height: 32px;
        font-size: 0.85rem;
    }
    
    .slider-btn.prev {
        left: 8px;
    }
    
    .slider-btn.next {
        right: 8px;
    }
    
    .slider-indicators {
        bottom: 10px;
        gap: 6px;
    }
    
    .indicator {
        width: 8px;
        height: 8px;
    }
    
    .indicator.active {
        width: 24px;
    }
    
    .project-info {
        padding: 1.25rem;
    }
    
    .project-title {
        font-size: 1.1rem;
    }
    
    .project-count {
        font-size: 0.85rem;
    }
    
    /* Hide hover overlay on mobile, show tap indicator instead */
    .gallery-overlay {
        opacity: 0.15;
        background: rgba(12, 45, 28, 0.3);
    }
    
    .gallery-overlay i {
        font-size: 2rem;
    }
    
    .project-card:active .gallery-overlay {
        opacity: 0.5;
    }
    
    .gallery-modal-content {
        width: 95%;
        height: 95vh;
        border-radius: 15px;
    }
    
    .gallery-header {
        padding: 1.5rem 1rem 1rem;
        flex-direction: column;
        gap: 0.5rem;
        align-items: flex-start;
    }
    
    .gallery-project-title {
        font-size: 1.1rem;
    }
    
    .gallery-counter {
        font-size: 1rem;
    }
    
    .gallery-slider {
        padding: 1rem;
    }
    
    .gallery-slide img {
        max-width: 90%;
        max-height: 90%;
    }
    
    .gallery-nav-btn {
        width: 45px;
        height: 45px;
        font-size: 1.2rem;
    }
    
    .gallery-prev {
        left: 10px;
    }
    
    .gallery-next {
        right: 10px;
    }
    
    .gallery-thumbnails {
        padding: 1rem;
        gap: 0.5rem;
    }
    
    .gallery-thumbnail {
        width: 70px;
        height: 55px;
    }
    
    .gallery-modal-close {
        width: 40px;
        height: 40px;
        top: 15px;
        right: 15px;
        font-size: 1.2rem;
    }
}
</style>

<script>
const sliders = {};
let currentGalleryProject = null;
let currentGallerySlide = 0;
const projectsData = @json($projects);

// Initialize sliders
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.project-slider').forEach((slider) => {
        const sliderId = slider.id.replace('slider-', '');
        sliders[sliderId] = {
            currentSlide: 0,
            totalSlides: slider.querySelectorAll('.slide').length
        };
    });
});

function changeSlide(sliderIndex, direction) {
    if (!sliders[sliderIndex]) return;
    
    const slider = sliders[sliderIndex];
    const sliderElement = document.getElementById(`slider-${sliderIndex}`);
    
    if (!sliderElement) return;
    
    // Hide current slide
    const slides = sliderElement.querySelectorAll('.slide');
    const indicators = sliderElement.querySelectorAll('.indicator');
    
    if (slides.length === 0) return;
    
    slides[slider.currentSlide].classList.remove('active');
    indicators[slider.currentSlide].classList.remove('active');
    
    // Calculate new slide
    slider.currentSlide = (slider.currentSlide + direction + slider.totalSlides) % slider.totalSlides;
    
    // Show new slide
    slides[slider.currentSlide].classList.add('active');
    indicators[slider.currentSlide].classList.add('active');
}

function goToSlide(sliderIndex, slideIndex) {
    if (!sliders[sliderIndex]) return;
    
    const slider = sliders[sliderIndex];
    const sliderElement = document.getElementById(`slider-${sliderIndex}`);
    
    if (!sliderElement) return;
    
    // Hide current slide
    const slides = sliderElement.querySelectorAll('.slide');
    const indicators = sliderElement.querySelectorAll('.indicator');
    
    if (slides.length === 0) return;
    
    slides[slider.currentSlide].classList.remove('active');
    indicators[slider.currentSlide].classList.remove('active');
    
    // Go to specific slide
    slider.currentSlide = slideIndex;
    
    // Show new slide
    slides[slider.currentSlide].classList.add('active');
    indicators[slider.currentSlide].classList.add('active');
}

// Gallery Modal Functions
function openGalleryModal(projectIndex) {
    currentGalleryProject = projectsData[projectIndex];
    currentGallerySlide = 0;
    
    const modal = document.getElementById('galleryModal');
    const imageContainer = document.getElementById('galleryImageContainer');
    const thumbnailsContainer = document.getElementById('galleryThumbnails');
    
    // Set project name
    document.getElementById('galleryProjectName').textContent = currentGalleryProject.name;
    
    // Clear previous content
    imageContainer.innerHTML = '';
    thumbnailsContainer.innerHTML = '';
    
    const baseUrl = '{{ url('/') }}/';
    
    // Create slides
    currentGalleryProject.images.forEach((image, index) => {
        // Create main slide
        const slide = document.createElement('div');
        slide.className = `gallery-slide ${index === 0 ? 'active' : ''}`;
        const img = document.createElement('img');
        img.src = baseUrl + image;
        img.alt = currentGalleryProject.name;
        slide.appendChild(img);
        imageContainer.appendChild(slide);
        
        // Create thumbnail
        const thumbnail = document.createElement('div');
        thumbnail.className = `gallery-thumbnail ${index === 0 ? 'active' : ''}`;
        const thumbImg = document.createElement('img');
        thumbImg.src = baseUrl + image;
        thumbImg.alt = currentGalleryProject.name;
        thumbnail.appendChild(thumbImg);
        thumbnail.onclick = () => goToGallerySlide(index);
        thumbnailsContainer.appendChild(thumbnail);
    });
    
    // Update counter
    updateGalleryCounter();
    
    // Show modal
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeGalleryModal() {
    const modal = document.getElementById('galleryModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
    currentGalleryProject = null;
    currentGallerySlide = 0;
}

function changeGallerySlide(direction) {
    if (!currentGalleryProject) return;
    
    const slides = document.querySelectorAll('.gallery-slide');
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    
    // Hide current
    slides[currentGallerySlide].classList.remove('active');
    thumbnails[currentGallerySlide].classList.remove('active');
    
    // Calculate new slide
    currentGallerySlide = (currentGallerySlide + direction + slides.length) % slides.length;
    
    // Show new
    slides[currentGallerySlide].classList.add('active');
    thumbnails[currentGallerySlide].classList.add('active');
    
    // Scroll thumbnail into view
    thumbnails[currentGallerySlide].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    
    updateGalleryCounter();
}

function goToGallerySlide(slideIndex) {
    if (!currentGalleryProject) return;
    
    const slides = document.querySelectorAll('.gallery-slide');
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    
    // Hide current
    slides[currentGallerySlide].classList.remove('active');
    thumbnails[currentGallerySlide].classList.remove('active');
    
    // Go to specific
    currentGallerySlide = slideIndex;
    
    // Show new
    slides[currentGallerySlide].classList.add('active');
    thumbnails[currentGallerySlide].classList.add('active');
    
    updateGalleryCounter();
}

function updateGalleryCounter() {
    document.getElementById('currentImageNumber').textContent = currentGallerySlide + 1;
    document.getElementById('totalImages').textContent = currentGalleryProject ? currentGalleryProject.images.length : 1;
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('galleryModal');
    if (modal.classList.contains('active')) {
        if (e.key === 'ArrowLeft') {
            changeGallerySlide(-1);
        } else if (e.key === 'ArrowRight') {
            changeGallerySlide(1);
        } else if (e.key === 'Escape') {
            closeGalleryModal();
        }
    }
});

// Optional: Auto-play functionality
// Uncomment if you want auto-play
/*
setInterval(() => {
    Object.keys(sliders).forEach(index => {
        changeSlide(parseInt(index), 1);
    });
}, 5000); // Change slide every 5 seconds
*/
</script>
@endsection
