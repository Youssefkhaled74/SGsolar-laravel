<!doctype html>
<html lang="en" x-data="{ sidebarOpen:false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SG Solar CRM - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('crm/crm.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <div class="crm-shell">
        <!-- Desktop sidebar -->
        <aside class="crm-sidebar" aria-hidden="false">
            <div class="crm-brand">
                <div>SG Solar CRM</div>
                <small>Admin</small>
            </div>

            <nav class="crm-nav" role="navigation" aria-label="Main">
                <a href="{{ route('crm.admin.dashboard') }}" class="crm-nav-item {{ request()->routeIs('crm.admin.dashboard') ? 'active' : '' }}">
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('crm.admin.leads.index') }}" class="crm-nav-item {{ request()->routeIs('crm.admin.leads.*') ? 'active' : '' }}">Leads</a>
                <a href="{{ route('crm.admin.users.index') }}" class="crm-nav-item {{ request()->routeIs('crm.admin.users.*') ? 'active' : '' }}">Users</a>
                <a href="{{ route('crm.admin.settings.index') }}" class="crm-nav-item {{ request()->routeIs('crm.admin.settings.*') ? 'active' : '' }}">Settings</a>
            </nav>

            <div class="crm-nav-footer">
                <div class="text-sm muted">Version 1</div>
            </div>
        </aside>

        <!-- Mobile off-canvas sidebar -->
        <div x-bind:data-show="sidebarOpen" x-show="sidebarOpen" x-cloak class="crm-overlay" @click="sidebarOpen = false"></div>
        <aside x-bind:data-open="sidebarOpen" class="crm-offcanvas" x-cloak>
            <div style="padding:18px;display:flex;align-items:center;justify-content:space-between">
                <div class="crm-brand">SG Solar CRM</div>
                <button @click="sidebarOpen = false" aria-label="Close sidebar" style="background:transparent;border:none;color:var(--crm-sidebar-text);font-size:20px">✕</button>
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
                    <button @click="sidebarOpen = true" aria-label="Open sidebar" style="background:transparent;border:none;font-size:20px">☰</button>
                    <div>
                        <div class="page-title">@yield('title', 'Dashboard')</div>
                        <div class="subtitle">@yield('subtitle')</div>
                    </div>
                </div>

                <div class="crm-user">
                    <div style="text-align:right">
                        <div class="name">{{ optional(Auth::user())->name ?? 'Guest' }}</div>
                        <div class="text-sm muted">{{ optional(Auth::user())->role ?? '' }}</div>
                    </div>
                    <div class="crm-avatar">{{ strtoupper(substr(optional(Auth::user())->name ?? 'G',0,1)) }}</div>
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button class="crm-btn-ghost crm-logout" type="submit">Logout</button>
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
</body>
</html>
