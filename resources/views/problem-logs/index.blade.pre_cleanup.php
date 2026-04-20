<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Problem Log Dashboard</title>
<style>
    :root{
        --bg:#071224;
        --bg-2:#0b1730;
        --panel:rgba(255,255,255,0.06);
        --panel-strong:rgba(255,255,255,0.09);
        --stroke:rgba(255,255,255,0.10);
        --text:#f8fafc;
        --muted:#94a3b8;
        --blue:#4f7cff;
        --blue-2:#2c5bff;
        --green:#22c55e;
        --amber:#f59e0b;
        --shadow:0 20px 40px rgba(0,0,0,.22);
    }

    * { box-sizing:border-box; }

    body{
        margin:0;
        font-family:Inter, Arial, sans-serif;
        color:var(--text);
        background:
            radial-gradient(circle at top right, rgba(79,124,255,.22), transparent 32%),
            radial-gradient(circle at bottom left, rgba(37,99,235,.14), transparent 26%),
            linear-gradient(135deg, #06101f 0%, #09152b 45%, #0b1a36 100%);
        min-height:100vh;
    }

    .app{
        display:flex;
        min-height:100vh;
    }

    .sidebar{
        width:260px;
        padding:26px 18px;
        background:linear-gradient(180deg, rgba(2,6,23,.88), rgba(7,18,36,.92));
        border-right:1px solid rgba(255,255,255,.06);
        backdrop-filter: blur(10px);
    }

    .brand{
        display:flex;
        align-items:center;
        gap:12px;
        margin-bottom:28px;
    }

    .brand-badge{
        width:42px;
        height:42px;
        border-radius:14px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:800;
        font-size:18px;
        color:#071224;
        background:linear-gradient(135deg, #7dd3fc, #38bdf8);
        box-shadow:0 12px 24px rgba(56,189,248,.22);
    }

    .brand-text{
        font-size:14px;
        letter-spacing:.12em;
        text-transform:uppercase;
        color:rgba(255,255,255,.78);
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
        margin-top:14px;
        border:1px solid rgba(255,255,255,.08);
        background:rgba(255,255,255,.03);
        border-radius:18px;
        overflow:hidden;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.03);
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
        line-height:1;
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
        text-decoration:none;
        color:#dbe7ff;
        padding:12px 14px;
        border-radius:14px;
        font-weight:700;
        font-size:14px;
        transition:.18s ease;
        border:1px solid transparent;
        background:rgba(255,255,255,.02);
    }

    .nav-submenu a:hover{
        background:rgba(255,255,255,.07);
        border-color:rgba(255,255,255,.06);
    }

    .sidebar-status{
        margin-top:18px;
        display:flex;
        align-items:flex-start;
        gap:10px;
        padding:14px 16px;
        border-radius:18px;
        border:1px solid rgba(255,255,255,.08);
        background:rgba(255,255,255,.03);
        color:#dff7e8;
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
        color:#eafbf0;
        margin-bottom:3px;
    }

    .sidebar-status-sub{
        font-size:12px;
        color:#98a7c4;
    }



    .main{
        flex:1;
        padding:28px;
    }

    .hero{
        padding:30px 34px;
        border-radius:28px;
        background:
            radial-gradient(circle at top left, rgba(79,124,255,.22), transparent 25%),
            linear-gradient(135deg, rgba(12,25,58,.92), rgba(20,42,114,.84));
        border:1px solid rgba(255,255,255,.10);
        box-shadow:var(--shadow);
        margin-bottom:22px;
    }

    .hero-top{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:20px;
        flex-wrap:wrap;
    }

    .eyebrow{
        display:flex;
        align-items:center;
        gap:12px;
        font-size:14px;
        letter-spacing:.12em;
        text-transform:uppercase;
        color:rgba(255,255,255,.70);
        font-weight:800;
        margin-bottom:14px;
    }

    .hero h1{
        margin:0;
        font-size:54px;
        line-height:1.02;
        letter-spacing:-0.03em;
        font-weight:900;
    }

    .hero p{
        margin:14px 0 0;
        color:#d7e1f5;
        font-size:17px;
        max-width:820px;
    }

    .hero-meta{
        margin-top:18px;
        font-size:16px;
        color:rgba(255,255,255,.86);
        font-weight:700;
    }

    .btn-row{
        display:flex;
        gap:12px;
        flex-wrap:wrap;
        margin-top:26px;
    }

    .btn{
        text-decoration:none;
        padding:14px 18px;
        border-radius:18px;
        font-weight:800;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border:1px solid rgba(255,255,255,.12);
        color:white;
        min-height:54px;
        transition:.18s ease;
        box-shadow:0 10px 18px rgba(0,0,0,.18);
    }

    .btn.primary{
        background:linear-gradient(135deg, #3b82f6, #5b7cff);
        border-color:rgba(255,255,255,.14);
    }

    .btn.secondary{
        background:rgba(255,255,255,.08);
        color:#f8fbff;
        backdrop-filter: blur(8px);
    }

    .btn:hover{
        transform:translateY(-1px);
    }

    .metrics{
        display:grid;
        grid-template-columns:1.2fr 1fr 1fr;
        gap:18px;
        margin-bottom:22px;
    }

    .metric-card{
        border-radius:24px;
        padding:22px 24px;
        background:linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,.05));
        border:1px solid rgba(255,255,255,.09);
        box-shadow:var(--shadow);
        min-height:138px;
    }

    .metric-label{
        font-size:13px;
        text-transform:uppercase;
        letter-spacing:.12em;
        color:#b9c7e3;
        font-weight:800;
        margin-bottom:14px;
    }

    .metric-value{
        font-size:50px;
        line-height:1;
        font-weight:900;
        margin-bottom:10px;
    }

    .metric-sub{
        color:#d6e0f4;
        font-size:15px;
    }

    .table-wrap{
        border-radius:28px;
        background:linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,.05));
        border:1px solid rgba(255,255,255,.09);
        box-shadow:var(--shadow);
        padding:22px;
    }

    .table-title{
        font-size:22px;
        font-weight:900;
        margin:0 0 18px;
        letter-spacing:-0.02em;
    }

    .table-scroll{
        overflow:auto;
    }

    table{
        width:100%;
        border-collapse:collapse;
        min-width:900px;
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
    }

    .title{
        font-weight:800;
        font-size:16px;
        line-height:1.3;
    }

    .desc{
        color:#d7e1f5;
        line-height:1.4;
        max-width:480px;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    .time{
        color:#c6d2ea;
        font-size:14px;
        line-height:1.35;
    }

    .status-pill{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-width:118px;
        padding:8px 14px;
        border-radius:999px;
        font-size:13px;
        font-weight:900;
        color:white;
        white-space:nowrap;
        text-transform:capitalize;
        box-shadow:0 10px 18px rgba(0,0,0,.18);
    }

    .status-open{ background:linear-gradient(135deg, #3b82f6, #2563eb); }
    .status-progress{ background:linear-gradient(135deg, #f59e0b, #f59e0b); }
    .status-closed{ background:linear-gradient(135deg, #22c55e, #16a34a); }

    .pagination-wrap{
        margin-top:18px;
    }

    @media (max-width: 1200px){
        .metrics{
            grid-template-columns:1fr 1fr;
        }
        .hero h1{
            font-size:42px;
        }
    }

    @media (max-width: 860px){
        .app{
            flex-direction:column;
        }
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
            font-size:34px;
        }
    }


/* TOP ACTIONS */
.top-actions{
    margin-top:24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    flex-wrap:wrap;
}

.action-left{
    display:flex;
    gap:12px;
}

.action-right{
    display:flex;
    gap:12px;
    align-items:center;
}

.search-input{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.12);
    padding:12px 16px;
    border-radius:14px;
    color:white;
    min-width:220px;
    outline:none;
}

.search-input::placeholder{
    color:#94a3b8;
}

.filter-btn{
    width:44px;
    height:44px;
    border-radius:12px;
    background:rgba(255,255,255,.08);
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    border:1px solid rgba(255,255,255,.1);
}

/* BUTTON STYLE UPGRADE */
.btn.ghost{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
}

.btn.primary{
    background:linear-gradient(135deg,#3b82f6,#6366f1);
}

/* TABLE POLISH */
.table-wrap{
    margin-top:20px;
}

.table-title{
    margin-bottom:14px;
}

table th{
    font-size:12px;
    letter-spacing:.08em;
}

tr.clickable{
    border-radius:12px;
}

tr.clickable:hover{
    background:rgba(255,255,255,.04);
    transform:scale(1.002);
}

/* STATUS FIX */
.status-pill{
    min-width:120px;
    justify-content:center;
    text-align:center;
}

/* ROW LEFT BORDER GLOW */
tr.clickable td:first-child{
    position:relative;
}

tr.clickable td:first-child:before{
    content:'';
    position:absolute;
    left:0;
    top:20%;
    bottom:20%;
    width:3px;
    border-radius:3px;
    background:linear-gradient(180deg,#3b82f6,#6366f1);
    opacity:.6;
}



.top-actions{
    margin-top:24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    flex-wrap:wrap;
}

.action-left, .action-right{
    display:flex;
    gap:12px;
    align-items:center;
    flex-wrap:wrap;
}

/* BUTTON */
.btn{
    padding:12px 16px;
    border-radius:16px;
    font-weight:700;
    font-size:14px;
    text-decoration:none;
    display:flex;
    align-items:center;
    gap:6px;
}

.btn.primary{
    background:linear-gradient(135deg,#3b82f6,#6366f1);
    color:white;
    box-shadow:0 8px 18px rgba(99,102,241,.4);
}

.btn.ghost{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
    color:#e5edff;
}

/* SEARCH */
.search-input{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.12);
    padding:12px 16px;
    border-radius:14px;
    color:white;
    min-width:220px;
}

.filter-btn{
    width:44px;
    height:44px;
    border-radius:12px;
    background:rgba(255,255,255,.08);
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    border:1px solid rgba(255,255,255,.1);
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
@endphp

<div class="app">
    
    
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-badge">TS</div>
            <div class="brand-text">Operations Console</div>
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

<div class="top-actions">

    <div class="action-left">
        <a href="/resolution-library" class="btn ghost">📚 Knowledge Base</a>
        <a href="/admin/users" class="btn ghost">Users</a>
        <a href="/problem-logs/create" class="btn primary">+ Add New Ticket</a>
    </div>

    <div class="action-right">
        <a href="/sla-dashboard" class="btn ghost">SLA</a>
        <a href="/analytics" class="btn ghost">Analytics</a>
        <a href="/problem-logs/export" class="btn ghost">Export</a>
        <a href="/problem-logs" class="btn ghost">Refresh</a>

        <input type="text" placeholder="Search tickets..." class="search-input">
        <div class="filter-btn">⚙</div>
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

<div class="top-actions">

    <div class="action-left">
        <a href="/resolution-library" class="btn ghost">📚 Knowledge Base</a>
        <a href="/admin/users" class="btn ghost">Users</a>
        <a href="/problem-logs/create" class="btn primary">+ Add New Ticket</a>
    </div>

    <div class="action-right">
        <a href="/sla-dashboard" class="btn ghost">SLA</a>
        <a href="/analytics" class="btn ghost">Analytics</a>
        <a href="/problem-logs/export" class="btn ghost">Export</a>
        <a href="/problem-logs" class="btn ghost">Refresh</a>

        <input type="text" placeholder="Search tickets..." class="search-input">
        <div class="filter-btn">⚙</div>
    </div>

</div>


            <div class="sidebar-status">
                <div class="sidebar-status-dot"></div>
                <div>
                    <div class="sidebar-status-title">All systems operational</div>
                    <div class="sidebar-status-sub">Navigation ready</div>
                </div>
            </div>

<div class="top-actions">

    <div class="action-left">
        <a href="/resolution-library" class="btn ghost">📚 Knowledge Base</a>
        <a href="/admin/users" class="btn ghost">Users</a>
        <a href="/problem-logs/create" class="btn primary">+ Add New Ticket</a>
    </div>

    <div class="action-right">
        <a href="/sla-dashboard" class="btn ghost">SLA</a>
        <a href="/analytics" class="btn ghost">Analytics</a>
        <a href="/problem-logs/export" class="btn ghost">Export</a>
        <a href="/problem-logs" class="btn ghost">Refresh</a>

        <input type="text" placeholder="Search tickets..." class="search-input">
        <div class="filter-btn">⚙</div>
    </div>

</div>

        </nav>
    </aside>



    <main class="main">
        <section class="hero">
            <div class="eyebrow">Problem Log Command Center</div>

            <div class="hero-top">
                <div>
                    <h1>Problem Log Dashboard</h1>
                    <p>Incident tracking, lifecycle metrics, SLA filters, and operational visibility.</p>
                    <div class="hero-meta">
                        {{ optional(auth()->user()->company)->name ?? 'No Company' }} • {{ ucfirst(auth()->user()->role ?? 'User') }}
                    </div>
                </div>
            </div>

<div class="top-actions">

    <div class="action-left">
        <a href="/resolution-library" class="btn ghost">📚 Knowledge Base</a>
        <a href="/admin/users" class="btn ghost">Users</a>
        <a href="/problem-logs/create" class="btn primary">+ Add New Ticket</a>
    </div>

    <div class="action-right">
        <a href="/sla-dashboard" class="btn ghost">SLA</a>
        <a href="/analytics" class="btn ghost">Analytics</a>
        <a href="/problem-logs/export" class="btn ghost">Export</a>
        <a href="/problem-logs" class="btn ghost">Refresh</a>

        <input type="text" placeholder="Search tickets..." class="search-input">
        <div class="filter-btn">⚙</div>
    </div>

</div>


            
            <div class="top-actions">
                <div class="action-left">
                    <a href="/problem-logs/create" class="btn primary">+ Add New Ticket</a>
                    <a href="/problem-logs/export" class="btn ghost">Export</a>
                    <a href="/problem-logs" class="btn ghost">Refresh</a>
                </div>

                <div class="action-right">
                    <input type="text" placeholder="Search tickets..." class="search-input">
                    <div class="filter-btn">⚙</div>
                </div>
            </div>

<div class="top-actions">

    <div class="action-left">
        <a href="/resolution-library" class="btn ghost">📚 Knowledge Base</a>
        <a href="/admin/users" class="btn ghost">Users</a>
        <a href="/problem-logs/create" class="btn primary">+ Add New Ticket</a>
    </div>

    <div class="action-right">
        <a href="/sla-dashboard" class="btn ghost">SLA</a>
        <a href="/analytics" class="btn ghost">Analytics</a>
        <a href="/problem-logs/export" class="btn ghost">Export</a>
        <a href="/problem-logs" class="btn ghost">Refresh</a>

        <input type="text" placeholder="Search tickets..." class="search-input">
        <div class="filter-btn">⚙</div>
    </div>

</div>


                <a href="/resolution-library" class="btn secondary">📚 Knowledge Base</a>

                @if((auth()->user()->role ?? null) === 'admin')
                    <a href="/admin/users" class="btn secondary">Users</a>
                @endif

                <a href="/problem-logs/create" class="btn primary">+ Add New Log</a>
                <a href="/sla-dashboard" class="btn secondary">SLA Dashboard</a>
                <a href="/analytics" class="btn secondary">Analytics</a>
                <a href="/problem-logs/export" class="btn secondary">Export Excel</a>
                <a href="/problem-logs" class="btn secondary">Refresh</a>
                <a href="/help" class="btn secondary">Help</a>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn secondary" style="background:rgba(255,255,255,.08);">Logout</button>
                </form>
            </div>
        </section>

        <section class="metrics">
            <div class="metric-card">
                <div class="metric-label">Operational Snapshot</div>
                <div class="metric-value">{{ $total }}</div>
                <div class="metric-sub">Total incidents in current filtered view</div>
            </div>

<div class="top-actions">

    <div class="action-left">
        <a href="/resolution-library" class="btn ghost">📚 Knowledge Base</a>
        <a href="/admin/users" class="btn ghost">Users</a>
        <a href="/problem-logs/create" class="btn primary">+ Add New Ticket</a>
    </div>

    <div class="action-right">
        <a href="/sla-dashboard" class="btn ghost">SLA</a>
        <a href="/analytics" class="btn ghost">Analytics</a>
        <a href="/problem-logs/export" class="btn ghost">Export</a>
        <a href="/problem-logs" class="btn ghost">Refresh</a>

        <input type="text" placeholder="Search tickets..." class="search-input">
        <div class="filter-btn">⚙</div>
    </div>

</div>


            <div class="metric-card">
                <div class="metric-label">Open</div>
                <div class="metric-value">{{ $open }}</div>
                <div class="metric-sub">Need attention</div>
            </div>

<div class="top-actions">

    <div class="action-left">
        <a href="/resolution-library" class="btn ghost">📚 Knowledge Base</a>
        <a href="/admin/users" class="btn ghost">Users</a>
        <a href="/problem-logs/create" class="btn primary">+ Add New Ticket</a>
    </div>

    <div class="action-right">
        <a href="/sla-dashboard" class="btn ghost">SLA</a>
        <a href="/analytics" class="btn ghost">Analytics</a>
        <a href="/problem-logs/export" class="btn ghost">Export</a>
        <a href="/problem-logs" class="btn ghost">Refresh</a>

        <input type="text" placeholder="Search tickets..." class="search-input">
        <div class="filter-btn">⚙</div>
    </div>

</div>


            <div class="metric-card">
                <div class="metric-label">In Progress</div>
                <div class="metric-value">{{ $progress }}</div>
                <div class="metric-sub">Currently being handled</div>
            </div>

<div class="top-actions">

    <div class="action-left">
        <a href="/resolution-library" class="btn ghost">📚 Knowledge Base</a>
        <a href="/admin/users" class="btn ghost">Users</a>
        <a href="/problem-logs/create" class="btn primary">+ Add New Ticket</a>
    </div>

    <div class="action-right">
        <a href="/sla-dashboard" class="btn ghost">SLA</a>
        <a href="/analytics" class="btn ghost">Analytics</a>
        <a href="/problem-logs/export" class="btn ghost">Export</a>
        <a href="/problem-logs" class="btn ghost">Refresh</a>

        <input type="text" placeholder="Search tickets..." class="search-input">
        <div class="filter-btn">⚙</div>
    </div>

</div>

        </section>

        <section class="table-wrap">
            <h2 class="table-title">Your Tickets</h2>

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
                                <td class="time">{{ optional($t->created_at)->format('d M Y, H.i') }}</td>
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
