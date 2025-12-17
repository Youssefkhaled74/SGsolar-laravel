@extends('layouts.app')

@section('title', __('website.contact.title'))

@section('content')

@if(session('success'))
<!-- Success Alert Modal -->
<div class="success-overlay" id="successAlert">
    <div class="success-modal">
        <div class="success-icon">
            <svg viewBox="0 0 52 52">
                <circle cx="26" cy="26" r="25" fill="none"/>
                <path fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>
        <h2>{{ __('website.contact.message_sent') }}</h2>
        <p>سنتواصل معك في أقرب وقت ممكن</p>
        <button onclick="closeAlert()" class="close-alert-btn">حسناً</button>
    </div>
</div>

<style>
.success-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.success-modal {
    background: white;
    padding: 3rem;
    border-radius: 20px;
    text-align: center;
    max-width: 450px;
    animation: slideDown 0.5s ease;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

@keyframes slideDown {
    from {
        transform: translateY(-100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.success-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 2rem;
}

.success-icon svg {
    width: 100%;
    height: 100%;
}

.success-icon circle {
    stroke: #10B981;
    stroke-width: 2;
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.success-icon path {
    stroke: #10B981;
    stroke-width: 3;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.5s forwards;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

.success-modal h2 {
    color: #0C2D1C;
    font-size: 1.75rem;
    margin-bottom: 1rem;
    font-weight: 700;
}

.success-modal p {
    color: #6B7280;
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.close-alert-btn {
    background: linear-gradient(135deg, #FFDF41 0%, #E3A000 100%);
    color: #0C2D1C;
    padding: 1rem 3rem;
    border: none;
    border-radius: 10px;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(227, 160, 0, 0.3);
    font-family: 'Cairo', sans-serif;
}

.close-alert-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(227, 160, 0, 0.5);
}

@media (max-width: 768px) {
    .success-modal {
        margin: 1rem;
        padding: 2rem;
    }
    
    .success-modal h2 {
        font-size: 1.5rem;
    }
}
</style>

<script>
function closeAlert() {
    const alert = document.getElementById('successAlert');
    if (alert) {
        alert.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => {
            alert.remove();
        }, 300);
    }
}

// Auto close after 5 seconds
setTimeout(() => {
    const alert = document.getElementById('successAlert');
    if (alert) {
        closeAlert();
    }
}, 5000);

// Close on clicking overlay
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.getElementById('successAlert');
    if (overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                closeAlert();
            }
        });
    }
});
</script>

<style>
@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}
</style>
@endif

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1 class="page-title">{{ __('website.contact.title') }}</h1>
        <p class="page-subtitle">{{ __('website.contact.get_in_touch') }}</p>
    </div>
</section>

