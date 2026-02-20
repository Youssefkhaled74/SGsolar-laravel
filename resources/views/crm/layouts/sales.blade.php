<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark' || !localStorage.getItem('theme'),
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', this.darkMode);
    }
}" x-init="document.documentElement.classList.toggle('dark', darkMode)">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title>@yield('title', __('crm_sales.layout.title'))</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ===== Sales Layout Theme Variables ===== */
        :root{
            --brand-yellow: {{ config('website.primary_color', '#FFDF41') }};
            --brand-orange: {{ config('website.secondary_color', '#E3A000') }};
            --brand-light:  {{ config('website.light_green', '#8CC63F') }};
        }

        /* Dark Mode */
        .dark {
            --s-border:rgba(255,255,255,.10);
            --s-text:rgba(255,255,255,.92);
            --s-muted:rgba(255,255,255,.62);
            --s-bg0:#070B12;
            --s-bg1:#0A1220;
            --topbar-bg: rgba(0,0,0,.35);
            --nav-bg: rgba(255,255,255,.04);
            --nav-border: rgba(255,255,255,.12);
            --nav-color: rgba(255,255,255,.88);
            --nav-hover-bg: rgba(255,255,255,.07);
        }

        /* Light Mode */
        html:not(.dark) {
            --s-border:rgba(0,0,0,.12);
            --s-text:rgba(0,0,0,.95);
            --s-muted:rgba(0,0,0,.70);
            --s-bg0:#FFFFFF;
            --s-bg1:#F8F9FA;
            --topbar-bg: rgba(255,255,255,.95);
            --nav-bg: rgba(0,0,0,.05);
            --nav-border: rgba(0,0,0,.18);
            --nav-color: rgba(0,0,0,.92);
            --nav-hover-bg: rgba(0,0,0,.10);
        }

        body{
            margin:0;
            color: var(--s-text);
            font-family: "Manrope", "Segoe UI", Roboto, Arial, system-ui, sans-serif;
            transition: background 0.3s ease, color 0.3s ease;
        }
        html[dir="rtl"] body{
            font-family: "Cairo", "Tahoma", "Segoe UI", Arial, system-ui, sans-serif;
        }

        /* Dark mode background */
        .dark body {
            background: radial-gradient(1200px 700px at 18% 10%, rgba(140,198,63,.14), transparent 60%),
                        radial-gradient(1100px 680px at 86% 18%, rgba(255,223,65,.14), transparent 60%),
                        radial-gradient(900px 680px at 72% 92%, rgba(227,160,0,.10), transparent 60%),
                        linear-gradient(180deg, var(--s-bg0), var(--s-bg1));
        }

        /* Light mode background */
        html:not(.dark) body {
            background: radial-gradient(1200px 700px at 18% 10%, rgba(140,198,63,.04), transparent 60%),
                        radial-gradient(1100px 680px at 86% 18%, rgba(255,223,65,.04), transparent 60%),
                        linear-gradient(180deg, #FFFFFF, #F8F9FA);
        }

        a{color: var(--s-text); text-decoration:none}
        a:hover{text-decoration:underline}

        .sales-topbar{
            position:sticky; top:0; z-index:50;
            border-bottom:1px solid var(--s-border);
            background: var(--topbar-bg);
            backdrop-filter: blur(12px);
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        .sales-topbar-inner{
            max-width:1200px;
            margin:0 auto;
            padding:12px 16px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            flex-wrap:wrap;
        }

        .brand{
            display:flex; align-items:center; gap:10px;
            font-weight:700;
            letter-spacing:.2px;
        }
        .brand-badge{
            width:34px;height:34px;border-radius:12px;
            border:1px solid var(--s-border);
            background: var(--nav-bg);
            display:flex;align-items:center;justify-content:center;
            font-weight:700;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .brand small{display:block; font-weight:600; color:var(--s-muted); margin-top:2px}

        .sales-nav{
            display:flex; gap:8px; flex-wrap:wrap; align-items:center;
        }
        .nav-link{
            padding:9px 12px;
            border-radius:12px;
            border:1px solid var(--nav-border);
            background: var(--nav-bg);
            color: var(--nav-color);
            font-weight:600;
            text-decoration:none!important;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .nav-link:hover{background: var(--nav-hover-bg)}
        .nav-link.primary{
            background: linear-gradient(135deg, var(--brand-yellow) 0%, var(--brand-orange) 100%);
            color:#0b122a!important;
            border:1px solid rgba(255,255,255,.10);
            box-shadow: 0 18px 34px rgba(227,160,0,0.18);
        }

        .userbox{
            display:flex; align-items:center; gap:10px; flex-wrap:wrap;
            color: var(--s-text);
            font-weight:600;
        }
        .avatar{
            width:34px;height:34px;border-radius:12px;
            border:1px solid var(--s-border);
            background: var(--nav-bg);
            display:flex;align-items:center;justify-content:center;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .logout-btn{
            padding:9px 12px;
            border-radius:12px;
            border:1px solid var(--nav-border);
            background: var(--nav-bg);
            color: var(--nav-color);
            font-weight:600;
            cursor:pointer;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .logout-btn:hover{background: var(--nav-hover-bg)}

        .lang-switch{display:flex;gap:6px;align-items:center}
        .lang-link{
            padding:7px 10px;
            border-radius:10px;
            border:1px solid var(--nav-border);
            background: var(--nav-bg);
            color: var(--nav-color);
            text-decoration:none !important;
            font-weight:600;
            font-size:12px;
            line-height:1;
        }
        .lang-link.active{
            border-color: rgba(255,223,65,.40);
            box-shadow: 0 0 0 3px rgba(255,223,65,.12);
        }

        /* Theme toggle button */
        .theme-toggle {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            border: 1px solid var(--s-border);
            background: var(--nav-bg);
            color: var(--s-text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        .theme-toggle:hover {
            background: var(--nav-hover-bg);
            transform: rotate(20deg);
        }
        [x-cloak]{display:none!important}

        .sales-container{
            max-width:1200px;
            margin:0 auto;
            padding:18px 16px 28px;
        }

        /* لو crm-btn موجود عندك في global css، ده هيظبطه لو مش موجود */
        .crm-btn{
            display:inline-flex;align-items:center;justify-content:center;
            gap:8px;
            padding:10px 12px;
            border-radius:12px;
            font-weight:600;
            border:1px solid var(--nav-border);
            background: var(--nav-bg);
            color: var(--nav-color);
            text-decoration:none!important;
            cursor:pointer;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .crm-btn:hover{background: var(--nav-hover-bg)}
        .crm-btn-primary{
            background: linear-gradient(135deg, var(--brand-yellow) 0%, var(--brand-orange) 100%) !important;
            color:#0b122a !important;
            border:1px solid rgba(255,255,255,.10) !important;
        }
        .crm-btn-ghost{
            background: var(--nav-bg) !important;
            border:1px solid var(--nav-border) !important;
            color: var(--nav-color) !important;
        }
        html[dir="rtl"] .brand,
        html[dir="rtl"] .nav-link,
        html[dir="rtl"] .userbox,
        html[dir="rtl"] .logout-btn,
        html[dir="rtl"] .crm-btn{
            font-weight:700;
            letter-spacing:0;
        }
    </style>

    @stack('head')
</head>
<body>
    <header class="sales-topbar">
        <div class="sales-topbar-inner">
            <div class="brand">
                <div class="brand-badge">CRM</div>
                <div>
                    {{ __('crm_sales.layout.title') }}
                    <small>{{ __('crm_sales.layout.subtitle') }}</small>
                </div>
            </div>

            <nav class="sales-nav">
                <a class="nav-link primary" href="{{ route('crm.sales.dashboard') }}">{{ __('crm_sales.layout.nav_dashboard') }}</a>
                <a class="nav-link" href="{{ route('crm.sales.leads.index') }}">{{ __('crm_sales.layout.nav_my_leads') }}</a>
                <a class="nav-link" href="{{ route('crm.sales.leads.create') }}">{{ __('crm_sales.layout.nav_add_lead') }}</a>
                <a class="nav-link" href="{{ route('crm.sales.followups.index') }}">{{ __('crm_sales.layout.nav_followups') }}</a>
            </nav>

            <div class="userbox">
                <!-- Theme Toggle Button -->
                <button @click="toggleTheme()" class="theme-toggle" aria-label="{{ __('crm_sales.layout.toggle_theme') }}" title="{{ __('crm_sales.layout.toggle_theme') }}">
                    <span x-show="darkMode">&#9790;</span>
                    <span x-show="!darkMode" x-cloak>&#9728;</span>
                </button>

                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                </div>
                <div>{{ auth()->user()->name ?? 'Sales' }}</div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">{{ __('crm_sales.layout.logout') }}</button>
                </form>
                <div class="lang-switch">
                    <a href="{{ route('locale.switch', ['locale' => 'en']) }}" class="lang-link {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                    <a href="{{ route('locale.switch', ['locale' => 'ar']) }}" class="lang-link {{ app()->getLocale() === 'ar' ? 'active' : '' }}">AR</a>
                </div>
            </div>
        </div>
    </header>

    <main class="sales-container">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>


