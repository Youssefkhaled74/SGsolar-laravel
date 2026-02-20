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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SgSolar CRM - @yield('title', 'Leads')</title>

    <link rel="stylesheet" href="{{ asset('crm/crm.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --crm-font: "Manrope";
            --brand-yellow: {{ config('website.primary_color', '#FFDF41') }};
            --brand-orange: {{ config('website.secondary_color', '#E3A000') }};
            --brand-dark: {{ config('website.dark_green', '#0C2D1C') }};
            --brand-forest: {{ config('website.forest_green', '#115F45') }};
            --brand-light: {{ config('website.light_green', '#8CC63F') }};
        }

        .dark {
            --bg-0:#070B12;
            --bg-1:#0A1220;
            --dash-border:rgba(255,255,255,.10);
            --dash-text:rgba(255,255,255,.92);
            --dash-muted:rgba(255,255,255,.62);
            --glass: rgba(0,0,0,.18);
            --shadow: 0 22px 60px rgba(0,0,0,.35);
            --btn-ghost-bg: rgba(255,255,255,.04);
            --btn-ghost-border: rgba(255,255,255,.14);
            --btn-ghost-color: rgba(255,255,255,.86);
            --nav-hover-bg: rgba(255,255,255,.05);
        }

        html:not(.dark) {
            --bg-0:#FFFFFF;
            --bg-1:#F8F9FA;
            --dash-border:rgba(0,0,0,.12);
            --dash-text:rgba(0,0,0,.95);
            --dash-muted:rgba(0,0,0,.70);
            --glass: rgba(255,255,255,.95);
            --shadow: 0 4px 12px rgba(0,0,0,.08);
            --btn-ghost-bg: rgba(0,0,0,.05);
            --btn-ghost-border: rgba(0,0,0,.18);
            --btn-ghost-color: rgba(0,0,0,.92);
            --nav-hover-bg: rgba(0,0,0,.08);
        }

        *{box-sizing:border-box}
        body{
            margin:0;
            font-family: var(--crm-font), system-ui, -apple-system, "Segoe UI", Roboto, Arial;
            color: var(--dash-text);
            -webkit-font-smoothing:antialiased;
            overflow-x:hidden;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .dark body {
            background:
                radial-gradient(1100px 650px at 18% 10%, rgba(140,198,63,.10), transparent 55%),
                radial-gradient(1000px 600px at 86% 12%, rgba(255,223,65,.10), transparent 55%),
                linear-gradient(180deg, var(--bg-0), var(--bg-1));
        }

        html:not(.dark) body {
            background:
                radial-gradient(1100px 650px at 18% 10%, rgba(140,198,63,.04), transparent 55%),
                radial-gradient(1000px 600px at 86% 12%, rgba(255,223,65,.04), transparent 55%),
                linear-gradient(180deg, #FFFFFF, #F8F9FA);
        }

        .crm-standalone{
            min-height:100vh;
            padding:18px 16px 28px;
        }
        .crm-container{max-width:1400px;margin:0 auto}

        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 14px;
            border: 1px solid var(--dash-border);
            background: var(--btn-ghost-bg);
            color: var(--dash-text);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
        }
        .theme-toggle:hover {
            background: var(--nav-hover-bg);
            transform: rotate(20deg);
        }

        .topline{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            margin-bottom:14px;
            flex-wrap:wrap;
        }
        .title{
            font-weight:900;
            font-size:20px;
        }
        .subtitle{
            font-size:12px;
            font-weight:800;
            color: var(--dash-muted);
            margin-top:4px;
        }
    </style>
    @stack('head')
</head>
<body>
    <main class="crm-standalone">
        <div class="crm-container">
            <div class="topline">
                <div>
                    <div class="title">@yield('title', 'Leads')</div>
                    <div class="subtitle">@yield('subtitle')</div>
                </div>
                <button @click="toggleTheme()" class="theme-toggle" aria-label="Toggle theme" title="Toggle dark/light mode">
                    <span x-show="darkMode">🌙</span>
                    <span x-show="!darkMode" x-cloak>☀️</span>
                </button>
            </div>

            @yield('content')
        </div>
    </main>
    @stack('scripts')
</body>
</html>

