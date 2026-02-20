@extends('crm.layouts.admin')

@section('title', 'Settings')
@section('subtitle', 'Manage statuses, sources, and action types')

@section('content')
<style>
    [x-cloak]{display:none!important}

    .dark{
        --set-border: rgba(255,255,255,.10);
        --set-bg: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
        --set-shadow: 0 22px 60px rgba(0,0,0,.35);
        --set-text: rgba(255,255,255,.92);
        --set-muted: rgba(255,255,255,.62);
        --set-card-bg: rgba(0,0,0,.14);
        --set-card-border: rgba(255,255,255,.10);
        --set-card-shadow: 0 12px 26px rgba(0,0,0,.22);
        --set-tab-bg: rgba(0,0,0,.16);
        --set-tab-border: rgba(255,255,255,.10);
        --set-tab-text: rgba(255,255,255,.72);
        --set-tab-active: rgba(255,255,255,.92);
        --set-tab-item-bg: rgba(255,255,255,.03);
        --set-input-bg: rgba(255,255,255,.04);
        --set-input-border: rgba(255,255,255,.14);
        --set-input-color: rgba(255,255,255,.90);
        --set-input-placeholder: rgba(255,255,255,.55);
        --set-table-head-bg: rgba(255,255,255,.04);
        --set-table-row-bg: rgba(0,0,0,.06);
        --set-table-border: rgba(255,255,255,.06);
        --set-table-hover: rgba(255,255,255,.03);
        --set-pill-bg: rgba(255,255,255,.05);
        --set-pill-border: rgba(255,255,255,.14);
        --set-pill-text: rgba(255,255,255,.85);
        --set-toast-bg: rgba(0,0,0,.35);
        --set-toast-border: rgba(255,255,255,.12);
        --set-toast-text: rgba(255,255,255,.88);
        --set-alert-bg: rgba(0,0,0,.18);
        --set-alert-border: rgba(255,255,255,.12);
        --set-empty-bg: rgba(0,0,0,.14);
        --set-empty-border: rgba(255,255,255,.14);
        --set-danger-text: #ffd0d0;
    }

    html:not(.dark){
        --set-border: rgba(0,0,0,.12);
        --set-bg: #FFFFFF;
        --set-shadow: 0 4px 12px rgba(0,0,0,.08);
        --set-text: rgba(0,0,0,.92);
        --set-muted: rgba(0,0,0,.60);
        --set-card-bg: #FFFFFF;
        --set-card-border: rgba(0,0,0,.12);
        --set-card-shadow: 0 2px 8px rgba(0,0,0,.06);
        --set-tab-bg: rgba(0,0,0,.05);
        --set-tab-border: rgba(0,0,0,.12);
        --set-tab-text: rgba(0,0,0,.70);
        --set-tab-active: rgba(0,0,0,.90);
        --set-tab-item-bg: rgba(0,0,0,.03);
        --set-input-bg: rgba(0,0,0,.03);
        --set-input-border: rgba(0,0,0,.18);
        --set-input-color: rgba(0,0,0,.95);
        --set-input-placeholder: rgba(0,0,0,.50);
        --set-table-head-bg: rgba(0,0,0,.05);
        --set-table-row-bg: #FFFFFF;
        --set-table-border: rgba(0,0,0,.10);
        --set-table-hover: rgba(0,0,0,.03);
        --set-pill-bg: rgba(0,0,0,.05);
        --set-pill-border: rgba(0,0,0,.15);
        --set-pill-text: rgba(0,0,0,.85);
        --set-toast-bg: #FFFFFF;
        --set-toast-border: rgba(0,0,0,.12);
        --set-toast-text: rgba(0,0,0,.88);
        --set-alert-bg: rgba(0,0,0,.03);
        --set-alert-border: rgba(0,0,0,.12);
        --set-empty-bg: rgba(0,0,0,.03);
        --set-empty-border: rgba(0,0,0,.18);
        --set-danger-text: #b91c1c;
    }

    /* ===== Shell (same theme) ===== */
    .settings-shell{
        position:relative;
        border-radius:20px;
        overflow:hidden;
        border:1px solid var(--set-border);
        background: var(--set-bg);
        box-shadow: var(--set-shadow);
    }
    .settings-bg{
        position:absolute; inset:0; z-index:0; pointer-events:none;
        background:
            radial-gradient(900px 520px at 16% 10%, rgba(140,198,63,.14), transparent 55%),
            radial-gradient(900px 520px at 86% 18%, rgba(255,223,65,.14), transparent 55%),
            radial-gradient(800px 520px at 72% 90%, rgba(227,160,0,.10), transparent 55%),
            linear-gradient(180deg, rgba(7,11,18,.45), rgba(10,18,32,.25));
        filter: blur(14px);
        opacity:.75;
    }
    html:not(.dark) .settings-bg{display:none}
    .settings-wrap{
        position:relative; z-index:1; padding:16px;
        display:flex;flex-direction:column;gap:14px;
    }

    /* ===== Text helpers ===== */
    .title{margin:0;font-size:18px;font-weight:900;color:var(--set-text)}
    .hint{font-size:13px;font-weight:800;color:var(--set-muted)}
    .muted{color:var(--set-muted)!important}

    .topline{
        display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap;
        margin-bottom:2px;
    }
    .count-pill{
        display:inline-flex;align-items:center;gap:8px;
        padding:7px 10px;border-radius:999px;
        border:1px solid var(--set-pill-border);
        background: var(--set-pill-bg);
        font-weight:900;font-size:12px;
        color: var(--set-pill-text);
    }

    /* ===== Alerts / Toast ===== */
    .crm-alert{
        border-radius:14px;
        padding:12px 14px;
        border:1px solid var(--set-alert-border);
        background: var(--set-alert-bg);
        box-shadow: var(--set-card-shadow);
        backdrop-filter: blur(10px);
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:12px;
        color:var(--set-text);
    }
    .crm-alert-error{border-color:rgba(239,68,68,.25);background:rgba(239,68,68,.10);color:var(--set-danger-text)}
    .crm-alert .close{
        background:transparent;border:none;cursor:pointer;font-weight:900;
        opacity:.85;color:var(--set-text)
    }
    .crm-alert .close:hover{opacity:1}

    .toast{
        position:fixed;
        right:18px;
        bottom:18px;
        z-index:9999;
        max-width:420px;
    }
    .toast-card{
        background: var(--set-toast-bg);
        border:1px solid var(--set-toast-border);
        border-radius:14px;
        padding:12px 14px;
        box-shadow: 0 18px 40px rgba(0,0,0,.35);
        backdrop-filter: blur(10px);
        display:flex;justify-content:space-between;gap:12px;
        color: var(--set-toast-text);
    }
    .toast .close{
        background:transparent;border:none;cursor:pointer;font-weight:900;
        opacity:.85;color:var(--set-text)
    }
    .toast .close:hover{opacity:1}

    /* ===== Tabs ===== */
    .settings-tabs{
        display:flex;
        gap:8px;
        flex-wrap:wrap;
        padding:8px;
        border-radius:16px;
        border:1px solid var(--set-tab-border);
        background: var(--set-tab-bg);
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 26px rgba(0,0,0,.22);
    }
    .settings-tab{
        border:1px solid var(--set-tab-border);
        background: var(--set-tab-item-bg);
        padding:10px 12px;
        border-radius:14px;
        font-weight:900;
        cursor:pointer;
        color: var(--set-tab-text);
        transition: background .15s ease, border-color .15s ease, box-shadow .15s ease;
        display:inline-flex;align-items:center;gap:8px;
    }
    .settings-tab:hover{background: var(--set-input-bg); color: var(--set-tab-active)}
    .settings-tab.active{
        border-color: rgba(255,223,65,.26);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
        color: var(--set-tab-active);
    }
    .tab-dot{
        width:8px;height:8px;border-radius:999px;background:rgba(255,223,65,.35);
    }

    /* ===== Panels ===== */
    .settings-panel{
        border-radius:16px;
        border:1px solid var(--set-card-border);
        background: var(--set-card-bg);
        box-shadow: var(--set-card-shadow);
        backdrop-filter: blur(10px);
        padding:14px;
    }
    .panel-title{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:10px;
    }
    .panel-title h3{margin:0;font-size:14px;font-weight:900;color:var(--set-text)}
    .panel-title .meta{font-size:12px;font-weight:800;color:var(--set-muted)}

    /* ===== Add row ===== */
    .add-row{
        display:flex;
        gap:10px;
        align-items:center;
        flex-wrap:wrap;
        margin-bottom:12px;
        padding:12px;
        border-radius:14px;
        border:1px solid var(--set-border);
        background: var(--set-tab-item-bg);
    }
    .helper{font-size:12px;font-weight:800;color:var(--set-muted)}
    .btn-sm{padding:8px 12px;border-radius:12px;font-weight:900}

    /* ===== Inputs (dark) ===== */
    .dark-input{
        width:100%;
        max-width:420px;
        padding:10px 12px;
        border-radius:14px;
        border:1px solid var(--set-input-border);
        background: var(--set-input-bg);
        color: var(--set-input-color);
        font-weight:800;
        outline:none;
    }
    .dark-input::placeholder{color: var(--set-input-placeholder)}
    .dark-input:focus{
        border-color: rgba(255,223,65,.28);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }

    /* ===== Table ===== */
    .table-card{
        border-radius:14px;
        border:1px solid var(--set-card-border);
        background: var(--set-card-bg);
        overflow:hidden;
    }
    .table-wrap{overflow-x:auto}
    .dark-table{width:100%; border-collapse:collapse}
    .dark-table th{
        text-align:left;
        font-size:12px;
        font-weight:900;
        color: var(--set-muted);
        padding:12px 14px;
        background: var(--set-table-head-bg);
        border-bottom:1px solid var(--set-table-border);
        white-space:nowrap;
    }
    .dark-table td{
        padding:12px 14px;
        color: var(--set-text);
        font-weight:800;
        border-bottom:1px solid var(--set-table-border);
        background: var(--set-table-row-bg);
        vertical-align:middle;
        white-space:nowrap;
    }
    .dark-table td:first-child{white-space:normal;min-width:240px}
    .dark-table tbody tr:hover td{background: var(--set-table-hover)}

    .actions-inline{display:flex;gap:8px;flex-wrap:wrap}

    /* ===== Active pill ===== */
    .status-pill{
        display:inline-flex;align-items:center;gap:8px;
        font-weight:900;
        font-size:12px;
        padding:6px 10px;
        border-radius:999px;
        border:1px solid var(--set-pill-border);
        background: var(--set-pill-bg);
        color: var(--set-pill-text);
    }
    .dot{
        width:8px;height:8px;border-radius:999px;
        background: rgba(16,185,129,.55);
        box-shadow: 0 0 0 3px rgba(16,185,129,.12);
    }
    .dot.off{
        background: rgba(239,68,68,.55);
        box-shadow: 0 0 0 3px rgba(239,68,68,.12);
    }

    /* ===== Inline edit ===== */
    .row-edit{
        display:flex;
        align-items:center;
        gap:8px;
        flex-wrap:wrap;
    }
    .row-edit .dark-input{min-width:260px;max-width:520px}

    /* Empty */
    .empty{
        padding:14px;
        border-radius:14px;
        border:1px dashed var(--set-empty-border);
        background: var(--set-empty-bg);
        color:var(--set-muted);
        font-weight:800;
        margin:14px;
        text-align:center;
    }
