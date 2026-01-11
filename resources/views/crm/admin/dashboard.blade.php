@extends('crm.layouts.admin')

@section('title', 'Admin Dashboard')
@section('subtitle', 'Overview and quick actions')

@section('content')
    <div class="crm-main">
        <div class="crm-grid">
            <div class="crm-card">
                <h3>Total Leads</h3>
                <div class="value">—</div>
                <div class="text-muted mt-2">Trend: —</div>
            </div>
            <div class="crm-card">
                <h3>New Leads</h3>
                <div class="value">—</div>
                <div class="text-muted mt-2">Trend: —</div>
            </div>
            <div class="crm-card">
                <h3>Unassigned Leads</h3>
                <div class="value">—</div>
                <div class="text-muted mt-2">Trend: —</div>
            </div>
            <div class="crm-card">
                <h3>Followups Today</h3>
                <div class="value">—</div>
                <div class="text-muted mt-2">Trend: —</div>
            </div>
        </div>

        <div style="margin-top:18px;display:grid;gap:18px">
            <section class="crm-section">
                <div style="display:flex;align-items:center;justify-content:space-between">
                    <h3 style="margin:0">Quick Links</h3>
                    <div class="crm-quick">
                        <a href="{{ route('crm.admin.leads.index') }}" class="crm-btn">Leads</a>
                        <a href="{{ route('crm.admin.users.index') }}" class="crm-btn crm-btn-primary">Users</a>
                    </div>
                </div>
            </section>

            <section class="crm-section">
                <h3 style="margin:0 0 12px 0">Recent Activity</h3>
                <div style="overflow-x:auto">
                    <table class="crm-table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Actor</th>
                                <th>Action</th>
                                <th>Target</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i=0;$i<5;$i++)
                                <tr>
                                    <td>—</td>
                                    <td>—</td>
                                    <td>—</td>
                                    <td>—</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection
