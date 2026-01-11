@extends('layouts.app')

@section('title', $title ?? 'Sales')

@section('content')
<div class="flex min-h-screen">
    <aside class="w-64 bg-white border-r">
        <div class="p-4 text-xl font-bold">Sales</div>
        <nav class="p-4 space-y-2">
            <a href="{{ route('sales.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Dashboard</a>
            <a href="{{ route('sales.leads.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">My Leads</a>
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">Followups Today</a>
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">Orders</a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="bg-white border-b p-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button class="text-gray-600 lg:hidden">☰</button>
                @include('components.page-header', ['title' => $title ?? 'Sales Dashboard'])
            </div>

            <div class="flex items-center gap-4">
                <div class="text-sm">{{ optional(Auth::user())->name ?? 'Guest' }}</div>
                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button class="text-sm text-red-600">Logout</button>
                </form>
            </div>
        </header>

        <main class="p-6 flex-1 bg-gray-50">
            @yield('sales-content')
        </main>
    </div>
</div>
@endsection