</style>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('crmSettings', () => ({
            tab: localStorage.getItem('crm_settings_tab') || 'statuses',
            setTab(t){
                this.tab = t;
                localStorage.setItem('crm_settings_tab', t);
            }
        }));
    });
</script>

<div class="settings-shell">
    <div class="settings-bg" aria-hidden="true"></div>

    <div class="settings-wrap" x-data="crmSettings">
        {{-- Inline alert area (errors) --}}
        @if ($errors->any())
            <div class="crm-alert crm-alert-error" x-data="{show:true}" x-show="show" x-transition>
                <div>
                    <strong style="display:block;margin-bottom:6px;">Please fix the following:</strong>
                    <ul style="margin:0;padding-left:18px;">
                        @foreach ($errors->all() as $error)
                            <li style="margin:2px 0;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button class="close" @click="show=false" aria-label="Close">✕</button>
            </div>
        @endif

        {{-- Toast success (auto hide) --}}
        @if(session('success'))
            <div class="toast" x-data="{show:true}" x-init="setTimeout(()=>show=false, 2600)" x-show="show" x-transition>
                <div class="toast-card">
                    <div>
                        <strong>Success</strong>
                        <div class="muted" style="margin-top:2px;font-size:12px;font-weight:800">{{ session('success') }}</div>
                    </div>
                    <button class="close" @click="show=false" aria-label="Close">✕</button>
                </div>
            </div>
        @endif

        <div class="topline">
            <div>
                <div class="count-pill">
                    <span style="width:8px;height:8px;border-radius:999px;background:rgba(255,223,65,.35)"></span>
                    Settings Center
                </div>
                <div style="margin-top:10px">
                    <h2 class="title">Settings</h2>
                    <div class="hint">Manage lead statuses, sources, and action types used across the CRM.</div>
                </div>
            </div>

            <div class="hint">
                Tip: Changes apply immediately across Leads & Followups.
            </div>
        </div>

        {{-- Tabs --}}
        <div class="settings-tabs">
            <button class="settings-tab" :class="tab==='statuses' ? 'settings-tab active' : 'settings-tab'"
                    @click.prevent="setTab('statuses')">
                <span class="tab-dot" style="background:rgba(255,223,65,.35)"></span>
                Statuses
            </button>
            <button class="settings-tab" :class="tab==='sources' ? 'settings-tab active' : 'settings-tab'"
                    @click.prevent="setTab('sources')">
                <span class="tab-dot" style="background:rgba(140,198,63,.35)"></span>
                Sources
            </button>
            <button class="settings-tab" :class="tab==='actions' ? 'settings-tab active' : 'settings-tab'"
                    @click.prevent="setTab('actions')">
                <span class="tab-dot" style="background:rgba(227,160,0,.32)"></span>
                Action Types
            </button>
        </div>

        {{-- Statuses --}}
        <div class="settings-panel" x-show="tab==='statuses'" x-cloak x-transition.opacity>
            <div class="panel-title">
                <div>
                    <h3>Lead Statuses</h3>
                    <div class="meta">Track lead progress (New, In Progress, Closed).</div>
                </div>
                <div class="hint">Total: {{ $statuses->count() }}</div>
            </div>

            <form method="POST" action="{{ route('crm.admin.settings.statuses.store') }}" class="add-row">
                @csrf
                <input name="name" placeholder="Add new status (e.g., Waiting Payment)" class="dark-input" />
                <button class="crm-btn crm-btn-primary btn-sm">Add</button>
                <div class="helper">Keep names short & clear.</div>
            </form>

            <div class="table-card">
                <div class="table-wrap">
                    <table class="dark-table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Active</th>
                            <th style="width:260px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($statuses as $status)
                            <tr x-data="{editing:false, name:@js($status->name)}">
                                <td>
                                    <div x-show="!editing">
                                        <strong class="row-title">{{ $status->name }}</strong>
                                    </div>

                                    <div x-show="editing" x-cloak>
                                        <form method="POST" action="{{ route('crm.admin.settings.statuses.update', $status->id) }}" class="row-edit">
                                            @csrf
                                            @method('PATCH')
                                            <input name="name" x-model="name" class="dark-input" />
                                            <button class="crm-btn crm-btn-primary btn-sm">Save</button>
                                            <button type="button" class="crm-btn crm-btn-ghost btn-sm"
                                                    @click="editing=false; name=@js($status->name)">Cancel</button>
                                        </form>
                                    </div>
                                </td>

                                <td>
                                    <span class="status-pill">
                                        <span class="dot {{ $status->is_active ? '' : 'off' }}"></span>
                                        {{ $status->is_active ? 'Yes' : 'No' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="actions-inline">
                                        <button class="crm-btn crm-btn-ghost btn-sm"
                                                @click.prevent="editing=!editing"
                                                x-text="editing ? 'Close' : 'Edit'"></button>

                                        <form method="POST" action="{{ route('crm.admin.settings.statuses.toggle', $status->id) }}"
                                              onsubmit="return confirm('Toggle status active state?')" style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="crm-btn crm-btn-ghost btn-sm">
                                                {{ $status->is_active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3"><div class="empty">No statuses found. Add one above.</div></td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Sources --}}
        <div class="settings-panel" x-show="tab==='sources'" x-cloak x-transition.opacity>
            <div class="panel-title">
                <div>
                    <h3>Lead Sources</h3>
                    <div class="meta">Where the lead came from (Contact Us, Product Page, Manual).</div>
                </div>
                <div class="hint">Total: {{ $sources->count() }}</div>
            </div>

            <form method="POST" action="{{ route('crm.admin.settings.sources.store') }}" class="add-row">
                @csrf
                <input name="name" placeholder="Add new source (e.g., Facebook Ads)" class="dark-input" />
                <button class="crm-btn crm-btn-primary btn-sm">Add</button>
                <div class="helper">Use a consistent naming style.</div>
            </form>

            <div class="table-card">
                <div class="table-wrap">
                    <table class="dark-table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Active</th>
                            <th style="width:260px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sources as $source)
                            <tr x-data="{editing:false, name:@js($source->name)}">
                                <td>
                                    <div x-show="!editing">
                                        <strong class="row-title">{{ $source->name }}</strong>
                                    </div>

                                    <div x-show="editing" x-cloak>
                                        <form method="POST" action="{{ route('crm.admin.settings.sources.update', $source->id) }}" class="row-edit">
                                            @csrf
                                            @method('PATCH')
                                            <input name="name" x-model="name" class="dark-input" />
                                            <button class="crm-btn crm-btn-primary btn-sm">Save</button>
                                            <button type="button" class="crm-btn crm-btn-ghost btn-sm"
                                                    @click="editing=false; name=@js($source->name)">Cancel</button>
                                        </form>
                                    </div>
                                </td>

                                <td>
                                    <span class="status-pill">
                                        <span class="dot {{ $source->is_active ? '' : 'off' }}"></span>
                                        {{ $source->is_active ? 'Yes' : 'No' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="actions-inline">
                                        <button class="crm-btn crm-btn-ghost btn-sm"
                                                @click.prevent="editing=!editing"
                                                x-text="editing ? 'Close' : 'Edit'"></button>

                                        <form method="POST" action="{{ route('crm.admin.settings.sources.toggle', $source->id) }}"
                                              onsubmit="return confirm('Toggle source active state?')" style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="crm-btn crm-btn-ghost btn-sm">
                                                {{ $source->is_active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3"><div class="empty">No sources found. Add one above.</div></td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Action Types --}}
        <div class="settings-panel" x-show="tab==='actions'" x-cloak x-transition.opacity>
            <div class="panel-title">
                <div>
                    <h3>Action Types</h3>
                    <div class="meta">Used in Actions log (Call, WhatsApp, Meeting, Follow Up).</div>
                </div>
                <div class="hint">Total: {{ $actionTypes->count() }}</div>
            </div>

            <form method="POST" action="{{ route('crm.admin.settings.actionTypes.store') }}" class="add-row">
                @csrf
                <input name="name" placeholder="Add new action type (e.g., Site Visit)" class="dark-input" />
                <button class="crm-btn crm-btn-primary btn-sm">Add</button>
                <div class="helper">Keep action verbs clear.</div>
            </form>

            <div class="table-card">
                <div class="table-wrap">
                    <table class="dark-table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Active</th>
                            <th style="width:260px;">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($actionTypes as $type)
                            <tr x-data="{editing:false, name:@js($type->name)}">
                                <td>
                                    <div x-show="!editing">
                                        <strong class="row-title">{{ $type->name }}</strong>
                                    </div>

                                    <div x-show="editing" x-cloak>
                                        <form method="POST" action="{{ route('crm.admin.settings.actionTypes.update', $type->id) }}" class="row-edit">
                                            @csrf
                                            @method('PATCH')
                                            <input name="name" x-model="name" class="dark-input" />
                                            <button class="crm-btn crm-btn-primary btn-sm">Save</button>
                                            <button type="button" class="crm-btn crm-btn-ghost btn-sm"
                                                    @click="editing=false; name=@js($type->name)">Cancel</button>
                                        </form>
                                    </div>
                                </td>

                                <td>
                                    <span class="status-pill">
                                        <span class="dot {{ $type->is_active ? '' : 'off' }}"></span>
                                        {{ $type->is_active ? 'Yes' : 'No' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="actions-inline">
                                        <button class="crm-btn crm-btn-ghost btn-sm"
                                                @click.prevent="editing=!editing"
                                                x-text="editing ? 'Close' : 'Edit'"></button>

                                        <form method="POST" action="{{ route('crm.admin.settings.actionTypes.toggle', $type->id) }}"
                                              onsubmit="return confirm('Toggle action type active state?')" style="display:inline">
                                            @csrf
                                            @method('PATCH')
                                            <button class="crm-btn crm-btn-ghost btn-sm">
                                                {{ $type->is_active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3"><div class="empty">No action types found. Add one above.</div></td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
