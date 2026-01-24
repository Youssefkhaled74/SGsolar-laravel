<!doctype html>
<html lang="en" x-data="{ 
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

    <title>@yield('title','CRM Sales')</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Apple Color Emoji","Segoe UI Emoji";
            transition: background 0.3s ease, color 0.3s ease;
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
            font-weight:900;
            letter-spacing:.2px;
        }
        .brand-badge{
            width:34px;height:34px;border-radius:12px;
            border:1px solid var(--s-border);
            background: var(--nav-bg);
            display:flex;align-items:center;justify-content:center;
            font-weight:900;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .brand small{display:block; font-weight:800; color:var(--s-muted); margin-top:2px}

        .sales-nav{
            display:flex; gap:8px; flex-wrap:wrap; align-items:center;
        }
        .nav-link{
            padding:9px 12px;
            border-radius:12px;
            border:1px solid var(--nav-border);
            background: var(--nav-bg);
            color: var(--nav-color);
            font-weight:900;
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
            font-weight:900;
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
            font-weight:900;
            cursor:pointer;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .logout-btn:hover{background: var(--nav-hover-bg)}

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
            font-weight:900;
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
    </style>

    @stack('head')
</head>
<body>
    <header class="sales-topbar">
        <div class="sales-topbar-inner">
            <div class="brand">
                <div class="brand-badge">CRM</div>
                <div>
                    CRM Sales
                    <small>Sales overview</small>
                </div>
            </div>

            <nav class="sales-nav">
                <a class="nav-link primary" href="{{ route('crm.sales.dashboard') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('crm.sales.leads.index') }}">My Leads</a>
                <a class="nav-link" href="{{ route('crm.sales.leads.create') }}">Add New Lead</a>
                <a class="nav-link" href="{{ route('crm.sales.followups.index') }}">Followups Today</a>
            </nav>

            <div class="userbox">
                <!-- Theme Toggle Button -->
                <button @click="toggleTheme()" class="theme-toggle" aria-label="Toggle theme" title="Toggle dark/light mode">
                    <span x-show="darkMode">🌙</span>
                    <span x-show="!darkMode" x-cloak>☀️</span>
                </button>

                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                </div>
                <div>{{ auth()->user()->name ?? 'Sales' }}</div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <main class="sales-container">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
