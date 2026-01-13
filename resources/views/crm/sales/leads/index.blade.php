@extends('crm.layouts.sales')

@section('title','My Leads')

@section('content')
<style>
    [x-cloak]{display:none!important}

    :root{
        --s-border:rgba(255,255,255,.10);
        --s-text:rgba(255,255,255,.92);
        --s-muted:rgba(255,255,255,.62);
        --s-card:rgba(0,0,0,.14);
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

    .topline{
        display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;
        margin: 6px 2px 10px;
    }
    .count-pill{
        display:inline-flex;align-items:center;gap:8px;
        padding:7px 10px;border-radius:999px;
        border:1px solid rgba(255,255,255,.12);
        background: rgba(255,255,255,.04);
        font-weight:900;font-size:12px;
        color: rgba(255,255,255,.78);
    }
    .muted{color: rgba(255,255,255,.62)!important;font-weight:800}

    .toolbar{
        display:flex; gap:12px; flex-wrap:wrap; align-items:center; justify-content:space-between;
        padding:14px;
        border-radius:16px;
        border:1px solid rgba(255,255,255,.10);
        background: rgba(0,0,0,.16);
        backdrop-filter: blur(10px);
    }
    .toolbar .left{flex:1; min-width:260px}
    .toolbar .right{display:flex; gap:10px; flex-wrap:wrap; align-items:center}

    .dark-input{
        width:100%;
        padding:10px 12px;
        border-radius:14px;
        border:1px solid rgba(255,255,255,.14);
        background: rgba(255,255,255,.04);
        color: rgba(255,255,255,.90);
        font-weight:800;
        outline:none;
    }
    .dark-input::placeholder{color: rgba(255,255,255,.55)}
    .dark-input:focus{
        border-color: rgba(255,223,65,.28);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }

    .table-card{
        margin-top:14px;
        border-radius:16px;
        border:1px solid rgba(255,255,255,.10);
        background: rgba(0,0,0,.14);
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        overflow:hidden;
    }
    .dark-table{width:100%; border-collapse:collapse}
    .dark-table thead th{
        text-align:left;
        font-size:12px;
        font-weight:900;
        color: rgba(255,255,255,.62);
        padding:12px 14px;
        background: rgba(255,255,255,.04);
        border-bottom:1px solid rgba(255,255,255,.08);
        white-space:nowrap;
    }
    .dark-table td{
        padding:12px 14px;
        color: rgba(255,255,255,.86);
        font-weight:800;
        border-bottom:1px solid rgba(255,255,255,.06);
        background: rgba(0,0,0,.06);
        vertical-align:middle;
    }
    .dark-table tbody tr:hover td{background: rgba(255,255,255,.03)}
    .row-title{font-weight:900;color:rgba(255,255,255,.92)}

    .badge{
        display:inline-flex;align-items:center;gap:8px;
        padding:6px 10px;border-radius:999px;
        border:1px solid rgba(255,255,255,.14);
        background: rgba(255,255,255,.05);
        font-size:12px;font-weight:900;
        color: rgba(255,255,255,.85);
        white-space:nowrap;
    }
    .badge .dot{width:8px;height:8px;border-radius:999px;background: rgba(255,255,255,.22)}
    .badge.status .dot{background: rgba(255,223,65,.35)}
    .badge.source .dot{background: rgba(140,198,63,.30)}

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

    .pagination{margin-top:12px}
    .pagination *{color: rgba(255,255,255,.85)!important}
</style>

<div class="shell">
    <div class="bg" aria-hidden="true"></div>

    <div class="wrap">
        <div class="topline">
            <div class="count-pill">
                <span style="width:8px;height:8px;border-radius:999px;background:rgba(255,223,65,.35)"></span>
                Showing <strong style="color:rgba(255,255,255,.92)">{{ $leads->total() }}</strong> leads
            </div>

            <div class="muted" style="font-size:12px">
                Tip: Search by name/phone/email.
            </div>
        </div>

        <div class="toolbar">
            <div class="left">
                <form method="GET" action="{{ route('crm.sales.leads.index') }}">
                    <input
                        name="q"
                        value="{{ request('q') }}"
                        class="dark-input"
                        placeholder="Search leads by name, phone, or email…"
                    />
                </form>
            </div>

            <div class="right">
                @if(request('q'))
                    <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-ghost">Reset</a>
                @endif
                <a href="{{ route('crm.sales.followups.index') }}" class="crm-btn crm-btn-primary">Followups</a>
            </div>
        </div>

        <div class="table-card">
            <div style="overflow-x:auto">
                <table class="dark-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th style="width:130px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leads as $lead)
                            <tr>
                                <td class="row-title">{{ $lead->name }}</td>
                                <td>{{ $lead->phone ?? '—' }}</td>

                                <td>
                                    <span class="badge source">
                                        <span class="dot"></span>
                                        {{ optional($lead->source)->name ?? '—' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge status">
                                        <span class="dot"></span>
                                        {{ optional($lead->status)->name ?? '—' }}
                                    </span>
                                </td>

                                <td class="muted">{{ $lead->created_at ? $lead->created_at->format('Y-m-d') : '—' }}</td>

                                <td>
                                    <a href="{{ route('crm.sales.leads.show', $lead->id) }}" class="crm-btn crm-btn-ghost">Open</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div style="padding:16px" class="muted">
                                        No leads assigned to you. Try searching with a different keyword.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="padding:12px 14px">
                {{ $leads->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
