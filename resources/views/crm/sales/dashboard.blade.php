@extends('crm.layouts.sales')

@section('title', 'Sales Dashboard')

@section('content')
<style>
    [x-cloak]{display:none!important}

    :root{
        --brand-yellow: {{ config('website.primary_color', '#FFDF41') }};
        --brand-orange: {{ config('website.secondary_color', '#E3A000') }};
        --brand-light: {{ config('website.light_green', '#8CC63F') }};
    }

    /* Dark Mode Variables */
    .dark {
        --s-border:rgba(255,255,255,.10);
        --s-text:rgba(255,255,255,.92);
        --s-muted:rgba(255,255,255,.62);
        --s-card:rgba(0,0,0,.14);
        --s-card2:rgba(0,0,0,.10);
        --s-shadow: 0 22px 60px rgba(0,0,0,.35);
        --s-shadow2: 0 12px 26px rgba(0,0,0,.22);
        --s-shell-bg: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
        --s-head-bg: rgba(0,0,0,.14);
        --s-pill-bg: rgba(255,255,255,.05);
        --s-pill-border: rgba(255,255,255,.12);
        --s-pill-text: rgba(255,255,255,.78);
        --s-input-bg: rgba(255,255,255,.04);
        --s-input-border: rgba(255,255,255,.14);
        --s-input-color: rgba(255,255,255,.90);
        --s-input-placeholder: rgba(255,255,255,.55);
        --s-table-head-bg: rgba(255,255,255,.04);
        --s-table-row-bg: rgba(0,0,0,.06);
        --s-table-row-hover: rgba(255,255,255,.03);
        --s-table-border: rgba(255,255,255,.06);
        --s-empty-bg: rgba(0,0,0,.14);
        --s-empty-border: rgba(255,255,255,.14);
    }

    /* Light Mode Variables */
    html:not(.dark) {
        --s-border:rgba(0,0,0,.12);
        --s-text:rgba(0,0,0,.95);
        --s-muted:rgba(0,0,0,.70);
        --s-card:#FFFFFF;
        --s-card2:#FFFFFF;
        --s-shadow: 0 4px 12px rgba(0,0,0,.08);
        --s-shadow2: 0 2px 8px rgba(0,0,0,.06);
        --s-shell-bg: #FFFFFF;
        --s-head-bg: rgba(248,249,250,.8);
        --s-pill-bg: rgba(0,0,0,.05);
        --s-pill-border: rgba(0,0,0,.15);
        --s-pill-text: rgba(0,0,0,.85);
        --s-input-bg: rgba(0,0,0,.03);
        --s-input-border: rgba(0,0,0,.18);
        --s-input-color: rgba(0,0,0,.95);
        --s-input-placeholder: rgba(0,0,0,.50);
        --s-table-head-bg: rgba(0,0,0,.05);
        --s-table-row-bg: #FFFFFF;
        --s-table-row-hover: rgba(0,0,0,.03);
        --s-table-border: rgba(0,0,0,.10);
        --s-empty-bg: rgba(0,0,0,.03);
        --s-empty-border: rgba(0,0,0,.18);
    }

    /* Shell */
    .s-shell{
        position:relative;
        border-radius:20px;
        overflow:hidden;
        border:1px solid var(--s-border);
        background: var(--s-shell-bg);
        box-shadow: var(--s-shadow);
        transition: all 0.3s ease;
    }
    
    /* Dark mode background */
    .dark .s-bg{
        position:absolute; inset:0; z-index:0; pointer-events:none;
        background:
            radial-gradient(900px 520px at 16% 10%, rgba(140,198,63,.14), transparent 55%),
            radial-gradient(900px 520px at 86% 18%, rgba(255,223,65,.14), transparent 55%),
            radial-gradient(800px 520px at 72% 90%, rgba(227,160,0,.10), transparent 55%),
            linear-gradient(180deg, rgba(7,11,18,.45), rgba(10,18,32,.25));
        filter: blur(14px);
        opacity:.78;
    }
    
    /* Light mode - no background */
    html:not(.dark) .s-bg {
        display: none;
    }
    
    .s-wrap{position:relative; z-index:1; padding:16px}

    /* Head */
    .s-head{
        display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;
        padding:14px;
        border-radius:16px;
        border:1px solid var(--s-border);
        background: var(--s-head-bg);
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        margin-bottom:14px;
        transition: all 0.3s ease;
    }
    .s-head h3{margin:0;font-size:16px;font-weight:900;color:var(--s-text)}
    .s-head p{margin:6px 0 0;font-size:12px;font-weight:800;color:var(--s-muted);line-height:1.55}
    .s-actions{display:flex;gap:10px;flex-wrap:wrap;align-items:center}

    /* Pills */
    .s-pill{
        display:inline-flex;align-items:center;gap:8px;
        padding:7px 10px;border-radius:999px;
        border:1px solid var(--s-pill-border);
        background: var(--s-pill-bg);
        color: var(--s-pill-text);
        font-size:12px;font-weight:900;
        white-space:nowrap;
        transition: all 0.3s ease;
    }
    .s-pill .dot{width:8px;height:8px;border-radius:999px;background: var(--s-muted)}
    .s-pill.y .dot{background: rgba(255,223,65,.55)}
    .s-pill.g .dot{background: rgba(140,198,63,.50)}
    .s-pill.r .dot{background: rgba(239,68,68,.55)}

    /* Cards */
    .s-card{
        border-radius:16px;
        border:1px solid var(--s-border);
        background: var(--s-card);
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        padding:14px;
        transition: all 0.3s ease;
    }
    .s-card-title{margin:0;font-size:14px;font-weight:900;color:var(--s-text)}
    .s-card-sub{margin-top:4px;font-size:12px;font-weight:800;color:var(--s-muted)}
    .s-card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:10px}

    /* KPI */
    .s-kpi-grid{display:grid;grid-template-columns:1fr;gap:14px}
    @media(min-width:640px){ .s-kpi-grid{grid-template-columns:repeat(2,1fr)} }
    @media(min-width:1024px){ .s-kpi-grid{grid-template-columns:repeat(3,1fr)} }

    .s-kpi{
        border-radius:16px;
        border:1px solid var(--s-border);
        background: var(--s-card);
        padding:16px;
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        transition:all .3s ease;
    }
    .s-kpi:hover{transform: translateY(-1px); box-shadow: var(--s-shadow)}
    .s-kpi .t{font-size:12px;font-weight:900;color:var(--s-muted)}
    .s-kpi .v{margin-top:10px;font-size:30px;font-weight:900;color:var(--s-text);letter-spacing:-.2px}
    .s-kpi .m{margin-top:8px;font-size:12px;font-weight:800;color:var(--s-muted)}

    /* Inputs */
    .s-input{
        width:100%;
        padding:10px 12px;
        border-radius:14px;
        border:1px solid var(--s-input-border);
        background: var(--s-input-bg);
        color: var(--s-input-color);
        font-weight:800;
        outline:none;
        transition: all 0.3s ease;
    }
    .s-input::placeholder{color: var(--s-input-placeholder)}
    .s-input:focus{
        border-color: rgba(255,223,65,.38);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }

    /* Tabs */
    .s-tabs{display:flex;gap:8px;flex-wrap:wrap}
    .s-tab{
        background: var(--s-pill-bg);
        border:1px solid var(--s-pill-border);
        color: var(--s-pill-text);
        padding:9px 12px;border-radius:12px;font-weight:900;cursor:pointer;
        transition: all 0.3s ease;
    }
    .s-tab:hover{background: var(--s-table-row-hover)}
    .s-tab.active{border-color: rgba(255,223,65,.36); box-shadow: 0 0 0 4px rgba(255,223,65,.10)}

    /* Table */
    .s-table-card{
        border-radius:14px; overflow:hidden;
        border:1px solid var(--s-border);
        background: var(--s-card2);
        transition: all 0.3s ease;
    }
    .s-table{width:100%;border-collapse:collapse}
    .s-table thead th{
        text-align:left;font-size:12px;font-weight:900;color:var(--s-muted);
        padding:12px;background: var(--s-table-head-bg);border-bottom:1px solid var(--s-table-border);
        white-space:nowrap;
    }
    .s-table td{
        padding:12px;color:var(--s-text);font-weight:800;
        border-bottom:1px solid var(--s-table-border);background: var(--s-table-row-bg);
        vertical-align:middle;
    }
    .s-table tbody tr:hover td{background: var(--s-table-row-hover)}
    .s-muted{color: var(--s-muted)!important}
    .s-strong{font-weight:900;color:var(--s-text)}

    .s-empty{
        padding:14px;border-radius:14px;border:1px dashed var(--s-empty-border);
        background: var(--s-empty-bg);color:var(--s-muted);font-weight:800;line-height:1.55;
        text-align:center;
    }

    /* Buttons */
    .crm-btn.crm-btn-primary{
        background: linear-gradient(135deg, var(--brand-yellow) 0%, var(--brand-orange) 100%) !important;
        color:#0b122a !important;
        border: 1px solid rgba(255,255,255,.08) !important;
        box-shadow: 0 18px 34px rgba(227,160,0,0.18);
        font-weight:900;
    }
    .crm-btn.crm-btn-ghost{
        background: var(--s-pill-bg) !important;
        border:1px solid var(--s-pill-border) !important;
        color: var(--s-text) !important;
        font-weight:900;
        transition: all 0.3s ease;
    }
    .crm-btn.crm-btn-ghost:hover{background: var(--s-table-row-hover) !important}
    
    /* Inner card styling */
    .s-inner-card {
        border-radius:14px;
        border:1px solid var(--s-border);
        background:var(--s-card2);
        padding:12px;
        transition: all 0.3s ease;
    }