<!-- Contact Section -->
<section class="section">
    <div class="container">
        <!-- Form and Map Side by Side -->
        <div class="contact-wrapper">
            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <div class="contact-form-card">
                    <h2 class="form-title">{{ __('website.contact.send_message') }}</h2>
                    
                    @if(session('success'))
                        <div style="background: #D1FAE5; color: #065F46; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; text-align: center; font-weight: 600;">
                            ✓ {{ session('success') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.submit') }}" method="POST" class="contact-form">
                        @csrf
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">{{ __('website.contact.full_name') }}</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">{{ __('website.contact.email_address') }}</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone">{{ __('website.contact.phone_number') }}</label>
                                <input type="tel" id="phone" name="phone">
                            </div>
                            
                            <div class="form-group">
                                <label for="subject">{{ __('website.contact.subject') }}</label>
                                <select id="subject" name="subject" required>
                                    <option value="">{{ __('website.contact.select_topic') }}</option>
                                    <option value="product">{{ __('website.contact.product_inquiry') }}</option>
                                    <option value="quote">{{ __('website.contact.quote') }}</option>
                                    <option value="installation">{{ __('website.contact.installation') }}</option>
                                    <option value="maintenance">{{ __('website.contact.maintenance') }}</option>
                                    <option value="other">{{ __('website.contact.other') }}</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">{{ __('website.contact.message') }}</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="submit-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            {{ __('website.contact.send_message') }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Location Map -->
            <div class="location-map-wrapper">
                <div class="location-map-card">
                    <h2 class="map-title">{{ __('website.contact.our_location') }}</h2>
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.3689582876394!2d31.32447547588555!3d30.08634401883173!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583e5f0a8c5e23%3A0x5e3b3f3e3e3e3e3e!2s40%20El-Moltaka%20Al-Arabi%2C%20Sheraton%20Al%20Matar%2C%20El%20Nozha%2C%20Cairo%20Governorate!5e0!3m2!1sen!2seg!4v1703000000000!5m2!1sen!2seg"
                            width="100%" 
                            height="100%" 
                            style="border:0; border-radius: 15px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <div class="map-footer">
                        <i class="fas fa-map-marker-alt"></i>
                        <a href="{{ config('website.contact.maps_link') }}" target="_blank" rel="noopener noreferrer" style="color: #0C2D1C; font-weight: 600; text-decoration: none;">
                            {{ $data['contact']['address'] }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Form and Map Side by Side */
.contact-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    align-items: start;
}

.contact-form-wrapper,
.location-map-wrapper {
    width: 100%;
}

/* Location Map Styles */
.location-map-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(140, 198, 63, 0.1);
    height: 100%;
}

.map-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #0C2D1C;
    margin-bottom: 1.5rem;
    text-align: center;
}

.map-container {
    width: 100%;
    height: 450px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
}

.map-footer {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(140, 198, 63, 0.2);
}

.map-footer i {
    color: #FFDF41;
    font-size: 1.25rem;
}

.map-footer p {
    color: #0C2D1C;
    font-weight: 600;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .contact-wrapper {
        grid-template-columns: 1fr;
    }
    
    .contact-methods {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .location-map-card {
        padding: 1.5rem;
    }
    
    .map-title {
        font-size: 1.25rem;
    }
    
    .map-container {
        height: 300px;
    }
}
</style>

<!-- Contact Information Section -->
<section class="contact-info-section">
    <div class="container">
        <div class="contact-methods">
            <div class="contact-method">
                <div class="contact-method-icon contact-method-icon-phone">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="contact-method-content">
                    <h3>{{ __('website.contact.phone') }}</h3>
                    <a href="tel:{{ $data['contact']['phone'] }}">{{ $data['contact']['phone'] }}</a>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-method-icon contact-method-icon-whatsapp">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="contact-method-content">
                    <h3>{{ __('website.contact.whatsapp') }}</h3>
                    <a href="https://wa.me/{{ str_replace(['+', ' '], '', $data['contact']['whatsapp']) }}" target="_blank">{{ $data['contact']['whatsapp'] }}</a>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-method-icon contact-method-icon-gmail">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="contact-method-content">
                    <h3>{{ __('website.contact.email') }}</h3>
                    <a href="mailto:{{ $data['contact']['email'] }}">{{ $data['contact']['email'] }}</a>
                </div>
            </div>
            
            <div class="contact-method">
                <div class="contact-method-icon contact-method-icon-location">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="contact-method-content">
                    <h3>{{ __('website.contact.location') }}</h3>
                    <p>{{ $data['contact']['address'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.contact-info-section {
    padding: 3rem 0;
    background: #F9FAFB;
}

.contact-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.contact-method {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-method:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.contact-method-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.contact-method-icon-phone {
    background: linear-gradient(135deg, #FFDF41 0%, #E3A000 100%);
    color: #0C2D1C;
}

.contact-method-icon-whatsapp {
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: white;
}

.contact-method-icon-gmail {
    background: linear-gradient(135deg, #EA4335 0%, #C5221F 100%);
    color: white;
}

.contact-method-icon-location {
    background: linear-gradient(135deg, #8CC63F 0%, #115F45 100%);
    color: white;
}

.contact-method-content {
    text-align: left;
}

.contact-method-content h3 {
    font-size: 0.9rem;
    color: #6B7280;
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.contact-method-content a,
.contact-method-content p {
    font-size: 1rem;
    color: #0C2D1C;
    font-weight: 700;
    text-decoration: none;
    margin: 0;
}

.contact-method-content a:hover {
    color: #FFDF41;
}

@media (max-width: 1024px) {
    .contact-methods {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .contact-info-section {
        padding: 2rem 0;
    }
    
    .contact-methods {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
}
</style>

<!-- Let's Talk Section -->
<section class="lets-talk-section">
    <div class="container">
        <div class="lets-talk-content">
            <h2 class="lets-talk-title">{{ __('website.contact.lets_talk') }}</h2>
            <p class="lets-talk-text">{{ __('website.contact.have_questions') }}</p>
        </div>
    </div>
</section>

<style>
.lets-talk-section {
    padding: 4rem 0;
    background: linear-gradient(135deg, rgba(140, 198, 63, 0.05) 0%, rgba(17, 95, 69, 0.05) 100%);
}

.lets-talk-content {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.lets-talk-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #0C2D1C;
    margin-bottom: 1.5rem;
}

.lets-talk-text {
    font-size: 1.25rem;
    color: #6B7280;
    line-height: 1.8;
}

@media (max-width: 768px) {
    .lets-talk-section {
        padding: 3rem 0;
    }
    
    .lets-talk-title {
        font-size: 1.75rem;
    }
    
    .lets-talk-text {
        font-size: 1.1rem;
    }
}
</style>

<!-- Call to Action Banner -->
<section class="cta-banner">
    <div class="container">
        <div class="cta-content">
            <div class="cta-text">
                <h2>{{ __('website.contact.prefer_talk') }}</h2>
                <p>{{ __('website.contact.team_available') }}</p>
            </div>
            
            <div class="cta-buttons">
                <a href="tel:{{ $data['contact']['phone'] }}" class="cta-btn cta-btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    {{ __('website.contact.call_now') }}
                </a>
                
                <a href="https://wa.me/{{ str_replace(['+', ' '], '', $data['contact']['whatsapp']) }}" class="cta-btn cta-btn-secondary" target="_blank">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    {{ __('website.contact.whatsapp') }}
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
