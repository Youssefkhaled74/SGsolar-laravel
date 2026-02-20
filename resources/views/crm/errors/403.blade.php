@extends('crm.layouts.admin')

@section('title', 'Access denied')

@section('content')
<div class="crm-403 text-center py-12">
    <div class="icon mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto" width="96" height="96" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><path d="M12 8v4" /><path d="M12 16h.01" /></svg>
    </div>
    <h1 class="text-3xl font-semibold mb-3">Access denied</h1>
    <p class="muted mb-6">Your account role is not configured for CRM access. Please contact your administrator.</p>

    <div class="space-x-3">
        <a href="{{ route('crm.login') }}" class="btn btn-primary">Go to CRM Login</a>

        @if(auth()->check())
            @php
                $rname = 'crm.home';
                $user = auth()->user();
                $roleName = is_string($user->role) ? $user->role : ($user->role->name ?? null);
            @endphp
            @if($roleName === 'admin')
                <a href="{{ route('crm.admin.dashboard') }}" class="btn btn-secondary">Go to Dashboard</a>
            @elseif($roleName === 'sales')
                <a href="{{ route('crm.sales.dashboard') }}" class="btn btn-secondary">Go to Dashboard</a>
            @endif
        @endif
    </div>
</div>
@endsection
