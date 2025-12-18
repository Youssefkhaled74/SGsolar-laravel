<section class="hero-slider">
    <div class="slider-container">
        <div class="slide active">
            <img src="{{ asset('banner (1).png') }}" alt="SG Solar Banner 1">
        </div>
        <div class="slide">
            <img src="{{ asset('banner (2)..png') }}" alt="SG Solar Banner 2">
        </div>
        <div class="slide">
            <img src="{{ asset('banner (3).jpeg') }}" alt="SG Solar Banner 3">
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
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>
</section>

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
