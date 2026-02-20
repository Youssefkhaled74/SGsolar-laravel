@extends('crm.layouts.admin')

@section('title', 'Users')
@section('subtitle', 'Manage sales team users')

@section('content')
<style>
    [x-cloak]{display:none!important}

    .dark{
        --u-border: rgba(255,255,255,.10);
        --u-bg: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
        --u-shadow: 0 22px 60px rgba(0,0,0,.35);
        --u-text: rgba(255,255,255,.92);
        --u-muted: rgba(255,255,255,.62);
        --u-card-bg: rgba(0,0,0,.14);
        --u-card-border: rgba(255,255,255,.10);
        --u-table-head-bg: rgba(255,255,255,.04);
        --u-table-row-bg: rgba(0,0,0,.06);
        --u-table-row-hover: rgba(255,255,255,.03);
        --u-table-border: rgba(255,255,255,.06);
        --u-pill-bg: rgba(255,255,255,.05);
        --u-pill-border: rgba(255,255,255,.14);
        --u-pill-text: rgba(255,255,255,.85);
        --u-input-bg: rgba(255,255,255,.04);
        --u-input-border: rgba(255,255,255,.14);
        --u-input-color: rgba(255,255,255,.90);
        --u-input-placeholder: rgba(255,255,255,.55);
        --u-toast-bg: rgba(0,0,0,.35);
        --u-toast-border: rgba(255,255,255,.12);
        --u-toast-text: rgba(255,255,255,.88);
        --u-overlay: rgba(0,0,0,.55);
        --u-modal-bg: rgba(7,11,18,.88);
        --u-modal-head-bg: rgba(255,255,255,.03);
        --u-alert-bg: rgba(255,255,255,.04);
        --u-alert-border: rgba(255,255,255,.12);
        --u-empty-bg: rgba(0,0,0,.14);
        --u-empty-border: rgba(255,255,255,.14);
        --u-danger-text: #ffd0d0;
        --u-danger-bg: rgba(239,68,68,.12);
        --u-danger-border: rgba(239,68,68,.28);
        --u-warning-text: rgba(255,255,255,.88);
        --u-warning-bg: rgba(255,223,65,.10);
        --u-warning-border: rgba(255,223,65,.22);
    }

    html:not(.dark){
        --u-border: rgba(0,0,0,.12);
        --u-bg: #FFFFFF;
        --u-shadow: 0 4px 12px rgba(0,0,0,.08);
        --u-text: rgba(0,0,0,.92);
        --u-muted: rgba(0,0,0,.60);
        --u-card-bg: #FFFFFF;
        --u-card-border: rgba(0,0,0,.12);
        --u-table-head-bg: rgba(0,0,0,.05);
        --u-table-row-bg: #FFFFFF;
        --u-table-row-hover: rgba(0,0,0,.03);
        --u-table-border: rgba(0,0,0,.10);
        --u-pill-bg: rgba(0,0,0,.05);
        --u-pill-border: rgba(0,0,0,.15);
        --u-pill-text: rgba(0,0,0,.85);
        --u-input-bg: rgba(0,0,0,.03);
        --u-input-border: rgba(0,0,0,.18);
        --u-input-color: rgba(0,0,0,.95);
        --u-input-placeholder: rgba(0,0,0,.50);
        --u-toast-bg: #FFFFFF;
        --u-toast-border: rgba(0,0,0,.12);
        --u-toast-text: rgba(0,0,0,.88);
        --u-overlay: rgba(0,0,0,.45);
        --u-modal-bg: #FFFFFF;
        --u-modal-head-bg: rgba(0,0,0,.03);
        --u-alert-bg: rgba(0,0,0,.03);
        --u-alert-border: rgba(0,0,0,.12);
        --u-empty-bg: rgba(0,0,0,.03);
        --u-empty-border: rgba(0,0,0,.18);
        --u-danger-text: #b91c1c;
        --u-danger-bg: rgba(239,68,68,.08);
        --u-danger-border: rgba(239,68,68,.35);
        --u-warning-text: #5c4100;
        --u-warning-bg: rgba(255,223,65,.20);
        --u-warning-border: rgba(255,223,65,.35);
    }

    /* ===== Shell (same theme) ===== */
    .users-shell{
        position:relative;
        border-radius:20px;
        overflow:hidden;
        border:1px solid var(--u-border);
        background: var(--u-bg);
        box-shadow: var(--u-shadow);
    }
    .users-bg{
        position:absolute; inset:0; z-index:0; pointer-events:none;
        background:
            radial-gradient(900px 520px at 16% 10%, rgba(140,198,63,.14), transparent 55%),
            radial-gradient(900px 520px at 86% 18%, rgba(255,223,65,.14), transparent 55%),
            radial-gradient(800px 520px at 72% 90%, rgba(227,160,0,.10), transparent 55%),
            linear-gradient(180deg, rgba(7,11,18,.45), rgba(10,18,32,.25));
        filter: blur(14px);
        opacity:.75;
    }
    html:not(.dark) .users-bg{display:none}
    .users-wrap{position:relative; z-index:1; padding:16px}

    /* ===== Header ===== */
    .users-header{
        display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;
        margin-bottom:12px;
    }
    .users-header h2{margin:0;font-size:18px;font-weight:900;color:var(--u-text)}
    .users-header .hint{font-size:13px;font-weight:800;color:var(--u-muted);margin-top:4px}
    .toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center}

    .count-pill{
        display:inline-flex;align-items:center;gap:8px;
        padding:7px 10px;border-radius:999px;
        border:1px solid var(--u-pill-border);
        background: var(--u-pill-bg);
        font-weight:900;font-size:12px;
        color: var(--u-pill-text);
    }

    /* ===== Table card ===== */
    .table-card{
        border-radius:16px;
        border:1px solid var(--u-card-border);
        background: var(--u-card-bg);
        box-shadow: 0 12px 26px rgba(0,0,0,.22);
        backdrop-filter: blur(10px);
        overflow:hidden;
    }
    .dark-table{width:100%;border-collapse:collapse}
    .dark-table thead th{
        text-align:left;
        font-size:12px;
        font-weight:900;
        color: var(--u-muted);
        padding:12px 14px;
        background: var(--u-table-head-bg);
        border-bottom:1px solid var(--u-table-border);
        white-space:nowrap;
    }
    .dark-table td{
        padding:12px 14px;
        color: var(--u-text);
        font-weight:800;
        border-bottom:1px solid var(--u-table-border);
        background: var(--u-table-row-bg);
        vertical-align:middle;
    }
    .dark-table tbody tr:hover td{background: var(--u-table-row-hover)}
    .row-title{font-weight:900;color:var(--u-text)}
    .muted{color: var(--u-muted)!important}

    /* ===== Status badge ===== */
    .badge{
        display:inline-flex;align-items:center;gap:8px;
        padding:6px 10px;border-radius:999px;
        border:1px solid var(--u-pill-border);
        background: var(--u-pill-bg);
        font-size:12px;font-weight:900;
        color: var(--u-pill-text);
        white-space:nowrap;
    }
    .badge .dot{width:8px;height:8px;border-radius:999px}
    .badge.on{border-color:rgba(16,185,129,.28);background:rgba(16,185,129,.12);color:#c7f9e9}
    .badge.on .dot{background:rgba(16,185,129,.55)}
    .badge.off{border-color:rgba(239,68,68,.28);background:rgba(239,68,68,.12);color:#ffd0d0}
    .badge.off .dot{background:rgba(239,68,68,.55)}

    /* ===== Actions layout (FIXED) ===== */
    .actions-cell{min-width:260px}
    .action-group{
        display:flex;
        gap:8px;
        flex-wrap:wrap;
        align-items:center;
        justify-content:flex-start;
    }
    .btn-mini{
        padding:9px 12px;
        border-radius:12px;
        font-weight:900;
        white-space:nowrap;
        line-height:1;
    }

    /* Better danger button (same theme, not screaming red) */
    .btn-danger{
        border:1px solid var(--u-danger-border);
        background: var(--u-danger-bg);
        color:var(--u-danger-text);
        box-shadow: 0 10px 22px rgba(0,0,0,.18);
    }
    .btn-danger:hover{background: rgba(239,68,68,.16)}
    .btn-warning{
        border:1px solid var(--u-warning-border);
        background: var(--u-warning-bg);
        color: var(--u-warning-text);
    }
    .btn-warning:hover{background: rgba(255,223,65,.14)}

    /* ===== Inputs (dark) ===== */
    .dark-input{
        width:100%;
        padding:10px 12px;
        border-radius:14px;
        border:1px solid var(--u-input-border);
        background: var(--u-input-bg);
        color: var(--u-input-color);
        font-weight:800;
        outline:none;
    }
    .dark-input::placeholder{color: var(--u-input-placeholder)}
    .dark-input:focus{
        border-color: rgba(255,223,65,.28);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }

    /* ===== Toast ===== */
    .toast{position:fixed;right:18px;bottom:18px;z-index:9999;max-width:420px}
    .toast-card{
        background: var(--u-toast-bg);
        border:1px solid var(--u-toast-border);
        border-radius:14px;
        padding:12px 14px;
        box-shadow: 0 18px 40px rgba(0,0,0,.35);
        backdrop-filter: blur(10px);
        display:flex;justify-content:space-between;gap:12px;
        color: var(--u-toast-text);
    }
    .toast .close{background:transparent;border:none;cursor:pointer;font-weight:900;opacity:.85;color:var(--u-text)}
    .toast .close:hover{opacity:1}

    /* ===== Modal (dark) ===== */
    .modal-overlay{
        position:fixed;inset:0;
        background: var(--u-overlay);
        z-index:9998;
        display:flex;align-items:center;justify-content:center;
        padding:16px;
    }
    .modal{
        width:100%;
        max-width:560px;
        border-radius:18px;
        border:1px solid var(--u-alert-border);
        background: var(--u-modal-bg);
        box-shadow: 0 26px 80px rgba(0,0,0,.60);
        backdrop-filter: blur(12px);
        overflow:hidden;
    }
    .modal-head{
        display:flex;align-items:flex-start;justify-content:space-between;gap:12px;
        padding:14px 16px;
        border-bottom:1px solid var(--u-alert-border);
        background: var(--u-modal-head-bg);
    }
    .modal-head h3{margin:0;font-size:16px;font-weight:900;color:var(--u-text)}
    .modal-head .sub{font-size:13px;font-weight:800;color:var(--u-muted);margin-top:4px}
    .modal-close{
        border:1px solid var(--u-input-border);
        background: var(--u-input-bg);
        color: var(--u-text);
        border-radius:12px;
        padding:6px 10px;
        cursor:pointer;
        font-weight:900;
    }
    .modal-close:hover{background: var(--u-table-row-hover)}
    .modal-body{padding:16px}

    .modal-actions{
        display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;margin-top:14px;
        padding-top:12px;border-top:1px solid var(--u-border);
    }

    /* Alerts (dark) */
    .alert{
        border-radius:14px;
        padding:12px 14px;
        border:1px solid var(--u-alert-border);
        background: var(--u-alert-bg);
        color: var(--u-text);
    }
    .alert-error{border-color:rgba(239,68,68,.25);background:rgba(239,68,68,.10);color:var(--u-danger-text)}
    .tip{font-size:12px;font-weight:800;color:var(--u-muted);margin-top:6px}

    /* Form grid */
    .form-grid{display:grid;grid-template-columns:1fr;gap:10px}
    @media(min-width:640px){.form-grid{grid-template-columns:1fr 1fr}}
    .full{grid-column:1 / -1}
    .field-label{font-size:12px;color:var(--u-muted);font-weight:900;margin-bottom:6px}

    /* Empty state */
    .empty{
        padding:14px;
        border-radius:14px;
        border:1px dashed var(--u-empty-border);
        background: var(--u-empty-bg);
        color:var(--u-muted);
        font-weight:800;
        margin:14px;
        text-align:center;
    }
</style>

@php
    $openOnErrors = $errors->any() ? 'true' : 'false';
@endphp

<div
    x-data="{
        openCreate: {{ $openOnErrors }},
        close(){ this.openCreate=false; },
        open(){ this.openCreate=true; },

        // delete modal
        showDelete:false,
        deleteId:null,
        openDelete(id){ this.deleteId = id; this.showDelete = true; },
        closeDelete(){ this.deleteId = null; this.showDelete = false; },
        confirmDelete(){ if(this.deleteId){ document.getElementById('delete-form-'+this.deleteId).submit(); } },

        // edit modal
        showEdit:false,
        editUser: { id: null, name: '', email: '', phone: '' },
        baseUpdateUrl: '{{ url('/crm/admin/users') }}',
        openEdit(u){ this.editUser = u; this.showEdit = true; },
        closeEdit(){ this.editUser = { id:null, name:'', email:'', phone:'' }; this.showEdit = false; }
    }"
    x-on:keydown.escape.window="close(); closeDelete(); closeEdit();"
>
    {{-- Toasts --}}
    @if(session('success'))
        <div class="toast" x-data="{show:true}" x-init="setTimeout(()=>show=false, 2600)" x-show="show" x-transition>
            <div class="toast-card">
                <div>
                    <strong>Success</strong>
                    <div class="tip" style="margin-top:2px">{{ session('success') }}</div>
                </div>
                <button class="close" @click="show=false" aria-label="Close">✕</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast" x-data="{show:true}" x-init="setTimeout(()=>show=false, 3600)" x-show="show" x-transition>
            <div class="toast-card">
                <div>
                    <strong>Error</strong>
                    <div class="tip" style="margin-top:2px">{{ session('error') }}</div>
                </div>
                <button class="close" @click="show=false" aria-label="Close">✕</button>
            </div>
        </div>
    @endif

    <div class="users-shell">
        <div class="users-bg" aria-hidden="true"></div>

        <div class="users-wrap">
            <div class="users-header">
                <div>
                    <div class="count-pill" style="margin-bottom:10px">
                        <span style="width:8px;height:8px;border-radius:999px;background:rgba(140,198,63,.40)"></span>
                        Total Users: <strong style="color:var(--u-text)">{{ $users->count() }}</strong>
                    </div>

                    <h2>Sales Users</h2>
                    <div class="hint">Create, deactivate, edit, and delete the sales team accounts.</div>
                </div>

                <div class="toolbar">
                    <button class="crm-btn crm-btn-primary" type="button" @click="open()">
                        + Add Sales User
                    </button>
                </div>
            </div>

            <div class="table-card">
                <div style="overflow-x:auto">
                    <table class="dark-table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="actions-cell">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $u)
                            <tr>
                                <td class="row-title">{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->phone ?? '—' }}</td>
                                <td>
                                    @if($u->is_active)
                                        <span class="badge on"><span class="dot"></span>Active</span>
                                    @else
                                        <span class="badge off"><span class="dot"></span>Inactive</span>
                                    @endif
                                </td>
                                <td class="muted">{{ $u->created_at ? $u->created_at->format('Y-m-d') : '—' }}</td>

                                <td class="actions-cell">
                                    <div class="action-group">
                                        {{-- Toggle active --}}
                                        <form method="POST"
                                              action="{{ route('crm.admin.users.toggle', $u->id) }}"
                                              style="display:inline"
                                              onsubmit="return confirm('Toggle this user active state?')"
                                        >
                                            @csrf
                                            @method('PATCH')
                                            <button class="crm-btn crm-btn-ghost btn-mini" type="submit">
                                                {{ $u->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                        {{-- Edit --}}
                                        <button
                                            type="button"
                                            class="crm-btn crm-btn-ghost btn-mini"
                                            @click="openEdit({ id: {{ $u->id }}, name: @js($u->name), email: @js($u->email), phone: @js($u->phone ?? '') })"
                                        >
                                            Edit
                                        </button>

                                        {{-- Delete --}}
                                        <form id="delete-form-{{ $u->id }}" method="POST" action="{{ route('crm.admin.users.destroy', $u->id) }}" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="crm-btn btn-danger btn-mini" @click="openDelete({{ $u->id }})">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty">No sales users yet. Click “Add Sales User”.</div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Create Modal --}}
    <div class="modal-overlay" x-show="openCreate" x-cloak x-transition.opacity @click.self="close()">
        <div class="modal" x-transition>
            <div class="modal-head">
                <div>
                    <h3>Create Sales User</h3>
                    <div class="sub">Add a new sales account for CRM access.</div>
                </div>
                <button class="modal-close" type="button" @click="close()">✕</button>
            </div>

            <div class="modal-body">
                @if($errors->any())
                    <div class="alert alert-error" style="margin-bottom:12px">
                        <strong style="display:block;margin-bottom:6px">Please fix:</strong>
                        <ul style="margin:0;padding-left:18px">
                            @foreach($errors->all() as $err)
                                <li style="margin:2px 0">{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('crm.admin.users.store') }}">
                    @csrf

                    <div class="form-grid">
                        <div>
                            <div class="field-label">Name</div>
                            <input name="name" value="{{ old('name') }}" class="dark-input" placeholder="e.g., Ahmed Hassan" />
                        </div>

                        <div>
                            <div class="field-label">Phone</div>
                            <input name="phone" value="{{ old('phone') }}" class="dark-input" placeholder="e.g., 010..." />
                        </div>

                        <div class="full">
                            <div class="field-label">Email</div>
                            <input name="email" value="{{ old('email') }}" class="dark-input" placeholder="e.g., ahmed@company.com" />
                        </div>

                        <div class="full">
                            <div class="field-label">Password</div>
                            <input type="password" name="password" class="dark-input" placeholder="Set a password" />
                            <div class="tip">Tip: Use at least 8 characters.</div>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="crm-btn crm-btn-ghost" @click="close()">Cancel</button>
                        <button class="crm-btn crm-btn-primary" type="submit">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal-overlay" x-show="showDelete" x-cloak x-transition.opacity @click.self="closeDelete()">
        <div class="modal" x-transition>
            <div class="modal-head">
                <div>
                    <h3>Confirm delete</h3>
                    <div class="sub">This will permanently delete the sales user.</div>
                </div>
                <button class="modal-close" type="button" @click="closeDelete()">✕</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-error">
                    Are you sure you want to delete this user? This action cannot be undone.
                </div>

                <div class="modal-actions">
                    <button type="button" class="crm-btn crm-btn-ghost" @click="closeDelete()">Cancel</button>
                    <button type="button" class="crm-btn btn-danger" @click="confirmDelete()">Delete user</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal-overlay" x-show="showEdit" x-cloak x-transition.opacity @click.self="closeEdit()">
        <div class="modal" x-transition>
            <div class="modal-head">
                <div>
                    <h3>Edit Sales User</h3>
                    <div class="sub">Update sales account details.</div>
                </div>
                <button class="modal-close" type="button" @click="closeEdit()">✕</button>
            </div>

            <div class="modal-body">
                <form method="POST" :action="baseUpdateUrl + '/' + editUser.id">
                    @csrf
                    @method('PATCH')

                    <div class="form-grid">
                        <div>
                            <div class="field-label">Name</div>
                            <input name="name" class="dark-input" x-model="editUser.name" />
                        </div>

                        <div>
                            <div class="field-label">Phone</div>
                            <input name="phone" class="dark-input" x-model="editUser.phone" />
                        </div>

                        <div class="full">
                            <div class="field-label">Email</div>
                            <input name="email" class="dark-input" x-model="editUser.email" />
                        </div>

                        <div class="full">
                            <div class="field-label">Password</div>
                            <input type="password" name="password" class="dark-input" placeholder="Leave blank to keep current password" />
                            <div class="tip">Leave blank to keep the existing password.</div>
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="crm-btn crm-btn-ghost" @click="closeEdit()">Cancel</button>
                        <button type="submit" class="crm-btn crm-btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

