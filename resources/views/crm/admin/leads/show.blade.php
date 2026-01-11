@extends('crm.layouts.admin')

@section('title', 'Lead Details')
@section('subtitle', 'Profile and timeline')

@section('content')
    <style>
        [x-cloak]{display:none!important}

        .lead-grid{display:grid;grid-template-columns:360px 1fr;gap:18px;align-items:start}
        @media(max-width:1024px){.lead-grid{grid-template-columns:1fr}}

        .lead-card{background:#fff;border:1px solid var(--crm-border);border-radius:12px;box-shadow:var(--crm-shadow-sm);padding:16px}
        .lead-card + .lead-card{margin-top:12px}

        .lead-head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px}
        .lead-name{margin:0;font-size:20px;font-weight:900}
        .lead-meta{margin-top:6px;font-size:13px;color:var(--crm-muted)}
        .lead-divider{border:none;border-top:1px solid var(--crm-border);margin:12px 0}

        .kv{display:grid;grid-template-columns:92px 1fr;gap:10px;row-gap:10px;font-size:14px}
        .kv .k{color:var(--crm-muted);font-weight:800}
        .kv .v{font-weight:700}

        .panel-title{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:10px}
        .panel-title h3{margin:0;font-size:16px;font-weight:900}
        .panel-title .hint{font-size:13px;color:var(--crm-muted)}

        .form-stack{display:flex;flex-direction:column;gap:10px}
        .form-actions{display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap}
        .full{width:100%}

        .top-actions{display:flex;gap:10px;flex-wrap:wrap}
        .mini{font-size:12px;color:var(--crm-muted)}

        .tabs-row{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
        .tabs{display:flex;gap:8px;flex-wrap:wrap}
        .tab{
            background:#fff;border:1px solid var(--crm-border);
            padding:9px 12px;border-radius:10px;font-weight:900;
            cursor:pointer;
        }
        .tab:hover{background:#f8fafc}
        .tab.active{border-color:rgba(14,165,164,0.35);box-shadow:var(--crm-ring)}

        .toolbar{display:flex;gap:10px;flex-wrap:wrap}
        .toolbar .crm-input{min-width:180px}

        .list{display:flex;flex-direction:column;gap:10px}
        .item{background:#fff;border:1px solid var(--crm-border);border-radius:12px;box-shadow:var(--crm-shadow-sm);padding:12px}
        .item-head{display:flex;gap:10px;align-items:center;justify-content:space-between;flex-wrap:wrap}
        .item-title{font-weight:900}
        .item-sub{font-size:13px;color:var(--crm-muted)}
        .item-body{margin-top:8px;font-weight:600}

        .pill{
            display:inline-flex;align-items:center;gap:8px;
            padding:6px 10px;border-radius:999px;border:1px solid var(--crm-border);
            font-size:12px;font-weight:900;background:#fff;
        }
        .pill.ok{border-color:#a7f3d0;background:#ecfdf5;color:#065f46}
        .pill.warn{border-color:#fde68a;background:#fffbeb;color:#92400e}
        .pill.bad{border-color:#fecaca;background:#fff5f5;color:#7f1d1d}

        .toast{position:fixed;right:18px;bottom:18px;z-index:60;max-width:420px}
        .toast-card{
            background:#fff;border:1px solid var(--crm-border);border-radius:12px;padding:12px 14px;
            box-shadow:var(--crm-shadow-md);display:flex;justify-content:space-between;gap:12px
        }
        .toast .close{background:transparent;border:none;cursor:pointer;font-weight:900;opacity:.8}
        .toast .close:hover{opacity:1}

        .alert{
            border-radius:12px;padding:12px 14px;border:1px solid var(--crm-border);background:#fff;
        }
        .alert.error{border-color:#fecaca;background:#fff5f5;color:#7f1d1d}
    </style>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('leadDetails', () => ({
                tab: localStorage.getItem('crm_lead_tab') || 'comments',
                setTab(t){
                    this.tab = t;
                    localStorage.setItem('crm_lead_tab', t);
                }
            }));
        });
    </script>

    {{-- Toast Success --}}
    @if(session('success'))
        <div class="toast" x-data="{show:true}" x-init="setTimeout(()=>show=false, 2600)" x-show="show" x-transition>
            <div class="toast-card">
                <div>
                    <strong>Success</strong>
                    <div class="mini" style="margin-top:2px">{{ session('success') }}</div>
                </div>
                <button class="close" @click="show=false" aria-label="Close">✕</button>
            </div>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert error" style="margin-bottom:12px">
            <strong style="display:block;margin-bottom:6px">Please fix:</strong>
            <ul style="margin:0;padding-left:18px">
                @foreach ($errors->all() as $error)
                    <li style="margin:2px 0">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <nav class="crm-breadcrumb">
        <a href="{{ route('crm.admin.leads.index') }}">Leads</a>
        <span>›</span>
        <span>Lead Details</span>
    </nav>

    <div class="lead-grid" x-data="leadDetails">
        {{-- LEFT COLUMN --}}
        <div>
            {{-- Profile --}}
            <div class="lead-card">
                <div class="lead-head">
                    <div>
                        <h2 class="lead-name">{{ $lead->name }}</h2>
                        <div class="lead-meta">
                            Created:
                            {{ optional($lead)->created_at ? \Carbon\Carbon::parse($lead->created_at)->toDayDateTimeString() : '—' }}
                        </div>
                    </div>
                    <div class="crm-avatar">{{ strtoupper(substr($lead->name ?? 'G',0,1)) }}</div>
                </div>

                <hr class="lead-divider">

                <div class="kv">
                    <div class="k">Phone</div><div class="v">{{ $lead->phone ?? '—' }}</div>
                    <div class="k">Email</div><div class="v">{{ $lead->email ?? '—' }}</div>
                    <div class="k">Source</div>
                    <div class="v"><span class="crm-badge crm-badge--source">{{ $lead->source->name ?? '—' }}</span></div>

                    <div class="k">Status</div>
                    <div class="v"><span class="crm-badge crm-badge--status">{{ $lead->status->name ?? '—' }}</span></div>

                    <div class="k">Assigned</div>
                    <div class="v">{{ optional($lead->assignedTo)->name ?? 'Unassigned' }}</div>
                </div>
            </div>

            {{-- Manage Lead --}}
            <div class="lead-card">
                <div class="panel-title">
                    <h3>Manage</h3>
                    <div class="hint">Assign & update status</div>
                </div>

                <form method="POST" action="{{ route('crm.admin.leads.assign', $lead->id) }}" class="form-stack">
                    @csrf
                    @method('PATCH')
                    <div>
                        <div class="mini" style="margin-bottom:6px">Assign to</div>
                        <select name="assigned_to" class="crm-select crm-input">
                            <option value="">Unassigned</option>
                            @foreach($sales as $s)
                                <option value="{{ $s->id }}" {{ optional($lead->assignedTo)->id == $s->id ? 'selected' : '' }}>
                                    {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="crm-btn crm-btn-primary full">Save Assignment</button>
                </form>

                <hr class="lead-divider">

                <form method="POST" action="{{ route('crm.admin.leads.status', $lead->id) }}" class="form-stack">
                    @csrf
                    @method('PATCH')
                    <div>
                        <div class="mini" style="margin-bottom:6px">Lead status</div>
                        <select name="status_id" class="crm-select crm-input">
                            @foreach(\App\Models\LeadStatus::orderBy('sort_order')->get() as $st)
                                <option value="{{ $st->id }}" {{ optional($lead->status)->id == $st->id ? 'selected' : '' }}>
                                    {{ $st->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="crm-btn crm-btn-ghost full">Update Status</button>
                </form>
            </div>

            {{-- Add Comment --}}
            <div class="lead-card">
                <div class="panel-title">
                    <h3>Add Comment</h3>
                    <div class="hint">Notes are saved to the timeline</div>
                </div>

                <form method="POST" action="{{ route('crm.admin.leads.comments.store', $lead->id) }}" class="form-stack">
                    @csrf
                    <textarea name="comment" class="crm-textarea crm-input" placeholder="Write a quick note...">{{ old('comment') }}</textarea>
                    <div class="form-actions">
                        <a href="{{ route('crm.admin.leads.index') }}" class="crm-btn crm-btn-ghost">Back</a>
                        <button class="crm-btn crm-btn-primary">Add Comment</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- RIGHT COLUMN --}}
        <div>
            <div class="tabs-row">
                <div class="tabs">
                    <button class="tab" :class="tab==='comments' ? 'tab active' : 'tab'" @click.prevent="setTab('comments')">Comments</button>
                    <button class="tab" :class="tab==='actions' ? 'tab active' : 'tab'" @click.prevent="setTab('actions')">Actions</button>
                    <button class="tab" :class="tab==='followups' ? 'tab active' : 'tab'" @click.prevent="setTab('followups')">Followups</button>
                </div>

                {{-- Quick create toolbar --}}
                <div class="toolbar">
                    <form method="POST" action="{{ route('crm.admin.leads.actions.store', $lead->id) }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
                        @csrf
                        <select name="action_type_id" class="crm-select crm-input">
                            <option value="">Action Type</option>
                            @foreach($actionTypes as $at)
                                <option value="{{ $at->id }}">{{ $at->name }}</option>
                            @endforeach
                        </select>

                        <input name="scheduled_at" type="datetime-local" class="crm-input" />

                        <button class="crm-btn crm-btn-ghost">Log Action</button>
                    </form>
                </div>
            </div>

            {{-- COMMENTS --}}
            <div x-show="tab==='comments'" x-cloak x-transition.opacity style="margin-top:12px">
                <div class="lead-card">
                    <div class="panel-title">
                        <h3>Comments</h3>
                        <div class="hint">{{ isset($comments) ? $comments->count() : 0 }} items</div>
                    </div>

                    @if(isset($comments) && $comments->count())
                        <div class="list">
                            @foreach($comments as $c)
                                <div class="item">
                                    <div class="item-head">
                                        <div>
                                            <div class="item-title">{{ optional($c->author)->name ?? 'System' }}</div>
                                            <div class="item-sub">{{ optional($c->created_at) ? \Carbon\Carbon::parse($c->created_at)->diffForHumans() : '' }}</div>
                                        </div>
                                        <span class="pill ok">Comment</span>
                                    </div>
                                    <div class="item-body">{{ $c->comment }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="crm-empty-state">No comments yet. Add one from the left panel.</div>
                    @endif
                </div>
            </div>

            {{-- ACTIONS --}}
            <div x-show="tab==='actions'" x-cloak x-transition.opacity style="margin-top:12px">
                <div class="lead-card">
                    <div class="panel-title">
                        <h3>Actions</h3>
                        <div class="hint">{{ isset($actions) ? $actions->count() : 0 }} items</div>
                    </div>

                    @if(isset($actions) && $actions->count())
                        <div class="list">
                            @foreach($actions as $act)
                                <div class="item">
                                    <div class="item-head">
                                        <div>
                                            <div class="item-title">{{ optional($act->type)->name ?? 'Action' }}</div>
                                            <div class="item-sub">
                                                {{ optional($act->scheduled_at) ? \Carbon\Carbon::parse($act->scheduled_at)->toDayDateTimeString() : '—' }}
                                            </div>
                                        </div>
                                        <span class="pill warn">Action</span>
                                    </div>
                                    <div class="item-body">{{ $act->notes ?: '—' }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="crm-empty-state">No actions logged yet. Use the toolbar to log the first action.</div>
                    @endif
                </div>
            </div>

            {{-- FOLLOWUPS --}}
            <div x-show="tab==='followups'" x-cloak x-transition.opacity style="margin-top:12px">
                <div class="lead-card">
                    <div class="panel-title">
                        <h3>Followups</h3>
                        <div class="hint">{{ isset($followups) ? $followups->count() : 0 }} items</div>
                    </div>

                    {{-- Schedule followup (moved here for better UX) --}}
                    <div class="lead-card" style="background:#fbfcfd;border-style:dashed;margin-bottom:12px">
                        <div class="panel-title">
                            <h3>Schedule Followup</h3>
                            <div class="hint">Set next step with a date/time</div>
                        </div>

                        <form method="POST" action="{{ route('crm.admin.leads.followups.store', $lead->id) }}" class="form-stack">
                            @csrf
                            <div class="crm-form-row">
                                <div style="flex:1">
                                    <div class="mini" style="margin-bottom:6px">When</div>
                                    <input type="datetime-local" name="scheduled_at" class="crm-input" />
                                </div>
                                <div style="flex:1">
                                    <div class="mini" style="margin-bottom:6px">Assign To</div>
                                    <select name="assigned_to" class="crm-input">
                                        <option value="">Unassigned</option>
                                        @foreach($sales as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="mini" style="margin-bottom:6px">Note</div>
                                <input name="note" class="crm-input" placeholder="e.g., Call to confirm installation date" />
                            </div>
                            <div class="form-actions">
                                <button class="crm-btn crm-btn-primary">Schedule</button>
                            </div>
                        </form>
                    </div>

                    @if(isset($followups) && $followups->count())
                        <div class="list">
                            @foreach($followups as $fup)
                                @php
                                    $when = $fup->scheduled_at ? \Carbon\Carbon::parse($fup->scheduled_at) : null;
                                    $isDone = (bool)($fup->completed ?? false);
                                    $isOverdue = $when && !$isDone && $when->isPast();
                                    $isToday = $when && !$isDone && $when->isToday();
                                @endphp

                                <div class="item">
                                    <div class="item-head">
                                        <div>
                                            <div class="item-title">Followup</div>
                                            <div class="item-sub">
                                                {{ $when ? $when->toDayDateTimeString() : '—' }}
                                            </div>
                                        </div>

                                        @if($isDone)
                                            <span class="pill ok">Done</span>
                                        @elseif($isOverdue)
                                            <span class="pill bad">Overdue</span>
                                        @elseif($isToday)
                                            <span class="pill warn">Today</span>
                                        @else
                                            <span class="pill">Planned</span>
                                        @endif
                                    </div>

                                    <div class="item-body">{{ $fup->note ?? '—' }}</div>

                                    <div style="margin-top:10px;display:flex;justify-content:flex-end">
                                        @if(!$isDone)
                                            <form method="POST" action="{{ route('crm.admin.followups.done', $fup->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="crm-btn crm-btn-ghost">Mark Done</button>
                                            </form>
                                        @else
                                            <div class="mini">
                                                Completed at
                                                {{ optional($fup->completed_at) ? \Carbon\Carbon::parse($fup->completed_at)->toDayDateTimeString() : '—' }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="crm-empty-state">No followups scheduled yet. Schedule one above.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
