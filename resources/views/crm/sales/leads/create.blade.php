@extends('crm.layouts.sales')

@section('title', 'Add New Lead')

@section('content')
<style>
    [x-cloak]{display:none!important}

    :root{
        --brand-yellow: {{ config('website.primary_color', '#FFDF41') }};
        --brand-orange: {{ config('website.secondary_color', '#E3A000') }};
        --brand-light: {{ config('website.light_green', '#8CC63F') }};
    }

    .dark{
        --s-border:rgba(255,255,255,.10);
        --s-text:rgba(255,255,255,.92);
        --s-muted:rgba(255,255,255,.62);
        --s-card:rgba(0,0,0,.14);
        --s-card2:rgba(0,0,0,.10);
        --s-shadow: 0 22px 60px rgba(0,0,0,.35);
        --s-shadow2: 0 12px 26px rgba(0,0,0,.22);
        --s-head-bg: rgba(0,0,0,.14);
        --s-pill-bg: rgba(255,255,255,.05);
        --s-pill-border: rgba(255,255,255,.12);
        --s-pill-text: rgba(255,255,255,.78);
        --s-input-bg: rgba(255,255,255,.04);
        --s-input-border: rgba(255,255,255,.14);
        --s-input-color: rgba(255,255,255,.90);
        --s-input-placeholder: rgba(255,255,255,.55);
        --s-table-row-hover: rgba(255,255,255,.07);
        --s-tag-bg: rgba(0,0,0,.14);
        --s-tag-border: rgba(255,255,255,.14);
        --s-tag-text: rgba(255,255,255,.70);
        --s-help: rgba(255,255,255,.58);
        --s-alert-bg: rgba(255,255,255,.04);
        --s-alert-border: rgba(255,255,255,.12);
        --s-alert-text: rgba(255,255,255,.86);
        --s-danger: #ffd0d0;
    }

    html:not(.dark){
        --s-border:rgba(0,0,0,.12);
        --s-text:rgba(0,0,0,.95);
        --s-muted:rgba(0,0,0,.70);
        --s-card:#FFFFFF;
        --s-card2:#FFFFFF;
        --s-shadow: 0 4px 12px rgba(0,0,0,.08);
        --s-shadow2: 0 2px 8px rgba(0,0,0,.06);
        --s-head-bg: rgba(248,249,250,.8);
        --s-pill-bg: rgba(0,0,0,.05);
        --s-pill-border: rgba(0,0,0,.15);
        --s-pill-text: rgba(0,0,0,.85);
        --s-input-bg: rgba(0,0,0,.03);
        --s-input-border: rgba(0,0,0,.18);
        --s-input-color: rgba(0,0,0,.95);
        --s-input-placeholder: rgba(0,0,0,.50);
        --s-table-row-hover: rgba(0,0,0,.04);
        --s-tag-bg: rgba(0,0,0,.05);
        --s-tag-border: rgba(0,0,0,.15);
        --s-tag-text: rgba(0,0,0,.70);
        --s-help: rgba(0,0,0,.58);
        --s-alert-bg: rgba(0,0,0,.03);
        --s-alert-border: rgba(0,0,0,.12);
        --s-alert-text: rgba(0,0,0,.86);
        --s-danger: #b91c1c;
    }

    /* ===== Shell ===== */
    .page-shell{
        position:relative;
        border-radius:20px;
        overflow: visible; /* IMPORTANT: allow dropdowns overlay */
        border:1px solid var(--s-border);
        background: var(--s-card2);
        box-shadow: var(--s-shadow);
    }
    .page-bg{
        position:absolute; inset:0; z-index:0; pointer-events:none;
        filter: blur(14px);
        opacity:.78;
        border-radius:20px;
    }
    .dark .page-bg{
        background:
            radial-gradient(900px 520px at 16% 10%, rgba(140,198,63,.14), transparent 55%),
            radial-gradient(900px 520px at 86% 18%, rgba(255,223,65,.14), transparent 55%),
            radial-gradient(800px 520px at 72% 90%, rgba(227,160,0,.10), transparent 55%),
            linear-gradient(180deg, rgba(7,11,18,.45), rgba(10,18,32,.25));
    }
    html:not(.dark) .page-bg{display:none}
    .page-wrap{position:relative; z-index:1; padding:16px}

    /* ===== Head ===== */
    .head{
        display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;
        padding:14px;
        border-radius:16px;
        border:1px solid var(--s-border);
        background: var(--s-head-bg);
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        margin-bottom:14px;
    }
    .head h3{margin:0;font-size:16px;font-weight:900;color:var(--s-text)}
    .head p{margin:6px 0 0;font-size:12px;font-weight:800;color:var(--s-muted);line-height:1.55}

    .pill{
        display:inline-flex;align-items:center;gap:8px;
        padding:7px 10px;border-radius:999px;
        border:1px solid var(--s-pill-border);
        background: var(--s-pill-bg);
        color: var(--s-pill-text);
        font-size:12px;font-weight:900;
        white-space:nowrap;
    }
    .pill .dot{width:8px;height:8px;border-radius:999px;background: var(--s-muted)}
    .pill.y .dot{background: rgba(255,223,65,.35)}
    .pill.g .dot{background: rgba(140,198,63,.30)}

    /* ===== Card ===== */
    .card{
        border-radius:16px;
        border:1px solid var(--s-border);
        background: var(--s-card);
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        padding:16px;
        position:relative;
        z-index:1;
    }

    /* ===== Alerts ===== */
    .alert{
        border-radius:14px;
        padding:12px 14px;
        border:1px solid var(--s-alert-border);
        background: var(--s-alert-bg);
        color: var(--s-alert-text);
        margin-bottom:12px;
    }
    .alert-error{
        border-color:rgba(239,68,68,.25);
        background:rgba(239,68,68,.10);
        color:var(--s-danger);
    }
    .alert ul{margin:8px 0 0;padding-left:18px}

    /* ===== Form grid ===== */
    .grid{display:grid;grid-template-columns:1fr;gap:12px}
    @media(min-width:900px){ .grid{grid-template-columns:1fr 1fr} }
    .full{grid-column:1 / -1}

    /* ===== Labels & help ===== */
    .label{
        display:flex;align-items:center;justify-content:space-between;gap:10px;
        font-size:12px;font-weight:900;color:var(--s-tag-text);
        margin-bottom:6px;
    }
    .tag{
        font-size:11px;font-weight:900;
        padding:4px 8px;border-radius:999px;
        border:1px solid var(--s-tag-border);
        background: var(--s-tag-bg);
        color: var(--s-tag-text);
        white-space:nowrap;
    }
    .tag.req{border-color:rgba(255,223,65,.20); background:rgba(255,223,65,.10); color:rgba(255,223,65,.95)}
    .help{margin-top:6px;font-size:12px;font-weight:800;color:var(--s-help);line-height:1.35}

    /* ===== Inputs ===== */
    .input, .textarea{
        width:100%;
        padding:11px 12px;
        border-radius:14px;
        border:1px solid var(--s-input-border);
        background: var(--s-input-bg);
        color: var(--s-input-color);
        font-weight:800;
        outline:none;
    }
    .textarea{min-height:120px;resize:vertical}
    .input::placeholder,.textarea::placeholder{color: var(--s-input-placeholder)}
    .input:focus,.textarea:focus{
        border-color: rgba(255,223,65,.28);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
        background: var(--s-input-bg);
    }

    .err{margin-top:6px;font-size:12px;font-weight:800;color:var(--s-danger)}

    /* ===== Actions ===== */
    .actions{
        display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;
        margin-top:14px;padding-top:14px;border-top:1px solid var(--s-border);
    }

    /* Buttons (match theme without global edits) */
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
    }
    .crm-btn.crm-btn-ghost:hover{background: var(--s-table-row-hover, rgba(255,255,255,.07)) !important}

    /* ===== Custom Select (same as Actions dropdown) ===== */
    .cselect{position:relative; z-index:5}
    .cselect.open{z-index:5000}
    .cselect-btn{
        width:100%;
        display:flex;align-items:center;justify-content:space-between;gap:10px;
        padding:11px 12px;
        border-radius:14px;
        border:1px solid var(--s-input-border);
        background: var(--s-input-bg);
        color: var(--s-input-color);
        font-weight:900;
        cursor:pointer;
        outline:none;
    }
    .cselect-btn:hover{background: var(--s-head-bg)}
    .cselect-btn:focus{
        border-color: rgba(255,223,65,.28);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }
    .cselect-label{display:flex;align-items:center;gap:10px;min-width:0}
    .cselect-pill{
        font-size:11px;font-weight:900;
        padding:5px 8px;border-radius:999px;
        border:1px solid var(--s-tag-border);
        background: var(--s-tag-bg);
        color: var(--s-tag-text);
        white-space:nowrap;
    }
    .cselect-text{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .cselect-menu{
        position:absolute;left:0;right:0;top:calc(100% + 8px);
        border-radius:14px;
        border:1px solid var(--s-border);
        background: var(--s-card);
        box-shadow: 0 22px 60px rgba(0,0,0,.55);
        backdrop-filter: blur(10px);
        overflow:hidden;
        z-index:9000;
    }
    .cselect-search{
        padding:10px;
        border-bottom:1px solid var(--s-border);
        background: var(--s-head-bg);
    }
    .cselect-item{
        padding:10px 12px;
        display:flex;align-items:center;justify-content:space-between;gap:10px;
        color: var(--s-text);
        font-weight:900;
        cursor:pointer;
    }
    .cselect-item:hover{background: var(--s-table-row-hover, rgba(255,255,255,.06))}
    .cselect-item.active{background: rgba(255,223,65,.10)}
    .cselect-muted{font-weight:800;color: var(--s-muted);font-size:12px}
</style>

<script>
    document.addEventListener('alpine:init', () => {
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
    $srcItems = collect($sources ?? [])->map(fn($s) => ['value'=>(string)$s->id, 'label'=>$s->name])->values();
    $stItems  = collect($statuses ?? [])->map(fn($s) => ['value'=>(string)$s->id, 'label'=>$s->name])->values();

    $oldSource = old('source_id');
    $oldStatus = old('status_id');

    $srcLabel = $oldSource ? (optional(collect($sources)->firstWhere('id', (int)$oldSource))->name ?? 'Source') : 'Select source';
    $stLabel  = $oldStatus ? (optional(collect($statuses)->firstWhere('id', (int)$oldStatus))->name ?? 'Status') : 'Select status';
@endphp

<div class="page-shell">
    <div class="page-bg" aria-hidden="true"></div>

    <div class="page-wrap">
        <div class="head">
            <div>
                <h3>Create a new lead</h3>
                <p>Fill the details below. Optional fields can be left empty.</p>
                <div style="margin-top:10px;display:flex;gap:10px;flex-wrap:wrap">
                    <span class="pill g"><span class="dot"></span>Sales area</span>
                    <span class="pill y"><span class="dot"></span>Fast add</span>
                </div>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center">
                <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-ghost">Back to Leads</a>
            </div>
        </div>

        <div class="card">
            @if($errors->any())
                <div class="alert alert-error">
                    <strong style="display:block;font-weight:900">Please fix:</strong>
                    <ul>
                        @foreach($errors->all() as $err)
                            <li style="margin:2px 0">{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('crm.sales.leads.store') }}">
                @csrf

                <div class="grid">
                    <div class="full">
                        <div class="label">
                            <span>Name</span>
                            <span class="tag req">Required</span>
                        </div>
                        <input
                            type="text"
                            name="name"
                            class="input"
                            placeholder="e.g., John Doe"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                        />
                        @error('name') <div class="err">{{ $message }}</div> @enderror
                        <div class="help">Use the customer’s full name for better search results.</div>
                    </div>

                    <div>
                        <div class="label">
                            <span>Phone</span>
                            <span class="tag">Optional</span>
                        </div>
                        <input
                            type="text"
                            name="phone"
                            class="input"
                            placeholder="e.g., +20 10..."
                            value="{{ old('phone') }}"
                            inputmode="tel"
                            autocomplete="tel"
                        />
                        @error('phone') <div class="err">{{ $message }}</div> @enderror
                        <div class="help">Tip: Use international format if possible.</div>
                    </div>

                    <div>
                        <div class="label">
                            <span>Email</span>
                            <span class="tag">Optional</span>
                        </div>
                        <input
                            type="email"
                            name="email"
                            class="input"
                            placeholder="e.g., john@company.com"
                            value="{{ old('email') }}"
                            inputmode="email"
                            autocomplete="email"
                        />
                        @error('email') <div class="err">{{ $message }}</div> @enderror
                        <div class="help">We’ll use this for follow-up messages (if enabled).</div>
                    </div>

                    {{-- Source (Custom Select) --}}
                    <div>
                        <div class="label">
                            <span>Source</span>
                            <span class="tag">Optional</span>
                        </div>

                        <div
                            class="cselect"
                            x-data="cselect({
                                value: '{{ (string)old('source_id', '') }}',
                                label: @js($srcLabel),
                                items: {{ $srcItems->toJson() }}
                            })"
                            :class="open ? 'open' : ''"
                            @click.outside="open=false"
                            @keydown.escape.window="open=false"
                        >
                            <input type="hidden" name="source_id" :value="value">

                            <button type="button" class="cselect-btn" @click="open=!open" :aria-expanded="open">
                                <span class="cselect-label">
                                    <span class="cselect-pill">Source</span>
                                    <span class="cselect-text" x-text="label"></span>
                                </span>
                                <span style="opacity:.8;font-weight:900" x-text="open ? '▲' : '▼'"></span>
                            </button>

                            <div class="cselect-menu" x-show="open" x-transition.opacity x-cloak>
                                <div class="cselect-search">
                                    <input class="input" style="padding:9px 10px;border-radius:12px"
                                           placeholder="Search source…"
                                           x-model="q">
                                </div>

                                <div style="max-height:260px;overflow:auto">
                                    <template x-for="item in filtered" :key="item.value">
                                        <div
                                            class="cselect-item"
                                            :class="(item.value===value) ? 'active' : ''"
                                            @click="pick(item)"
                                        >
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

                        @error('source_id') <div class="err">{{ $message }}</div> @enderror
                    </div>

                    {{-- Status (Custom Select) --}}
                    <div>
                        <div class="label">
                            <span>Status</span>
                            <span class="tag">Optional</span>
                        </div>

                        <div
                            class="cselect"
                            x-data="cselect({
                                value: '{{ (string)old('status_id', '') }}',
                                label: @js($stLabel),
                                items: {{ $stItems->toJson() }}
                            })"
                            :class="open ? 'open' : ''"
                            @click.outside="open=false"
                            @keydown.escape.window="open=false"
                        >
                            <input type="hidden" name="status_id" :value="value">

                            <button type="button" class="cselect-btn" @click="open=!open" :aria-expanded="open">
                                <span class="cselect-label">
                                    <span class="cselect-pill">Status</span>
                                    <span class="cselect-text" x-text="label"></span>
                                </span>
                                <span style="opacity:.8;font-weight:900" x-text="open ? '▲' : '▼'"></span>
                            </button>

                            <div class="cselect-menu" x-show="open" x-transition.opacity x-cloak>
                                <div class="cselect-search">
                                    <input class="input" style="padding:9px 10px;border-radius:12px"
                                           placeholder="Search status…"
                                           x-model="q">
                                </div>

                                <div style="max-height:260px;overflow:auto">
                                    <template x-for="item in filtered" :key="item.value">
                                        <div
                                            class="cselect-item"
                                            :class="(item.value===value) ? 'active' : ''"
                                            @click="pick(item)"
                                        >
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

                        @error('status_id') <div class="err">{{ $message }}</div> @enderror
                    </div>

                    <div class="full">
                        <div class="label">
                            <span>Message</span>
                            <span class="tag">Optional</span>
                        </div>
                        <textarea
                            name="message"
                            class="textarea"
                            placeholder="Write any notes or customer request details..."
                        >{{ old('message') }}</textarea>
                        @error('message') <div class="err">{{ $message }}</div> @enderror
                        <div class="help">This note will be visible in lead details for the team.</div>
                    </div>
                </div>

                <div class="actions">
                    <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-ghost">Cancel</a>
                    <button class="crm-btn crm-btn-primary" type="submit">Create Lead</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
