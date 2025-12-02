<div class="language-switcher">
    <a href="{{ route('locale.switch', 'en') }}" 
       class="lang-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}"
       title="English">
        EN
    </a>
    <span class="lang-separator">|</span>
    <a href="{{ route('locale.switch', 'ar') }}" 
       class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}"
       title="العربية">
        AR
    </a>
</div>
