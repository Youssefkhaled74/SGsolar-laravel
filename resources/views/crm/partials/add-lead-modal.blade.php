@php
    $leadStatuses = \App\Models\LeadStatus::orderBy('sort_order')->get();
    $leadSources = \App\Models\LeadSource::orderBy('name')->get();
    $salesUsers = \App\Models\User::whereHas('role', function($r){ $r->where('name','sales'); })->get();
@endphp

<div x-data="{ open:false, form: { name:'', phone:'', email:'', source_id:'', status_id:'', assigned_to:'', message:'' } }"
     @open-add-lead.window="open=true"
     x-cloak
>
    <template x-if="open">
        <div class="crm-overlay" x-show="open" @click="open=false" style="position:fixed;inset:0;z-index:60"></div>
    </template>

    <div x-show="open" x-cloak style="position:fixed;right:0;top:8%;width:520px;z-index:70">
        <div style="background:var(--glass);border:1px solid var(--dash-border);border-radius:12px;padding:18px;box-shadow:var(--shadow);color:var(--dash-text)">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                <div style="font-weight:900;font-size:16px">Add New Lead</div>
                <button @click="open=false" class="icon-btn">✕</button>
            </div>

            <form method="POST" action="{{ route('crm.admin.leads.store') }}">
                @csrf
                <div style="display:grid;gap:8px">
                    <div>
                        <label class="text-sm muted">Name</label>
                        <input name="name" required class="crm-input" />
                    </div>

                    <div style="display:flex;gap:8px">
                        <div style="flex:1">
                            <label class="text-sm muted">Phone</label>
                            <input name="phone" class="crm-input" />
                        </div>
                        <div style="flex:1">
                            <label class="text-sm muted">Email</label>
                            <input name="email" class="crm-input" />
                        </div>
                    </div>

                    <div style="display:flex;gap:8px">
                        <div style="flex:1">
                            <label class="text-sm muted">Source</label>
                            <select name="source_id" class="crm-input">
                                <option value="">Select source</option>
                                @foreach($leadSources as $src)
                                    <option value="{{ $src->id }}">{{ $src->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div style="flex:1">
                            <label class="text-sm muted">Status</label>
                            <select name="status_id" class="crm-input">
                                <option value="">Select status</option>
                                @foreach($leadStatuses as $st)
                                    <option value="{{ $st->id }}">{{ $st->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if(optional(Auth::user())->isAdmin())
                        <div>
                            <label class="text-sm muted">Assign to</label>
                            <select name="assigned_to" class="crm-input">
                                <option value="">Unassigned</option>
                                @foreach($salesUsers as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div>
                        <label class="text-sm muted">Message</label>
                        <textarea name="message" rows="3" class="crm-input"></textarea>
                    </div>

                    <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:6px">
                        <button type="button" @click="open=false" class="crm-btn crm-btn-ghost">Cancel</button>
                        <button class="crm-btn crm-btn-primary">Create Lead</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