</style>

@php
    // Expect these from controller; safe defaults:
    $myLeadsCount = $myLeadsCount ?? 0;
    $followupsTodayCount = $followupsTodayCount ?? 0;
    $overdueFollowupsCount = $overdueFollowupsCount ?? 0;

    $todayFollowups = $todayFollowups ?? collect();
    $recentLeads = $recentLeads ?? collect();
@endphp

<div class="s-shell">
    <div class="s-bg" aria-hidden="true"></div>

    <div class="s-wrap">
        <div class="s-head">
            <div>
                <h3>Welcome back</h3>
                <p>Quick overview of your leads and followups for today.</p>
                <div style="margin-top:10px;display:flex;gap:10px;flex-wrap:wrap">
                    <span class="s-pill g"><span class="dot"></span>Sales area</span>
                    <span class="s-pill y"><span class="dot"></span>Live overview</span>
                    @if($overdueFollowupsCount > 0)
                        <span class="s-pill r"><span class="dot"></span>Overdue attention</span>
                    @endif
                </div>
            </div>
            <div class="s-actions">
                <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-primary">My Leads</a>
                <a href="{{ route('crm.sales.followups.index') }}" class="crm-btn crm-btn-ghost">Followups</a>
            </div>
        </div>

        {{-- KPIs --}}
        <div class="s-kpi-grid">
            <div class="s-kpi">
                <div class="t">My Leads</div>
                <div class="v">{{ number_format($myLeadsCount) }}</div>
                <div class="m">Assigned to you</div>
            </div>

            <div class="s-kpi">
                <div class="t">Followups Today</div>
                <div class="v">{{ number_format($followupsTodayCount) }}</div>
                <div class="m">Scheduled for today</div>
            </div>

            <div class="s-kpi">
                <div class="t">Overdue Followups</div>
                <div class="v" style="{{ $overdueFollowupsCount > 0 ? 'color:#ffd0d0' : '' }}">{{ number_format($overdueFollowupsCount) }}</div>
                <div class="m">Need action</div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr;gap:14px;margin-top:14px">
            {{-- Today Followups --}}
            <section class="s-card">
                <div class="s-card-head">
                    <div>
                        <h3 class="s-card-title">Today Followups</h3>
                        <div class="s-card-sub">Your scheduled tasks for today.</div>
                    </div>
                    <a href="{{ route('crm.sales.followups.index') }}" class="crm-btn crm-btn-ghost">View all</a>
                </div>

                @if($todayFollowups->count())
                    <div style="display:flex;flex-direction:column;gap:10px">
                        @foreach($todayFollowups->take(6) as $f)
                            @php
                                $when = $f->scheduled_at ? \Carbon\Carbon::parse($f->scheduled_at) : null;
                                $isOverdue = $when && $when->isPast() && !$f->completed;
                            @endphp
                            <div class="s-inner-card">
                                <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;align-items:center">
                                    <div class="s-strong">{{ optional($f->lead)->name ?? 'Lead' }}</div>
                                    <span class="s-pill {{ $isOverdue ? 'r' : 'y' }}">
                                        <span class="dot"></span>
                                        {{ $when ? $when->format('H:i') : '—' }}
                                    </span>
                                </div>
                                <div class="s-muted" style="margin-top:6px;font-size:12px;font-weight:800;line-height:1.45">
                                    {{ $f->note ?? '—' }}
                                </div>
                                <div style="margin-top:10px;display:flex;justify-content:flex-end">
                                    @if(!$f->completed)
                                        <form method="POST" action="{{ route('crm.sales.followups.done', $f->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="crm-btn crm-btn-ghost">Mark Done</button>
                                        </form>
                                    @else
                                        <span class="s-muted" style="font-size:12px;font-weight:800">Done</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="s-empty">No followups scheduled for today.</div>
                @endif
            </section>

            {{-- Recent Leads --}}
            <section class="s-card">
                <div class="s-card-head">
                    <div>
                        <h3 class="s-card-title">My Recent Leads</h3>
                        <div class="s-card-sub">Latest leads assigned to you.</div>
                    </div>
                    <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-ghost">Open leads</a>
                </div>

                <div class="s-table-card" style="overflow-x:auto">
                    <table class="s-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th style="width:120px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($recentLeads->take(8) as $l)
                            <tr>
                                <td class="s-strong">{{ $l->name }}</td>
                                <td>{{ $l->phone ?? '—' }}</td>
                                <td class="s-muted">{{ optional($l->status)->name ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('crm.sales.leads.show', $l->id) }}" class="crm-btn crm-btn-ghost">Open</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"><div class="s-empty" style="margin:12px">No leads assigned yet.</div></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
