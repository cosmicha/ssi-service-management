
<div style="margin-bottom: 15px;">
</div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problem Log Dashboard</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, Arial, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.25), transparent 30%),
                radial-gradient(circle at top right, rgba(59, 130, 246, 0.18), transparent 30%),
                linear-gradient(180deg, #081120 0%, #0d1728 42%, #f4f7fb 42%, #f4f7fb 100%);
            color: #0f172a;
        }

        .page {
            max-width: 1450px;
            margin: 0 auto;
            padding: 16px 16px 60px;
        }

        .hero {
            color: white;
            padding: 22px 24px 24px;
            border-radius: 28px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(29, 78, 216, 0.88));
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.28);
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .hero-top {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.82);
            margin-bottom: 12px;
        }

        .brand-mark {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #60a5fa, #22d3ee);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: #081120;
            box-shadow: 0 0 20px rgba(96,165,250,0.45);
            font-size: 15px;
        }

        .hero h1 {
            margin: 0 0 8px;
            font-size: 28px;
            line-height: 1.1;
        }

        .hero p {
            margin: 0;
            color: rgba(255,255,255,0.82);
            max-width: 760px;
            font-size: 15px;
            line-height: 1.6;
        }

        .company-line {
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .company-logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid rgba(255,255,255,.22);
            background: rgba(255,255,255,.12);
        }

        .company-fallback {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: #081120;
            background: linear-gradient(135deg, #60a5fa, #22d3ee);
        }

        .company-name {
            font-size: 15px;
            font-weight: 800;
            color: rgba(255,255,255,0.92);
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 22px;
            align-items: center;
        }

        .actions .btn,
        .actions .logout-form,
        .actions .logout-btn {
            height: 56px;
        }

        .actions .btn,
        .actions .logout-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .logout-form {
            margin: 0;
            display: inline-flex;
            align-items: center;
        }

        .logout-btn {
            appearance: none;
            -webkit-appearance: none;
            border: none;
            font: inherit;
            line-height: 1;
            cursor: pointer;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.35);
        }

        .btn-secondary {
            background: rgba(255,255,255,0.10);
            color: white;
            border: 1px solid rgba(255,255,255,0.16);
        }

        .btn-ghost {
            background: #eef2ff;
            color: #1e40af;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            margin-top: 18px;
        }

        .summary-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 20px;
            padding: 16px;
            min-height: 120px;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }

        .summary-card.is-link {
            cursor: pointer;
            text-decoration: none;
            display: block;
        }

        .summary-card.is-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(2, 6, 23, 0.18);
            border-color: rgba(255,255,255,0.22);
        }

        .summary-card.is-active {
            border-color: rgba(255,255,255,0.36);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.10);
        }

        .summary-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255,255,255,0.74);
            margin-bottom: 8px;
            font-weight: 800;
        }

        .summary-value {
            font-size: 26px;
            font-weight: 900;
            color: white;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        .summary-sub {
            font-size: 13px;
            color: rgba(255,255,255,0.78);
            line-height: 1.5;
        }

        .card {
            background: rgba(255,255,255,0.94);
            border-radius: 24px;
            padding: 20px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
            margin-bottom: 18px;
        }

        .card-title {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 6px;
        }

        .muted {
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 14px;
        }

        .filter-toggle-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }

        .filter-panel {
            display: none;
        }

        .filter-panel.open {
            display: block;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 14px;
        }

        .input, .select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: white;
            font-size: 14px;
            color: #0f172a;
            outline: none;
        }

        .toolbar-chip-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 999px;
            background: #f8fbff;
            border: 1px solid #dbeafe;
            color: #1e3a8a;
            font-size: 13px;
            font-weight: 800;
        }

        .tickets-wrap {
            display: grid;
            gap: 14px;
        }

        .ticket-card {
            background: #f8fbff;
            border: 1px solid #dbeafe;
            border-radius: 22px;
            padding: 18px;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .ticket-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08);
        }

        .ticket-top {
            display: grid;
            grid-template-columns: 110px 1.2fr 1fr 160px;
            gap: 16px;
            align-items: start;
        }

        .ticket-id {
            font-size: 26px;
            font-weight: 900;
            color: #0f172a;
        }

        .ticket-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 800;
            font-size: 13px;
            text-decoration: none;
            margin-top: 8px;
        }

        .incident-title {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
            line-height: 1.35;
        }

        .incident-desc {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .meta-inline {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        .badge-open { background: #fee2e2; color: #b91c1c; }
        .badge-progress { background: #fef3c7; color: #b45309; }
        .badge-closed { background: #dcfce7; color: #15803d; }

        .badge-high { background: #fee2e2; color: #b91c1c; }
        .badge-medium { background: #dbeafe; color: #1d4ed8; }
        .badge-low { background: #e5e7eb; color: #374151; }

        .badge-sla-ok { background: #dcfce7; color: #15803d; }
        .badge-sla-breach { background: #fee2e2; color: #b91c1c; }
        .badge-sla-none { background: #e5e7eb; color: #374151; }
        .sla-timer-wrap {
            display: grid;
            gap: 10px;
            margin-top: 10px;
        }

        .sla-timer {
            padding: 12px 14px;
            border-radius: 16px;
            background: white;
            border: 1px solid #e2e8f0;
        }

        .sla-timer-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
            margin-bottom: 6px;
            font-weight: 800;
        }

        .sla-timer-value {
            font-size: 14px;
            font-weight: 900;
            line-height: 1.45;
        }

        .sla-safe .sla-timer-value {
            color: #15803d;
        }

        .sla-warning .sla-timer-value {
            color: #b45309;
        }

        .sla-breached .sla-timer-value {
            color: #b91c1c;
        }


        .ticket-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .meta-box {
            padding: 12px 14px;
            border-radius: 16px;
            background: white;
            border: 1px solid #e2e8f0;
        }

        .meta-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            margin-bottom: 6px;
            font-weight: 800;
        }

        .meta-value {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.5;
        }

        .ticket-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }

        .ticket-details {
            display: none;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #dbeafe;
        }

        .ticket-details.open {
            display: block;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1.1fr 1fr 1fr;
            gap: 12px;
        }

        .detail-box {
            padding: 14px;
            border-radius: 16px;
            background: white;
            border: 1px solid #e2e8f0;
        }

        .detail-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 800;
        }

        .detail-body {
            font-size: 14px;
            line-height: 1.65;
            color: #0f172a;
            word-break: break-word;
        }

        .detail-photo {
            width: 100%;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
        }

        .empty-state {
            padding: 28px;
            text-align: center;
            color: #64748b;
            border: 1px dashed #cbd5e1;
            border-radius: 20px;
            background: white;
        }

        @media (max-width: 1250px) {
            .summary-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .filter-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ticket-top {
                grid-template-columns: 1fr;
            }

            .ticket-actions {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {
            .summary-grid {
                grid-template-columns: 1fr 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .summary-card {
                min-height: 0;
            }

            .ticket-meta-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    @php
        $problemLogs = $problemLogs ?? $logs ?? $tickets ?? collect();
        $summaryLogs = $summaryLogs ?? $problemLogs;
        $user = auth()->user();
        $company = optional($user)->company;
        $snapshotTotal = $summaryLogs->count();
        $snapshotOpen = $summaryLogs->where('status', 'open')->count();
        $snapshotProgress = $summaryLogs->where('status', 'in_progress')->count();
        $snapshotClosed = $summaryLogs->where('status', 'closed')->count();
        $closureRate = $snapshotTotal > 0 ? round(($snapshotClosed / $snapshotTotal) * 100) : 0;
        $baseFilterQuery = request()->except('status', 'page');
        $allUrl = url('/problem-logs') . (count($baseFilterQuery) ? ('?' . http_build_query($baseFilterQuery)) : '');
        $openUrl = url('/problem-logs') . '?' . http_build_query(array_merge($baseFilterQuery, ['status' => 'open']));
        $progressUrl = url('/problem-logs') . '?' . http_build_query(array_merge($baseFilterQuery, ['status' => 'in_progress']));
        $closedUrl = url('/problem-logs') . '?' . http_build_query(array_merge($baseFilterQuery, ['status' => 'closed']));
        $exportUrl = url('/problem-logs/export') . (count(request()->query()) ? ('?' . http_build_query(request()->query())) : '');
    @endphp

    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="brand">
                        <span class="brand-mark">TS</span>
                        OPERATIONS CONSOLE
                    </div>
                    <h1>Problem Log Dashboard</h1>
                    <p>Incident tracking, lifecycle metrics, SLA filters, and operational visibility.</p>

                    @if($company)
                        <div class="company-line">
                            @if($company->logo_path)
                                <img src="{{ url('/storage/' . $company->logo_path) }}" alt="{{ $company->name }}" class="company-logo">
                            @else
                                <div class="company-fallback">{{ strtoupper(substr($company->name, 0, 2)) }}</div>
                            @endif
                            <div class="company-name">{{ $company->name }} • {{ ucfirst($user->role ?? 'user') }}</div>
                        </div>
                    @else
                        <div class="company-line">
                            <div class="company-name">No Company • {{ ucfirst($user->role ?? 'user') }}</div>
                        </div>
                    @endif

                    <div class="actions">
                    <a href="/resolution-library" class="btn btn-secondary">📚 Knowledge Base</a>
                        @if(($user->role ?? '') === 'admin')
                            <a href="/admin/users" class="btn btn-secondary">Users</a>
                        @endif

                        <a href="/problem-logs/create" class="btn btn-primary">+ Add New Log</a>

                        @if(in_array(($user->role ?? ''), ['admin', 'engineer']))
                            <a href="/sla-dashboard" class="btn btn-secondary">SLA Dashboard</a>
                        @endif

                        <a href="/analytics" class="btn btn-secondary">Analytics</a>
                        <a href="/problem-logs/export" class="btn btn-secondary">Export Excel</a>
                        <a href="/problem-logs" class="btn btn-secondary">Refresh</a>
                        <a href="/help" class="btn btn-secondary">Help</a>

                        <form method="POST" action="/logout" class="logout-form">
                            @csrf
                            <button type="submit" class="btn btn-secondary logout-btn">Logout</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="summary-grid">
                <a href="{{ $allUrl }}" class="summary-card is-link {{ request('status') ? '' : 'is-active' }}">
                    <div class="summary-label">Operational Snapshot</div>
                    <div class="summary-value">{{ $snapshotTotal }}</div>
                    <div class="summary-sub">Total incidents in current filtered view</div>
                </a>

                <a href="{{ $openUrl }}" class="summary-card is-link {{ request('status') === 'open' ? 'is-active' : '' }}">
                    <div class="summary-label">Open</div>
                    <div class="summary-value">{{ $snapshotOpen }}</div>
                    <div class="summary-sub">Need attention</div>
                </a>

                <a href="{{ $progressUrl }}" class="summary-card is-link {{ request('status') === 'in_progress' ? 'is-active' : '' }}">
                    <div class="summary-label">In Progress</div>
                    <div class="summary-value">{{ $snapshotProgress }}</div>
                    <div class="summary-sub">Currently being handled</div>
                </a>

                <a href="{{ $closedUrl }}" class="summary-card is-link {{ request('status') === 'closed' ? 'is-active' : '' }}">
                    <div class="summary-label">Closed</div>
                    <div class="summary-value">{{ $snapshotClosed }}</div>
                    <div class="summary-sub">Resolved incidents</div>
                </a>

                <a href="{{ $allUrl }}" class="summary-card is-link {{ request('status') ? '' : 'is-active' }}">
                    <div class="summary-label">Closure Rate</div>
                    <div class="summary-value">{{ $closureRate }}%</div>
                    <div class="summary-sub">Current filtered result</div>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="card" style="background:#ecfdf5;color:#166534;border-color:#bbf7d0;">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="filter-toggle-row">
                <div>
                    <div class="card-title">Filter & Search</div>
                    <div class="muted" style="margin-bottom:0;"></div>
                </div>

                <div class="toolbar-chip-row">
                    <span class="chip">Results: {{ $problemLogs->count() }}</span>
                    <button type="button" class="btn btn-ghost" id="toggleFiltersBtn">Show Filters</button>
                </div>
            </div>

            <div class="filter-panel" id="filterPanel">
                <form method="GET" action="/problem-logs">
                    <div class="filter-grid">
                        <input class="input" type="text" name="search" value="{{ request('search') }}" placeholder="Search title, description, ticket, engineer">

                        <select class="select" name="status">
                            <option value="">All Status</option>
                            <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>

                        <select class="select" name="priority">
                            <option value="">All Priority</option>
                            <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                            <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        </select>

                        <select class="select" name="company_id">
                            <option value="">All Companies</option>
                            @foreach(($companies ?? collect()) as $c)
                                <option value="{{ $c->id }}" {{ (string)request('company_id') === (string)$c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>

                        <select class="select" name="assigned_engineer_id">
                            <option value="">All Engineers</option>
                            @foreach(($engineers ?? collect()) as $eng)
                                <option value="{{ $eng->id }}" {{ (string)request('assigned_engineer_id') === (string)$eng->id ? 'selected' : '' }}>
                                    {{ $eng->name }}
                                </option>
                            @endforeach
                        </select>

                        <select class="select" name="response_sla">
                            <option value="">All Response SLA</option>
                            <option value="ok" {{ request('response_sla') === 'ok' ? 'selected' : '' }}>On Time</option>
                            <option value="breached" {{ request('response_sla') === 'breached' ? 'selected' : '' }}>Breached</option>
                        </select>

                        <select class="select" name="resolution_sla">
                            <option value="">All Resolution SLA</option>
                            <option value="ok" {{ request('resolution_sla') === 'ok' ? 'selected' : '' }}>On Time</option>
                            <option value="breached" {{ request('resolution_sla') === 'breached' ? 'selected' : '' }}>Breached</option>
                        </select>

                        <input class="input" type="date" name="date_from" value="{{ request('date_from') }}">
                        <input class="input" type="date" name="date_to" value="{{ request('date_to') }}">
                    </div>

                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                        <a href="{{ $allUrl }}" class="btn btn-ghost">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        
        
        <div class="card">
            <div style="display:flex; justify-content:space-between; gap:12px; align-items:center; flex-wrap:wrap; margin-bottom:12px;">
                <div class="card-title">Incident Tickets</div>
                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="/resolution-library" class="btn btn-ghost">Knowledge Base</a>
                </div>
            </div>
            <div class="muted">Compact one-line list. Click a row to open full detail.</div>

            <div style="display:flex; justify-content:flex-end; margin-bottom:12px;">
                
            </div>
            
            <form method="POST" action="{{ route('problem-logs.bulk-action') }}" style="margin-bottom:16px;">
                @csrf
                <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                    <select name="action" class="select" style="max-width:220px;">
                        <option value="">Bulk Action</option>
                        <option value="assign">Assign Engineer</option>
                        <option value="acknowledge">Acknowledge</option>
                        <option value="delete">Delete</option>
                    </select>

                    <select name="assigned_engineer_id" class="select" style="max-width:240px;">
                        <option value="">Select engineer (for assign)</option>
                        @foreach($engineers ?? [] as $engineer)
                            <option value="{{ $engineer->id }}">{{ $engineer->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">Apply</button>
                </div>

                <div style="overflow-x:auto; margin-top:16px;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="text-align:left; padding:10px;"><input type="checkbox" id="selectAllTickets"></th>
                                <th style="text-align:left; padding:10px;">Ticket</th>
                                <th style="text-align:left; padding:10px;">Problem</th>
                                <th style="text-align:left; padding:10px;">Current Process</th>
                                <th style="text-align:left; padding:10px;">Resolution</th>
                                <th style="text-align:left; padding:10px;">Response SLA</th>
                                <th style="text-align:left; padding:10px;">Resolution SLA</th>
                                <th style="text-align:left; padding:10px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($problemLogs as $log)
                                @php
                                    $status = $log->status ?? 'open';
                                    $responseSla = method_exists($log, 'responseSlaStatus') ? $log->responseSlaStatus() : null;
                                    $resolutionSla = method_exists($log, 'resolutionSlaStatus') ? $log->resolutionSlaStatus() : null;
                                @endphp
                                <tr class="ticketRowClickable" data-href="/problem-logs/{{ $log->id }}" style="border-top:1px solid #e5e7eb; cursor:pointer;">
                                    <td style="padding:10px;">
                                        <input type="checkbox" name="ids[]" value="{{ $log->id }}" class="ticketCheckbox" onclick="event.stopPropagation();">
                                    </td>
                                    <td style="padding:10px; font-weight:700;">
                                        {{ $log->ticket_number ?: ('TICKET-' . $log->id) }}
                                    </td>
                                    <td style="padding:10px;">
                                        <div style="font-weight:700;">{{ $log->dashboardProblemSummary() }}</div>
                                        @if($status === 'closed')
                                            <div style="font-size:12px; color:#64748b; margin-top:4px;">
                                                Closed summary: {{ $log->dashboardProblemSummary() }} → {{ $log->dashboardResolutionSummary() }}
                                            </div>
                                        @endif
                                    </td>
                                    <td style="padding:10px;">{{ $log->dashboardCurrentProcess() }}</td>
                                    <td style="padding:10px;">{{ $log->dashboardResolutionSummary() }}</td>
                                    <td style="padding:10px;">
                                        @if($responseSla === 'breached')
                                            <span class="badge badge-sla-breach">Breach</span>
                                        @elseif($responseSla === 'ok')
                                            <span class="badge badge-sla-ok">OK</span>
                                        @else
                                            <span class="badge badge-sla-none">N/A</span>
                                        @endif
                                    </td>
                                    <td style="padding:10px;">
                                        @if($resolutionSla === 'breached')
                                            <span class="badge badge-sla-breach">Breach</span>
                                        @elseif($resolutionSla === 'ok')
                                            <span class="badge badge-sla-ok">OK</span>
                                        @else
                                            <span class="badge badge-sla-none">N/A</span>
                                        @endif
                                    </td>
                                    <td style="padding:10px;">
                                        @if($status === 'open')
                                            <span class="badge badge-open">Open</span>
                                        @elseif($status === 'in_progress')
                                            <span class="badge badge-progress">In Progress</span>
                                        @else
                                            <span class="badge badge-closed">Closed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" style="padding:16px;">No tickets found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>


    </div>

    <script>
        const toggleBtn = document.getElementById('toggleFiltersBtn');
        const panel = document.getElementById('filterPanel');

        toggleBtn.addEventListener('click', () => {
            const isOpen = panel.classList.contains('open');
            panel.classList.toggle('open');
            toggleBtn.textContent = isOpen ? 'Show Filters' : 'Hide Filters';
        });

        function formatMinutes(totalMinutes) {
            const abs = Math.abs(totalMinutes);
            const h = Math.floor(abs / 60);
            const m = abs % 60;
            return h > 0 ? `${h}h ${m}m` : `${m}m`;
        }

        function applySlaCountdown() {
            const nowTs = Math.floor(Date.now() / 1000);

            document.querySelectorAll('.sla-timer').forEach(el => {
                const createdAt = parseInt(el.dataset.createdAt || '0', 10);
                const endedAt = parseInt(el.dataset.endedAt || '0', 10);
                const limitMinutes = parseInt(el.dataset.limitMinutes || '0', 10);
                const valueEl = el.querySelector('.sla-timer-value');

                el.classList.remove('sla-safe', 'sla-warning', 'sla-breached');

                if (!createdAt || !limitMinutes) {
                    valueEl.textContent = 'N/A';
                    return;
                }

                const effectiveEnd = endedAt || nowTs;
                const elapsedMinutes = Math.max(0, Math.floor((effectiveEnd - createdAt) / 60));
                const remaining = limitMinutes - elapsedMinutes;

                if (remaining < 0) {
                    el.classList.add('sla-breached');
                    valueEl.textContent = `Breached by ${formatMinutes(remaining)}`;
                } else if (remaining <= Math.max(30, Math.floor(limitMinutes * 0.2))) {
                    el.classList.add('sla-warning');
                    valueEl.textContent = `${formatMinutes(remaining)} remaining`;
                } else {
                    el.classList.add('sla-safe');
                    valueEl.textContent = `${formatMinutes(remaining)} remaining`;
                }

                if (endedAt) {
                    if (remaining < 0) {
                        valueEl.textContent += ' at stop time';
                    } else {
                        valueEl.textContent += ' when stopped';
                    }
                }
            });
        }

        applySlaCountdown();
        setInterval(applySlaCountdown, 60000);

        document.querySelectorAll('.detailToggleBtn').forEach(btn => {
            btn.addEventListener('click', () => {
                const details = btn.closest('.ticket-card').querySelector('.ticket-details');
                const isOpen = details.classList.contains('open');
                details.classList.toggle('open');
                btn.textContent = isOpen ? 'Details' : 'Hide Details';
            });
        });

        document.querySelectorAll('.ticketRowClickable').forEach(row => {
            row.addEventListener('click', (e) => {
                if (e.target.closest('input, button, select, a, label')) return;
                window.location = row.dataset.href;
            });
        });

        const selectAll = document.getElementById('selectAllTickets');
        if (selectAll) {
            selectAll.addEventListener('change', () => {
                document.querySelectorAll('.ticketCheckbox').forEach(cb => {
                    cb.checked = selectAll.checked;
                });
            });
        }

    </script>
</body>
</html>
