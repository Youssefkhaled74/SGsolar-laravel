<section class="hero-slider">
    <div class="slider-container">
        <div class="slide active">
            <img src="{{ asset('banner (1).png') }}" alt="SG Solar Banner 1">
        </div>
        <div class="slide">
            <img src="{{ asset('banner (2)..png') }}" alt="SG Solar Banner 2">
        </div>
    </div>
    
    <!-- Location Text Overlay -->
    {{-- <div class="hero-location-overlay">
        <div class="location-text">
            <i class="fas fa-map-marker-alt"></i>
            <span>201 - 40 الملتقي العربي شيراتون المطار - النزهة - القاهرة</span>
        </div>
    </div> --}}
    
    <!-- Navigation Dots -->
    <div class="slider-dots">
        <span class="dot active" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
    </div>
</section>

<!-- Solutions Banner Section -->
{{-- <section class="solutions-banner">
    <div class="container">
        <div class="banner-grid">
            <div class="banner-item">
                <img src="{{ asset('icons/icons/on grid.png') }}" alt="On Grid">
                <span>On Grid</span>
            </div>
            <div class="banner-item">
                <img src="{{ asset('icons/icons/off grid.png') }}" alt="Off Grid">
                <span>Off Grid</span>
            </div>
            <div class="banner-item">
                <img src="{{ asset('icons/icons/pump.png') }}" alt="Pump">
                <span>Pump</span>
            </div>
            <div class="banner-item">
                <img src="{{ asset('icons/icons/heater.png') }}" alt="Solar Heater">
                <span>Solar Heater</span>
            </div>
            <div class="banner-item">
                <img src="{{ asset('icons/icons/light.png') }}" alt="Solar Light">
                <span>Solar Light</span>
            </div>
        </div>
    </div>
</section> --}}

<script>
let slideIndex = 0;
let slideTimer;

function showSlides() {
    let slides = document.getElementsByClassName("slide");
    let dots = document.getElementsByClassName("dot");
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
    }
    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1}
    
    slides[slideIndex-1].classList.add("active");
    dots[slideIndex-1].classList.add("active");
    
    slideTimer = setTimeout(showSlides, 4000); // Change every 4 seconds
}

function currentSlide(n) {
    clearTimeout(slideTimer);
    slideIndex = n - 1;
    showSlides();
}

// Start the slideshow
document.addEventListener('DOMContentLoaded', function() {
    showSlides();
});
</script>
