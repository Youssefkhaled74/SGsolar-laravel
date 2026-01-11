@extends('crm.layouts.sales')

@section('title','My Leads')

@section('content')
<div>
    <form method="GET" action="{{ route('crm.sales.leads.index') }}" style="display:flex;gap:8px;margin-bottom:12px">
        <input name="q" value="{{ request('q') }}" placeholder="Search leads" class="crm-input" />
        <button class="crm-btn crm-btn-primary">Search</button>
    </form>

    <div class="crm-section">
        <div style="overflow-x:auto">
            <table class="crm-table">
                <thead>
                    <tr><th>Name</th><th>Phone</th><th>Source</th><th>Status</th><th>Created</th><th>Action</th></tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                        <tr>
                            <td>{{ $lead->name }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td>{{ optional($lead->source)->name }}</td>
                            <td><span class="crm-badge crm-badge--status">{{ optional($lead->status)->name }}</span></td>
                            <td>{{ $lead->created_at ? $lead->created_at->format('Y-m-d') : '—' }}</td>
                            <td><a href="{{ route('crm.sales.leads.show',$lead->id) }}" class="crm-btn crm-btn-ghost">Open</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="crm-empty-state">No leads assigned to you.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:12px">{{ $leads->links() }}</div>
    </div>
</div>
@endsection
