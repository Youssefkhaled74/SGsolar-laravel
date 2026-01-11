@extends('crm.layouts.admin')

@section('title', 'Leads')
@section('subtitle', 'Manage and review leads')

@section('content')
    <div class="crm-section">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
            <div style="flex:1;min-width:220px">
                    <form method="GET" action="{{ route('crm.admin.leads.index') }}">
                        <input name="q" value="{{ request('q') }}" placeholder="Search leads by name, phone or email" style="width:100%;padding:10px;border-radius:8px;border:1px solid var(--crm-border)" />
                    </form>
                </div>

            <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                <form method="GET" action="{{ route('crm.admin.leads.index') }}" style="display:flex;gap:8px">
                    <select name="status_id" style="padding:8px;border-radius:8px;border:1px solid var(--crm-border)">
                        <option value="">Status</option>
                        @foreach($statuses as $s)
                            <option value="{{ $s->id }}" {{ request('status_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                    <select name="source_id" style="padding:8px;border-radius:8px;border:1px solid var(--crm-border)">
                        <option value="">Source</option>
                        @foreach($sources as $src)
                            <option value="{{ $src->id }}" {{ request('source_id') == $src->id ? 'selected' : '' }}>{{ $src->name }}</option>
                        @endforeach
                    </select>
                    <select name="assigned_to" style="padding:8px;border-radius:8px;border:1px solid var(--crm-border)">
                        <option value="">Assigned</option>
                        @foreach($sales as $s)
                            <option value="{{ $s->id }}" {{ request('assigned_to') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                    <button class="crm-btn crm-btn-primary">Apply</button>
                </form>
            </div>
        </div>
    </div>

    <div class="crm-section" style="margin-top:18px">
        <div style="overflow-x:auto">
            <table class="crm-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Source</th>
                        <th>Status</th>
                        <th>Assigned</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr>
                            <td>{{ $lead->name }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td>{{ optional($lead->source)->name }}</td>
                            <td><span class="crm-badge crm-badge--status">{{ optional($lead->status)->name }}</span></td>
                            <td>{{ optional($lead->assignedTo)->name ?? 'Unassigned' }}</td>
                            <td>{{ $lead->created_at ? $lead->created_at->format('Y-m-d') : '—' }}</td>
                            <td><a href="{{ route('crm.admin.leads.show', ['lead' => $lead->id]) }}" class="crm-btn crm-btn-ghost">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="crm-empty-state">No leads found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:12px">{{ $leads->links() }}</div>
    </div>

@endsection
