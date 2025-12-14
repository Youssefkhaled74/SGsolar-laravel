<section class="hero-slider">
    <div class="slider-container">
        <div class="slide active">
            <img src="{{ asset('images/hero-slide-1.jpg') }}" alt="SG Solar Team">
        </div>
        <div class="slide">
            <img src="{{ asset('images/hero-slide-2.jpg') }}" alt="SG Solar Team">
        </div>
        <div class="slide">
            <img src="{{ asset('images/hero-slide-3.jpg') }}" alt="SG Solar Team">
        </div>
        <div class="slide">
            <img src="{{ asset('images/hero-slide-4.jpg') }}" alt="SG Solar Team">
        </div>
    </div>
    
    <!-- Navigation Dots -->
    <div class="slider-dots">
        <span class="dot active" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
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
