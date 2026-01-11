@extends('crm.layouts.admin')

@section('title', 'Users')
@section('subtitle', 'Manage sales team users')

@section('content')
    <style>
        [x-cloak]{display:none!important}

        .users-header{
            display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;
            margin-bottom:12px;
        }
        .users-header h2{margin:0;font-size:18px;font-weight:900}
        .users-header .hint{font-size:13px;color:var(--crm-muted);margin-top:4px}

        .toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center}

        /* Modal */
        .modal-overlay{
            position:fixed;inset:0;background:rgba(15,23,42,0.55);
            z-index:70;display:flex;align-items:center;justify-content:center;
            padding:16px;
        }
        .modal{
            width:100%;max-width:520px;background:#fff;border-radius:14px;
            border:1px solid var(--crm-border);
            box-shadow: var(--crm-shadow-md, 0 10px 24px rgba(16,24,40,0.06));
            overflow:hidden;
        }
        .modal-head{
            display:flex;align-items:flex-start;justify-content:space-between;gap:12px;
            padding:14px 16px;border-bottom:1px solid var(--crm-border);
            background:#fafafa;
        }
        .modal-head h3{margin:0;font-size:16px;font-weight:900}
        .modal-head .sub{font-size:13px;color:var(--crm-muted);margin-top:4px}
        .modal-close{
            border:1px solid var(--crm-border);
            background:#fff;border-radius:10px;padding:6px 10px;
            cursor:pointer;font-weight:900;
        }
        .modal-body{padding:16px}
        .modal-actions{display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;margin-top:12px}

        .alert{
            border-radius:12px;padding:12px 14px;border:1px solid var(--crm-border);background:#fff;
        }
        .alert-success{border-color:#a7f3d0;background:#ecfdf5;color:#065f46}
        .alert-error{border-color:#fecaca;background:#fff5f5;color:#7f1d1d}

        .badge{
            display:inline-flex;align-items:center;gap:8px;
            font-weight:900;font-size:12px;padding:6px 10px;border-radius:999px;
            border:1px solid var(--crm-border);background:#fff;
        }
        .badge.on{border-color:#a7f3d0;background:#ecfdf5;color:#065f46}
        .badge.off{border-color:#fecaca;background:#fff5f5;color:#7f1d1d}

        .toast{position:fixed;right:18px;bottom:18px;z-index:80;max-width:420px}
        .toast-card{
            background:#fff;border:1px solid var(--crm-border);border-radius:12px;padding:12px 14px;
            box-shadow: var(--crm-shadow-md, 0 10px 24px rgba(16,24,40,0.06));
            display:flex;justify-content:space-between;gap:12px;
        }
        .toast .close{background:transparent;border:none;cursor:pointer;font-weight:900;opacity:.85}
        .toast .close:hover{opacity:1}

        .form-grid{display:grid;grid-template-columns:1fr;gap:10px}
        @media(min-width:640px){.form-grid{grid-template-columns:1fr 1fr}}
        .full{grid-column:1 / -1}
        .field-label{font-size:12px;color:var(--crm-muted);font-weight:900;margin-bottom:6px}
    </style>

    @php
        // Open modal automatically if validation errors exist (create form errors)
        $openOnErrors = $errors->any() ? 'true' : 'false';
    @endphp

    <div x-data="{
            openCreate: {{ $openOnErrors }},
            close(){ this.openCreate=false; },
            open(){ this.openCreate=true; }
        }"
        x-on:keydown.escape.window="close()"
    >
        {{-- Success toast --}}
        @if(session('success'))
            <div class="toast" x-data="{show:true}" x-init="setTimeout(()=>show=false, 2600)" x-show="show" x-transition>
                <div class="toast-card">
                    <div>
                        <strong>Success</strong>
                        <div class="text-sm muted" style="margin-top:2px">{{ session('success') }}</div>
                    </div>
                    <button class="close" @click="show=false" aria-label="Close">✕</button>
                </div>
            </div>
        @endif

        <div class="crm-section">
            <div class="users-header">
                <div>
                    <h2>Sales Users</h2>
                    <div class="hint">Create, deactivate, and manage the sales team accounts.</div>
                </div>

                <div class="toolbar">
                    <button class="crm-btn crm-btn-primary" type="button" @click="open()">
                        + Add Sales User
                    </button>
                </div>
            </div>

            <div style="overflow-x:auto">
                <table class="crm-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="width:160px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td><strong>{{ $u->name }}</strong></td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->phone ?? '—' }}</td>
                            <td>
                                @if($u->is_active)
                                    <span class="badge on">Active</span>
                                @else
                                    <span class="badge off">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $u->created_at ? $u->created_at->format('Y-m-d') : '—' }}</td>
                            <td>
                                <form method="POST"
                                      action="{{ route('crm.admin.users.toggle', $u->id) }}"
                                      style="display:inline"
                                      onsubmit="return confirm('Toggle this user active state?')"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <button class="crm-btn crm-btn-ghost" type="submit">
                                        {{ $u->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="crm-empty-state">No sales users yet. Click “Add Sales User”.</div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal --}}
        <div class="modal-overlay" x-show="openCreate" x-cloak x-transition.opacity
             @click.self="close()"
        >
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
                                <input name="name" value="{{ old('name') }}" class="crm-input" placeholder="e.g., Ahmed Hassan" />
                            </div>

                            <div>
                                <div class="field-label">Phone</div>
                                <input name="phone" value="{{ old('phone') }}" class="crm-input" placeholder="e.g., 010..." />
                            </div>

                            <div class="full">
                                <div class="field-label">Email</div>
                                <input name="email" value="{{ old('email') }}" class="crm-input" placeholder="e.g., ahmed@company.com" />
                            </div>

                            <div class="full">
                                <div class="field-label">Password</div>
                                <input type="password" name="password" class="crm-input" placeholder="Set a password" />
                                <div class="text-sm muted" style="margin-top:6px">
                                    Tip: Use at least 8 characters.
                                </div>
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
    </div>
@endsection
