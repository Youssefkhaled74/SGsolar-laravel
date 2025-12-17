@php
    $feedbacks = isset($feedbacks) ? $feedbacks : (config('website.testimonials') ?? []);
    $feedbacks = array_values($feedbacks);
@endphp

@if(count($feedbacks) > 0)
    <section class="section-feedback" style="background-color: {{ config('website.dark_green', '#0C2D1C') }};">
        <div class="container">
            <div class="feedback-heading">
                <div class="feedback-heading-text">
                    <h2 class="section-title">{{ __('website.feedback.title') }}</h2>
                </div>
            </div>

            <div class="feedback-carousel-container">
                <!-- Navigation Arrows -->
                <button class="feedback-scroll-btn feedback-scroll-left" aria-label="Scroll left">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <div class="feedback-carousel-wrapper">
                    <div class="feedback-carousel" id="feedbackCarousel">
                        @foreach($feedbacks as $index => $item)
                            <article class="feedback-card" data-index="{{ $index }}">
                                <div class="feedback-card-header">
                                    <div class="feedback-quote-icon">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
                                        </svg>
                                    </div>
                                    <div class="feedback-card-stars" role="img" aria-label="{{ $item['rating'] ?? 0 }} stars">
                                        @php $rating = isset($item['rating']) ? (int)$item['rating'] : 0; @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="star-icon {{ $i <= $rating ? 'filled' : '' }}" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <div class="feedback-card-content">
                                    <p class="feedback-card-message">{{ $item['message'] ?? '' }}</p>
                                </div>
                                <div class="feedback-card-footer">
                                    <div class="feedback-customer-avatar">
                                        <span>{{ mb_substr($item['name'] ?? 'U', 0, 1) }}</span>
                                    </div>
                                    <div class="feedback-customer-info">
                                        <span class="feedback-card-name">{{ $item['name'] ?? '' }}</span>
                                        <span class="feedback-card-verified">عميل موثق</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <button class="feedback-scroll-btn feedback-scroll-right" aria-label="Scroll right">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <!-- Share Feedback Button -->
            <div class="feedback-action">
                <button id="openFeedbackModal" class="btn btn-primary btn-lg">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z" fill="currentColor"/>
                        <path d="M7 9h10v2H7zm0-3h10v2H7zm0 6h7v2H7z" fill="currentColor"/>
                    </svg>
                    {{ __('website.footer.feedback_form') }}
                </button>
            </div>
        </div>
    </section>

    <script>
    (function() {
        'use strict';
        
        function initFeedbackCarousel() {
            const carousel = document.getElementById('feedbackCarousel');
            const leftBtn = document.querySelector('.feedback-scroll-left');
            const rightBtn = document.querySelector('.feedback-scroll-right');
            
            if (!carousel || !leftBtn || !rightBtn) return;
            
            let isRTL = document.documentElement.dir === 'rtl';
            
            function getScrollAmount() {
                const card = carousel.querySelector('.feedback-card');
                if (!card) return 300;
                const computedStyle = window.getComputedStyle(carousel);
                const gap = parseInt(computedStyle.gap) || 32;
                return card.offsetWidth + gap;
            }
            
            function scrollCarousel(direction) {
                const scrollAmount = getScrollAmount();
                const scrollValue = direction === 'left' ? -scrollAmount : scrollAmount;
                const actualScroll = isRTL ? -scrollValue : scrollValue;
                
                carousel.scrollBy({
                    left: actualScroll,
                    behavior: 'smooth'
                });
            }
            
            leftBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                scrollCarousel('left');
            });
            
            rightBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                scrollCarousel('right');
            });
            
            function updateButtons() {
                const maxScroll = carousel.scrollWidth - carousel.clientWidth;
                const scrollLeft = Math.abs(carousel.scrollLeft);
                const threshold = 10;
                
                if (scrollLeft <= threshold) {
                    leftBtn.classList.add('disabled');
                } else {
                    leftBtn.classList.remove('disabled');
                }
                
                if (scrollLeft >= maxScroll - threshold) {
                    rightBtn.classList.add('disabled');
                } else {
                    rightBtn.classList.remove('disabled');
                }
            }
            
            carousel.addEventListener('scroll', updateButtons);
            window.addEventListener('resize', function() {
                setTimeout(updateButtons, 100);
            });
            
            setTimeout(updateButtons, 200);
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initFeedbackCarousel);
        } else {
            initFeedbackCarousel();
        }
    })();
    </script>
@endif
