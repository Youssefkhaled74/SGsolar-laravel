<div class="language-switcher">
    <a href="{{ route('locale.switch', 'en') }}" 
       class="lang-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}"
       title="English">
        <img src="https://flagcdn.com/w40/us.png" alt="US Flag" class="lang-flag-img">
        <span class="sr-only">English</span>
    </a>
    <span class="lang-separator">|</span>
    <a href="{{ route('locale.switch', 'ar') }}" 
       class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}"
       title="العربية">
        <img src="https://flagcdn.com/w40/eg.png" alt="Egypt Flag" class="lang-flag-img">
        <span class="sr-only">العربية</span>
    </a>
</div>
