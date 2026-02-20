@extends('crm.layouts.admin')

@section('title', 'Lead Details')
@section('subtitle', 'Profile and timeline')

@section('content')
<style>
    [x-cloak]{display:none!important}

    .dark{
        --lead-border: rgba(255,255,255,.10);
        --lead-bg: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
        --lead-shadow: 0 22px 60px rgba(0,0,0,.35);
        --lead-card-bg: rgba(0,0,0,.14);
        --lead-card-border: rgba(255,255,255,.10);
        --lead-card-shadow: 0 12px 26px rgba(0,0,0,.22);
        --lead-text: rgba(255,255,255,.92);
        --lead-muted: rgba(255,255,255,.62);
        --lead-input-bg: rgba(255,255,255,.04);
        --lead-input-border: rgba(255,255,255,.14);
        --lead-input-color: rgba(255,255,255,.90);
        --lead-input-placeholder: rgba(255,255,255,.55);
        --lead-tab-bg: rgba(255,255,255,.04);
        --lead-tab-border: rgba(255,255,255,.12);
        --lead-tab-text: rgba(255,255,255,.86);
        --lead-item-bg: rgba(0,0,0,.10);
        --lead-item-border: rgba(255,255,255,.10);
        --lead-pill-bg: rgba(255,255,255,.05);
        --lead-pill-border: rgba(255,255,255,.14);
        --lead-pill-text: rgba(255,255,255,.82);
        --lead-toast-bg: rgba(0,0,0,.35);
        --lead-toast-border: rgba(255,255,255,.12);
        --lead-toast-text: rgba(255,255,255,.88);
        --lead-crumb: rgba(255,255,255,.62);
        --lead-select-bg: rgba(7,11,18,.94);
        --lead-select-head: rgba(255,255,255,.03);
        --lead-select-pill-bg: rgba(0,0,0,.14);
        --lead-select-pill-border: rgba(255,255,255,.14);
        --lead-select-pill-text: rgba(255,255,255,.72);
    }

    html:not(.dark){
        --lead-border: rgba(0,0,0,.12);
        --lead-bg: #FFFFFF;
        --lead-shadow: 0 4px 12px rgba(0,0,0,.08);
        --lead-card-bg: #FFFFFF;
        --lead-card-border: rgba(0,0,0,.12);
        --lead-card-shadow: 0 2px 8px rgba(0,0,0,.06);
        --lead-text: rgba(0,0,0,.92);
        --lead-muted: rgba(0,0,0,.60);
        --lead-input-bg: rgba(0,0,0,.03);
        --lead-input-border: rgba(0,0,0,.18);
        --lead-input-color: rgba(0,0,0,.95);
        --lead-input-placeholder: rgba(0,0,0,.50);
        --lead-tab-bg: rgba(0,0,0,.05);
        --lead-tab-border: rgba(0,0,0,.15);
        --lead-tab-text: rgba(0,0,0,.85);
        --lead-item-bg: rgba(0,0,0,.03);
        --lead-item-border: rgba(0,0,0,.10);
        --lead-pill-bg: rgba(0,0,0,.05);
        --lead-pill-border: rgba(0,0,0,.15);
        --lead-pill-text: rgba(0,0,0,.85);
        --lead-toast-bg: #FFFFFF;
        --lead-toast-border: rgba(0,0,0,.12);
        --lead-toast-text: rgba(0,0,0,.88);
        --lead-crumb: rgba(0,0,0,.60);
        --lead-select-bg: #FFFFFF;
        --lead-select-head: rgba(0,0,0,.03);
        --lead-select-pill-bg: rgba(0,0,0,.05);
        --lead-select-pill-border: rgba(0,0,0,.15);
        --lead-select-pill-text: rgba(0,0,0,.70);
    }

    .lead-shell{
        position:relative;
        border-radius:20px;
        overflow: visible;
        border:1px solid var(--lead-border);
        background: var(--lead-bg);
        box-shadow: var(--lead-shadow);
    }
    .lead-bg{
        position:absolute; inset:0; z-index:0; pointer-events:none;
        background:
            radial-gradient(900px 520px at 16% 10%, rgba(140,198,63,.14), transparent 55%),
            radial-gradient(900px 520px at 86% 18%, rgba(255,223,65,.14), transparent 55%),
            radial-gradient(800px 520px at 72% 90%, rgba(227,160,0,.10), transparent 55%);
        filter: blur(14px);
        opacity:.7;
        border-radius:20px;
    }
    html:not(.dark) .lead-bg{display:none}
    .lead-wrap{position:relative; z-index:1; padding:16px}

    .lead-grid{display:grid;grid-template-columns:380px 1fr;gap:14px;align-items:start}
    @media(max-width:1024px){.lead-grid{grid-template-columns:1fr}}

    .card{
        position:relative;
        z-index:1;
        border-radius:16px;
        border:1px solid var(--lead-card-border);
        background: var(--lead-card-bg);
        box-shadow: var(--lead-card-shadow);
        backdrop-filter: blur(10px);
        padding:14px;
    }
    .card + .card{margin-top:12px}

    .head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px}
    .name{margin:0;font-size:18px;font-weight:900;color:var(--lead-text)}
    .meta{margin-top:6px;font-size:12px;font-weight:800;color:var(--lead-muted)}
    .divider{border:none;border-top:1px solid var(--lead-border);margin:12px 0}

    .kv{display:grid;grid-template-columns:92px 1fr;gap:10px;row-gap:10px;font-size:13px}
    .kv .k{color:var(--lead-muted);font-weight:900}
    .kv .v{font-weight:800;color:var(--lead-text)}

    .mini{font-size:12px;font-weight:800;color:var(--lead-muted)}
    .panel-title{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:10px}
    .panel-title h3{margin:0;font-size:14px;font-weight:900;color:var(--lead-text)}

    .dark-input, .dark-textarea{
        width:100%;
        padding:10px 12px;
        border-radius:14px;
        border:1px solid var(--lead-input-border);
        background: var(--lead-input-bg);
        color: var(--lead-input-color);
        font-weight:800;
        outline:none;
    }
    .dark-textarea{min-height:110px;resize:vertical}
    .dark-input::placeholder{color: var(--lead-input-placeholder)}
    .dark-input:focus, .dark-textarea:focus{
        border-color: rgba(255,223,65,.28);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }

    .actions-row{display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap}
    .full{width:100%}

    .tabs-row{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap}
    .tabs{display:flex;gap:8px;flex-wrap:wrap}
    .tab{
        background: var(--lead-tab-bg);
        border:1px solid var(--lead-tab-border);
        color: var(--lead-tab-text);
        padding:9px 12px;border-radius:12px;font-weight:900;cursor:pointer;
    }
    .tab:hover{background: var(--lead-input-bg)}
    .tab.active{
        border-color: rgba(255,223,65,.26);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }

    .list{display:flex;flex-direction:column;gap:10px}
    .item{
        border-radius:14px;
        border:1px solid var(--lead-item-border);
        background: var(--lead-item-bg);
        padding:12px;
    }
    .item-head{display:flex;gap:10px;align-items:center;justify-content:space-between;flex-wrap:wrap}
    .item-title{font-weight:900;color:var(--lead-text)}
    .item-sub{font-size:12px;font-weight:800;color:var(--lead-muted)}
    .item-body{margin-top:8px;font-weight:800;color:var(--lead-text);line-height:1.55}

    .pill{
        display:inline-flex;align-items:center;gap:8px;
        padding:6px 10px;border-radius:999px;
        border:1px solid var(--lead-pill-border);
        background: var(--lead-pill-bg);
        font-size:12px;font-weight:900;color: var(--lead-pill-text);
        white-space:nowrap;
    }
    .pill.ok{border-color:#a7f3d0;background:rgba(16,185,129,.14);color:#c7f9e9}
    .pill.warn{border-color:#fde68a;background:rgba(245,158,11,.12);color:#ffe9b5}
    .pill.bad{border-color:#fecaca;background:rgba(239,68,68,.12);color:#ffd0d0}

    .toast{position:fixed;right:18px;bottom:18px;z-index:9999;max-width:420px}
    .toast-card{
        background: var(--lead-toast-bg);
        border:1px solid var(--lead-toast-border);
        border-radius:14px;
        padding:12px 14px;
        box-shadow: 0 18px 40px rgba(0,0,0,.35);
        backdrop-filter: blur(10px);
        display:flex;justify-content:space-between;gap:12px;
        color: var(--lead-toast-text);
    }
    .toast .close{background:transparent;border:none;cursor:pointer;font-weight:900;opacity:.8;color:var(--lead-text)}
    .toast .close:hover{opacity:1}

    .crumb{display:flex;gap:8px;align-items:center;font-size:12px;font-weight:900;color:var(--lead-crumb);margin-bottom:10px}
    .crumb a{color:var(--lead-text);text-decoration:none}
    .crumb a:hover{text-decoration:underline}

    /* ===== Custom Select (Dark) ===== */
    .cselect{position:relative;min-width:220px;flex:1;z-index:5}
    .cselect.open{z-index:5000}
    .cselect-btn{
        width:100%;
        display:flex;align-items:center;justify-content:space-between;gap:10px;
        padding:10px 12px;
        border-radius:14px;
        border:1px solid var(--lead-input-border);
        background: var(--lead-input-bg);
        color: var(--lead-input-color);
        font-weight:900;
        cursor:pointer;
        outline:none;
    }
    .cselect-btn:hover{background: var(--lead-input-bg)}
    .cselect-btn:focus{
        border-color: rgba(255,223,65,.28);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }
    .cselect-label{display:flex;align-items:center;gap:10px;min-width:0}
    .cselect-pill{
        font-size:11px;font-weight:900;
        padding:5px 8px;border-radius:999px;
        border:1px solid var(--lead-select-pill-border);
        background: var(--lead-select-pill-bg);
        color: var(--lead-select-pill-text);
        white-space:nowrap;
    }
    .cselect-text{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .cselect-menu{
        position:absolute;left:0;right:0;top:calc(100% + 8px);
        border-radius:14px;
        border:1px solid var(--lead-border);
        background: var(--lead-select-bg);
        box-shadow: 0 22px 60px rgba(0,0,0,.55);
        backdrop-filter: blur(10px);
        overflow:hidden;
        z-index:9000;
    }
    .cselect-search{
        padding:10px;
        border-bottom:1px solid var(--lead-border);
        background: var(--lead-select-head);
    }
    .cselect-item{
        padding:10px 12px;
        display:flex;align-items:center;justify-content:space-between;gap:10px;
        color: var(--lead-text);
        font-weight:900;
        cursor:pointer;
    }
    .cselect-item:hover{background: var(--lead-input-bg)}
    .cselect-item.active{background: rgba(255,223,65,.10)}
    .cselect-muted{font-weight:800;color: var(--lead-muted);font-size:12px}
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('leadDetails', () => ({
            tab: localStorage.getItem('crm_lead_tab') || 'comments',
            setTab(t){ this.tab=t; localStorage.setItem('crm_lead_tab', t); }
        }));

        Alpine.data('cselect', (opts) => ({
            open:false,
            q:'',
            value: opts.value || '',
            label: opts.label || 'Select…',
            items: opts.items || [],
            get filtered(){
                if(!this.q) return this.items;
                const s = this.q.toLowerCase();
                return this.items.filter(i => (i.label || '').toLowerCase().includes(s));
            },
            pick(item){
                this.value = item.value;
                this.label = item.label;
                this.open = false;
                this.q = '';
            }
        }));
    });
</script>

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

@php
    $assigneeItems = collect($sales)->map(fn($u) => ['value'=>(string)$u->id,'label'=>$u->name])->values();
    $statusItems = \App\Models\LeadStatus::orderBy('sort_order')->get()->map(fn($st)=>['value'=>(string)$st->id,'label'=>$st->name])->values();
    $actionItems = $actionTypes->map(fn($t)=>['value'=>(string)$t->id,'label'=>$t->name])->values();

    $currentAssigneeId = optional($lead->assignedTo)->id ? (string)optional($lead->assignedTo)->id : '';
    $currentAssigneeLabel = optional($lead->assignedTo)->name ?? 'Unassigned';

    $currentStatusId = optional($lead->status)->id ? (string)optional($lead->status)->id : '';
    $currentStatusLabel = optional($lead->status)->name ?? '—';
@endphp

<div class="lead-shell">
    <div class="lead-bg" aria-hidden="true"></div>

    <div class="lead-wrap">
        <nav class="crumb">
            <a href="{{ route('crm.admin.leads.index') }}">Leads</a>
            <span>›</span>
            <span>Lead Details</span>
        </nav>

        <div class="lead-grid" x-data="leadDetails">
            {{-- LEFT --}}
            <div>
                <div class="card">
                    <div class="head">
                        <div>
                            <h2 class="name">{{ $lead->name }}</h2>
                            <div class="meta">
                                Created: {{ $lead->created_at ? $lead->created_at->toDayDateTimeString() : '—' }}
                            </div>
                        </div>
                        <div class="crm-avatar">{{ strtoupper(substr($lead->name ?? 'G',0,1)) }}</div>
                    </div>

                    <hr class="divider">

                    <div class="kv">
                        <div class="k">Phone</div><div class="v">{{ $lead->phone ?? '—' }}</div>
                        <div class="k">Email</div><div class="v">{{ $lead->email ?? '—' }}</div>
                        <div class="k">Source</div><div class="v">{{ optional($lead->source)->name ?? '—' }}</div>
                        <div class="k">Status</div><div class="v">{{ optional($lead->status)->name ?? '—' }}</div>
                        <div class="k">Assigned</div><div class="v">{{ optional($lead->assignedTo)->name ?? 'Unassigned' }}</div>
                    </div>
                </div>

                {{-- MANAGE --}}
                <div class="card">
                    <div class="panel-title">
                        <h3>Manage</h3>
                        <div class="mini">Assign & update status</div>
                    </div>

                    {{-- Assign --}}
                    <form method="POST" action="{{ route('crm.admin.leads.assign', $lead->id) }}" style="display:flex;flex-direction:column;gap:10px">
                        @csrf
                        @method('PATCH')

                        <div>
                            <div class="mini" style="margin-bottom:6px">Assign to</div>

                            <div class="cselect"
                                 x-data="cselect({ value:'{{ $currentAssigneeId }}', label:'{{ addslashes($currentAssigneeLabel) }}', items:[{value:'',label:'Unassigned'}, ...{{ $assigneeItems->toJson() }}] })"
                                 :class="open ? 'open' : ''"
                                 @click.outside="open=false"
                            >
                                <input type="hidden" name="assigned_to" :value="value">

                                <button type="button" class="cselect-btn" @click="open=!open">
                                    <span class="cselect-label">
                                        <span class="cselect-pill">Assign</span>
                                        <span class="cselect-text" x-text="label"></span>
                                    </span>
                                    <span style="opacity:.8;font-weight:900" x-text="open ? '▲' : '▼'"></span>
                                </button>

                                <div class="cselect-menu" x-show="open" x-transition.opacity x-cloak>
                                    <div class="cselect-search">
                                        <input class="dark-input" style="padding:9px 10px;border-radius:12px" placeholder="Search assignee…" x-model="q">
                                    </div>
                                    <div style="max-height:260px;overflow:auto">
                                        <template x-for="item in filtered" :key="item.value">
                                            <div class="cselect-item" :class="(item.value===value) ? 'active' : ''" @click="pick(item)">
                                                <span x-text="item.label"></span>
                                                <span class="cselect-muted" x-show="item.value===value">Selected</span>
                                            </div>
                                        </template>
                                        <div class="cselect-item cselect-muted" x-show="filtered.length===0" style="justify-content:center">No results</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="crm-btn crm-btn-primary full">Save Assignment</button>
                    </form>

                    <hr class="divider">

                    {{-- Status --}}
                    <form method="POST" action="{{ route('crm.admin.leads.status', $lead->id) }}" style="display:flex;flex-direction:column;gap:10px">
                        @csrf
                        @method('PATCH')

                        <div>
                            <div class="mini" style="margin-bottom:6px">Lead status</div>

                            <div class="cselect"
                                 x-data="cselect({ value:'{{ $currentStatusId }}', label:'{{ addslashes($currentStatusLabel) }}', items: {{ $statusItems->toJson() }} })"
                                 :class="open ? 'open' : ''"
                                 @click.outside="open=false"
                            >
                                <input type="hidden" name="status_id" :value="value">

                                <button type="button" class="cselect-btn" @click="open=!open">
                                    <span class="cselect-label">
                                        <span class="cselect-pill">Status</span>
                                        <span class="cselect-text" x-text="label"></span>
                                    </span>
                                    <span style="opacity:.8;font-weight:900" x-text="open ? '▲' : '▼'"></span>
                                </button>

                                <div class="cselect-menu" x-show="open" x-transition.opacity x-cloak>
                                    <div class="cselect-search">
                                        <input class="dark-input" style="padding:9px 10px;border-radius:12px" placeholder="Search status…" x-model="q">
                                    </div>
                                    <div style="max-height:260px;overflow:auto">
                                        <template x-for="item in filtered" :key="item.value">
                                            <div class="cselect-item" :class="(item.value===value) ? 'active' : ''" @click="pick(item)">
                                                <span x-text="item.label"></span>
                                                <span class="cselect-muted" x-show="item.value===value">Selected</span>
                                            </div>
                                        </template>
                                        <div class="cselect-item cselect-muted" x-show="filtered.length===0" style="justify-content:center">No results</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="crm-btn crm-btn-ghost full">Update Status</button>
                    </form>
                </div>

                {{-- Add Comment --}}
                <div class="card">
                    <div class="panel-title">
                        <h3>Add Comment</h3>
                        <div class="mini">Saved to timeline</div>
                    </div>

                    <form method="POST" action="{{ route('crm.admin.leads.comments.store', $lead->id) }}" style="display:flex;flex-direction:column;gap:10px">
                        @csrf
                        <textarea name="comment" class="dark-textarea" placeholder="Write a quick note...">{{ old('comment') }}</textarea>

                        <div class="actions-row">
                            <a href="{{ route('crm.admin.leads.index') }}" class="crm-btn crm-btn-ghost">Back</a>
                            <button class="crm-btn crm-btn-primary">Add Comment</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- RIGHT --}}
            <div>
                <div class="card">
                    <div class="tabs-row">
                        <div class="tabs">
                            <button class="tab" :class="tab==='comments' ? 'tab active' : 'tab'" @click.prevent="setTab('comments')">Comments</button>
                            <button class="tab" :class="tab==='actions' ? 'tab active' : 'tab'" @click.prevent="setTab('actions')">Actions</button>
                            <button class="tab" :class="tab==='followups' ? 'tab active' : 'tab'" @click.prevent="setTab('followups')">Followups</button>
                        </div>

                        {{-- Action Toolbar --}}
                        <form method="POST" action="{{ route('crm.admin.leads.actions.store', $lead->id) }}"
                              style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;flex:1;justify-content:flex-end">
                            @csrf

                            <div class="cselect"
                                 x-data="cselect({ value:'', label:'Action Type', items: {{ $actionItems->toJson() }} })"
                                 :class="open ? 'open' : ''"
                                 @click.outside="open=false"
                            >
                                <input type="hidden" name="action_type_id" :value="value">

                                <button type="button" class="cselect-btn" @click="open=!open">
                                    <span class="cselect-label">
                                        <span class="cselect-pill">Type</span>
                                        <span class="cselect-text" x-text="label"></span>
                                    </span>
                                    <span style="opacity:.8;font-weight:900" x-text="open ? '▲' : '▼'"></span>
                                </button>

                                <div class="cselect-menu" x-show="open" x-transition.opacity x-cloak>
                                    <div class="cselect-search">
                                        <input class="dark-input" style="padding:9px 10px;border-radius:12px" placeholder="Search action type…" x-model="q">
                                    </div>
                                    <div style="max-height:260px;overflow:auto">
                                        <template x-for="item in filtered" :key="item.value">
                                            <div class="cselect-item" :class="(item.value===value) ? 'active' : ''" @click="pick(item)">
                                                <span x-text="item.label"></span>
                                                <span class="cselect-muted" x-show="item.value===value">Selected</span>
                                            </div>
                                        </template>
                                        <div class="cselect-item cselect-muted" x-show="filtered.length===0" style="justify-content:center">No results</div>
                                    </div>
                                </div>
                            </div>

                            <input name="scheduled_at" type="datetime-local" required class="dark-input" style="min-width:210px" />
                            <button class="crm-btn crm-btn-ghost">Log Action</button>
                        </form>
                    </div>
                </div>

                {{-- COMMENTS --}}
                <div x-show="tab==='comments'" x-cloak x-transition.opacity style="margin-top:12px">
                    <div class="card">
                        <div class="panel-title">
                            <h3>Comments</h3>
                            <div class="mini">{{ $comments?->count() ?? 0 }} items</div>
                        </div>

                        @if(isset($comments) && $comments->count())
                            <div class="list">
                                @foreach($comments as $c)
                                    <div class="item">
                                        <div class="item-head">
                                            <div>
                                                <div class="item-title">{{ optional($c->author)->name ?? 'System' }}</div>
                                                <div class="item-sub">{{ $c->created_at?->diffForHumans() }}</div>
                                            </div>
                                            <span class="pill ok">Comment</span>
                                        </div>
                                        <div class="item-body">{{ $c->comment }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mini">No comments yet.</div>
                        @endif
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div x-show="tab==='actions'" x-cloak x-transition.opacity style="margin-top:12px">
                    <div class="card">
                        <div class="panel-title">
                            <h3>Actions</h3>
                            <div class="mini">{{ $actions?->count() ?? 0 }} items</div>
                        </div>

                        @if(isset($actions) && $actions->count())
                            <div class="list">
                                @foreach($actions as $act)
                                    <div class="item">
                                        <div class="item-head">
                                            <div>
                                                <div class="item-title">{{ optional($act->type)->name ?? 'Action' }}</div>
                                                <div class="item-sub">{{ $act->scheduled_at ? \Carbon\Carbon::parse($act->scheduled_at)->toDayDateTimeString() : '—' }}</div>
                                            </div>
                                            <span class="pill warn">Action</span>
                                        </div>
                                        <div class="item-body">{{ $act->notes ?: '—' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mini">No actions logged yet.</div>
                        @endif
                    </div>
                </div>

                {{-- FOLLOWUPS --}}
                <div x-show="tab==='followups'" x-cloak x-transition.opacity style="margin-top:12px">
                    <div class="card">
                        <div class="panel-title">
                            <h3>Schedule Followup</h3>
                            <div class="mini">Set next step with date/time</div>
                        </div>

                        <form method="POST" action="{{ route('crm.admin.leads.followups.store', $lead->id) }}" style="display:flex;flex-direction:column;gap:10px">
                            @csrf

                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                <div>
                                    <div class="mini" style="margin-bottom:6px">When</div>
                                    <input type="datetime-local" name="scheduled_at" class="dark-input" />
                                </div>

                                <div>
                                    <div class="mini" style="margin-bottom:6px">Assign to</div>

                                    <div class="cselect"
                                         x-data="cselect({ value:'', label:'Unassigned', items:[{value:'',label:'Unassigned'}, ...{{ $assigneeItems->toJson() }}] })"
                                         :class="open ? 'open' : ''"
                                         @click.outside="open=false"
                                    >
                                        <input type="hidden" name="assigned_to" :value="value">

                                        <button type="button" class="cselect-btn" @click="open=!open">
                                            <span class="cselect-label">
                                                <span class="cselect-pill">Assign</span>
                                                <span class="cselect-text" x-text="label"></span>
                                            </span>
                                            <span style="opacity:.8;font-weight:900" x-text="open ? '▲' : '▼'"></span>
                                        </button>

                                        <div class="cselect-menu" x-show="open" x-transition.opacity x-cloak>
                                            <div class="cselect-search">
                                                <input class="dark-input" style="padding:9px 10px;border-radius:12px" placeholder="Search assignee…" x-model="q">
                                            </div>
                                            <div style="max-height:260px;overflow:auto">
                                                <template x-for="item in filtered" :key="item.value">
                                                    <div class="cselect-item" :class="(item.value===value) ? 'active' : ''" @click="pick(item)">
                                                        <span x-text="item.label"></span>
                                                        <span class="cselect-muted" x-show="item.value===value">Selected</span>
                                                    </div>
                                                </template>
                                                <div class="cselect-item cselect-muted" x-show="filtered.length===0" style="justify-content:center">No results</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div>
                                <div class="mini" style="margin-bottom:6px">Note</div>
                                <input name="note" class="dark-input" placeholder="e.g., Call to confirm installation date" />
                            </div>

                            <div class="actions-row">
                                <button class="crm-btn crm-btn-primary">Schedule</button>
                            </div>
                        </form>

                        <hr class="divider">

                        <div class="panel-title">
                            <h3>Followups</h3>
                            <div class="mini">{{ $followups?->count() ?? 0 }} items</div>
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
                                                <div class="item-sub">{{ $when ? $when->toDayDateTimeString() : '—' }}</div>
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

                                        <div class="actions-row" style="margin-top:10px">
                                            @if(!$isDone)
                                                <form method="POST" action="{{ route('crm.admin.followups.done', $fup->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="crm-btn crm-btn-ghost">Mark Done</button>
                                                </form>
                                            @else
                                                <div class="mini">
                                                    Completed at {{ $fup->completed_at ? \Carbon\Carbon::parse($fup->completed_at)->toDayDateTimeString() : '—' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mini">No followups scheduled yet.</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

