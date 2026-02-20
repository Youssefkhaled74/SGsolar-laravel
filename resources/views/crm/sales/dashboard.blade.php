@extends('crm.layouts.sales')

@section('title', __('crm_sales.dashboard.title'))

@section('content')
<style>
    [x-cloak]{display:none!important}

    :root{
        --brand-yellow: {{ config('website.primary_color', '#FFDF41') }};
        --brand-orange: {{ config('website.secondary_color', '#E3A000') }};
    }

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
        --s-table-head-bg: rgba(255,255,255,.04);
        --s-table-row-bg: rgba(0,0,0,.06);
        --s-table-row-hover: rgba(255,255,255,.03);
        --s-table-border: rgba(255,255,255,.06);
        --s-empty-bg: rgba(0,0,0,.14);
        --s-empty-border: rgba(255,255,255,.14);
        --s-danger: #ffd0d0;
    }

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
        --s-table-head-bg: rgba(0,0,0,.05);
        --s-table-row-bg: #FFFFFF;
        --s-table-row-hover: rgba(0,0,0,.03);
        --s-table-border: rgba(0,0,0,.10);
        --s-empty-bg: rgba(0,0,0,.03);
        --s-empty-border: rgba(0,0,0,.18);
        --s-danger: #b91c1c;
    }

    .s-shell{position:relative;border-radius:20px;overflow:hidden;border:1px solid var(--s-border);background:var(--s-shell-bg);box-shadow:var(--s-shadow)}
    .dark .s-bg{position:absolute;inset:0;z-index:0;pointer-events:none;background:radial-gradient(900px 520px at 16% 10%, rgba(140,198,63,.14), transparent 55%),radial-gradient(900px 520px at 86% 18%, rgba(255,223,65,.14), transparent 55%),radial-gradient(800px 520px at 72% 90%, rgba(227,160,0,.10), transparent 55%);filter: blur(14px);opacity:.78}
    html:not(.dark) .s-bg{display:none}
    .s-wrap{position:relative;z-index:1;padding:16px}

    .s-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;padding:14px;border-radius:16px;border:1px solid var(--s-border);background:var(--s-head-bg);box-shadow:var(--s-shadow2);backdrop-filter: blur(10px);margin-bottom:14px}
    .s-head h3{margin:0;font-size:16px;font-weight:900;color:var(--s-text)}
    .s-head p{margin:6px 0 0;font-size:12px;font-weight:800;color:var(--s-muted);line-height:1.55}
    .s-actions{display:flex;gap:10px;flex-wrap:wrap;align-items:center}

    .s-pill{display:inline-flex;align-items:center;gap:8px;padding:7px 10px;border-radius:999px;border:1px solid var(--s-pill-border);background:var(--s-pill-bg);color:var(--s-pill-text);font-size:12px;font-weight:900;white-space:nowrap}
    .s-pill .dot{width:8px;height:8px;border-radius:999px;background:var(--s-muted)}
    .s-pill.y .dot{background: rgba(255,223,65,.55)}
    .s-pill.g .dot{background: rgba(140,198,63,.50)}
    .s-pill.r .dot{background: rgba(239,68,68,.55)}

    .s-card{border-radius:16px;border:1px solid var(--s-border);background:var(--s-card);box-shadow:var(--s-shadow2);backdrop-filter: blur(10px);padding:14px}
    .s-card-title{margin:0;font-size:14px;font-weight:900;color:var(--s-text)}
    .s-card-sub{margin-top:4px;font-size:12px;font-weight:800;color:var(--s-muted)}
    .s-card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:10px}

    .s-kpi-grid{display:grid;grid-template-columns:1fr;gap:14px}
    @media(min-width:640px){ .s-kpi-grid{grid-template-columns:repeat(2,1fr)} }
    @media(min-width:1024px){ .s-kpi-grid{grid-template-columns:repeat(3,1fr)} }
    .s-kpi{border-radius:16px;border:1px solid var(--s-border);background:var(--s-card);padding:16px;box-shadow:var(--s-shadow2)}
    .s-kpi .t{font-size:12px;font-weight:900;color:var(--s-muted)}
    .s-kpi .v{margin-top:10px;font-size:30px;font-weight:900;color:var(--s-text);letter-spacing:-.2px}
    .s-kpi .m{margin-top:8px;font-size:12px;font-weight:800;color:var(--s-muted)}

    .s-table-card{border-radius:14px;overflow:hidden;border:1px solid var(--s-border);background:var(--s-card2)}
    .s-table{width:100%;border-collapse:collapse}
    .s-table thead th{text-align:left;font-size:12px;font-weight:900;color:var(--s-muted);padding:12px;background:var(--s-table-head-bg);border-bottom:1px solid var(--s-table-border);white-space:nowrap}
    .s-table td{padding:12px;color:var(--s-text);font-weight:800;border-bottom:1px solid var(--s-table-border);background:var(--s-table-row-bg);vertical-align:top}
    .s-table tbody tr:hover td{background:var(--s-table-row-hover)}
    [dir="rtl"] .s-table thead th{ text-align:right }

    .s-empty{padding:14px;border-radius:14px;border:1px dashed var(--s-empty-border);background:var(--s-empty-bg);color:var(--s-muted);font-weight:800;line-height:1.55;text-align:center}
    .s-muted{color: var(--s-muted)!important}
    .s-strong{font-weight:900;color:var(--s-text)}
    .lead-meta{font-size:12px;font-weight:800;color:var(--s-muted);margin-top:4px}
    .lead-clip{max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
    .s-inner-card{border-radius:14px;border:1px solid var(--s-border);background:var(--s-card2);padding:12px}

    .crm-btn.crm-btn-primary{background: linear-gradient(135deg, var(--brand-yellow) 0%, var(--brand-orange) 100%) !important;color:#0b122a !important;border: 1px solid rgba(255,255,255,.08) !important;box-shadow: 0 18px 34px rgba(227,160,0,0.18);font-weight:900}
    .crm-btn.crm-btn-ghost{background: var(--s-pill-bg) !important;border:1px solid var(--s-pill-border) !important;color: var(--s-text) !important;font-weight:900}
</style>

@php
    $myLeadsCount = $myLeadsCount ?? 0;
    $followupsTodayCount = $followupsTodayCount ?? 0;
    $overdueFollowupsCount = $overdueFollowupsCount ?? 0;
    $upcomingWeekFollowupsCount = $upcomingWeekFollowupsCount ?? 0;
    $completedTodayCount = $completedTodayCount ?? 0;
    $newLeadsThisWeekCount = $newLeadsThisWeekCount ?? 0;
    $leadsWithoutNextActionCount = $leadsWithoutNextActionCount ?? 0;
    $staleLeadsCount = $staleLeadsCount ?? 0;

    $todayFollowups = $todayFollowups ?? collect();
    $priorityFollowups = $priorityFollowups ?? collect();
    $statusBreakdown = $statusBreakdown ?? collect();
    $attentionLeads = $attentionLeads ?? collect();
    $recentLeads = $recentLeads ?? collect();
@endphp

<div class="s-shell">
    <div class="s-bg" aria-hidden="true"></div>

    <div class="s-wrap">
        <div class="s-head">
            <div>
                <h3>{{ __('crm_sales.dashboard.welcome') }}</h3>
                <p>{{ __('crm_sales.dashboard.overview') }}</p>
                <div style="margin-top:10px;display:flex;gap:10px;flex-wrap:wrap">
                    <span class="s-pill g"><span class="dot"></span>{{ __('crm_sales.dashboard.pill_sales') }}</span>
                    <span class="s-pill y"><span class="dot"></span>{{ __('crm_sales.dashboard.pill_live') }}</span>
                    @if($overdueFollowupsCount > 0)
                        <span class="s-pill r"><span class="dot"></span>{{ __('crm_sales.dashboard.pill_overdue', ['count' => $overdueFollowupsCount]) }}</span>
                    @endif
                </div>
            </div>
            <div class="s-actions">
                <a href="{{ route('crm.sales.leads.create') }}" class="crm-btn crm-btn-ghost">{{ __('crm_sales.dashboard.add_lead') }}</a>
                <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-primary">{{ __('crm_sales.dashboard.my_leads') }}</a>
                <a href="{{ route('crm.sales.followups.index') }}" class="crm-btn crm-btn-ghost">{{ __('crm_sales.dashboard.followups') }}</a>
            </div>
        </div>

        <div class="s-kpi-grid">
            <div class="s-kpi"><div class="t">{{ __('crm_sales.dashboard.kpi_my_leads') }}</div><div class="v">{{ number_format($myLeadsCount) }}</div><div class="m">{{ __('crm_sales.dashboard.kpi_my_leads_hint') }}</div></div>
            <div class="s-kpi"><div class="t">{{ __('crm_sales.dashboard.kpi_today') }}</div><div class="v">{{ number_format($followupsTodayCount) }}</div><div class="m">{{ __('crm_sales.dashboard.kpi_today_hint') }}</div></div>
            <div class="s-kpi"><div class="t">{{ __('crm_sales.dashboard.kpi_overdue') }}</div><div class="v" style="{{ $overdueFollowupsCount > 0 ? 'color:var(--s-danger)' : '' }}">{{ number_format($overdueFollowupsCount) }}</div><div class="m">{{ __('crm_sales.dashboard.kpi_overdue_hint') }}</div></div>
            <div class="s-kpi"><div class="t">{{ __('crm_sales.dashboard.kpi_week') }}</div><div class="v">{{ number_format($upcomingWeekFollowupsCount) }}</div><div class="m">{{ __('crm_sales.dashboard.kpi_week_hint') }}</div></div>
            <div class="s-kpi"><div class="t">{{ __('crm_sales.dashboard.kpi_completed') }}</div><div class="v">{{ number_format($completedTodayCount) }}</div><div class="m">{{ __('crm_sales.dashboard.kpi_completed_hint') }}</div></div>
            <div class="s-kpi"><div class="t">{{ __('crm_sales.dashboard.kpi_new_week') }}</div><div class="v">{{ number_format($newLeadsThisWeekCount) }}</div><div class="m">{{ __('crm_sales.dashboard.kpi_new_week_hint') }}</div></div>
        </div>

        <div style="display:grid;grid-template-columns:1fr;gap:14px;margin-top:14px">
            <section class="s-card">
                <div class="s-card-head">
                    <div><h3 class="s-card-title">{{ __('crm_sales.dashboard.priority_title') }}</h3><div class="s-card-sub">{{ __('crm_sales.dashboard.priority_subtitle') }}</div></div>
                    <a href="{{ route('crm.sales.followups.index') }}" class="crm-btn crm-btn-ghost">{{ __('crm_sales.dashboard.open_followups') }}</a>
                </div>

                @if($priorityFollowups->count())
                    <div style="display:grid;grid-template-columns:1fr;gap:10px">
                        @foreach($priorityFollowups as $f)
                            @php
                                $when = $f->scheduled_at ? \Carbon\Carbon::parse($f->scheduled_at) : null;
                                $isOverdue = $when && $when->lt(now()->startOfDay()) && ! $f->completed;
                            @endphp
                            <div class="s-inner-card" style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;align-items:center">
                                <div>
                                    <div class="s-strong">{{ optional($f->lead)->name ?? __('crm_sales.dashboard.unspecified') }}</div>
                                    <div class="lead-meta">{{ $f->note ?: __('crm_sales.dashboard.no_note') }}</div>
                                </div>
                                <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                                    <span class="s-pill {{ $isOverdue ? 'r' : 'y' }}"><span class="dot"></span>{{ $isOverdue ? __('crm_sales.dashboard.priority_overdue') : __('crm_sales.dashboard.priority_today') }}</span>
                                    <span class="s-pill g"><span class="dot"></span>{{ $when ? $when->translatedFormat('Y-m-d H:i') : __('crm_sales.dashboard.none') }}</span>
                                    @if(optional($f->lead)->id)
                                        <a href="{{ route('crm.sales.leads.show', optional($f->lead)->id) }}" class="crm-btn crm-btn-ghost">{{ __('crm_sales.dashboard.open') }}</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="s-empty">{{ __('crm_sales.dashboard.priority_empty') }}</div>
                @endif
            </section>

            <section class="s-card">
                <div class="s-card-head">
                    <div><h3 class="s-card-title">{{ __('crm_sales.dashboard.pipeline_title') }}</h3><div class="s-card-sub">{{ __('crm_sales.dashboard.pipeline_subtitle') }}</div></div>
                </div>

                <div style="display:grid;grid-template-columns:1fr;gap:10px">
                    <div class="s-inner-card">
                        <div class="s-card-sub" style="margin-bottom:8px">{{ __('crm_sales.dashboard.status_mix') }}</div>
                        @if($statusBreakdown->count())
                            <div style="display:flex;flex-wrap:wrap;gap:8px">
                                @foreach($statusBreakdown as $row)
                                    <span class="s-pill y"><span class="dot"></span>{{ $row->status_name }}: {{ number_format($row->total) }}</span>
                                @endforeach
                            </div>
                        @else
                            <div class="s-empty">{{ __('crm_sales.dashboard.no_status_data') }}</div>
                        @endif
                    </div>

                    <div class="s-inner-card">
                        <div class="s-card-sub" style="margin-bottom:8px">{{ __('crm_sales.dashboard.risk_metrics') }}</div>
                        <div style="display:flex;gap:8px;flex-wrap:wrap">
                            <span class="s-pill r"><span class="dot"></span>{{ __('crm_sales.dashboard.risk_no_next', ['count' => number_format($leadsWithoutNextActionCount)]) }}</span>
                            <span class="s-pill r"><span class="dot"></span>{{ __('crm_sales.dashboard.risk_stale', ['count' => number_format($staleLeadsCount)]) }}</span>
                        </div>
                    </div>

                    @if($attentionLeads->count())
                        <div class="s-inner-card">
                            <div class="s-card-sub" style="margin-bottom:8px">{{ __('crm_sales.dashboard.missing_next_title') }}</div>
                            <div style="display:grid;grid-template-columns:1fr;gap:8px">
                                @foreach($attentionLeads as $lead)
                                    <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;align-items:center">
                                        <div>
                                            <div class="s-strong">{{ $lead->name }}</div>
                                            <div class="lead-meta">{{ optional($lead->status)->name ?? __('crm_sales.dashboard.unspecified') }} | {{ optional($lead->source)->name ?? __('crm_sales.dashboard.unknown_source') }}</div>
                                        </div>
                                        <a href="{{ route('crm.sales.leads.show', $lead->id) }}" class="crm-btn crm-btn-ghost">{{ __('crm_sales.dashboard.plan_next') }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </section>

            <section class="s-card">
                <div class="s-card-head">
                    <div><h3 class="s-card-title">{{ __('crm_sales.dashboard.today_title') }}</h3><div class="s-card-sub">{{ __('crm_sales.dashboard.today_subtitle') }}</div></div>
                    <a href="{{ route('crm.sales.followups.index') }}" class="crm-btn crm-btn-ghost">{{ __('crm_sales.dashboard.view_all') }}</a>
                </div>

                @if($todayFollowups->count())
                    <div style="display:flex;flex-direction:column;gap:10px">
                        @foreach($todayFollowups->take(6) as $f)
                            @php $when = $f->scheduled_at ? \Carbon\Carbon::parse($f->scheduled_at) : null; @endphp
                            <div class="s-inner-card">
                                <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;align-items:center">
                                    <div class="s-strong">{{ optional($f->lead)->name ?? __('crm_sales.dashboard.unspecified') }}</div>
                                    <span class="s-pill y"><span class="dot"></span>{{ $when ? $when->translatedFormat('H:i') : __('crm_sales.dashboard.none') }}</span>
                                </div>
                                <div class="s-muted" style="margin-top:6px;font-size:12px;font-weight:800;line-height:1.45">{{ $f->note ?? __('crm_sales.dashboard.none') }}</div>
                                <div style="margin-top:10px;display:flex;justify-content:flex-end">
                                    @if(!$f->completed)
                                        <form method="POST" action="{{ route('crm.sales.followups.done', $f->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="crm-btn crm-btn-ghost">{{ __('crm_sales.dashboard.mark_done') }}</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="s-empty">{{ __('crm_sales.dashboard.today_empty') }}</div>
                @endif
            </section>

            <section class="s-card">
                <div class="s-card-head">
                    <div><h3 class="s-card-title">{{ __('crm_sales.dashboard.recent_title') }}</h3><div class="s-card-sub">{{ __('crm_sales.dashboard.recent_subtitle') }}</div></div>
                    <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-ghost">{{ __('crm_sales.dashboard.open_leads') }}</a>
                </div>

                <div class="s-table-card" style="overflow-x:auto">
                    <table class="s-table">
                        <thead>
                            <tr>
                                <th>{{ __('crm_sales.dashboard.table_name') }}</th>
                                <th>{{ __('crm_sales.dashboard.table_phone') }}</th>
                                <th>{{ __('crm_sales.dashboard.table_source') }}</th>
                                <th>{{ __('crm_sales.dashboard.table_status') }}</th>
                                <th>{{ __('crm_sales.dashboard.table_last_action') }}</th>
                                <th>{{ __('crm_sales.dashboard.table_next_action') }}</th>
                                <th>{{ __('crm_sales.dashboard.table_last_comment') }}</th>
                                <th style="width:120px">{{ __('crm_sales.dashboard.table_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($recentLeads->take(8) as $l)
                            @php
                                $lastAction = $l->lastAction;
                                $nextAction = $l->nextAction;
                                $lastComment = $l->lastComment;
                            @endphp
                            <tr>
                                <td class="s-strong">{{ $l->name }}</td>
                                <td>{{ $l->phone ?? __('crm_sales.dashboard.none') }}</td>
                                <td class="s-muted">{{ optional($l->source)->name ?? __('crm_sales.dashboard.none') }}</td>
                                <td class="s-muted">{{ optional($l->status)->name ?? __('crm_sales.dashboard.none') }}</td>
                                <td class="s-muted">
                                    @if($lastAction)
                                        <div class="s-strong">{{ optional($lastAction->type)->name ?? __('crm_sales.dashboard.action_generic') }}</div>
                                        <div class="lead-meta">{{ $lastAction->scheduled_at ? \Carbon\Carbon::parse($lastAction->scheduled_at)->translatedFormat('Y-m-d H:i') : __('crm_sales.dashboard.none') }}</div>
                                    @else
                                        {{ __('crm_sales.dashboard.none') }}
                                    @endif
                                </td>
                                <td class="s-muted">
                                    @if($nextAction)
                                        <div class="s-strong">{{ optional($nextAction->type)->name ?? __('crm_sales.dashboard.action_generic') }}</div>
                                        <div class="lead-meta">{{ $nextAction->scheduled_at ? \Carbon\Carbon::parse($nextAction->scheduled_at)->translatedFormat('Y-m-d H:i') : __('crm_sales.dashboard.none') }}</div>
                                    @else
                                        {{ __('crm_sales.dashboard.none') }}
                                    @endif
                                </td>
                                <td class="s-muted">
                                    @if($lastComment)
                                        <div class="lead-clip">{{ $lastComment->comment }}</div>
                                        <div class="lead-meta">{{ $lastComment->created_at ? $lastComment->created_at->translatedFormat('Y-m-d H:i') : __('crm_sales.dashboard.none') }}</div>
                                    @else
                                        {{ __('crm_sales.dashboard.none') }}
                                    @endif
                                </td>
                                <td><a href="{{ route('crm.sales.leads.show', $l->id) }}" class="crm-btn crm-btn-ghost">{{ __('crm_sales.dashboard.open') }}</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="8"><div class="s-empty" style="margin:12px">{{ __('crm_sales.dashboard.empty_leads') }}</div></td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection