@extends('crm.layouts.admin-standalone')

@section('title', 'Leads')
@section('subtitle', 'Manage and review leads')

@section('content')
<style>
    [x-cloak]{display:none!important}

    /* Theme Variables */
    .dark {
        --leads-border: rgba(255,255,255,.10);
        --leads-bg: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
        --leads-shadow: 0 22px 60px rgba(0,0,0,.35);
        --leads-text: rgba(255,255,255,.90);
        --leads-muted: rgba(255,255,255,.62);
        --leads-input-bg: rgba(255,255,255,.04);
        --leads-input-border: rgba(255,255,255,.14);
        --leads-input-color: rgba(255,255,255,.90);
        --leads-input-placeholder: rgba(255,255,255,.55);
        --leads-panel-bg: rgba(0,0,0,.16);
        --leads-panel-head: rgba(255,255,255,.04);
        --leads-table-bg: rgba(0,0,0,.14);
        --leads-table-head: rgba(255,255,255,.04);
        --leads-table-row: rgba(0,0,0,.06);
        --leads-table-hover: rgba(255,255,255,.03);
        --leads-table-border: rgba(255,255,255,.06);
        --leads-pill-bg: rgba(255,255,255,.04);
        --leads-pill-border: rgba(255,255,255,.12);
        --leads-pill-text: rgba(255,255,255,.78);
        --leads-chip-bg: rgba(0,0,0,.12);
        --leads-chip-text: rgba(255,255,255,.82);
    }

    html:not(.dark) {
        --leads-border: rgba(0,0,0,.12);
        --leads-bg: #FFFFFF;
        --leads-shadow: 0 4px 12px rgba(0,0,0,.08);
        --leads-text: rgba(0,0,0,.95);
        --leads-muted: rgba(0,0,0,.70);
        --leads-input-bg: rgba(0,0,0,.03);
        --leads-input-border: rgba(0,0,0,.18);
        --leads-input-color: rgba(0,0,0,.95);
        --leads-input-placeholder: rgba(0,0,0,.50);
        --leads-panel-bg: rgba(0,0,0,.03);
        --leads-panel-head: rgba(0,0,0,.05);
        --leads-table-bg: #FFFFFF;
        --leads-table-head: rgba(0,0,0,.05);
        --leads-table-row: #FFFFFF;
        --leads-table-hover: rgba(0,0,0,.03);
        --leads-table-border: rgba(0,0,0,.10);
        --leads-pill-bg: rgba(0,0,0,.05);
        --leads-pill-border: rgba(0,0,0,.15);
        --leads-pill-text: rgba(0,0,0,.85);
        --leads-chip-bg: rgba(0,0,0,.08);
        --leads-chip-text: rgba(0,0,0,.90);
    }

    .leads-shell{
        border-radius:20px;
        border:1px solid var(--leads-border);
        background: var(--leads-bg);
        box-shadow: var(--leads-shadow);
        overflow:hidden;
        position:relative;
        transition: all 0.3s ease;
    }
    .dark .leads-bg{
        position:absolute; inset:0; z-index:0; pointer-events:none;
        background:
            radial-gradient(900px 520px at 16% 10%, rgba(140,198,63,.14), transparent 55%),
            radial-gradient(900px 520px at 86% 18%, rgba(255,223,65,.14), transparent 55%),
            radial-gradient(800px 520px at 72% 90%, rgba(227,160,0,.10), transparent 55%);
        filter: blur(14px);
        opacity:.7;
    }
    html:not(.dark) .leads-bg { display: none; }
    .leads-wrap{position:relative; padding:16px; z-index:1}

    .topline{
        display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;
        margin: 6px 2px 10px;
    }
    .count-pill{
        display:inline-flex;align-items:center;gap:8px;
        padding:7px 10px;border-radius:999px;
        border:1px solid var(--leads-pill-border);
        background: var(--leads-pill-bg);
        font-weight:900;font-size:12px;
        color: var(--leads-pill-text);
        transition: all 0.3s ease;
    }
    .muted{color: var(--leads-muted) !important}

    .toolbar{
        display:flex; gap:12px; flex-wrap:wrap; align-items:center; justify-content:space-between;
        padding:14px;
        border-radius:16px;
        border:1px solid var(--leads-border);
        background: var(--leads-panel-bg);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    .toolbar .left{flex:1; min-width:260px}
    .toolbar .right{display:flex; gap:10px; flex-wrap:wrap; align-items:center}

    .dark-input{
        width:100%;
        padding:10px 12px;
        border-radius:14px;
        border:1px solid var(--leads-input-border);
        background: var(--leads-input-bg);
        color: var(--leads-input-color);
        font-weight:800;
        outline:none;
        transition: all 0.3s ease;
    }
    .dark-input::placeholder{color: var(--leads-input-placeholder)}
    .dark-input:focus{
        border-color: rgba(255,223,65,.38);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }

    /* FILTER BUTTON */
    .filter-btn{
        display:inline-flex;align-items:center;gap:10px;
        padding:10px 12px;border-radius:14px;
        border:1px solid var(--leads-input-border);
        background: var(--leads-input-bg);
        color: var(--leads-text);
        font-weight:900;
        cursor:pointer;
        transition:all .2s ease;
    }
    .filter-btn:hover{background: var(--leads-table-hover)}
    .filter-btn .icon{width:18px;height:18px;opacity:.9}

    /* CHIPS */
    .chips{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-top:10px}
    .chip{
        display:inline-flex;align-items:center;gap:8px;
        padding:7px 10px;border-radius:999px;
        border:1px solid var(--leads-pill-border);
        background: var(--leads-chip-bg);
        color: var(--leads-chip-text);
        font-size:12px;font-weight:900;
        white-space:nowrap;
        transition: all 0.3s ease;
    }
    .chip .dot{width:8px;height:8px;border-radius:999px;background:rgba(255,223,65,.45)}

    /* FILTER PANEL */
    .panel{
        margin-top:12px;
        border-radius:16px;
        border:1px solid var(--leads-border);
        background: var(--leads-panel-bg);
        box-shadow: var(--leads-shadow);
        backdrop-filter: blur(10px);
        overflow:hidden;
        transition: all 0.3s ease;
    }
    .panel-head{
        display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;
        padding:12px 14px;
        background: var(--leads-panel-head);
        border-bottom:1px solid var(--leads-border);
    }
    .panel-title{
        margin:0;
        font-size:13px;
        font-weight:900;
        color: var(--leads-text);
        letter-spacing:.2px;
    }
    .panel-sub{
        font-size:12px;
        font-weight:800;
        color: var(--leads-muted);
        margin-top:4px;
    }
    .panel-body{padding:14px}
    .grid{
        display:grid;
        grid-template-columns:1fr;
        gap:10px;
    }
    @media(min-width:900px){ .grid{grid-template-columns:1fr 1fr 1fr} }

    .field label{
        display:block;
        font-size:12px;
        font-weight:900;
        color: var(--leads-muted);
        margin-bottom:6px;
    }
    .dark-select{
        width:100%;
        padding:11px 12px;
        border-radius:14px;
        border:1px solid var(--leads-input-border);
        background: var(--leads-input-bg);
        color: var(--leads-input-color);
        font-weight:900;
        outline:none;
        appearance:none;
        transition: all 0.3s ease;
        background-image:
            linear-gradient(45deg, transparent 50%, var(--leads-text) 50%),
            linear-gradient(135deg, var(--leads-text) 50%, transparent 50%);
        background-position:
            calc(100% - 18px) calc(50% - 3px),
            calc(100% - 13px) calc(50% - 3px);
        background-size: 5px 5px, 5px 5px;
        background-repeat:no-repeat;
    }
    .dark-select:focus{
        border-color: rgba(255,223,65,.38);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }
    /* help native dropdown look appropriate for theme */
    .dark select.dark-select option{
        background:#0b1220;
        color:#fff;
    }
    html:not(.dark) select.dark-select option{
        background:#ffffff;
        color:#000;
    }

    .panel-actions{
        display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap;
        margin-top:12px;
    }

    .table-card{
        margin-top:14px;
        border-radius:16px;
        border:1px solid var(--leads-border);
        background: var(--leads-table-bg);
        box-shadow: var(--leads-shadow);
        backdrop-filter: blur(10px);
        overflow:hidden;
        transition: all 0.3s ease;
    }
    .dark-table{width:100%; border-collapse:collapse}
    .dark-table thead th{
        text-align:left;
        font-size:12px;
        font-weight:900;
        color: var(--leads-muted);
        padding:12px 14px;
        background: var(--leads-table-head);
        border-bottom:1px solid var(--leads-table-border);
        white-space:nowrap;
    }
    .dark-table td{
        padding:12px 14px;
        color: var(--leads-text);
        font-weight:800;
        border-bottom:1px solid var(--leads-table-border);
        background: var(--leads-table-row);
        vertical-align:middle;
    }
    .dark-table tbody tr:hover td{background: var(--leads-table-hover)}
    .row-title{font-weight:900;color:var(--leads-text)}

    .badge{
        display:inline-flex;align-items:center;gap:8px;
        padding:6px 10px;border-radius:999px;
        border:1px solid var(--leads-pill-border);
        background: var(--leads-pill-bg);
        font-size:12px;font-weight:900;
        color: var(--leads-pill-text);
        white-space:nowrap;
        transition: all 0.3s ease;
    }
    .badge .dot{width:8px;height:8px;border-radius:999px;background: var(--leads-muted)}
    .badge.status .dot{background: rgba(255,223,65,.55)}
    .badge.source .dot{background: rgba(140,198,63,.50)}

    .pagination{margin-top:12px}
    .pagination *{color: var(--leads-text)!important}
</style>

<div
    class="leads-shell"
    x-data="{ openFilters:false }"
>
    <div class="leads-bg" aria-hidden="true"></div>

    <div class="leads-wrap">
        <div class="topline">
            <div class="count-pill">
                <span style="width:8px;height:8px;border-radius:999px;background:rgba(255,223,65,.35)"></span>
                Showing <strong style="color:var(--leads-text)">{{ $leads->total() }}</strong> leads
            </div>

            <div class="muted" style="font-weight:800;font-size:12px">
                Tip: Use filters then click “Apply”.
            </div>
        </div>

        {{-- Toolbar --}}
        <div class="toolbar">
            {{-- Search (keeps filters by sending them as hidden inputs) --}}
            <div class="left">
                <form method="GET" action="{{ route('crm.admin.leads.index') }}">
                    <input type="hidden" name="status_id" value="{{ request('status_id') }}">
                    <input type="hidden" name="source_id" value="{{ request('source_id') }}">
                    <input type="hidden" name="assigned_to" value="{{ request('assigned_to') }}">

                    <input
                        name="q"
                        value="{{ request('q') }}"
                        class="dark-input"
                        placeholder="Search by name, phone, or email…"
                    />
                </form>
            </div>

            {{-- Filters button + Reset --}}
            <div class="right">
                <button type="button" class="filter-btn" @click="openFilters = !openFilters">
                    <svg class="icon" viewBox="0 0 24 24" fill="none">
                        <path d="M4 6h16M7 12h10M10 18h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Filters
                    <span style="opacity:.75;font-weight:900" x-text="openFilters ? '▲' : '▼'"></span>
                </button>

                @if(request()->hasAny(['q','status_id','source_id','assigned_to']))
                    <a href="{{ route('crm.admin.leads.index') }}" class="crm-btn crm-btn-ghost">Reset</a>
                @endif
            </div>

            {{-- Active filter chips --}}
            @if(request()->hasAny(['q','status_id','source_id','assigned_to']))
                <div class="chips" style="flex-basis:100%">
                    @if(request('q'))
                        <span class="chip"><span class="dot"></span> Search: “{{ request('q') }}”</span>
                    @endif
                    @if(request('status_id'))
                        <span class="chip">
                            <span class="dot"></span>
                            Status:
                            {{ optional($statuses->firstWhere('id', (int)request('status_id')))->name }}
                        </span>
                    @endif
                    @if(request('source_id'))
                        <span class="chip">
                            <span class="dot"></span>
                            Source:
                            {{ optional($sources->firstWhere('id', (int)request('source_id')))->name }}
                        </span>
                    @endif
                    @if(request('assigned_to'))
                        <span class="chip">
                            <span class="dot"></span>
                            Assigned:
                            {{ optional($sales->firstWhere('id', (int)request('assigned_to')))->name }}
                        </span>
                    @endif
                </div>
            @endif
        </div>

        {{-- Filters Panel --}}
        <div class="panel" x-show="openFilters" x-transition.opacity x-cloak>
            <div class="panel-head">
                <div>
                    <div class="panel-title">Refine Leads</div>
                    <div class="panel-sub">Choose filters then click Apply.</div>
                </div>
                <button type="button" class="crm-btn crm-btn-ghost" @click="openFilters=false">Close</button>
            </div>

            <div class="panel-body">
                <form method="GET" action="{{ route('crm.admin.leads.index') }}">
                    <input type="hidden" name="q" value="{{ request('q') }}">

                    <div class="grid">
                        <div class="field">
                            <label>Status</label>
                            <select name="status_id" class="dark-select">
                                <option value="">All Statuses</option>
                                @foreach($statuses as $s)
                                    <option value="{{ $s->id }}" {{ request('status_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label>Source</label>
                            <select name="source_id" class="dark-select">
                                <option value="">All Sources</option>
                                @foreach($sources as $src)
                                    <option value="{{ $src->id }}" {{ request('source_id') == $src->id ? 'selected' : '' }}>
                                        {{ $src->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field">
                            <label>Assigned to</label>
                            <select name="assigned_to" class="dark-select">
                                <option value="">All Assignees</option>
                                @foreach($sales as $s)
                                    <option value="{{ $s->id }}" {{ request('assigned_to') == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="panel-actions">
                        <a href="{{ route('crm.admin.leads.index') }}" class="crm-btn crm-btn-ghost">Reset</a>
                        <button class="crm-btn crm-btn-primary" type="submit">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-card">
            <div style="overflow-x:auto">
                <table class="dark-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Source <span class="muted" style="font-size:11px">(from)</span></th>
                        <th>Status</th>
                        <th>Assigned</th>
                        <th>Last Action</th>
                        <th>Next Action</th>
                        <th>Last Comment</th>
                        <th style="width:130px">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($leads as $lead)
                        @php
                            $lastAction = $lead->lastAction;
                            $nextAction = $lead->nextAction;
                            $lastComment = $lead->lastComment;
                        @endphp
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

                            <td>{{ optional($lead->assignedTo)->name ?? 'Unassigned' }}</td>
                            <td class="muted">
                                @if($lastAction)
                                    <div>{{ optional($lastAction->type)->name ?? 'Action' }}</div>
                                    <div class="muted" style="font-size:12px;font-weight:800">
                                        {{ $lastAction->scheduled_at ? \Carbon\Carbon::parse($lastAction->scheduled_at)->format('Y-m-d H:i') : '—' }}
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="muted">
                                @if($nextAction)
                                    <div>{{ optional($nextAction->type)->name ?? 'Action' }}</div>
                                    <div class="muted" style="font-size:12px;font-weight:800">
                                        {{ $nextAction->scheduled_at ? \Carbon\Carbon::parse($nextAction->scheduled_at)->format('Y-m-d H:i') : '—' }}
                                    </div>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="muted">
                                @if($lastComment)
                                    <div style="max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                        {{ $lastComment->comment }}
                                    </div>
                                    <div class="muted" style="font-size:12px;font-weight:800">
                                        {{ $lastComment->created_at ? $lastComment->created_at->format('Y-m-d H:i') : '—' }}
                                    </div>
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('crm.admin.leads.show', ['lead' => $lead->id]) }}" class="crm-btn crm-btn-ghost">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">
                                <div style="padding:16px" class="muted">
                                    No leads found. Try changing filters or search.
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






