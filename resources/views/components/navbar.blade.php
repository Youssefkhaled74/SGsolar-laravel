<nav class="navbar">
    <div class="container">
        <div class="navbar-wrapper">
            <div class="navbar-brand">
                <a href="/">
                    <x-logo />
                </a>
            </div>

            <button class="navbar-toggle" id="navToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="navbar-menu" id="navMenu">
                @foreach(config('website.menu') as $item)
                    <a href="{{ $item['url'] }}" class="navbar-link {{ request()->is(trim($item['url'], '/') ?: '/') ? 'active' : '' }}">
                        {{ $item['name'] }}
                    </a>
                @endforeach>
                
                <a href="/contact" class="btn btn-primary navbar-cta">Get a Quote</a>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
        });
    }
});
</script>
