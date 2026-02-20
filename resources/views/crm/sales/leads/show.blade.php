@extends('crm.layouts.sales')

@section('title','Lead Details')

@section('content')
@include('crm.sales.partials.theme')

<style>
    /* Allow dropdowns to overlay */
    .s-shell{overflow:visible}
    .s-bg{border-radius:20px}
    .s-card{position:relative; overflow:visible}
    .s-right-top{position:relative; z-index:10}
    .s-breadcrumb{font-size:12px;font-weight:900;margin-bottom:12px;display:flex;gap:8px;align-items:center;flex-wrap:wrap}
    .s-link{color:var(--s-text);text-decoration:none}
    .s-link:hover{text-decoration:underline}
</style>

@php
    $leadName = $lead->name ?? 'Lead';
@endphp

<div class="s-shell" x-data="{
        tab: localStorage.getItem('sales_lead_tab') || 'comments',
        setTab(t){ this.tab=t; localStorage.setItem('sales_lead_tab', t); }
    }">
    <div class="s-bg" aria-hidden="true"></div>

    <div class="s-wrap">
        {{-- Breadcrumb --}}
        <div class="s-muted s-breadcrumb">
            <a href="{{ route('crm.sales.leads.index') }}" class="s-link">My Leads</a>
            <span>›</span>
            <span class="s-strong">{{ $leadName }}</span>
        </div>

        <div style="display:grid;grid-template-columns:1fr;gap:14px">
            <div style="display:grid;grid-template-columns:1fr;gap:14px">
                {{-- Lead Summary --}}
                <div class="s-card">
                    <div class="s-card-head">
                        <div>
                            <h4 class="s-card-title">{{ $leadName }}</h4>
                            <div class="s-card-sub">
                                Created: {{ $lead->created_at ? $lead->created_at->toDayDateTimeString() : '—' }}
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;flex-wrap:wrap">
                            <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-ghost">Back</a>
                            <a href="{{ route('crm.sales.followups.index') }}" class="crm-btn crm-btn-ghost">Followups</a>
                        </div>
                    </div>

                    <div style="display:grid;grid-template-columns:120px 1fr;gap:10px;row-gap:10px;font-size:13px">
                        <div class="s-muted" style="font-weight:900">Phone</div>
                        <div class="s-strong">{{ $lead->phone ?? '—' }}</div>

                        <div class="s-muted" style="font-weight:900">Email</div>
                        <div class="s-strong">{{ $lead->email ?? '—' }}</div>

                        <div class="s-muted" style="font-weight:900">Source</div>
                        <div class="s-muted" style="font-weight:900">{{ optional($lead->source)->name ?? '—' }}</div>

                        <div class="s-muted" style="font-weight:900">Status</div>
                        <div class="s-muted" style="font-weight:900">{{ optional($lead->status)->name ?? '—' }}</div>
                    </div>
                </div>

                {{-- Top Tools (Tabs + Log Action quick) --}}
                <div class="s-card s-right-top">
                    <div class="s-card-head" style="margin-bottom:12px">
                        <div class="s-tabs">
                            <button type="button" class="s-tab" :class="tab==='comments' ? 's-tab active' : 's-tab'" @click="setTab('comments')">
                                Comments ({{ $comments->count() }})
                            </button>
                            <button type="button" class="s-tab" :class="tab==='actions' ? 's-tab active' : 's-tab'" @click="setTab('actions')">
                                Actions ({{ $actions->count() }})
                            </button>
                            <button type="button" class="s-tab" :class="tab==='followups' ? 's-tab active' : 's-tab'" @click="setTab('followups')">
                                Followups ({{ $followups->count() }})
                            </button>
                        </div>

                        <div class="s-muted" style="font-size:12px;font-weight:800">
                            Tip: Log action first then schedule followup if needed.
                        </div>
                    </div>

                    {{-- Log Action --}}
                    <form method="POST" action="{{ route('crm.sales.leads.actions.store', $lead->id) }}"
                          style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
                        @csrf
                        <select name="action_type_id" class="s-input" style="min-width:200px;cursor:pointer">
                            <option value="">Action Type</option>
                            @foreach($actionTypes as $at)
                                <option value="{{ $at->id }}">{{ $at->name }}</option>
                            @endforeach
                        </select>

                        <input type="datetime-local" name="scheduled_at" class="s-input" required style="min-width:220px" />
                        <button class="crm-btn crm-btn-ghost">Log Action</button>
                    </form>
                </div>

                {{-- COMMENTS --}}
                <div class="s-card" x-show="tab==='comments'" x-cloak>
                    <div class="s-card-head">
                        <div>
                            <h4 class="s-card-title">Comments</h4>
                            <div class="s-card-sub">Write short notes about customer needs.</div>
                        </div>
                    </div>

                    {{-- Add Comment --}}
                    <form method="POST" action="{{ route('crm.sales.leads.comments.store', $lead->id) }}"
                          style="display:grid;gap:10px;margin-bottom:12px">
                        @csrf
                        <textarea name="comment" class="s-input" style="min-height:120px;resize:vertical" placeholder="Write a quick note...">{{ old('comment') }}</textarea>
                        <div style="display:flex;justify-content:flex-end">
                            <button class="crm-btn crm-btn-primary">Add Comment</button>
                        </div>
                    </form>

                    {{-- List --}}
                    @if($comments->count())
                        <div style="display:flex;flex-direction:column;gap:10px">
                            @foreach($comments as $c)
                                <div class="s-panel">
                                    <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;align-items:center">
                                        <div class="s-strong">{{ optional($c->author)->name ?? 'You' }}</div>
                                        <span class="s-muted" style="font-size:12px;font-weight:800">
                                            {{ $c->created_at ? \Carbon\Carbon::parse($c->created_at)->diffForHumans() : '' }}
                                        </span>
                                    </div>
                                    <div class="s-panel-body">
                                        {{ $c->comment }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="s-empty">No comments yet.</div>
                    @endif
                </div>

                {{-- ACTIONS --}}
                <div class="s-card" x-show="tab==='actions'" x-cloak>
                    <div class="s-card-head">
                        <div>
                            <h4 class="s-card-title">Actions</h4>
                            <div class="s-card-sub">Logged interactions (Call, WhatsApp, Meeting...).</div>
                        </div>
                    </div>

                    @if($actions->count())
                        <div style="display:flex;flex-direction:column;gap:10px">
                            @foreach($actions as $a)
                                <div class="s-panel">
                                    <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;align-items:center">
                                        <div class="s-strong">{{ optional($a->type)->name ?? 'Action' }}</div>
                                        <span class="s-pill y">
                                            <span class="dot"></span>
                                            {{ $a->scheduled_at ? \Carbon\Carbon::parse($a->scheduled_at)->toDayDateTimeString() : '—' }}
                                        </span>
                                    </div>
                                    <div class="s-panel-muted" style="margin-top:8px;line-height:1.55">
                                        {{ $a->notes ?? '—' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="s-empty">No actions logged yet.</div>
                    @endif
                </div>

                {{-- FOLLOWUPS --}}
                <div class="s-card" x-show="tab==='followups'" x-cloak>
                    <div class="s-card-head">
                        <div>
                            <h4 class="s-card-title">Followups</h4>
                            <div class="s-card-sub">Schedule next steps and mark them done.</div>
                        </div>
                    </div>

                    {{-- Schedule Followup --}}
                    <form method="POST" action="{{ route('crm.sales.leads.followups.store', $lead->id) }}"
                          style="display:grid;gap:10px;margin-bottom:12px">
                        @csrf

                        <div style="display:grid;grid-template-columns:1fr;gap:10px">
                            <div>
                                <div class="s-muted" style="font-size:12px;font-weight:900;margin-bottom:6px">When</div>
                                <input type="datetime-local" name="scheduled_at" class="s-input" required />
                            </div>

                            <div>
                                <div class="s-muted" style="font-size:12px;font-weight:900;margin-bottom:6px">Note</div>
                                <input name="note" class="s-input" placeholder="e.g., Call to confirm installation date" />
                            </div>
                        </div>

                        <div style="display:flex;justify-content:flex-end">
                            <button class="crm-btn crm-btn-primary">Schedule Followup</button>
                        </div>
                    </form>

                    {{-- List --}}
                    @if($followups->count())
                        <div style="display:flex;flex-direction:column;gap:10px">
                            @foreach($followups as $f)
                                @php
                                    $when = $f->scheduled_at ? \Carbon\Carbon::parse($f->scheduled_at) : null;
                                    $isDone = (bool)($f->completed ?? false);
                                    $isOverdue = $when && !$isDone && $when->isPast();
                                    $isToday = $when && !$isDone && $when->isToday();
                                @endphp

                                <div class="s-panel">
                                    <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;align-items:center">
                                        <div class="s-strong">Followup</div>

                                        @if($isDone)
                                            <span class="s-pill g"><span class="dot"></span>Done</span>
                                        @elseif($isOverdue)
                                            <span class="s-pill r"><span class="dot"></span>Overdue</span>
                                        @elseif($isToday)
                                            <span class="s-pill y"><span class="dot"></span>Today</span>
                                        @else
                                            <span class="s-pill"><span class="dot"></span>Planned</span>
                                        @endif
                                    </div>

                                    <div class="s-muted" style="margin-top:6px;font-size:12px;font-weight:900">
                                        {{ $when ? $when->toDayDateTimeString() : '—' }}
                                    </div>

                                    <div class="s-panel-body">
                                        {{ $f->note ?? '—' }}
                                    </div>

                                    <div style="margin-top:10px;display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap">
                                        @if(!$isDone)
                                            <form method="POST" action="{{ route('crm.sales.followups.done', $f->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="crm-btn crm-btn-ghost">Mark Done</button>
                                            </form>
                                        @else
                                            <div class="s-muted" style="font-size:12px;font-weight:800">
                                                Completed at {{ $f->completed_at ? \Carbon\Carbon::parse($f->completed_at)->toDayDateTimeString() : '—' }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="s-empty">No followups scheduled.</div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection



