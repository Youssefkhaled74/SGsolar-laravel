<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('website.slogan') }}">
    <title>@yield('title', __('website.company_name') . ' - ' . __('website.slogan'))</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @yield('extra-styles')
</head>
<body>
    <!-- Floating Social Buttons -->
    <div class="floating-social">
        <a href="tel:{{ config('website.contact.phone') }}" 
           class="call-btn" 
           title="Call Us">
            <i class="fas fa-phone"></i>
        </a>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', config('website.contact.whatsapp')) }}" 
           target="_blank" 
           class="whatsapp-btn" 
           title="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="{{ route('contact') }}" 
           class="chat-btn" 
           title="{{ __('website.nav.contact') }}">
            <i class="fas fa-comments"></i>
        </a>
    </div>
    
    <x-navbar />
    
    <main>
        @yield('content')
    </main>
    
    <x-footer />
    
    <!-- Feedback Modal -->
    <div id="feedbackModal" class="feedback-modal-overlay" style="display: none;">
        <div class="feedback-modal">
            <button class="feedback-modal-close" onclick="closeFeedbackModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            
            <div class="feedback-modal-header">
                <h3 class="feedback-modal-title">{{ __('website.footer.feedback_form') }}</h3>
                <p class="feedback-modal-description">{{ __('website.footer.feedback_description') }}</p>
            </div>
            
            <form id="feedbackModalForm" class="feedback-modal-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="modal-feedback-name" class="form-label">{{ __('website.footer.name_label') }}</label>
                        <input 
                            type="text" 
                            id="modal-feedback-name" 
                            name="name" 
                            class="form-input" 
                            placeholder="{{ __('website.footer.name_placeholder') }}"
                            required
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="modal-feedback-rating" class="form-label">{{ __('website.footer.rating_label') }}</label>
                        <div class="star-rating-input">
                            <input type="hidden" id="modal-feedback-rating" name="rating" value="0">
                            <div class="star-rating-display">
                                <span class="star-btn" data-rating="1">
                                    <svg width="24" height="24" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 1.5l2.6 5.3 5.8.8-4.2 3.9 1 5.8L10 15.9 4.8 17.3l1-5.8L1.6 7.6l5.8-.8L10 1.5z"/>
                                    </svg>
                                </span>
                                <span class="star-btn" data-rating="2">
                                    <svg width="24" height="24" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 1.5l2.6 5.3 5.8.8-4.2 3.9 1 5.8L10 15.9 4.8 17.3l1-5.8L1.6 7.6l5.8-.8L10 1.5z"/>
                                    </svg>
                                </span>
                                <span class="star-btn" data-rating="3">
                                    <svg width="24" height="24" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 1.5l2.6 5.3 5.8.8-4.2 3.9 1 5.8L10 15.9 4.8 17.3l1-5.8L1.6 7.6l5.8-.8L10 1.5z"/>
                                    </svg>
                                </span>
                                <span class="star-btn" data-rating="4">
                                    <svg width="24" height="24" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 1.5l2.6 5.3 5.8.8-4.2 3.9 1 5.8L10 15.9 4.8 17.3l1-5.8L1.6 7.6l5.8-.8L10 1.5z"/>
                                    </svg>
                                </span>
                                <span class="star-btn" data-rating="5">
                                    <svg width="24" height="24" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 1.5l2.6 5.3 5.8.8-4.2 3.9 1 5.8L10 15.9 4.8 17.3l1-5.8L1.6 7.6l5.8-.8L10 1.5z"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="modal-feedback-message" class="form-label">{{ __('website.footer.message_label') }}</label>
                    <textarea 
                        id="modal-feedback-message" 
                        name="message" 
                        class="form-textarea" 
                        rows="4" 
                        placeholder="{{ __('website.footer.message_placeholder') }}"
                        required
                    ></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary btn-feedback-submit">
                    {{ __('website.footer.submit_feedback') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Feedback Success Alert -->
    <div id="feedbackSuccessAlert" class="success-overlay" style="display: none;">
        <div class="success-modal">
            <div class="success-icon">
                <svg viewBox="0 0 52 52">
                    <circle cx="26" cy="26" r="25" fill="none"/>
                    <path fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            </div>
            <h2 id="successAlertTitle">{{ __('website.footer.feedback_success') }}</h2>
            <p id="successAlertMessage"></p>
            <button onclick="closeFeedbackSuccessAlert()" class="close-alert-btn">
                {{ app()->getLocale() == 'ar' ? 'حسناً' : 'OK' }}
            </button>
        </div>
    </div>
    
    <!-- Scroll Animation Script -->
    <script>
        // Intersection Observer for scroll animations
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.15,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            // Observe all elements with animation classes
            const animateElements = document.querySelectorAll(
                '.scroll-animate, .scroll-slide-left, .scroll-slide-right, .scroll-fade, .scroll-scale'
            );
            
            animateElements.forEach(el => observer.observe(el));

            // Feedback Carousel - Static Display (No auto-scroll)
            const carousel = document.querySelector('.feedback-carousel');
            if (carousel) {
                // All cards are displayed in grid, no scrolling needed
                console.log('Feedback section loaded with', carousel.querySelectorAll('.feedback-card').length, 'reviews');
            }

            // Feedback Modal Handler
            const feedbackModal = document.getElementById('feedbackModal');
            const openModalBtn = document.getElementById('openFeedbackModal');
            const feedbackForm = document.getElementById('feedbackModalForm');
            
            if (openModalBtn) {
                openModalBtn.addEventListener('click', function() {
                    feedbackModal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                });
            }

            // Close modal on overlay click
            if (feedbackModal) {
                feedbackModal.addEventListener('click', function(e) {
                    if (e.target === feedbackModal) {
                        closeFeedbackModal();
                    }
                });
            }

            // Feedback Form Handler
            if (feedbackForm) {
                const ratingInput = document.getElementById('modal-feedback-rating');
                const starButtons = feedbackForm.querySelectorAll('.star-btn');
                let selectedRating = 0;

                // Star rating interaction
                starButtons.forEach(star => {
                    star.addEventListener('click', function() {
                        selectedRating = parseInt(this.dataset.rating);
                        ratingInput.value = selectedRating;
                        
                        // Update star display
                        starButtons.forEach((s, index) => {
                            if (index < selectedRating) {
                                s.classList.add('active');
                            } else {
                                s.classList.remove('active');
                            }
                        });
                    });

                    // Hover effect
                    star.addEventListener('mouseenter', function() {
                        const hoverRating = parseInt(this.dataset.rating);
                        starButtons.forEach((s, index) => {
                            if (index < hoverRating) {
                                s.style.color = '#FFDF41';
                            } else {
                                s.style.color = '';
                            }
                        });
                    });
                });

                // Reset hover effect
                const starDisplay = feedbackForm.querySelector('.star-rating-display');
                if (starDisplay) {
                    starDisplay.addEventListener('mouseleave', function() {
                        starButtons.forEach((s, index) => {
                            if (index < selectedRating) {
                                s.style.color = '#FFDF41';
                            } else {
                                s.style.color = '';
                            }
                        });
                    });
                }

                // Form submission handler
                feedbackForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const name = document.getElementById('modal-feedback-name').value.trim();
                    const message = document.getElementById('modal-feedback-message').value.trim();
                    const rating = parseInt(ratingInput.value);

                    // Validation
                    if (!name || !message || rating === 0) {
                        const errorMsg = document.documentElement.lang === 'ar' 
                            ? '{{ __("website.footer.feedback_error") }}'
                            : '{{ __("website.footer.feedback_error") }}';
                        alert(errorMsg);
                        return;
                    }

                    // Close modal
                    closeFeedbackModal();

                    // Show success alert after a brief delay
                    setTimeout(() => {
                        showFeedbackSuccessAlert();
                    }, 300);

                    // Clear form
                    feedbackForm.reset();
                    selectedRating = 0;
                    ratingInput.value = 0;
                    starButtons.forEach(s => s.classList.remove('active'));
                });
            }
        });

        // Modal control functions
        function closeFeedbackModal() {
            const modal = document.getElementById('feedbackModal');
            if (modal) {
                modal.style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => {
                    modal.style.display = 'none';
                    modal.style.animation = '';
                    document.body.style.overflow = '';
                }, 300);
            }
        }

        function showFeedbackSuccessAlert() {
            const alert = document.getElementById('feedbackSuccessAlert');
            if (alert) {
                alert.style.display = 'flex';
                
                // Auto close after 5 seconds
                setTimeout(() => {
                    closeFeedbackSuccessAlert();
                }, 5000);
            }
        }

        function closeFeedbackSuccessAlert() {
            const alert = document.getElementById('feedbackSuccessAlert');
            if (alert) {
                alert.style.animation = 'fadeOut 0.3s ease';
                setTimeout(() => {
                    alert.style.display = 'none';
                    alert.style.animation = '';
                }, 300);
            }
        }
    </script>
    
    @yield('extra-scripts')
</body>
</html>
