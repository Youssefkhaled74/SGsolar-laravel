<div class="language-switcher">
    <a href="{{ route('locale.switch', 'en') }}" 
       class="lang-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}"
       title="English">
        <span class="lang-flag" aria-hidden="true">🇺🇸</span>
        <span class="sr-only">English</span>
    </a>
    <span class="lang-separator">|</span>
    <a href="{{ route('locale.switch', 'ar') }}" 
       class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}"
       title="العربية">
        <span class="lang-flag" aria-hidden="true">🇪🇬</span>
        <span class="sr-only">العربية</span>
    </a>
</div>
