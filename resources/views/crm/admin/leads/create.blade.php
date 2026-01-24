@extends('crm.layouts.admin')

@section('title','Add Lead')
@section('subtitle','Create a new lead')

@section('content')
<style>
    [x-cloak]{display:none!important}

    /* Theme Variables */
    .dark {
        --create-border: rgba(255,255,255,.10);
        --create-bg: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
        --create-shadow: 0 22px 60px rgba(0,0,0,.35);
        --create-text: rgba(255,255,255,.92);
        --create-muted: rgba(255,255,255,.62);
        --create-card-bg: rgba(0,0,0,.14);
        --create-card-head: rgba(255,255,255,.03);
        --create-input-bg: rgba(255,255,255,.04);
        --create-input-border: rgba(255,255,255,.14);
        --create-input-color: rgba(255,255,255,.90);
        --create-input-placeholder: rgba(255,255,255,.55);
        --create-label-bg: rgba(0,0,0,.14);
        --create-label-border: rgba(255,255,255,.12);
    }

    html:not(.dark) {
        --create-border: rgba(0,0,0,.12);
        --create-bg: #FFFFFF;
        --create-shadow: 0 4px 12px rgba(0,0,0,.08);
        --create-text: rgba(0,0,0,.95);
        --create-muted: rgba(0,0,0,.70);
        --create-card-bg: #FFFFFF;
        --create-card-head: rgba(248,249,250,.8);
        --create-input-bg: rgba(0,0,0,.03);
        --create-input-border: rgba(0,0,0,.18);
        --create-input-color: rgba(0,0,0,.95);
        --create-input-placeholder: rgba(0,0,0,.50);
        --create-label-bg: rgba(0,0,0,.05);
        --create-label-border: rgba(0,0,0,.15);
    }

    /* ===== Shell (same theme) ===== */
    .lead-create-shell{
        position:relative;
        border-radius:20px;
        overflow:hidden;
        border:1px solid var(--create-border);
        background: var(--create-bg);
        box-shadow: var(--create-shadow);
        transition: all 0.3s ease;
    }
    .dark .lead-create-bg{
        position:absolute; inset:0; z-index:0; pointer-events:none;
        background:
            radial-gradient(900px 520px at 16% 10%, rgba(140,198,63,.14), transparent 55%),
            radial-gradient(900px 520px at 86% 18%, rgba(255,223,65,.14), transparent 55%),
            radial-gradient(800px 520px at 72% 90%, rgba(227,160,0,.10), transparent 55%),
            linear-gradient(180deg, rgba(7,11,18,.45), rgba(10,18,32,.25));
        filter: blur(14px);
        opacity:.78;
    }
    html:not(.dark) .lead-create-bg { display: none; }
    .lead-create-wrap{position:relative; z-index:1; padding:16px}

    /* IMPORTANT: allow dropdowns to overlay (fix native select clipping) */
    .lead-card{
        position:relative;
        max-width:980px;
        margin:0 auto;
        border-radius:16px;
        border:1px solid var(--create-border);
        background: var(--create-card-bg);
        box-shadow: var(--create-shadow);
        backdrop-filter: blur(10px);
        overflow: visible; /* <-- key */
        transition: all 0.3s ease;
    }

    .lead-card-head{
        display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;
        padding:14px 16px;
        border-bottom:1px solid var(--create-border);
        background: var(--create-card-head);
        border-top-left-radius:16px;
        border-top-right-radius:16px;
    }
    .lead-card-head .title{
        margin:0;
        font-size:16px;
        font-weight:900;
        color: var(--create-text);
    }
    .lead-card-head .hint{
        margin-top:4px;
        font-size:12px;
        font-weight:800;
        color: var(--create-muted);
    }
    .lead-card-body{padding:16px}

    .crumb{
        display:flex;gap:8px;align-items:center;
        font-size:12px;font-weight:900;color:var(--create-muted);
        margin-bottom:12px;
    }
    .crumb a{color:var(--create-text);text-decoration:none;opacity:.85}
    .crumb a:hover{text-decoration:underline}

    /* Grid */
    .grid{
        display:grid;
        grid-template-columns:1fr;
        gap:12px;
    }
    @media(min-width:900px){
        .grid{grid-template-columns:1fr 1fr}
    }
    .full{grid-column:1 / -1}

    /* Fields */
    .label{
        font-size:12px;
        font-weight:900;
        color: var(--create-muted);
        margin-bottom:6px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
    }
    .label .req{
        font-size:11px;
        font-weight:900;
        padding:4px 8px;
        border-radius:999px;
        border:1px solid var(--create-label-border);
        background: var(--create-label-bg);
        color: var(--create-muted);
        white-space:nowrap;
    }

    .dark-input, .dark-textarea{
        width:100%;
        padding:11px 12px;
        border-radius:14px;
        border:1px solid var(--create-input-border);
        background: var(--create-input-bg);
        color: var(--create-input-color);
        font-weight:800;
        outline:none;
        transition: all 0.3s ease;
    }
    .dark-textarea{min-height:120px;resize:vertical}
    .dark-input::placeholder, .dark-textarea::placeholder{color: var(--create-input-placeholder)}
    .dark-input:focus, .dark-textarea:focus{
        border-color: rgba(255,223,65,.38);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }

    .help{
        margin-top:6px;
        font-size:12px;
        font-weight:800;
        color: var(--create-muted);
        line-height:1.35;
    }

    /* Alerts */
    .alert{
        border-radius:14px;
        padding:12px 14px;
        border:1px solid var(--create-border);
        background: var(--create-input-bg);
        color: var(--create-text);
        transition: all 0.3s ease;
    }
    .alert-error{
        border-color:rgba(239,68,68,.35);
        background:rgba(239,68,68,.12);
        color:#ff6b6b;
    }
    .dark .alert-error{color:#ffd0d0}
    .alert ul{margin:8px 0 0;padding-left:18px}

    /* Footer actions */
    .actions{
        display:flex;
        justify-content:flex-end;
        gap:10px;
        flex-wrap:wrap;
        margin-top:14px;
        padding-top:14px;
        border-top:1px solid var(--create-border);
    }

    /* Sub section divider */
    .section-title{
        display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;
        margin:2px 0 8px;
    }
    .section-title .left{
        font-weight:900;
        color: var(--create-text);
        font-size:13px;
    }
    .section-title .right{
        font-size:12px;
        font-weight:800;
        color: var(--create-muted);
        line-height:1.3;
    }

    /* ===== Custom Select (Dark) - fixes native dropdown white box issue ===== */
    .cselect{position:relative; z-index:5}
    .cselect.open{z-index:9999}
    .cselect-btn{
        width:100%;
        display:flex;align-items:center;justify-content:space-between;gap:10px;
        padding:11px 12px;
        border-radius:14px;
        border:1px solid var(--create-input-border);
        background: var(--create-input-bg);
        color: var(--create-input-color);
        font-weight:900;
        cursor:pointer;
        outline:none;
        transition: all 0.3s ease;
    }
    .cselect-btn:hover{background: var(--create-label-bg)}
    .cselect-btn:focus{
        border-color: rgba(255,223,65,.38);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }
    .cselect-text{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .cselect-menu{
        position:absolute;left:0;right:0;top:calc(100% + 8px);
        border-radius:14px;
        border:1px solid var(--create-border);
        background: var(--create-card-bg);
        box-shadow: var(--create-shadow);
        backdrop-filter: blur(10px);
        overflow:hidden;
        z-index:99999;
    }
    .dark .cselect-menu{
        background: rgba(7,11,18,.94);
    }
    .cselect-search{
        padding:10px;
        border-bottom:1px solid var(--create-border);
        background: var(--create-card-head);
    }
    .cselect-item{
        padding:10px 12px;
        display:flex;align-items:center;justify-content:space-between;gap:10px;
        color: var(--create-text);
        font-weight:900;
        cursor:pointer;
        transition: all 0.2s ease;
    }
    .cselect-item:hover{background: var(--create-label-bg)}
    .cselect-item.active{background: rgba(255,223,65,.12)}
    .cselect-muted{font-weight:800;color: var(--create-muted);font-size:12px}
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('cselect', (opts) => ({
            open:false,
            q:'',
            value: opts.value ?? '',
            placeholder: opts.placeholder ?? 'Select…',
            items: opts.items ?? [],
            get label(){
                const found = this.items.find(i => String(i.value) === String(this.value));
                return found ? found.label : this.placeholder;
            },
            get filtered(){
                if(!this.q) return this.items;
                const s = this.q.toLowerCase();
                return this.items.filter(i => (i.label || '').toLowerCase().includes(s));
            },
            pick(val){
                this.value = val;
                this.open = false;
                this.q = '';
            }
        }));
    });
