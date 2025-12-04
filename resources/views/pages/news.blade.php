@extends('layouts.app')

@section('title', __('website.news.title'))

@section('content')
<!-- News Hero -->
<section class="news-hero">
    <div class="container">
        <h1 class="section-title">{{ __('website.news.title') }}</h1>
        <p class="section-subtitle">{{ __('website.news.subtitle') }}</p>
        <div class="hero-divider"></div>
    </div>
</section>

<!-- News Grid -->
<section class="news-section">
    <div class="container">
        <div class="news-grid">
            @foreach(__('website.news.articles') as $index => $article)
            <article class="news-card">
                <div class="news-card-header">
                    <div class="news-icon">
                        <i class="{{ $article['icon'] }}"></i>
                    </div>
                    <div class="news-meta">
                        <span class="news-category">{{ $article['category'] }}</span>
                        <span class="news-date">{{ $article['date'] }}</span>
                    </div>
                </div>
                
                <div class="news-content">
                    <h2 class="news-title">{{ $article['title'] }}</h2>
                    <p class="news-excerpt">{{ $article['excerpt'] }}</p>
                    
                    @if(isset($article['highlights']))
                    <div class="news-highlights">
                        @foreach($article['highlights'] as $highlight)
                        <div class="highlight-item">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ $highlight }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    
                    <button class="btn-read-more" onclick="openArticle({{ $index }})">
                        <span>{{ __('website.news.read_more') }}</span>
                        <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
                    </button>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Article Modal -->
<div class="article-modal" id="articleModal">
    <div class="article-modal-overlay" onclick="closeArticle()"></div>
    <div class="article-modal-content">
        <button class="modal-close" onclick="closeArticle()">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="article-full" id="articleContent">
            <!-- Content will be populated by JavaScript -->
        </div>
    </div>
</div>

<!-- Why Choose SG Solar CTA -->
<section class="news-cta">
    <div class="container">
        <div class="cta-card">
            <div class="cta-icon">
                <i class="fas fa-lightbulb"></i>
            </div>
            <h2>{{ __('website.news.cta_title') }}</h2>
            <p>{{ __('website.news.cta_text') }}</p>
            <div class="cta-guarantees">
                @foreach(__('website.news.cta_guarantees') as $guarantee)
                <div class="guarantee-item">
                    <i class="{{ $guarantee['icon'] }}"></i>
                    <h3>{{ $guarantee['title'] }}</h3>
                </div>
                @endforeach
            </div>
            <a href="{{ route('contact') }}" class="btn-cta">
                {{ __('website.news.cta_button') }}
                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}"></i>
            </a>
        </div>
    </div>
</section>

<script>
const articles = @json(__('website.news.articles'));

function openArticle(index) {
    const article = articles[index];
    const modal = document.getElementById('articleModal');
    const content = document.getElementById('articleContent');
    
    let fullContent = `
        <div class="article-header">
            <div class="article-icon">
                <i class="${article.icon}"></i>
            </div>
            <div class="article-meta-full">
                <span class="article-category">${article.category}</span>
                <span class="article-date">${article.date}</span>
            </div>
        </div>
        
        <h1 class="article-title-full">${article.title}</h1>
        
        <div class="article-body">
            ${article.full_content}
        </div>
    `;
    
    content.innerHTML = fullContent;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeArticle() {
    const modal = document.getElementById('articleModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeArticle();
    }
});
</script>

@endsection
