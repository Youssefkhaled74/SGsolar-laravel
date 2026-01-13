@extends('crm.layouts.sales')

@section('title','Lead')

@section('content')
<style>
    [x-cloak]{display:none!important}

    :root{
        --s-border:rgba(255,255,255,.10);
        --s-text:rgba(255,255,255,.92);
        --s-muted:rgba(255,255,255,.62);
        --s-card:rgba(0,0,0,.14);
        --s-shadow2: 0 12px 26px rgba(0,0,0,.22);
        --brand-yellow: {{ config('website.primary_color', '#FFDF41') }};
        --brand-orange: {{ config('website.secondary_color', '#E3A000') }};
    }

    .shell{
        position:relative;
        border-radius:20px;
        overflow:visible; /* IMPORTANT for dropdown overlays */
        border:1px solid var(--s-border);
        background: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
        box-shadow: 0 22px 60px rgba(0,0,0,.35);
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
        border-radius:20px;
    }
    .wrap{position:relative; z-index:1; padding:16px}

    .crumb{display:flex;gap:8px;align-items:center;font-size:12px;font-weight:900;color:var(--s-muted);margin-bottom:12px}
    .crumb a{color:rgba(255,255,255,.86);text-decoration:none}
    .crumb a:hover{text-decoration:underline}

    .grid{display:grid;grid-template-columns:380px 1fr;gap:14px;align-items:start}
    @media(max-width:1024px){.grid{grid-template-columns:1fr}}

    .card{
        position:relative;
        z-index:1;
        border-radius:16px;
        border:1px solid var(--s-border);
        background: var(--s-card);
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        padding:14px;
    }
    .card + .card{margin-top:12px}

    .head{display:flex;align-items:flex-start;justify-content:space-between;gap:12px}
    .name{margin:0;font-size:18px;font-weight:900;color:var(--s-text)}
    .meta{margin-top:6px;font-size:12px;font-weight:800;color:var(--s-muted)}
    .divider{border:none;border-top:1px solid rgba(255,255,255,.10);margin:12px 0}

    .kv{display:grid;grid-template-columns:92px 1fr;gap:10px;row-gap:10px;font-size:13px}
    .kv .k{color:var(--s-muted);font-weight:900}
    .kv .v{font-weight:800;color:rgba(255,255,255,.88)}

    .mini{font-size:12px;font-weight:800;color:var(--s-muted)}
    .panel-title{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:10px}
    .panel-title h3{margin:0;font-size:14px;font-weight:900;color:rgba(255,255,255,.90)}

    .dark-input, .dark-textarea{
        width:100%;
        padding:10px 12px;
        border-radius:14px;
        border:1px solid rgba(255,255,255,.14);
        background: rgba(255,255,255,.04);
        color: rgba(255,255,255,.90);
        font-weight:800;
        outline:none;
    }
    .dark-textarea{min-height:110px;resize:vertical}
    .dark-input::placeholder{color: rgba(255,255,255,.55)}
    .dark-input:focus, .dark-textarea:focus{
        border-color: rgba(255,223,65,.28);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }

    .tabs{display:flex;gap:8px;flex-wrap:wrap}
    .tab{
        background: rgba(255,255,255,.04);
        border:1px solid rgba(255,255,255,.12);
        color: rgba(255,255,255,.86);
        padding:9px 12px;border-radius:12px;font-weight:900;cursor:pointer;
    }
    .tab:hover{background: rgba(255,255,255,.07)}
    .tab.active{border-color: rgba(255,223,65,.26);box-shadow: 0 0 0 4px rgba(255,223,65,.10)}

    .list{display:flex;flex-direction:column;gap:10px}
    .item{border-radius:14px;border:1px solid rgba(255,255,255,.10);background: rgba(0,0,0,.10);padding:12px}
    .item-head{display:flex;gap:10px;align-items:center;justify-content:space-between;flex-wrap:wrap}
    .item-title{font-weight:900;color:rgba(255,255,255,.90)}
    .item-sub{font-size:12px;font-weight:800;color:rgba(255,255,255,.62)}
    .item-body{margin-top:8px;font-weight:800;color:rgba(255,255,255,.86);line-height:1.55}

    .pill{
        display:inline-flex;align-items:center;gap:8px;
        padding:6px 10px;border-radius:999px;
        border:1px solid rgba(255,255,255,.14);
        background: rgba(255,255,255,.05);
        font-size:12px;font-weight:900;color: rgba(255,255,255,.82);
        white-space:nowrap;
    }
    .pill.ok{border-color:#a7f3d0;background:rgba(16,185,129,.14);color:#c7f9e9}
    .pill.warn{border-color:#fde68a;background:rgba(245,158,11,.12);color:#ffe9b5}
    .pill.bad{border-color:#fecaca;background:rgba(239,68,68,.12);color:#ffd0d0}

    /* Buttons */
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

    /* ===== Custom Select (Dark) - fixes dropdown clipping ===== */
    .cselect{position:relative;min-width:220px;flex:1;z-index:5}
    .cselect.open{z-index:5000}
    .cselect-btn{
        width:100%;
        display:flex;align-items:center;justify-content:space-between;gap:10px;
        padding:10px 12px;
        border-radius:14px;
        border:1px solid rgba(255,255,255,.14);
        background: rgba(255,255,255,.04);
        color: rgba(255,255,255,.90);
        font-weight:900;
        cursor:pointer;
        outline:none;
    }
    .cselect-btn:hover{background: rgba(255,255,255,.06)}
    .cselect-btn:focus{border-color: rgba(255,223,65,.28);box-shadow: 0 0 0 4px rgba(255,223,65,.10)}
    .cselect-label{display:flex;align-items:center;gap:10px;min-width:0}
    .cselect-pill{
        font-size:11px;font-weight:900;
        padding:5px 8px;border-radius:999px;
        border:1px solid rgba(255,255,255,.14);
        background: rgba(0,0,0,.14);
        color: rgba(255,255,255,.72);
        white-space:nowrap;
    }
    .cselect-text{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .cselect-menu{
        position:absolute;left:0;right:0;top:calc(100% + 8px);
        border-radius:14px;
        border:1px solid rgba(255,255,255,.12);
        background: rgba(7,11,18,.94);
        box-shadow: 0 22px 60px rgba(0,0,0,.55);
        backdrop-filter: blur(10px);
        overflow:hidden;
        z-index:9000;
    }
    .cselect-search{padding:10px;border-bottom:1px solid rgba(255,255,255,.08);background: rgba(255,255,255,.03)}
    .cselect-item{
        padding:10px 12px;
        display:flex;align-items:center;justify-content:space-between;gap:10px;
        color: rgba(255,255,255,.86);
        font-weight:900;
        cursor:pointer;
    }
    .cselect-item:hover{background: rgba(255,255,255,.06)}
    .cselect-item.active{background: rgba(255,223,65,.10)}
    .cselect-muted{font-weight:800;color: rgba(255,255,255,.62);font-size:12px}
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('leadSalesDetails', () => ({
            tab: localStorage.getItem('crm_sales_lead_tab') || 'comments',
            setTab(t){ this.tab=t; localStorage.setItem('crm_sales_lead_tab', t); }
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

@php
    $actionItems = ($actionTypes ?? collect())->map(fn($t) => ['value' => (string)$t->id, 'label' => $t->name])->values();
@endphp

<div class="shell">
    <div class="bg" aria-hidden="true"></div>

    <div class="wrap" x-data="leadSalesDetails">
        <nav class="crumb">
            <a href="{{ route('crm.sales.leads.index') }}">My Leads</a>
            <span>›</span>
            <span>{{ $lead->name }}</span>
        </nav>

        <div class="grid">
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
                    </div>
                </div>

                <div class="card">
                    <div class="panel-title">
                        <h3>Add Comment</h3>
                        <div class="mini">Saved to timeline</div>
                    </div>

                    <form method="POST" action="{{ route('crm.sales.leads.comments.store', $lead->id) }}" style="display:flex;flex-direction:column;gap:10px">
                        @csrf
                        <textarea name="comment" class="dark-textarea" placeholder="Write a quick note...">{{ old('comment') }}</textarea>
                        <div style="display:flex;justify-content:flex-end">
                            <button class="crm-btn crm-btn-primary">Add Comment</button>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <div class="panel-title">
                        <h3>Log Action</h3>
                        <div class="mini">Track calls, meetings, etc.</div>
                    </div>

                    <form method="POST" action="{{ route('crm.sales.leads.actions.store', $lead->id) }}"
                          style="display:flex;flex-direction:column;gap:10px">
                        @csrf

                        <div
                            class="cselect"
                            x-data="cselect({ value:'', label:'Action Type', items: {{ $actionItems->toJson() }} })"
                            :class="open ? 'open' : ''"
                            @click.outside="open=false"
                            @keydown.escape.window="open=false"
                        >
                            <input type="hidden" name="action_type_id" :value="value">

                            <button type="button" class="cselect-btn" @click="open=!open" :aria-expanded="open">
                                <span class="cselect-label">
                                    <span class="cselect-pill">Type</span>
                                    <span class="cselect-text" x-text="label"></span>
                                </span>
                                <span style="opacity:.8;font-weight:900" x-text="open ? '▲' : '▼'"></span>
                            </button>

                            <div class="cselect-menu" x-show="open" x-transition.opacity x-cloak>
                                <div class="cselect-search">
                                    <input class="dark-input" style="padding:9px 10px;border-radius:12px"
                                           placeholder="Search action type…"
                                           x-model="q">
                                </div>

                                <div style="max-height:260px;overflow:auto">
                                    <template x-for="item in filtered" :key="item.value">
                                        <div class="cselect-item" :class="(item.value===value) ? 'active' : ''" @click="pick(item)">
                                            <span x-text="item.label"></span>
                                            <span class="cselect-muted" x-show="item.value===value">Selected</span>
                                        </div>
                                    </template>

                                    <div class="cselect-item cselect-muted" x-show="filtered.length===0" style="justify-content:center">
                                        No results
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="datetime-local" name="scheduled_at" class="dark-input" />

                        <div style="display:flex;justify-content:flex-end">
                            <button class="crm-btn crm-btn-ghost">Log</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- RIGHT --}}
            <div>
                <div class="card">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
                        <div class="tabs">
                            <button class="tab" :class="tab==='comments' ? 'tab active' : 'tab'" @click.prevent="setTab('comments')">Comments</button>
                            <button class="tab" :class="tab==='actions' ? 'tab active' : 'tab'" @click.prevent="setTab('actions')">Actions</button>
                            <button class="tab" :class="tab==='followups' ? 'tab active' : 'tab'" @click.prevent="setTab('followups')">Followups</button>
                        </div>
                        <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-ghost">Back</a>
                    </div>
                </div>

                {{-- COMMENTS --}}
                <div x-show="tab==='comments'" x-cloak x-transition.opacity style="margin-top:12px">
                    <div class="card">
                        <div class="panel-title">
                            <h3>Comments</h3>
                            <div class="mini">{{ $comments?->count() ?? 0 }} items</div>
                        </div>

                        @if($comments->count())
                            <div class="list">
                                @foreach($comments as $c)
                                    <div class="item">
                                        <div class="item-head">
                                            <div>
                                                <div class="item-title">{{ optional($c->author)->name ?? 'You' }}</div>
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

                        @if($actions->count())
                            <div class="list">
                                @foreach($actions as $a)
                                    <div class="item">
                                        <div class="item-head">
                                            <div>
                                                <div class="item-title">{{ optional($a->type)->name ?? 'Action' }}</div>
                                                <div class="item-sub">{{ $a->scheduled_at ? \Carbon\Carbon::parse($a->scheduled_at)->toDayDateTimeString() : '—' }}</div>
                                            </div>
                                            <span class="pill warn">Action</span>
                                        </div>
                                        <div class="item-body">{{ $a->notes ?: '—' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mini">No actions logged.</div>
                        @endif
                    </div>
                </div>

                {{-- FOLLOWUPS --}}
                <div x-show="tab==='followups'" x-cloak x-transition.opacity style="margin-top:12px">
                    <div class="card">
                        <div class="panel-title">
                            <h3>Followups</h3>
                            <div class="mini">{{ $followups?->count() ?? 0 }} items</div>
                        </div>

                        @if($followups->count())
                            <div class="list">
                                @foreach($followups as $f)
                                    @php
                                        $when = $f->scheduled_at ? \Carbon\Carbon::parse($f->scheduled_at) : null;
                                        $isDone = (bool)($f->completed ?? false);
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

                                        <div class="item-body">{{ $f->note ?? '—' }}</div>

                                        <div style="margin-top:10px;display:flex;justify-content:flex-end">
                                            @if(!$isDone)
                                                <form method="POST" action="{{ route('crm.sales.followups.done', $f->id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="crm-btn crm-btn-ghost">Mark Done</button>
                                                </form>
                                            @else
                                                <div class="mini">
                                                    Completed at {{ $f->completed_at ? \Carbon\Carbon::parse($f->completed_at)->toDayDateTimeString() : '—' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="mini">No followups scheduled.</div>
                        @endif

                        <hr class="divider">

                        <div class="panel-title">
                            <h3>Schedule Followup</h3>
                            <div class="mini">Set next step</div>
                        </div>

                        <form method="POST" action="{{ route('crm.sales.leads.followups.store', $lead->id) }}" style="display:flex;flex-direction:column;gap:10px">
                            @csrf
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px">
                                <div>
                                    <div class="mini" style="margin-bottom:6px">When</div>
                                    <input type="datetime-local" name="scheduled_at" class="dark-input" />
                                </div>
                                <div>
                                    <div class="mini" style="margin-bottom:6px">Note</div>
                                    <input name="note" class="dark-input" placeholder="e.g., Call to confirm details" />
                                </div>
                            </div>
                            <div style="display:flex;justify-content:flex-end">
                                <button class="crm-btn crm-btn-primary">Schedule</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