</script>

@php
    $sourceItems = collect($sources ?? [])->map(fn($s) => ['value' => (string)$s->id, 'label' => $s->name])->values();
    $statusItems = collect($statuses ?? [])->map(fn($s) => ['value' => (string)$s->id, 'label' => $s->name])->values();
    $salesItems  = collect($sales ?? [])->map(fn($s) => ['value' => (string)$s->id, 'label' => $s->name])->values();

    $oldSource = (string)old('source_id', '');
    $oldStatus = (string)old('status_id', '');
    $oldAssign = (string)old('assigned_to', '');
@endphp

<div class="lead-create-shell">
    <div class="lead-create-bg" aria-hidden="true"></div>

    <div class="lead-create-wrap">
        <nav class="crumb">
            <a href="{{ route('crm.admin.leads.index') }}">Leads</a>
            <span>›</span>
            <span>Add Lead</span>
        </nav>

        <div class="lead-card">
            <div class="lead-card-head">
                <div>
                    <h3 class="title">Create a new lead</h3>
                    <div class="hint">Fill the details below. You can leave optional fields empty.</div>
                </div>

                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
                    <div style="font-size:12px;font-weight:900;color:rgba(255,255,255,.62)">
                        Tip: Phone helps faster follow-ups.
                    </div>
                </div>
            </div>

            <div class="lead-card-body">

                @if($errors->any())
                    <div class="alert alert-error" style="margin-bottom:12px">
                        <strong style="display:block;font-weight:900">Please fix:</strong>
                        <ul>
                            @foreach($errors->all() as $err)
                                <li style="margin:2px 0">{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('crm.admin.leads.store') }}">
                    @csrf

                    <div class="section-title">
                        <div class="left">Lead info</div>
                        <div class="right">Fields marked required should be filled</div>
                    </div>

                    <div class="grid">
                        <div class="full">
                            <div class="label">
                                <span>Name</span>
                                <span class="req">Required</span>
                            </div>
                            <input
                                name="name"
                                required
                                class="dark-input"
                                value="{{ old('name') }}"
                                placeholder="e.g., John Doe"
                                autocomplete="name"
                            />
                        </div>

                        <div>
                            <div class="label">
                                <span>Phone</span>
                                <span class="req">Optional</span>
                            </div>
                            <input
                                name="phone"
                                class="dark-input"
                                value="{{ old('phone') }}"
                                placeholder="e.g., +20 10..."
                                autocomplete="tel"
                                inputmode="tel"
                            />
                            <div class="help">Use international format if possible.</div>
                        </div>

                        <div>
                            <div class="label">
                                <span>Email</span>
                                <span class="req">Optional</span>
                            </div>
                            <input
                                name="email"
                                class="dark-input"
                                value="{{ old('email') }}"
                                placeholder="e.g., john@company.com"
                                autocomplete="email"
                                inputmode="email"
                            />
                            <div class="help">We’ll use this for follow-up messages (if enabled).</div>
                        </div>

                        {{-- Source (custom dropdown - fixes white native dropdown) --}}
                        <div
                            class="cselect"
                            x-data="cselect({ value: @js($oldSource), placeholder: 'Select source', items: {{ $sourceItems->toJson() }} })"
                            :class="open ? 'open' : ''"
                            @click.outside="open=false"
                            @keydown.escape.window="open=false"
                        >
                            <div class="label">
                                <span>Source</span>
                                <span class="req">Optional</span>
                            </div>

                            <input type="hidden" name="source_id" :value="value">

                            <button type="button" class="cselect-btn" @click="open=!open" :aria-expanded="open">
                                <span class="cselect-text" x-text="label"></span>
                                <span style="opacity:.8;font-weight:900" x-text="open ? '▲' : '▼'"></span>
                            </button>

                            <div class="cselect-menu" x-show="open" x-transition.opacity x-cloak>
                                <div class="cselect-search">
                                    <input class="dark-input" style="padding:9px 10px;border-radius:12px"
                                           placeholder="Search source…"
                                           x-model="q">
                                </div>

                                <div style="max-height:260px;overflow:auto">
                                    <div class="cselect-item" :class="value==='' ? 'active' : ''" @click="pick('')">
                                        <span>Select source</span>
                                        <span class="cselect-muted" x-show="value===''">Selected</span>
                                    </div>

                                    <template x-for="item in filtered" :key="item.value">
                                        <div class="cselect-item"
                                             :class="String(item.value)===String(value) ? 'active' : ''"
                                             @click="pick(item.value)">
                                            <span x-text="item.label"></span>
                                            <span class="cselect-muted" x-show="String(item.value)===String(value)">Selected</span>
                                        </div>
                                    </template>

                                    <div class="cselect-item cselect-muted" x-show="filtered.length===0" style="justify-content:center">
                                        No results
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Status (custom dropdown - fixes white native dropdown) --}}
                        <div
                            class="cselect"
                            x-data="cselect({ value: @js($oldStatus), placeholder: 'Select status', items: {{ $statusItems->toJson() }} })"
                            :class="open ? 'open' : ''"
                            @click.outside="open=false"
                            @keydown.escape.window="open=false"
                        >
                            <div class="label">
                                <span>Status</span>
                                <span class="req">Optional</span>
                            </div>

                            <input type="hidden" name="status_id" :value="value">

                            <button type="button" class="cselect-btn" @click="open=!open" :aria-expanded="open">
                                <span class="cselect-text" x-text="label"></span>
                                <span style="opacity:.8;font-weight:900" x-text="open ? '▲' : '▼'"></span>
                            </button>

                            <div class="cselect-menu" x-show="open" x-transition.opacity x-cloak>
                                <div class="cselect-search">
                                    <input class="dark-input" style="padding:9px 10px;border-radius:12px"
                                           placeholder="Search status…"
                                           x-model="q">
                                </div>

                                <div style="max-height:260px;overflow:auto">
                                    <div class="cselect-item" :class="value==='' ? 'active' : ''" @click="pick('')">
                                        <span>Select status</span>
                                        <span class="cselect-muted" x-show="value===''">Selected</span>
                                    </div>

                                    <template x-for="item in filtered" :key="item.value">
                                        <div class="cselect-item"
                                             :class="String(item.value)===String(value) ? 'active' : ''"
                                             @click="pick(item.value)">
                                            <span x-text="item.label"></span>
                                            <span class="cselect-muted" x-show="String(item.value)===String(value)">Selected</span>
                                        </div>
                                    </template>

                                    <div class="cselect-item cselect-muted" x-show="filtered.length===0" style="justify-content:center">
                                        No results
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(optional(Auth::user())->isAdmin())
                            {{-- Assign to (custom dropdown - fixes native) --}}
                            <div
                                class="cselect full"
                                x-data="cselect({ value: @js($oldAssign), placeholder: 'Unassigned', items: {{ $salesItems->toJson() }} })"
                                :class="open ? 'open' : ''"
                                @click.outside="open=false"
                                @keydown.escape.window="open=false"
                            >
                                <div class="label">
                                    <span>Assign to</span>
                                    <span class="req">Optional</span>
                                </div>

                                <input type="hidden" name="assigned_to" :value="value">

                                <button type="button" class="cselect-btn" @click="open=!open" :aria-expanded="open">
                                    <span class="cselect-text" x-text="label"></span>
                                    <span style="opacity:.8;font-weight:900" x-text="open ? '▲' : '▼'"></span>
                                </button>

                                <div class="cselect-menu" x-show="open" x-transition.opacity x-cloak>
                                    <div class="cselect-search">
                                        <input class="dark-input" style="padding:9px 10px;border-radius:12px"
                                               placeholder="Search assignee…"
                                               x-model="q">
                                    </div>

                                    <div style="max-height:260px;overflow:auto">
                                        <div class="cselect-item" :class="value==='' ? 'active' : ''" @click="pick('')">
                                            <span>Unassigned</span>
                                            <span class="cselect-muted" x-show="value===''">Selected</span>
                                        </div>

                                        <template x-for="item in filtered" :key="item.value">
                                            <div class="cselect-item"
                                                 :class="String(item.value)===String(value) ? 'active' : ''"
                                                 @click="pick(item.value)">
                                                <span x-text="item.label"></span>
                                                <span class="cselect-muted" x-show="String(item.value)===String(value)">Selected</span>
                                            </div>
                                        </template>

                                        <div class="cselect-item cselect-muted" x-show="filtered.length===0" style="justify-content:center">
                                            No results
                                        </div>
                                    </div>
                                </div>

                                <div class="help">Assigning a sales user will show the lead in their queue.</div>
                            </div>
                        @endif

                        <div class="full">
                            <div class="label">
                                <span>Message</span>
                                <span class="req">Optional</span>
                            </div>
                            <textarea
                                name="message"
                                rows="5"
                                class="dark-textarea"
                                placeholder="Write any notes or customer request details..."
                            >{{ old('message') }}</textarea>
                            <div class="help">This note will be visible in lead details for the team.</div>
                        </div>
                    </div>

                    <div class="actions">
                        <a href="{{ route('crm.admin.leads.index') }}" class="crm-btn crm-btn-ghost">Cancel</a>
                        <button class="crm-btn crm-btn-primary" type="submit">Create Lead</button>
                    </div>
                </form>

                {{-- Import from Excel/CSV --}}
                <div style="margin-top:18px">
                    <div class="section-title">
                        <div class="left">Import from Excel / CSV</div>
                        <div class="right">
                            Upload a CSV exported from Excel (columns: name,phone,email,source,status,assigned_to,message)
                        </div>
                    </div>

                    @if(session('import_errors'))
                        <div class="alert alert-error" style="margin-bottom:12px">
                            <strong style="display:block;font-weight:900">Import issues:</strong>
                            <ul>
                                @foreach(session('import_errors') as $ie)
                                    <li style="margin:2px 0">{{ $ie }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('crm.leads.import') }}" enctype="multipart/form-data" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                        @csrf
                        <input type="file" name="file" accept=".csv" class="dark-input" style="padding:8px;flex:1;min-width:260px" />
                        <div style="display:flex;gap:8px;flex-wrap:wrap">
                            <a href="{{ asset('crm/templates/lead_import_template.csv') }}" class="crm-btn crm-btn-ghost" download>Download template</a>
                            <button class="crm-btn crm-btn-primary">Import CSV</button>
                        </div>
                    </form>

                    <div class="help" style="margin-top:8px">
                        Tip: Open the template in Excel, fill rows, then <b>Save As → CSV UTF-8</b> and upload. First row must keep headers.
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
