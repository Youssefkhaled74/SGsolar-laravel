@extends('crm.layouts.sales')

@section('title', 'Sales Dashboard')

@section('content')
<style>
    [x-cloak]{display:none!important}

    :root{
        --s-border:rgba(255,255,255,.10);
        --s-text:rgba(255,255,255,.92);
        --s-muted:rgba(255,255,255,.62);
        --s-card:rgba(0,0,0,.14);
        --s-card2:rgba(0,0,0,.10);
        --s-shadow: 0 22px 60px rgba(0,0,0,.35);
        --s-shadow2: 0 12px 26px rgba(0,0,0,.22);
        --brand-yellow: {{ config('website.primary_color', '#FFDF41') }};
        --brand-orange: {{ config('website.secondary_color', '#E3A000') }};
        --brand-light: {{ config('website.light_green', '#8CC63F') }};
    }

    .shell{
        position:relative;
        border-radius:20px;
        overflow:hidden;
        border:1px solid var(--s-border);
        background: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
        box-shadow: var(--s-shadow);
    }
    .bg{
        position:absolute; inset:0; z-index:0; pointer-events:none;
        background:
            radial-gradient(900px 520px at 16% 10%, rgba(140,198,63,.14), transparent 55%),
            radial-gradient(900px 520px at 86% 18%, rgba(255,223,65,.14), transparent 55%),
            radial-gradient(800px 520px at 72% 90%, rgba(227,160,0,.10), transparent 55%),
            linear-gradient(180deg, rgba(7,11,18,.45), rgba(10,18,32,.25));
        filter: blur(14px);
        opacity:.78;
    }
    .wrap{position:relative; z-index:1; padding:16px}

    .head{
        display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;
        padding:14px;
        border-radius:16px;
        border:1px solid var(--s-border);
        background: rgba(0,0,0,.14);
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        margin-bottom:14px;
    }
    .head h3{margin:0;font-size:16px;font-weight:900;color:var(--s-text)}
    .head p{margin:6px 0 0;font-size:12px;font-weight:800;color:var(--s-muted);line-height:1.55}
    .head .actions{display:flex;gap:10px;flex-wrap:wrap;align-items:center}

    .pill{
        display:inline-flex;align-items:center;gap:8px;
        padding:7px 10px;border-radius:999px;
        border:1px solid rgba(255,255,255,.12);
        background: rgba(255,255,255,.05);
        color: rgba(255,255,255,.78);
        font-size:12px;font-weight:900;
        white-space:nowrap;
    }
    .pill .dot{width:8px;height:8px;border-radius:999px;background: rgba(255,255,255,.22)}
    .pill.y .dot{background: rgba(255,223,65,.35)}
    .pill.g .dot{background: rgba(140,198,63,.30)}
    .pill.r .dot{background: rgba(239,68,68,.45)}

    .kpi-grid{display:grid;grid-template-columns:1fr;gap:14px}
    @media(min-width:640px){ .kpi-grid{grid-template-columns:repeat(2,1fr)} }
    @media(min-width:1024px){ .kpi-grid{grid-template-columns:repeat(3,1fr)} }

    .kpi{
        border-radius:16px;
        border:1px solid var(--s-border);
        background: var(--s-card);
        padding:16px;
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        transition:transform .12s ease, box-shadow .12s ease, border-color .12s ease;
    }
    .kpi:hover{transform: translateY(-1px); border-color: rgba(255,255,255,.14); box-shadow: 0 16px 34px rgba(0,0,0,.28)}
    .kpi .t{font-size:12px;font-weight:900;color:rgba(255,255,255,.68)}
    .kpi .v{margin-top:10px;font-size:30px;font-weight:900;color:var(--s-text);letter-spacing:-.2px}
    .kpi .m{margin-top:8px;font-size:12px;font-weight:800;color:var(--s-muted)}

    .row{display:grid;grid-template-columns:1fr;gap:14px;margin-top:14px}
    @media(min-width:1024px){ .row{grid-template-columns: 1.2fr 1.8fr} }

    .panel{
        border-radius:16px;
        border:1px solid var(--s-border);
        background: var(--s-card2);
        padding:14px;
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
    }
    .panel-head{display:flex;align-items:flex-start;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:10px}
    .panel-title{margin:0;font-size:14px;font-weight:900;color:var(--s-text)}
    .panel-sub{margin-top:4px;font-size:12px;font-weight:800;color:var(--s-muted)}
    .empty{
        padding:14px;border-radius:14px;border:1px dashed rgba(255,255,255,.14);
        background: rgba(0,0,0,.14);color:rgba(255,255,255,.65);font-weight:800;line-height:1.55;
    }

    .table-card{
        border-radius:14px; overflow:hidden;
        border:1px solid rgba(255,255,255,.10);
        background: rgba(0,0,0,.10);
    }
    .dark-table{width:100%;border-collapse:collapse}
    .dark-table thead th{
        text-align:left;font-size:12px;font-weight:900;color:rgba(255,255,255,.62);
        padding:12px;background: rgba(255,255,255,.04);border-bottom:1px solid rgba(255,255,255,.08);
        white-space:nowrap;
    }
    .dark-table td{
        padding:12px;color:rgba(255,255,255,.84);font-weight:800;
        border-bottom:1px solid rgba(255,255,255,.06);background: rgba(0,0,0,.06);
        vertical-align:middle;
    }
    .dark-table tbody tr:hover td{background: rgba(255,255,255,.03)}
    .muted{color: rgba(255,255,255,.62)!important}
    .row-title{font-weight:900;color:rgba(255,255,255,.92)}

    /* Buttons match theme */
    .crm-btn.crm-btn-primary{
        background: linear-gradient(135deg, var(--brand-yellow) 0%, var(--brand-orange) 100%) !important;
        color:#0b122a !important;
        border: 1px solid rgba(255,255,255,.08) !important;
        box-shadow: 0 18px 34px rgba(227,160,0,0.18);
        font-weight:900;
    }
    .crm-btn.crm-btn-ghost{
        background: rgba(255,255,255,.04) !important;
        border:1px solid rgba(255,255,255,.14) !important;
        color: rgba(255,255,255,.86) !important;
        font-weight:900;
    }
    .crm-btn.crm-btn-ghost:hover{background: rgba(255,255,255,.07) !important}
