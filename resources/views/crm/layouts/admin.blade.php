<!doctype html>
<html lang="en" x-data="{ 
    sidebarOpen:false,
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
    <title>SgSolar CRM - @yield('title', 'Dashboard')</title>

    <link rel="stylesheet" href="{{ asset('crm/crm.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Professional font -->
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

        /* Dark Mode Variables */
        .dark {
            --bg-0:#070B12;
            --bg-1:#0A1220;
            --dash-border:rgba(255,255,255,.10);
            --dash-text:rgba(255,255,255,.92);
            --dash-muted:rgba(255,255,255,.62);
            --glass: rgba(0,0,0,.18);
            --glass2: rgba(0,0,0,.14);
            --shadow: 0 22px 60px rgba(0,0,0,.35);
            --shadow2: 0 12px 26px rgba(0,0,0,.22);
            --sidebar-bg: rgba(0,0,0,.24);
            --topbar-bg: rgba(0,0,0,.18);
            --btn-ghost-bg: rgba(255,255,255,.04);
            --btn-ghost-border: rgba(255,255,255,.14);
            --btn-ghost-color: rgba(255,255,255,.86);
            --nav-hover-bg: rgba(255,255,255,.05);
            --nav-hover-border: rgba(255,255,255,.06);
        }

        /* Light Mode Variables */
        html:not(.dark) {
            --bg-0:#FFFFFF;
            --bg-1:#F8F9FA;
            --dash-border:rgba(0,0,0,.12);
            --dash-text:rgba(0,0,0,.95);
            --dash-muted:rgba(0,0,0,.70);
            --glass: rgba(255,255,255,.95);
            --glass2: rgba(255,255,255,.98);
            --shadow: 0 4px 12px rgba(0,0,0,.08);
            --shadow2: 0 2px 8px rgba(0,0,0,.06);
            --sidebar-bg: #FFFFFF;
            --topbar-bg: rgba(255,255,255,.95);
            --btn-ghost-bg: rgba(0,0,0,.05);
            --btn-ghost-border: rgba(0,0,0,.18);
            --btn-ghost-color: rgba(0,0,0,.92);
            --nav-hover-bg: rgba(0,0,0,.08);
            --nav-hover-border: rgba(0,0,0,.12);
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

        /* Dark mode background */
        .dark body {
            background:
                radial-gradient(1100px 650px at 18% 10%, rgba(140,198,63,.10), transparent 55%),
                radial-gradient(1000px 600px at 86% 12%, rgba(255,223,65,.10), transparent 55%),
                linear-gradient(180deg, var(--bg-0), var(--bg-1));
        }

        /* Light mode background */
        html:not(.dark) body {
            background:
                radial-gradient(1100px 650px at 18% 10%, rgba(140,198,63,.04), transparent 55%),
                radial-gradient(1000px 600px at 86% 12%, rgba(255,223,65,.04), transparent 55%),
                linear-gradient(180deg, #FFFFFF, #F8F9FA);
        }

        /* Subtle animated background - dark mode only */
        .dark .app-bg{position:fixed; inset:0; z-index:-2; overflow:hidden}
        .dark .app-bg::before{
            content:"";
            position:absolute; inset:-40%;
            background:
                radial-gradient(circle at 18% 18%, rgba(140,198,63,.16), transparent 40%),
                radial-gradient(circle at 84% 20%, rgba(255,223,65,.16), transparent 42%),
                radial-gradient(circle at 70% 88%, rgba(227,160,0,.10), transparent 45%),
                radial-gradient(circle at 28% 86%, rgba(17,95,69,.12), transparent 45%);
            filter: blur(18px);
            animation: appDrift 18s ease-in-out infinite alternate;
        }
        .dark .app-bg::after{
            content:"";
            position:absolute; inset:0;
            background-image:
                linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 44px 44px;
            opacity:.08;
            mask-image: radial-gradient(closest-side at 50% 35%, black 0%, transparent 72%);
            pointer-events:none;
        }
        
        /* Light mode - no animated background */
        html:not(.dark) .app-bg {
            display: none;
        }
        
        @keyframes appDrift{
            0%   { transform: translate3d(-1.5%, -1%, 0) scale(1.02) rotate(-.5deg); }
            50%  { transform: translate3d( 1.5%,  1.5%, 0) scale(1.06) rotate( .5deg); }
            100% { transform: translate3d( 1%,  -1.5%, 0) scale(1.03) rotate( 0deg); }
        }

        /* Shell */
        .crm-shell{display:grid;grid-template-columns:280px 1fr;min-height:100vh}
        @media(max-width:1023px){ .crm-shell{grid-template-columns:1fr} }

        /* Sidebar (dark glass) */
        .crm-sidebar{
            background: var(--sidebar-bg) !important;
            border-right:1px solid var(--dash-border);
            box-shadow: var(--shadow2);
            backdrop-filter: blur(10px);
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .crm-brand{
            display:flex;align-items:center;gap:10px;
            font-weight:900;
        }
        .brand-logo{
            width:36px;height:36px;border-radius:14px;
            border:1px solid var(--dash-border);
            background: rgba(255,255,255,.06);
            display:flex;align-items:center;justify-content:center;
            overflow:hidden;
        }
        .brand-logo img{width:100%;height:100%;object-fit:contain;padding:6px;filter: drop-shadow(0 8px 12px rgba(0,0,0,.35));}
        .brand-meta small{color:var(--dash-muted) !important; font-weight:800}

        .crm-nav-item{
            border:1px solid transparent !important;
            background: transparent !important;
            color: var(--dash-text) !important;
            font-weight:800;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .crm-nav-item:hover{
            background: var(--nav-hover-bg) !important;
            border-color: var(--nav-hover-border) !important;
        }
        .crm-nav-item.active{
            background: linear-gradient(135deg, rgba(255,223,65,.16), rgba(227,160,0,.10)) !important;
            border-color: rgba(255,223,65,.22) !important;
            color: var(--dash-text) !important;
        }

        /* Topbar (glass) */
        .crm-topbar{
            background: var(--topbar-bg) !important;
            border-bottom:1px solid var(--dash-border) !important;
            backdrop-filter: blur(10px);
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .crm-topbar .page-title{color: var(--dash-text) !important; font-weight:900}
        .crm-topbar .subtitle{color: var(--dash-muted) !important; font-weight:800}

        /* Main content container */
        .crm-content{padding:22px 18px !important}
        .crm-container{max-width:1200px;margin:0 auto}

        /* Buttons to match theme */
        .crm-btn{border-radius:14px !important; font-weight:900 !important}
        .crm-btn.crm-btn-primary{
            background: linear-gradient(135deg, var(--brand-yellow) 0%, var(--brand-orange) 100%) !important;
            color:#0b122a !important;
            box-shadow: 0 18px 34px rgba(227,160,0,0.18);
        }
        .crm-btn.crm-btn-primary:hover{filter:brightness(.98)}
        .crm-btn.crm-btn-ghost{
            background: var(--btn-ghost-bg) !important;
            border:1px solid var(--btn-ghost-border) !important;
            color: var(--btn-ghost-color) !important;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .crm-btn.crm-btn-ghost:hover{background: var(--nav-hover-bg) !important}

        /* Logout button already has crm-logout; make it match */
        .crm-logout{
            background: var(--btn-ghost-bg) !important;
            border:1px solid var(--btn-ghost-border) !important;
            color: var(--btn-ghost-color) !important;
            border-radius:14px !important;
            font-weight:900 !important;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        /* Avatar */
        .crm-avatar{
            background: var(--glass) !important;
            border:1px solid var(--dash-border);
            color: var(--dash-text) !important;
            border-radius:14px !important;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        /* Offcanvas */
        .crm-overlay{background: rgba(0,0,0,0.55) !important}
        .crm-offcanvas{
            background: var(--sidebar-bg) !important;
            border-right:1px solid var(--dash-border);
            backdrop-filter: blur(10px);
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        [x-cloak]{display:none!important}

        /* Icon button */
        .icon-btn{
            width:40px;height:40px;border-radius:14px;
            border:1px solid var(--dash-border);
            background: var(--btn-ghost-bg);
            color: var(--dash-text);
            cursor:pointer;
            transition: background 0.3s ease, border-color 0.3s ease;
        }
        .icon-btn:hover{background: var(--nav-hover-bg)}
        .muted{color:var(--dash-muted)!important}

        /* Theme toggle button */
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
    </style>
</head>

<body>
    <div class="app-bg" aria-hidden="true"></div>

    <div class="crm-shell">
        <!-- Desktop sidebar -->
        <aside class="crm-sidebar" aria-hidden="false">
            <div class="crm-brand">
                <div class="brand-logo">
                    <img src="{{ asset('png/SG-013.png') }}" alt="SgSolar CRM Logo">
                </div>
                <div class="brand-meta">
                    <div style="font-weight:900">SgSolar CRM</div>
                    <small>Admin</small>
                </div>
            </div>

            <nav class="crm-nav" role="navigation" aria-label="Main">
                <a href="{{ route('crm.admin.dashboard') }}" class="crm-nav-item {{ request()->routeIs('crm.admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('crm.admin.leads.index') }}" class="crm-nav-item {{ request()->routeIs('crm.admin.leads.*') ? 'active' : '' }}">
                    Leads
                </a>

                <a href="{{ route('crm.leads.create') }}" class="crm-nav-item {{ request()->routeIs('crm.leads.create') ? 'active' : '' }}">
                    Add New Lead
                </a>

                <a href="{{ route('crm.admin.users.index') }}" class="crm-nav-item {{ request()->routeIs('crm.admin.users.*') ? 'active' : '' }}">
                    Users
                </a>

                <a href="{{ route('crm.admin.settings.index') }}" class="crm-nav-item {{ request()->routeIs('crm.admin.settings.*') ? 'active' : '' }}">
                    Settings
                </a>
            </nav>

            <div class="crm-nav-footer">
                <div class="text-sm muted">Version 1</div>
            </div>
        </aside>

        <!-- Mobile off-canvas sidebar -->
        <div x-bind:data-show="sidebarOpen" x-show="sidebarOpen" x-cloak class="crm-overlay" @click="sidebarOpen = false"></div>

        <aside x-bind:data-open="sidebarOpen" class="crm-offcanvas" x-cloak>
            <div style="padding:18px;display:flex;align-items:center;justify-content:space-between;gap:12px">
                <div class="crm-brand" style="gap:10px">
                    <div class="brand-logo">
                        <img src="{{ asset('png/SG-013.png') }}" alt="SgSolar CRM Logo">
                    </div>
                    <div style="font-weight:900;color:rgba(255,255,255,.92)">SgSolar CRM</div>
                </div>

                <button @click="sidebarOpen = false" aria-label="Close sidebar" class="icon-btn">✕</button>
            </div>

            <nav style="padding:0 12px;margin-top:12px;display:flex;flex-direction:column;gap:6px">
                <a href="{{ route('crm.admin.dashboard') }}" @click="sidebarOpen = false" class="crm-nav-item {{ request()->routeIs('crm.admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('crm.admin.leads.index') }}" @click="sidebarOpen = false" class="crm-nav-item {{ request()->routeIs('crm.admin.leads.*') ? 'active' : '' }}">Leads</a>
                <a href="{{ route('crm.admin.users.index') }}" @click="sidebarOpen = false" class="crm-nav-item {{ request()->routeIs('crm.admin.users.*') ? 'active' : '' }}">Users</a>
                <a href="{{ route('crm.admin.settings.index') }}" @click="sidebarOpen = false" class="crm-nav-item {{ request()->routeIs('crm.admin.settings.*') ? 'active' : '' }}">Settings</a>
            </nav>
        </aside>

        <!-- Main column -->
        <div class="crm-main-column">
            <header class="crm-topbar">
                <div class="left">
                    <button @click="sidebarOpen = true" aria-label="Open sidebar" class="icon-btn">☰</button>

                    <div>
                        <div class="page-title">@yield('title', 'Dashboard')</div>
                        <div class="subtitle">@yield('subtitle')</div>
                    </div>
                </div>

                <div class="crm-user">
                    <!-- Theme Toggle Button -->
                    <button @click="toggleTheme()" class="theme-toggle" aria-label="Toggle theme" title="Toggle dark/light mode">
                        <span x-show="darkMode">🌙</span>
                        <span x-show="!darkMode" x-cloak>☀️</span>
                    </button>

                    <div style="text-align:right">
                        <div class="name" style="color:var(--dash-text);font-weight:900">
                            {{ optional(Auth::user())->name ?? 'Guest' }}
                        </div>
                        <div class="text-sm muted">
                            {{ data_get(optional(Auth::user())->role, 'name', optional(Auth::user())->role ?? '') }}
                        </div>
                    </div>

                    <div class="crm-avatar">{{ strtoupper(substr(optional(Auth::user())->name ?? 'G',0,1)) }}</div>

                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button class="crm-btn crm-btn-ghost crm-logout" type="submit">Logout</button>
                    </form>
                </div>
            </header>

            <main class="crm-content">
                <div class="crm-container">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @include('crm.partials.add-lead-modal')
</body>
</html>
