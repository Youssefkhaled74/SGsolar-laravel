@extends('crm.layouts.admin')

@section('title', 'Admin Dashboard')
@section('subtitle', 'Overview and quick actions')

@section('content')
    <style>
        /* ============ Theme-Aware Dashboard Styles ============ */
        :root{
            --brand-yellow: {{ config('website.primary_color', '#FFDF41') }};
            --brand-orange: {{ config('website.secondary_color', '#E3A000') }};
            --brand-green: {{ config('website.forest_green', '#115F45') }};
            --brand-light: {{ config('website.light_green', '#8CC63F') }};
        }

        /* Dark Mode Variables */
        .dark {
            --dash-border:rgba(255,255,255,.10);
            --dash-text:rgba(255,255,255,.92);
            --dash-muted:rgba(255,255,255,.62);
            --dash-card:rgba(0,0,0,.18);
            --dash-card2:rgba(0,0,0,.14);
            --dash-shadow: 0 22px 60px rgba(0,0,0,.35);
            --dash-shadow2: 0 12px 26px rgba(0,0,0,.22);
            --dash-wrap-bg: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.02));
            --dash-head-bg: rgba(0,0,0,.14);
            --kpi-icon-bg: rgba(255,255,255,.05);
            --kpi-icon-border: rgba(255,255,255,.12);
            --table-head-bg: rgba(255,255,255,.04);
            --table-row-bg: rgba(0,0,0,.06);
            --table-row-hover: rgba(255,255,255,.03);
            --table-border: rgba(255,255,255,.06);
            --pill-bg: rgba(255,255,255,.05);
            --pill-border: rgba(255,255,255,.12);
            --pill-text: rgba(255,255,255,.78);
            --empty-bg: rgba(0,0,0,.14);
            --empty-border: rgba(255,255,255,.14);
        }

        /* Light Mode Variables */
        html:not(.dark) {
            --dash-border:rgba(0,0,0,.12);
            --dash-text:rgba(0,0,0,.95);
            --dash-muted:rgba(0,0,0,.70);
            --dash-card:#FFFFFF;
            --dash-card2:#FFFFFF;
            --dash-shadow: 0 4px 12px rgba(0,0,0,.08);
            --dash-shadow2: 0 2px 8px rgba(0,0,0,.06);
            --dash-wrap-bg: #FFFFFF;
            --dash-head-bg: rgba(248,249,250,.8);
            --kpi-icon-bg: rgba(0,0,0,.05);
            --kpi-icon-border: rgba(0,0,0,.12);
            --table-head-bg: rgba(0,0,0,.05);
            --table-row-bg: #FFFFFF;
            --table-row-hover: rgba(0,0,0,.03);
            --table-border: rgba(0,0,0,.10);
            --pill-bg: rgba(0,0,0,.05);
            --pill-border: rgba(0,0,0,.15);
            --pill-text: rgba(0,0,0,.85);
            --empty-bg: rgba(0,0,0,.03);
            --empty-border: rgba(0,0,0,.18);
        }

        .dash-wrap{
            position:relative;
            border-radius:20px;
            overflow:hidden;
            border:1px solid var(--dash-border);
            background: var(--dash-wrap-bg);
            box-shadow: var(--dash-shadow);
            transition: all 0.3s ease;
        }

        /* Dark mode animated background layer */
        .dark .dash-bg{
            position:absolute; inset:0; z-index:0; pointer-events:none; overflow:hidden;
        }
        .dark .dash-bg::before{
            content:"";
            position:absolute; inset:-40%;
            background:
                radial-gradient(circle at 18% 18%, rgba(140,198,63,.16), transparent 40%),
                radial-gradient(circle at 84% 20%, rgba(255,223,65,.16), transparent 42%),
                radial-gradient(circle at 70% 88%, rgba(227,160,0,.10), transparent 45%),
                radial-gradient(circle at 28% 86%, rgba(17,95,69,.12), transparent 45%),
                linear-gradient(180deg, rgba(7,11,18,.45), rgba(10,18,32,.25));
            filter: blur(14px);
            animation: dashDrift 18s ease-in-out infinite alternate;
        }
        .dark .dash-bg::after{
            content:"";
            position:absolute; inset:0;
            background-image:
                linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 44px 44px;
            opacity:.08;
            mask-image: radial-gradient(closest-side at 50% 35%, black 0%, transparent 72%);
        }
        
        /* Light mode - no animated background */
        html:not(.dark) .dash-bg {
            display: none;
        }
        
        @keyframes dashDrift{
            0%   { transform: translate3d(-1.5%, -1%, 0) scale(1.02) rotate(-.5deg); }
            50%  { transform: translate3d( 1.5%,  1.5%, 0) scale(1.06) rotate( .5deg); }
            100% { transform: translate3d( 1%,  -1.5%, 0) scale(1.03) rotate( 0deg); }
        }

        .dash-grid{
            position:relative;
            z-index:1;
            padding:18px;
        }

        /* Header strip inside dashboard */
        .dash-head{
            display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;
            padding:14px 14px;
            border:1px solid var(--dash-border);
            border-radius:16px;
            background: var(--dash-head-bg);
            box-shadow: var(--dash-shadow2);
            backdrop-filter: blur(10px);
            margin-bottom:14px;
            transition: all 0.3s ease;
        }
        .dash-head .left h3{margin:0;font-size:14px;font-weight:900;color:var(--dash-text)}
        .dash-head .left p{margin:6px 0 0 0;font-size:12px;font-weight:800;color:var(--dash-muted);line-height:1.55}
        .dash-head .actions{display:flex;gap:10px;flex-wrap:wrap;align-items:center}

        /* KPI grid */
        .kpi-grid{display:grid;grid-template-columns:1fr;gap:14px}
        @media(min-width:640px){ .kpi-grid{grid-template-columns:repeat(2,1fr)} }
        @media(min-width:1024px){ .kpi-grid{grid-template-columns:repeat(4,1fr)} }

        .kpi-card{
            border-radius:16px;
            border:1px solid var(--dash-border);
            background: var(--dash-card);
            padding:16px 16px;
            box-shadow: var(--dash-shadow2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .kpi-card:hover{
            transform: translateY(-1px);
            box-shadow: var(--dash-shadow);
        }

        .kpi-top{display:flex;align-items:flex-start;justify-content:space-between;gap:10px}
        .kpi-title{
            margin:0;
            font-size:12px;
            letter-spacing:.2px;
            font-weight:900;
            color:var(--dash-muted)
        }
        .kpi-value{
            margin-top:10px;
            font-size:30px;
            font-weight:900;
            color:var(--dash-text);
            letter-spacing:-.2px
        }
        .kpi-meta{margin-top:8px;font-size:12px;font-weight:800;color:var(--dash-muted)}

        .kpi-icon{
            width:38px;height:38px;border-radius:14px;
            border:1px solid var(--kpi-icon-border);
            background: var(--kpi-icon-bg);
            display:flex;align-items:center;justify-content:center;
            color:var(--dash-text);
            transition: all 0.3s ease;
        }
        .kpi-icon svg{width:18px;height:18px;opacity:.95}

        /* Panels layout */
        .dash-row{display:grid;grid-template-columns:1fr;gap:14px;margin-top:14px}
        @media(min-width:1024px){ .dash-row{grid-template-columns: 1fr 1.6fr} }

        .panel{
            border-radius:16px;
            border:1px solid var(--dash-border);
            background: var(--dash-card2);
            padding:14px;
            box-shadow: var(--dash-shadow2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .panel-head{
            display:flex;align-items:flex-start;justify-content:space-between;gap:10px;flex-wrap:wrap;
            margin-bottom:10px;
        }
        .panel-title{margin:0;font-size:14px;font-weight:900;color:var(--dash-text)}
        .panel-sub{font-size:12px;font-weight:800;color:var(--dash-muted);margin-top:4px}

        /* Tables with theme support */
        .dash-table{width:100%;border-collapse:collapse;border-radius:14px;overflow:hidden}
        .dash-table thead th{
            text-align:left;
            font-size:12px;
            font-weight:900;
            color:var(--dash-muted);
            padding:12px;
            background: var(--table-head-bg);
            border-bottom:1px solid var(--table-border);
        }
        .dash-table td{
            padding:12px;
            color:var(--dash-text);
            font-weight:800;
            border-bottom:1px solid var(--table-border);
            background: var(--table-row-bg);
            vertical-align:top;
        }
        .dash-table tbody tr:hover td{background: var(--table-row-hover)}
        .empty{
            padding:14px;
            border-radius:14px;
            border:1px dashed var(--empty-border);
            background: var(--empty-bg);
            color:var(--dash-muted);
            font-weight:800;
            line-height:1.55;
        }

        /* Pills with theme support */
        .pill{
            display:inline-flex;align-items:center;gap:8px;
            padding:7px 10px;border-radius:999px;
            border:1px solid var(--pill-border);
            background: var(--pill-bg);
            color: var(--pill-text);
            font-size:12px;font-weight:900;
        }
        .pill .dot{width:8px;height:8px;border-radius:999px;background: var(--dash-muted)}
        .pill.y .dot{background: rgba(255,223,65,.55)}
        .pill.g .dot{background: rgba(140,198,63,.50)}

        /* Buttons */
        .crm-btn.crm-btn-primary{
            background: linear-gradient(135deg, var(--brand-yellow) 0%, var(--brand-orange) 100%) !important;
            color:#0b122a !important;
            border: 1px solid rgba(255,255,255,.08) !important;
            box-shadow: 0 18px 34px rgba(227,160,0,0.18);
            font-weight:900;
        }
        .crm-btn.crm-btn-ghost{
            background: var(--pill-bg) !important;
            border:1px solid var(--pill-border) !important;
            color: var(--dash-text) !important;
            font-weight:900;
            transition: all 0.3s ease;
        }
        .crm-btn.crm-btn-ghost:hover{
            background: var(--table-row-hover) !important;
        }
    </style>

    <div class="dash-wrap">
        <div class="dash-bg" aria-hidden="true"></div>

        <div class="dash-grid">
            {{-- Page header inside dashboard --}}
            <div class="dash-head">
                <div class="left">
                    <h3>Welcome back</h3>
                    <p>Quick overview of leads, assignments, and today’s followups.</p>
                    <div style="margin-top:10px;display:flex;gap:10px;flex-wrap:wrap">
                        <span class="pill y"><span class="dot"></span>Live overview</span>
                        <span class="pill g"><span class="dot"></span>Admin area</span>
                    </div>
                </div>
                <div class="actions">
                    <a href="{{ route('crm.admin.leads.index') }}" class="crm-btn crm-btn-primary">Manage Leads</a>
                    <a href="{{ route('crm.admin.users.index') }}" class="crm-btn crm-btn-ghost">Manage Users</a>
                </div>
            </div>

            {{-- KPI Cards --}}
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <h3 class="kpi-title">Total Leads</h3>
                        <div class="kpi-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor" stroke-width="1.8"/>
                            </svg>
                        </div>
                    </div>
                    <div class="kpi-value">{{ number_format($totalLeads ?? 0) }}</div>
                    <div class="kpi-meta">Trend: —</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <h3 class="kpi-title">New Leads</h3>
                        <div class="kpi-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M12 5v14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M5 12h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="kpi-value">{{ number_format($newLeads ?? 0) }}</div>
                    <div class="kpi-meta">(last 7 days)</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <h3 class="kpi-title">Unassigned Leads</h3>
                        <div class="kpi-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M16 16l4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M20 16v4h-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M4 20v-2a4 4 0 0 1 4-4h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M12 6a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" stroke="currentColor" stroke-width="1.8"/>
                            </svg>
                        </div>
                    </div>
                    <div class="kpi-value">{{ number_format($unassigned ?? 0) }}</div>
                    <div class="kpi-meta">Need assignment</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <h3 class="kpi-title">Followups Today</h3>
                        <div class="kpi-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none">
                                <path d="M8 2v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M16 2v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M3.5 9h17" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                <path d="M5 6h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.8"/>
                                <path d="M9 14l2 2 4-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="kpi-value">{{ number_format($followupsToday ?? 0) }}</div>
                    <div class="kpi-meta">Due by end of day</div>
                </div>
            </div>

            {{-- Panels --}}
            <div class="dash-row">
                <section class="panel">
                    <div class="panel-head">
                        <div>
                            <h3 class="panel-title">Quick Links</h3>
                            <div class="panel-sub">Jump to the most used CRM sections.</div>
                        </div>
                    </div>

                    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:12px">
                        <a href="{{ route('crm.admin.leads.index') }}" class="crm-btn crm-btn-primary">Leads</a>
                        <a href="{{ route('crm.admin.users.index') }}" class="crm-btn crm-btn-ghost">Users</a>
                    </div>

                    <div class="empty">
                        Tip: Use <strong>Leads</strong> to assign users, update statuses, and manage followups.
                        Use <strong>Users</strong> to create and manage the sales team accounts.
                    </div>
                </section>

                <section class="panel">
                    <div class="panel-head">
                        <div>
                            <h3 class="panel-title">Recent Activity</h3>
                            <div class="panel-sub">Latest actions performed in the CRM.</div>
                        </div>
                    </div>

                    <div style="overflow-x:auto">
                        <table class="dash-table">
                            <thead>
                            <tr>
                                <th>Time</th>
                                <th>Actor</th>
                                <th>Action</th>
                                <th>Target</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($activities as $act)
                                <tr>
                                    <td>{{ optional($act->time)->format('Y-m-d H:i') ?? '—' }}</td>
                                    <td>{{ $act->actor ?? '—' }}</td>
                                    <td>{{ $act->action ?? '—' }}</td>
                                    <td>{{ $act->target ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4">No recent activity</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