</style>

@php
    // Expect these from controller; safe defaults:
    $myLeadsCount = $myLeadsCount ?? 0;
    $followupsTodayCount = $followupsTodayCount ?? 0;
    $overdueFollowupsCount = $overdueFollowupsCount ?? 0;

    $todayFollowups = $todayFollowups ?? collect();
    $recentLeads = $recentLeads ?? collect();
@endphp

<div class="shell">
    <div class="bg" aria-hidden="true"></div>

    <div class="wrap">
        <div class="head">
            <div>
                <h3>Welcome back</h3>
                <p>Quick overview of your leads and followups for today.</p>
                <div style="margin-top:10px;display:flex;gap:10px;flex-wrap:wrap">
                    <span class="pill g"><span class="dot"></span>Sales area</span>
                    <span class="pill y"><span class="dot"></span>Live overview</span>
                    @if($overdueFollowupsCount > 0)
                        <span class="pill r"><span class="dot"></span>Overdue attention</span>
                    @endif
                </div>
            </div>
            <div class="actions">
                <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-primary">My Leads</a>
                <a href="{{ route('crm.sales.followups.index') }}" class="crm-btn crm-btn-ghost">Followups</a>
            </div>
        </div>

        {{-- KPIs --}}
        <div class="kpi-grid">
            <div class="kpi">
                <div class="t">My Leads</div>
                <div class="v">{{ number_format($myLeadsCount) }}</div>
                <div class="m">Assigned to you</div>
            </div>

            <div class="kpi">
                <div class="t">Followups Today</div>
                <div class="v">{{ number_format($followupsTodayCount) }}</div>
                <div class="m">Scheduled for today</div>
            </div>

            <div class="kpi">
                <div class="t">Overdue Followups</div>
                <div class="v" style="{{ $overdueFollowupsCount > 0 ? 'color:#ffd0d0' : '' }}">{{ number_format($overdueFollowupsCount) }}</div>
                <div class="m">Need action</div>
            </div>
        </div>

        <div class="row">
            {{-- Today Followups --}}
            <section class="panel">
                <div class="panel-head">
                    <div>
                        <h3 class="panel-title">Today Followups</h3>
                        <div class="panel-sub">Your scheduled tasks for today.</div>
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
                            <div style="border-radius:14px;border:1px solid rgba(255,255,255,.10);background:rgba(0,0,0,.10);padding:12px">
                                <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;align-items:center">
                                    <div class="row-title">{{ optional($f->lead)->name ?? 'Lead' }}</div>
                                    <span class="pill {{ $isOverdue ? 'r' : 'y' }}">
                                        <span class="dot"></span>
                                        {{ $when ? $when->format('H:i') : '—' }}
                                    </span>
                                </div>
                                <div class="muted" style="margin-top:6px;font-size:12px;font-weight:800;line-height:1.45">
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
                                        <span class="muted" style="font-size:12px;font-weight:800">Done</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty">No followups scheduled for today.</div>
                @endif
            </section>

            {{-- Recent Leads --}}
            <section class="panel">
                <div class="panel-head">
                    <div>
                        <h3 class="panel-title">My Recent Leads</h3>
                        <div class="panel-sub">Latest leads assigned to you.</div>
                    </div>
                    <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-ghost">Open leads</a>
                </div>

                <div class="table-card" style="overflow-x:auto">
                    <table class="dark-table">
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
                                <td class="row-title">{{ $l->name }}</td>
                                <td>{{ $l->phone ?? '—' }}</td>
                                <td class="muted">{{ optional($l->status)->name ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('crm.sales.leads.show', $l->id) }}" class="crm-btn crm-btn-ghost">Open</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"><div class="empty" style="margin:12px">No leads assigned yet.</div></td>
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
