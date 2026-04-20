<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ticket Monitoring Dashboard</title>
<style>
    :root{
        --bg:#05101f;
        --bg2:#09172e;
        --panel:rgba(255,255,255,.06);
        --panel-2:rgba(255,255,255,.08);
        --stroke:rgba(255,255,255,.10);
        --text:#f8fbff;
        --muted:#9fb0cf;
        --blue:#4f7cff;
        --blue2:#2563eb;
        --violet:#7c3aed;
        --green:#16a34a;
        --amber:#d97706;
        --shadow:0 18px 40px rgba(0,0,0,.28);
    }

    *{ box-sizing:border-box; }

    body{
        margin:0;
        font-family:Inter, Arial, sans-serif;
        color:var(--text);
        background:
            radial-gradient(circle at top right, rgba(59,130,246,.18), transparent 28%),
            radial-gradient(circle at bottom left, rgba(34,197,94,.10), transparent 22%),
            linear-gradient(135deg, #030915 0%, #071224 45%, #0a1730 100%);
        min-height:100vh;
    }

    .app{
        display:flex;
        min-height:100vh;
    }

    .sidebar{
        width:270px;
        padding:22px 18px;
        background:linear-gradient(180deg, rgba(2,6,23,.88), rgba(6,17,35,.95));
        border-right:1px solid rgba(255,255,255,.06);
        backdrop-filter: blur(10px);
    }

    .brand{
        display:flex;
        align-items:center;
        gap:14px;
        margin-bottom:26px;
    }

    .brand-badge{
        width:48px;
        height:48px;
        border-radius:16px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:900;
        font-size:20px;
        color:#071224;
        background:linear-gradient(135deg,#7dd3fc,#38bdf8);
        box-shadow:0 10px 24px rgba(56,189,248,.28);
        flex:0 0 auto;
    }

    .brand-text{
        font-size:14px;
        line-height:1.2;
        letter-spacing:.12em;
        text-transform:uppercase;
        color:rgba(255,255,255,.84);
        font-weight:800;
    }

    .nav{
        display:flex;
        flex-direction:column;
        gap:10px;
    }

    .nav a{
        text-decoration:none;
        color:#dbe7ff;
        padding:14px 16px;
        border-radius:16px;
        font-weight:700;
        font-size:15px;
        transition:.18s ease;
        border:1px solid transparent;
        display:block;
    }

    .nav a.active{
        background:rgba(255,255,255,.10);
        border-color:rgba(255,255,255,.08);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.08);
    }

    .nav a:hover{
        background:rgba(255,255,255,.06);
    }

    .nav-group{
        margin-top:12px;
        border:1px solid rgba(255,255,255,.08);
        background:rgba(255,255,255,.03);
        border-radius:18px;
        overflow:hidden;
    }

    .nav-group-toggle{
        width:100%;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        background:transparent;
        border:none;
        color:#f3f7ff;
        padding:14px 16px;
        font-size:15px;
        font-weight:800;
        cursor:pointer;
    }

    .nav-group-toggle:hover{
        background:rgba(255,255,255,.04);
    }

    .nav-arrow{
        font-size:16px;
        color:#b8c7e6;
        transition:transform .18s ease;
    }

    .nav-group.is-open .nav-arrow{
        transform:rotate(180deg);
    }

    .nav-submenu{
        display:flex;
        flex-direction:column;
        gap:8px;
        padding:0 10px 12px;
    }

    .nav-group:not(.is-open) .nav-submenu{
        display:none;
    }

    .nav-submenu a{
        padding:12px 14px;
        border-radius:14px;
        font-size:14px;
        background:rgba(255,255,255,.02);
    }

    .sidebar-status{
        margin-top:16px;
        display:flex;
        align-items:flex-start;
        gap:10px;
        padding:14px 16px;
        border-radius:18px;
        border:1px solid rgba(255,255,255,.08);
        background:rgba(255,255,255,.03);
    }

    .sidebar-status-dot{
        width:10px;
        height:10px;
        border-radius:999px;
        background:#22c55e;
        margin-top:6px;
        box-shadow:0 0 12px rgba(34,197,94,.45);
        flex:0 0 auto;
    }

    .sidebar-status-title{
        font-size:13px;
        font-weight:800;
        margin-bottom:3px;
    }

    .sidebar-status-sub{
        font-size:12px;
        color:#98a7c4;
    }

    .main{
        flex:1;
        padding:26px;
    }

    .hero{
        border-radius:30px;
        padding:28px 30px 24px;
        background:
            radial-gradient(circle at right top, rgba(79,124,255,.18), transparent 32%),
            linear-gradient(135deg, rgba(12,25,58,.92), rgba(20,42,114,.84));
        border:1px solid rgba(255,255,255,.10);
        box-shadow:var(--shadow);
        margin-bottom:22px;
    }

    .hero-top{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:18px;
        flex-wrap:wrap;
    }

    .support-chip{
        display:inline-flex;
        align-items:center;
        gap:10px;
        padding:10px 16px;
        border-radius:999px;
        background:rgba(255,255,255,.07);
        border:1px solid rgba(255,255,255,.10);
        color:#eaf1ff;
        font-size:13px;
        font-weight:800;
        margin-bottom:14px;
    }

    .hero h1{
        margin:0;
        font-size:58px;
        line-height:1.02;
        letter-spacing:-0.04em;
        font-weight:900;
    }

    .hero h1 .accent{
        background:linear-gradient(135deg,#7dd3fc,#60a5fa,#8b5cf6);
        -webkit-background-clip:text;
        background-clip:text;
        color:transparent;
    }

    .hero-subtitle{
        margin:16px 0 0;
        color:#d7e1f5;
        font-size:17px;
        max-width:820px;
    }

    .identity-row{
        margin-top:18px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:16px;
        flex-wrap:wrap;
    }

    .identity-left{
        display:flex;
        align-items:center;
        gap:14px;
        flex-wrap:wrap;
    }

    .identity-pill{
        display:inline-flex;
        align-items:center;
        gap:10px;
        padding:10px 16px;
        border-radius:999px;
        background:rgba(255,255,255,.07);
        border:1px solid rgba(255,255,255,.10);
        font-size:14px;
        font-weight:800;
        color:#f4f8ff;
    }

    .company-logo-slot{
        width:56px;
        height:56px;
        border-radius:18px;
        border:1px dashed rgba(255,255,255,.18);
        background:rgba(255,255,255,.04);
        display:flex;
        align-items:center;
        justify-content:center;
        color:#9eb0d4;
        font-size:11px;
        font-weight:800;
        text-align:center;
        padding:6px;
    }

    .updated-pill{
        display:inline-flex;
        align-items:center;
        gap:10px;
        padding:10px 16px;
        border-radius:999px;
        background:rgba(255,255,255,.06);
        border:1px solid rgba(255,255,255,.09);
        color:#dbe8ff;
        font-size:13px;
        font-weight:800;
    }

    .top-actions{
        margin-top:24px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:18px;
        flex-wrap:wrap;
    }

    .action-left, .action-right{
        display:flex;
        align-items:center;
        gap:12px;
        flex-wrap:wrap;
    }

    .btn{
        text-decoration:none;
        padding:14px 18px;
        border-radius:18px;
        font-weight:800;
        font-size:14px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        color:white;
        border:1px solid rgba(255,255,255,.12);
        min-height:52px;
        box-shadow:0 10px 18px rgba(0,0,0,.18);
        transition:.18s ease;
    }

    .btn.primary{
        background:linear-gradient(135deg,#3b82f6,#8b5cf6);
    }

    .btn.ghost{
        background:rgba(255,255,255,.06);
    }

    .btn:hover{
        transform:translateY(-1px);
    }

    .search-input{
        background:rgba(255,255,255,.06);
        border:1px solid rgba(255,255,255,.12);
        padding:13px 16px;
        border-radius:16px;
        color:white;
        min-width:250px;
        outline:none;
        font-size:14px;
    }

    .search-input::placeholder{
        color:#94a3b8;
    }

    .filter-btn{
        width:48px;
        height:48px;
        border-radius:14px;
        background:rgba(255,255,255,.08);
        border:1px solid rgba(255,255,255,.10);
        display:flex;
        align-items:center;
        justify-content:center;
        color:#e2ebff;
        font-weight:900;
    }

    .metrics{
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:18px;
        margin-bottom:22px;
    }

    .metric-card{
        position:relative;
        overflow:hidden;
        border-radius:24px;
        padding:22px 24px;
        min-height:152px;
        border:1px solid rgba(255,255,255,.12);
        box-shadow:var(--shadow);
    }

    .metric-card::after{
        content:'';
        position:absolute;
        inset:auto -10% -30% -10%;
        height:90px;
        background:radial-gradient(circle at center, rgba(255,255,255,.15), transparent 65%);
        pointer-events:none;
    }

    .metric-blue{
        background:linear-gradient(135deg, rgba(26,38,120,.9), rgba(37,99,235,.76));
    }

    .metric-cyan{
        background:linear-gradient(135deg, rgba(8,55,120,.92), rgba(14,165,233,.72));
    }

    .metric-violet{
        background:linear-gradient(135deg, rgba(76,29,149,.92), rgba(236,72,153,.46));
    }

    .metric-green{
        background:linear-gradient(135deg, rgba(5,80,80,.95), rgba(34,197,94,.46));
    }

    .metric-label{
        font-size:13px;
        text-transform:uppercase;
        letter-spacing:.12em;
        color:#d3ddf6;
        font-weight:900;
        margin-bottom:16px;
    }

    .metric-value{
        font-size:56px;
        line-height:1;
        font-weight:900;
        margin-bottom:10px;
    }

    .metric-sub{
        font-size:15px;
        color:#edf4ff;
    }

    .table-wrap{
        border-radius:28px;
        background:linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,.05));
        border:1px solid rgba(255,255,255,.09);
        box-shadow:var(--shadow);
        padding:22px;
    }

    .table-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:16px;
        flex-wrap:wrap;
        margin-bottom:16px;
    }

    .table-title-group{
        display:flex;
        align-items:center;
        gap:12px;
        flex-wrap:wrap;
    }

    .table-title{
        margin:0;
        font-size:22px;
        font-weight:900;
        letter-spacing:-0.02em;
    }

    .latest-chip{
        display:inline-flex;
        align-items:center;
        padding:7px 12px;
        border-radius:999px;
        font-size:13px;
        font-weight:800;
        background:rgba(255,255,255,.06);
        border:1px solid rgba(255,255,255,.10);
        color:#d6e3ff;
    }

    .table-tools{
        display:flex;
        align-items:center;
        gap:10px;
        flex-wrap:wrap;
    }

    .tool-select{
        background:rgba(255,255,255,.06);
        border:1px solid rgba(255,255,255,.12);
        color:#eef5ff;
        padding:12px 14px;
        border-radius:14px;
        min-width:150px;
    }

    .table-scroll{
        overflow:auto;
    }

    table{
        width:100%;
        border-collapse:collapse;
        min-width:980px;
    }

    th{
        text-align:left;
        padding:14px 16px;
        color:#aebdd8;
        font-size:13px;
        font-weight:800;
        letter-spacing:.04em;
        border-bottom:1px solid rgba(255,255,255,.08);
    }

    td{
        padding:18px 16px;
        border-bottom:1px solid rgba(255,255,255,.06);
        vertical-align:middle;
        font-size:15px;
        color:#f8fafc;
    }

    tr.clickable{
        cursor:pointer;
        transition:background .18s ease;
    }

    tr.clickable:hover{
        background:rgba(255,255,255,.05);
    }

    .ticket-id{
        font-weight:800;
        letter-spacing:.02em;
        color:#f8fbff;
        white-space:nowrap;
    }

    .title{
        font-weight:800;
        font-size:16px;
        line-height:1.35;
        max-width:260px;
    }

    .desc{
        color:#d7e1f5;
        line-height:1.45;
        max-width:430px;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    .time{
        color:#dbe7ff;
        font-size:14px;
        line-height:1.45;
        white-space:nowrap;
    }

    .status-pill{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-width:124px;
        padding:8px 14px;
        border-radius:999px;
        font-size:13px;
        font-weight:900;
        color:white;
        white-space:nowrap;
        text-transform:capitalize;
        box-shadow:0 10px 18px rgba(0,0,0,.18);
    }

    .status-open{ background:linear-gradient(135deg,#2563eb,#1d4ed8); }
    .status-progress{ background:linear-gradient(135deg,#b45309,#f59e0b); }
    .status-closed{ background:linear-gradient(135deg,#15803d,#22c55e); }

    .pagination-wrap{
        margin-top:18px;
    }

    @media (max-width: 1280px){
        .metrics{
            grid-template-columns:repeat(2,minmax(0,1fr));
        }
        .hero h1{
            font-size:48px;
        }
    }

    @media (max-width: 900px){
        .app{ flex-direction:column; }
        .sidebar{
            width:100%;
            border-right:none;
            border-bottom:1px solid rgba(255,255,255,.06);
        }
        .metrics{
            grid-template-columns:1fr;
        }
        .main{
            padding:18px;
        }
        .hero{
            padding:22px;
        }
        .hero h1{
            font-size:36px;
        }
    }
</style>
</head>
<body>

@php
    $open = \App\Models\ProblemLog::where('status','open')->count();
    $progress = \App\Models\ProblemLog::where('status','in_progress')->count();
    $closed = \App\Models\ProblemLog::where('status','closed')->count();
    $total = \App\Models\ProblemLog::count();
    $problemLogs = $problemLogs ?? \App\Models\ProblemLog::latest()->paginate(15);

    $isCustomer = (auth()->user()->role ?? null) === 'customer';
    $companyName = optional(auth()->user()->company)->name ?? 'No Company';
    $identityLabel = $isCustomer ? $companyName : 'Administrator';

    $lastUpdated = optional(
        \App\Models\ProblemLog::latest('updated_at')->first()
    )->updated_at;
@endphp

<div class="app">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-badge">TS</div>
            <div class="brand-text">Operations<br>Console</div>
        </div>

        <nav class="nav">
            <a href="/problem-logs" class="active">Dashboard</a>
            <a href="/problem-logs">Tickets</a>
            <a href="/resolution-library">Knowledge Base</a>
            <a href="/sla-dashboard">SLA Dashboard</a>
            <a href="/help">Help</a>

            <div class="nav-group is-open" data-group>
                <button type="button" class="nav-group-toggle" data-toggle>
                    <span>Settings</span>
                    <span class="nav-arrow">⌄</span>
                </button>
                <div class="nav-submenu">
                    <a href="/admin/users">User Management</a>
                    <a href="/admin/companies/settings">Company</a>
                    <a href="/devices">Devices</a>
                    <a href="/vendors">Vendors</a>
                </div>
            </div>

            <div class="nav-group is-open" data-group>
                <button type="button" class="nav-group-toggle" data-toggle>
                    <span>Report</span>
                    <span class="nav-arrow">⌄</span>
                </button>
                <div class="nav-submenu">
                    <a href="/problem-logs/export">Report</a>
                    <a href="/analytics">Analytics</a>
                </div>
            </div>

            <div class="sidebar-status">
                <div class="sidebar-status-dot"></div>
                <div>
                    <div class="sidebar-status-title">All systems operational</div>
                    <div class="sidebar-status-sub">Last sync {{ $lastUpdated ? $lastUpdated->format('d M Y, H.i') : '—' }}</div>
                </div>
            </div>
        </nav>
    </aside>

    <main class="main">
        <section class="hero">
            <div class="hero-top">
                <div>
                    <div class="support-chip">Support Centre</div>
                    <h1>Ticket Monitoring <span class="accent">Dashboard</span></h1>
                    <div class="hero-subtitle">Incident tracking, lifecycle metrics, SLA filters, and operational visibility.</div>
                </div>

                <div class="updated-pill">
                    Last updated: {{ $lastUpdated ? $lastUpdated->format('d M Y, H.i') : '—' }}
                </div>
            </div>

            <div class="identity-row">
                <div class="identity-left">
                    <div class="company-logo-slot">Logo</div>
                    <div class="identity-pill">{{ $identityLabel }}</div>
                </div>
            </div>

            <div class="top-actions">
                <div class="action-left">
                    <a href="/resolution-library" class="btn ghost">📚 Knowledge Base</a>

                    @if((auth()->user()->role ?? null) !== 'customer')
                        <a href="/admin/users" class="btn ghost">Users</a>
                    @endif

                    <a href="/problem-logs/create" class="btn primary">+ Add New Ticket</a>
                    <a href="/sla-dashboard" class="btn ghost">SLA Dashboard</a>
                    <a href="/analytics" class="btn ghost">Analytics</a>
                    <a href="/problem-logs/export" class="btn ghost">Export Excel</a>
                    <a href="/problem-logs" class="btn ghost">Refresh</a>
                </div>

                <div class="action-right">
                    <input type="text" placeholder="Search tickets..." class="search-input">
                    <div class="filter-btn">⌕</div>
                </div>
            </div>
        </section>

        <section class="metrics">
            <div class="metric-card metric-blue">
                <div class="metric-label">Operational Snapshot</div>
                <div class="metric-value">{{ $total }}</div>
                <div class="metric-sub">Total tickets</div>
            </div>

            <div class="metric-card metric-cyan">
                <div class="metric-label">Open</div>
                <div class="metric-value">{{ $open }}</div>
                <div class="metric-sub">Need attention</div>
            </div>

            <div class="metric-card metric-violet">
                <div class="metric-label">In Progress</div>
                <div class="metric-value">{{ $progress }}</div>
                <div class="metric-sub">Currently being handled</div>
            </div>

            <div class="metric-card metric-green">
                <div class="metric-label">Closed</div>
                <div class="metric-value">{{ $closed }}</div>
                <div class="metric-sub">Resolved tickets</div>
            </div>
        </section>

        <section class="table-wrap">
            <div class="table-header">
                <div class="table-title-group">
                    <h2 class="table-title">Your Tickets</h2>
                    <div class="latest-chip">{{ method_exists($problemLogs, 'total') ? $problemLogs->total() : $problemLogs->count() }} latest</div>
                </div>

                <div class="table-tools">
                    <input type="text" placeholder="Search tickets..." class="search-input">
                    <select class="tool-select">
                        <option>Latest First</option>
                    </select>
                    <div class="filter-btn">☰</div>
                </div>
            </div>

            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Status</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($problemLogs as $t)
                            @php
                                $status = $t->status ?? 'open';
                                $statusClass = $status === 'closed'
                                    ? 'status-closed'
                                    : ($status === 'in_progress' ? 'status-progress' : 'status-open');
                            @endphp

                            <tr class="clickable" onclick="window.location='/problem-logs/{{ $t->id }}'">
                                <td class="ticket-id">{{ $t->ticket_number ?? $t->id }}</td>
                                <td>
                                    <span class="status-pill {{ $statusClass }}">
                                        {{ $status === 'in_progress' ? 'In Progress' : ucfirst(str_replace('_', ' ', $status)) }}
                                    </span>
                                </td>
                                <td class="title">{{ $t->title }}</td>
                                <td class="desc">{{ $t->description }}</td>
                                <td class="time">{{ optional($t->created_at)->format('d M Y') }}<br>{{ optional($t->created_at)->format('H.i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="color:#b6c3db;">No tickets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($problemLogs, 'links'))
                <div class="pagination-wrap">
                    {{ $problemLogs->links() }}
                </div>
            @endif
        </section>
    </main>
</div>

<script>
document.querySelectorAll('[data-toggle]').forEach(function(btn){
    btn.addEventListener('click', function(){
        var group = btn.closest('[data-group]');
        if (group) group.classList.toggle('is-open');
    });
});
</script>
</body>
</html>
