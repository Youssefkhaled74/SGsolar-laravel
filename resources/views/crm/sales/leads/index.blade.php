@extends('crm.layouts.sales')

@section('title','My Leads')

@section('content')
@include('crm.sales.partials.theme')

@php
    $q = request('q');
@endphp

<div class="s-shell">
    <div class="s-bg" aria-hidden="true"></div>

    <div class="s-wrap">
        {{-- Header --}}
        <div class="s-head">
            <div style="min-width:260px;flex:1">
                <h3>My Leads</h3>
                <p>Search, open, and track your assigned leads.</p>

                <div style="margin-top:10px;display:flex;gap:10px;flex-wrap:wrap">
                    <span class="s-pill g"><span class="dot"></span>Assigned to you</span>
                    <span class="s-pill y"><span class="dot"></span>Total: {{ $leads->total() }}</span>
                </div>
            </div>

            <div class="s-actions">
                <a href="{{ route('crm.sales.followups.index') }}" class="crm-btn crm-btn-ghost">Followups</a>
                <a href="{{ route('crm.sales.dashboard') }}" class="crm-btn crm-btn-primary">Dashboard</a>
            </div>
        </div>

        {{-- Search + tips --}}
        <div class="s-card" style="margin-bottom:14px">
            <div class="s-card-head">
                <div>
                    <h4 class="s-card-title">Search</h4>
                    <div class="s-card-sub">Search by name, phone, or email.</div>
                </div>
                <div class="s-muted" style="font-size:12px;font-weight:800">
                    Tip: Press Enter to search.
                </div>
            </div>

            <form method="GET" action="{{ route('crm.sales.leads.index') }}"
                  style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
                <input
                    name="q"
                    value="{{ $q }}"
                    class="s-input"
                    placeholder="Search leads..."
                    style="flex:1;min-width:240px"
                />
                <button class="crm-btn crm-btn-primary">Search</button>

                @if($q)
                    <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-ghost">Reset</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="s-card">
            <div class="s-card-head">
                <div>
                    <h4 class="s-card-title">Leads List</h4>
                    <div class="s-card-sub">Open a lead to add comments, actions, and followups.</div>
                </div>
            </div>

            <div class="s-table-card" style="overflow-x:auto">
                <table class="s-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th style="width:120px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr>
                                <td class="s-strong">{{ $lead->name }}</td>
                                <td>{{ $lead->phone ?? '-' }}</td>
                                <td class="s-muted">{{ optional($lead->source)->name ?? '-' }}</td>
                                <td class="s-muted">{{ optional($lead->status)->name ?? '-' }}</td>
                                <td class="s-muted">{{ $lead->created_at ? $lead->created_at->format('Y-m-d') : '-' }}</td>
                                <td>
                                    <a href="{{ route('crm.sales.leads.show',$lead->id) }}" class="crm-btn crm-btn-ghost">Open</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="s-empty" style="margin:12px">
                                        No leads assigned to you right now.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="padding:12px 4px 0">
                {{ $leads->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

