<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>CRM Sales - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('crm/crm.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased bg-gray-100 text-gray-800">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-white border-r hidden md:block">
            <div class="p-6 text-lg font-bold border-b">CRM Sales</div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('crm.sales.dashboard') }}" class="block px-3 py-2 rounded text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                <a href="{{ route('crm.sales.leads.index') }}" class="block px-3 py-2 rounded text-sm text-gray-700 hover:bg-gray-50">My Leads</a>
                <a href="{{ route('crm.leads.create') }}" class="block px-3 py-2 rounded text-sm text-gray-700 hover:bg-gray-50">Add New Lead</a>
                <a href="{{ route('crm.sales.followups.today') }}" class="block px-3 py-2 rounded text-sm text-gray-700 hover:bg-gray-50">Followups Today</a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b p-4 md:p-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-gray-600">☰</button>
                    <div>
                        <h1 class="text-lg font-semibold">@yield('title', 'Dashboard')</h1>
                        <p class="text-sm text-gray-500">Sales overview</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-700">{{ optional(Auth::user())->name ?? 'Guest' }}</div>
                    <form method="POST" action="{{ url('/logout') }}">
                        @csrf
                        <button class="text-sm text-red-600">Logout</button>
                    </form>
                </div>
            </header>

            <main class="p-4 md:p-6 bg-gray-50 flex-1">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @include('crm.partials.add-lead-modal')
</body>
</html>
