<div class="language-switcher">
    @if(app()->getLocale() == 'ar')
        <a href="{{ route('locale.switch', 'en') }}" class="lang-btn" title="Switch to English">
            <span>English</span>
        </a>
    @else
        <a href="{{ route('locale.switch', 'ar') }}" class="lang-btn" title="التبديل إلى العربية">
            <span>عربي</span>
        </a>
    @endif
</div>
