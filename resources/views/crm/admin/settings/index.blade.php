@extends('crm.layouts.admin')

@section('title', 'Settings')
@section('subtitle', 'Manage statuses, sources, and action types')

@section('content')
    {{-- Page-scoped CSS (kept here as requested) --}}
    <style>
        [x-cloak]{display:none!important}

        .settings-wrap{display:flex;flex-direction:column;gap:14px}

        .crm-alert{
            border-radius:12px;
            padding:12px 14px;
            border:1px solid var(--crm-border);
            background:#fff;
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:12px;
        }
        .crm-alert-success{border-color:#a7f3d0;background:#ecfdf5;color:#065f46}
        .crm-alert-error{border-color:#fecaca;background:#fff5f5;color:#7f1d1d}
        .crm-alert .close{background:transparent;border:none;cursor:pointer;font-weight:900;opacity:.8}
        .crm-alert .close:hover{opacity:1}

        .settings-header{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            flex-wrap:wrap;
        }
        .settings-header .hint{color:var(--crm-muted);font-size:13px}

        .settings-tabs{
            display:flex;
            gap:8px;
            flex-wrap:wrap;
            padding:6px;
            border:1px solid var(--crm-border);
            border-radius:12px;
            background:#fff;
            box-shadow: var(--crm-shadow-sm, 0 6px 18px rgba(16,24,40,0.03));
        }
        .settings-tab{
            border:1px solid transparent;
            background:transparent;
            padding:10px 12px;
            border-radius:10px;
            font-weight:900;
            cursor:pointer;
            color:var(--crm-muted);
            transition:background .15s ease, color .15s ease, border-color .15s ease;
        }
        .settings-tab:hover{background:#f8fafc;color:var(--crm-text)}
        .settings-tab.active{
            background:rgba(14,165,164,0.10);
            border-color:rgba(14,165,164,0.25);
            color:var(--crm-text);
        }

        .settings-panel{
            background:#fff;
            border:1px solid var(--crm-border);
            border-radius:12px;
            padding:14px;
            box-shadow: var(--crm-shadow-sm, 0 6px 18px rgba(16,24,40,0.03));
        }

        .panel-title{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            flex-wrap:wrap;
            margin-bottom:10px;
        }
        .panel-title h3{margin:0;font-size:16px;font-weight:900}
        .panel-title .meta{font-size:13px;color:var(--crm-muted)}

        .add-row{
            display:flex;
            gap:10px;
            align-items:center;
            flex-wrap:wrap;
            margin-bottom:12px;
        }
        .add-row .crm-input{max-width:420px}
        .add-row .helper{font-size:12px;color:var(--crm-muted)}

        .actions-inline{display:flex;gap:8px;flex-wrap:wrap}
        .btn-sm{padding:8px 10px;border-radius:10px;font-weight:900}

        .status-pill{
            display:inline-flex;
            align-items:center;
            gap:8px;
            font-weight:900;
        }
        .dot{
            width:10px;height:10px;border-radius:999px;
            background:#22c55e;
            box-shadow:0 0 0 3px rgba(34,197,94,0.12);
        }
        .dot.off{
            background:#ef4444;
            box-shadow:0 0 0 3px rgba(239,68,68,0.12);
        }

        .row-edit{
            display:flex;
            align-items:center;
            gap:8px;
            flex-wrap:wrap;
        }
        .row-edit .crm-input{min-width:240px}

        /* Improve table spacing on small screens */
        .table-wrap{overflow-x:auto}
        .crm-table td, .crm-table th{white-space:nowrap}
        .crm-table td:first-child{white-space:normal;min-width:240px}

        /* Small toast */
        .toast{
            position:fixed;
            right:18px;
            bottom:18px;
            z-index:60;
            max-width:380px;
        }
        .toast-card{
            border-radius:12px;
            padding:12px 14px;
            border:1px solid var(--crm-border);
            background:#fff;
            box-shadow: var(--crm-shadow-md, 0 10px 24px rgba(16,24,40,0.06));
            display:flex;
            justify-content:space-between;
            gap:12px;
        }
    </style>

    {{-- Page-scoped JS (kept here as requested) --}}
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
                        <div class="muted text-sm" style="margin-top:2px;">{{ session('success') }}</div>
                    </div>
                    <button class="close" @click="show=false" aria-label="Close">✕</button>
                </div>
            </div>
        @endif

        <div class="settings-header">
            <div>
                <div class="h2">Settings</div>
                <div class="hint">Manage lead statuses, sources, and action types used across the CRM.</div>
            </div>
            <div class="muted text-sm">
                Tip: Changes apply immediately across Leads & Followups.
            </div>
        </div>

        {{-- Tabs --}}
        <div class="settings-tabs">
            <button class="settings-tab" :class="tab==='statuses' ? 'settings-tab active' : 'settings-tab'"
                    @click.prevent="setTab('statuses')">Statuses</button>
            <button class="settings-tab" :class="tab==='sources' ? 'settings-tab active' : 'settings-tab'"
                    @click.prevent="setTab('sources')">Sources</button>
            <button class="settings-tab" :class="tab==='actions' ? 'settings-tab active' : 'settings-tab'"
                    @click.prevent="setTab('actions')">Action Types</button>
        </div>

        {{-- Statuses --}}
        <div class="settings-panel" x-show="tab==='statuses'" x-cloak x-transition.opacity>
            <div class="panel-title">
                <h3>Lead Statuses</h3>
                <div class="meta">Used to track lead progress (e.g., New, In Progress, Closed).</div>
            </div>

            <form method="POST" action="{{ route('crm.admin.settings.statuses.store') }}" class="add-row">
                @csrf
                <input name="name" placeholder="Add new status (e.g., Waiting Payment)" class="crm-input" />
                <button class="crm-btn crm-btn-primary btn-sm">Add</button>
                <div class="helper">Keep names short & clear.</div>
            </form>

            <div class="table-wrap">
                <table class="crm-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Active</th>
                        <th style="width:240px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($statuses as $status)
                        <tr x-data="{editing:false, name:@js($status->name)}">
                            <td>
                                <div x-show="!editing">
                                    <strong>{{ $status->name }}</strong>
                                </div>

                                <div x-show="editing" x-cloak>
                                    <form method="POST" action="{{ route('crm.admin.settings.statuses.update', $status->id) }}" class="row-edit">
                                        @csrf
                                        @method('PATCH')
                                        <input name="name" x-model="name" class="crm-input" />
                                        <button class="crm-btn crm-btn-primary btn-sm">Save</button>
                                        <button type="button" class="crm-btn crm-btn-ghost btn-sm" @click="editing=false; name=@js($status->name)">Cancel</button>
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
                                    <button class="crm-btn crm-btn-ghost btn-sm" @click.prevent="editing=!editing" x-text="editing ? 'Close' : 'Edit'"></button>

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
                        <tr>
                            <td colspan="3">
                                <div class="crm-empty-state">No statuses found. Add one above.</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sources --}}
        <div class="settings-panel" x-show="tab==='sources'" x-cloak x-transition.opacity>
            <div class="panel-title">
                <h3>Lead Sources</h3>
                <div class="meta">Where the lead came from (Contact Us, Product Page, Manual, Excel Import).</div>
            </div>

            <form method="POST" action="{{ route('crm.admin.settings.sources.store') }}" class="add-row">
                @csrf
                <input name="name" placeholder="Add new source (e.g., Facebook Ads)" class="crm-input" />
                <button class="crm-btn crm-btn-primary btn-sm">Add</button>
                <div class="helper">Use a consistent naming style.</div>
            </form>

            <div class="table-wrap">
                <table class="crm-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Active</th>
                        <th style="width:240px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($sources as $source)
                        <tr x-data="{editing:false, name:@js($source->name)}">
                            <td>
                                <div x-show="!editing">
                                    <strong>{{ $source->name }}</strong>
                                </div>

                                <div x-show="editing" x-cloak>
                                    <form method="POST" action="{{ route('crm.admin.settings.sources.update', $source->id) }}" class="row-edit">
                                        @csrf
                                        @method('PATCH')
                                        <input name="name" x-model="name" class="crm-input" />
                                        <button class="crm-btn crm-btn-primary btn-sm">Save</button>
                                        <button type="button" class="crm-btn crm-btn-ghost btn-sm" @click="editing=false; name=@js($source->name)">Cancel</button>
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
                                    <button class="crm-btn crm-btn-ghost btn-sm" @click.prevent="editing=!editing" x-text="editing ? 'Close' : 'Edit'"></button>

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
                        <tr>
                            <td colspan="3">
                                <div class="crm-empty-state">No sources found. Add one above.</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Action Types --}}
        <div class="settings-panel" x-show="tab==='actions'" x-cloak x-transition.opacity>
            <div class="panel-title">
                <h3>Action Types</h3>
                <div class="meta">Used in Actions log (Call, WhatsApp, Meeting, Follow Up).</div>
            </div>

            <form method="POST" action="{{ route('crm.admin.settings.actionTypes.store') }}" class="add-row">
                @csrf
                <input name="name" placeholder="Add new action type (e.g., Site Visit)" class="crm-input" />
                <button class="crm-btn crm-btn-primary btn-sm">Add</button>
                <div class="helper">Keep action verbs clear.</div>
            </form>

            <div class="table-wrap">
                <table class="crm-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Active</th>
                        <th style="width:240px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($actionTypes as $type)
                        <tr x-data="{editing:false, name:@js($type->name)}">
                            <td>
                                <div x-show="!editing">
                                    <strong>{{ $type->name }}</strong>
                                </div>

                                <div x-show="editing" x-cloak>
                                    <form method="POST" action="{{ route('crm.admin.settings.actionTypes.update', $type->id) }}" class="row-edit">
                                        @csrf
                                        @method('PATCH')
                                        <input name="name" x-model="name" class="crm-input" />
                                        <button class="crm-btn crm-btn-primary btn-sm">Save</button>
                                        <button type="button" class="crm-btn crm-btn-ghost btn-sm" @click="editing=false; name=@js($type->name)">Cancel</button>
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
                                    <button class="crm-btn crm-btn-ghost btn-sm" @click.prevent="editing=!editing" x-text="editing ? 'Close' : 'Edit'"></button>

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
                        <tr>
                            <td colspan="3">
                                <div class="crm-empty-state">No action types found. Add one above.</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
