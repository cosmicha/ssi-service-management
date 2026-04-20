<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ticket Monitoring Dashboard</title>
<style>
    :root{
        --bg:#040b18;
        --bg2:#071427;
        --panel:rgba(255,255,255,.06);
        --panel-2:rgba(255,255,255,.08);
        --stroke:rgba(255,255,255,.10);
        --text:#f8fbff;
        --muted:#9fb0cf;
        --blue:#4f7cff;
        --blue2:#2563eb;
        --violet:#8b5cf6;
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
            radial-gradient(circle at top right, rgba(59,130,246,.22), transparent 28%),
            radial-gradient(circle at bottom left, rgba(34,197,94,.08), transparent 22%),
            linear-gradient(135deg, #020814 0%, #061122 45%, #091730 100%);
        min-height:100vh;
    }

    .app{
        display:flex;
        min-height:100vh;
    }

    .sidebar{
        width:240px;
        padding:11px 10px;
        background:
            radial-gradient(circle at top left, rgba(59,130,246,.10), transparent 26%),
            linear-gradient(180deg, rgba(2,6,23,.92), rgba(5,14,30,.96));
        border-right:1px solid rgba(255,255,255,.06);
        backdrop-filter: blur(12px);
    }

    .brand{
        display:flex;
        align-items:center;
        gap:14px;
        margin-bottom:12px;
    }

    .brand-badge{
        width:42px;
        height:42px;
        border-radius:16px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:900;
        font-size:18px;
        color:#071224;
        background:linear-gradient(135deg,#8bd7ff,#60a5fa);
        box-shadow:0 12px 24px rgba(56,189,248,.28);
        flex:0 0 auto;
    }

    .brand-text{
        font-size:12px;
        line-height:1.2;
        letter-spacing:.14em;
        text-transform:uppercase;
        color:rgba(255,255,255,.88);
        font-weight:900;
    }

    .nav{
        display:flex;
        flex-direction:column;
        gap:10px;
    }

    .nav a{
        text-decoration:none;
        color:#dbe7ff;
        padding:11px 13px;
        border-radius:16px;
        font-weight:800;
        font-size:12px;
        transition:.18s ease;
        border:1px solid transparent;
        display:flex;
        align-items:center;
        gap:12px;
    }

    .nav a.active{
        background:linear-gradient(135deg, rgba(37,99,235,.38), rgba(79,124,255,.18));
        border-color:rgba(96,165,250,.35);
        box-shadow: inset 0 1px 0 rgba(255,255,255,.08), 0 10px 24px rgba(37,99,235,.18);
    }

    .nav a:hover{
        background:rgba(255,255,255,.06);
    }

    .nav-icon{
        width:20px;
        text-align:center;
        opacity:.95;
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
        padding:11px 13px;
        font-size:12px;
        font-weight:900;
        cursor:pointer;
    }

    .nav-group-toggle:hover{
        background:rgba(255,255,255,.04);
    }

    .nav-group-label{
        display:flex;
        align-items:center;
        gap:12px;
    }

    .nav-arrow{
        font-size:14px;
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
        padding:10px 12px;
        border-radius:14px;
        font-size:12px;
        background:rgba(255,255,255,.02);
    }

    .sidebar-status{
        margin-top:10px;
        display:flex;
        align-items:flex-start;
        gap:10px;
        padding:11px 13px;
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
        font-size:12px;
        font-weight:800;
        margin-bottom:3px;
    }

    .sidebar-status-sub{
        font-size:12px;
        color:#98a7c4;
    }

    .main{
        flex:1;
        padding:14px 16px 16px;
    }

    .hero{
        border-radius:22px;
        padding:18px 20px 16px;
        background:
            radial-gradient(circle at right top, rgba(79,124,255,.20), transparent 32%),
            linear-gradient(135deg, rgba(10,24,56,.94), rgba(16,38,108,.84));
        border:1px solid rgba(255,255,255,.10);
        box-shadow:var(--shadow);
        margin-bottom:12px;
    }

    .hero-top{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:12px;
        flex-wrap:wrap;
    }

    .support-chip{
        display:inline-flex;
        align-items:center;
        gap:10px;
        padding:9px 14px;
        border-radius:999px;
        background:rgba(255,255,255,.07);
        border:1px solid rgba(255,255,255,.10);
        color:#eaf1ff;
        font-size:12px;
        font-weight:800;
        margin-bottom:10px;
    }

    .hero h1{
        margin:0;
        font-size:30px;
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
        margin:14px 0 0;
        color:#d7e1f5;
        font-size:14px;
        max-width:780px;
    }

    .identity-row{
        margin-top:10px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        flex-wrap:wrap;
    }

    .identity-left{
        display:flex;
        align-items:center;
        gap:12px;
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
        font-size:12px;
        font-weight:900;
        color:#f4f8ff;
    }

    .company-logo-slot{
        width:42px;
        height:42px;
        border-radius:16px;
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
        padding:10px 15px;
        border-radius:999px;
        background:rgba(255,255,255,.06);
        border:1px solid rgba(255,255,255,.09);
        color:#dbe8ff;
        font-size:12px;
        font-weight:800;
    }

    .top-actions{
        margin-top:8px;
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:12px;
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
        padding:10px 14px;
        border-radius:18px;
        font-weight:800;
        font-size:12px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        color:white;
        border:1px solid rgba(255,255,255,.12);
        min-height:42px;
        box-shadow:0 10px 18px rgba(0,0,0,.18);
        transition:.18s ease;
        gap:10px;
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

    .icon{
        width:18px;
        height:18px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        flex:0 0 auto;
    }

    .search-input{
        background:rgba(255,255,255,.06);
        border:1px solid rgba(255,255,255,.12);
        padding:13px 16px;
        border-radius:16px;
        color:white;
        min-width:200px;
        outline:none;
        font-size:12px;
    }

    .search-input::placeholder{
        color:#94a3b8;
    }

    .filter-btn{
        width:42px;
        height:42px;
        border-radius:15px;
        background:rgba(255,255,255,.08);
        border:1px solid rgba(255,255,255,.10);
        display:flex;
        align-items:center;
        justify-content:center;
        color:#e2ebff;
        font-weight:900;
        font-size:18px;
    }

    .metrics{
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:12px;
        margin-bottom:12px;
    }

    .metric-card{
        position:relative;
        overflow:hidden;
        border-radius:24px;
        padding:10px 12px;
        min-height:82px;
        border:1px solid rgba(255,255,255,.12);
        box-shadow:var(--shadow);
    }

    .metric-card::before{
        content:'';
        position:absolute;
        inset:0;
        background:
            radial-gradient(circle at bottom center, rgba(255,255,255,.12), transparent 42%);
        pointer-events:none;
    }

    .metric-icon{
        position:absolute;
        right:18px;
        top:18px;
        width:42px;
        height:42px;
        border-radius:18px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:rgba(255,255,255,.10);
        border:1px solid rgba(255,255,255,.12);
        font-size:18px;
        box-shadow: inset 0 1px 0 rgba(255,255,255,.08);
    }

    .metric-blue{
        background:linear-gradient(135deg, rgba(26,38,120,.92), rgba(37,99,235,.78));
    }

    .metric-cyan{
        background:linear-gradient(135deg, rgba(8,55,120,.94), rgba(14,165,233,.72));
    }

    .metric-violet{
        background:linear-gradient(135deg, rgba(76,29,149,.94), rgba(236,72,153,.44));
    }

    .metric-green{
        background:linear-gradient(135deg, rgba(5,80,80,.95), rgba(34,197,94,.44));
    }

    .metric-label{
        font-size:12px;
        text-transform:uppercase;
        letter-spacing:.14em;
        color:#d3ddf6;
        font-weight:900;
        margin-bottom:10px;
    }

    .metric-value{
        font-size:30px;
        line-height:1;
        font-weight:900;
        margin-bottom:8px;
    }

    .metric-sub{
        font-size:12px;
        color:#edf4ff;
    }

    .table-wrap{
        border-radius:22px;
        background:linear-gradient(180deg, rgba(255,255,255,.07), rgba(255,255,255,.05));
        border:1px solid rgba(255,255,255,.09);
        box-shadow:var(--shadow);
        padding:14px 14px 10px;
    }

    .table-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:10px;
    }

    .table-title-group{
        display:flex;
        align-items:center;
        gap:12px;
        flex-wrap:wrap;
    }

    .table-title{
        margin:0;
        font-size:18px;
        font-weight:900;
        letter-spacing:-0.02em;
    }

    .latest-chip{
        display:inline-flex;
        align-items:center;
        padding:7px 12px;
        border-radius:999px;
        font-size:12px;
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
        padding:10px 12px;
        border-radius:14px;
        min-width:120px;
    }

    .table-scroll{
        overflow:auto;
    }

    table{
        width:100%;
        border-collapse:collapse;
        min-width:860px;
    }

    th{
        text-align:left;
        padding:10px 12px;
        color:#aebdd8;
        font-size:12px;
        font-weight:800;
        letter-spacing:.04em;
        border-bottom:1px solid rgba(255,255,255,.08);
    }

    td{
        padding:11px 10px;
        border-bottom:1px solid rgba(255,255,255,.06);
        vertical-align:middle;
        font-size:12px;
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

    .ticket-id-wrap{
        display:flex;
        align-items:center;
        gap:10px;
        white-space:nowrap;
    }

    .row-copy{
        color:#9fb0cf;
        font-size:12px;
    }

    .title{
        font-weight:800;
        font-size:12px;
        line-height:1.35;
        max-width:240px;
    }

    .desc{
        color:#d7e1f5;
        line-height:1.45;
        max-width:340px;
        white-space:nowrap;
        overflow:hidden;
        text-overflow:ellipsis;
    }

    .time{
        color:#dbe7ff;
        font-size:12px;
        line-height:1.45;
        white-space:nowrap;
    }

    .status-pill{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-width:108px;
        padding:7px 12px;
        border-radius:999px;
        font-size:12px;
        font-weight:900;
        color:white;
        white-space:nowrap;
        text-transform:capitalize;
        box-shadow:0 10px 18px rgba(0,0,0,.18);
    }

    .status-open{ background:linear-gradient(135deg,#2563eb,#1d4ed8); }
    .status-progress{ background:linear-gradient(135deg,#b45309,#f59e0b); }
    .status-closed{ background:linear-gradient(135deg,#15803d,#22c55e); }

    .row-arrow{
        color:#d7e1f5;
        font-size:18px;
        text-align:right;
        white-space:nowrap;
    }

    .pagination-wrap{
        margin-top:10px;
    }

    @media (max-width: 1280px){
        .metrics{
            grid-template-columns:repeat(2,minmax(0,1fr));
        }
        .hero h1{
            font-size:46px;
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
            padding:16px;
        }
        .hero{
            padding:20px;
        }
        .hero h1{
            font-size:34px;
        }
    }

.sidebar{
    position:fixed;
    left:0;
    top:0;
    height:100vh;
    z-index:100;
}

.main{
    margin-left:240px;
}


.sidebar.collapsed{
    width:80px;
}
.sidebar.collapsed .brand-text,
.sidebar.collapsed a span:not(.nav-icon){
    display:none;
}
.main.collapsed{
    margin-left:80px;
}


/* ===== FINAL POLISH ===== */
.metric-card{
    position:relative;
    overflow:hidden;
    transform:translateY(0);
    transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease, filter .18s ease;
}
.metric-card:hover{
    transform:translateY(-2px);
    box-shadow:0 22px 40px rgba(0,0,0,.34);
    border-color:rgba(255,255,255,.18);
    filter:brightness(1.03);
}
.metric-card.active-metric{
    border-color:rgba(125,211,252,.55);
    box-shadow:0 0 0 1px rgba(125,211,252,.22), 0 20px 36px rgba(37,99,235,.28);
}

.metric-sub{
    opacity:.92;
}

.table-wrap{
    position:relative;
    overflow:hidden;
}
.table-wrap::before{
    content:'';
    position:absolute;
    inset:0 0 auto 0;
    height:1px;
    background:linear-gradient(90deg, transparent, rgba(255,255,255,.18), transparent);
    pointer-events:none;
}

.table-tools .search-input{
    min-width:220px;
    height:42px;
    padding:10px 14px;
}
.tool-select{
    height:42px;
    padding:9px 12px;
}
.table-tools .filter-btn{
    width:42px;
    height:42px;
    border-radius:12px;
}

.top-actions .search-input{
    height:42px;
    padding:10px 14px;
    min-width:210px;
}
.top-actions .filter-btn{
    width:42px;
    height:42px;
    border-radius:12px;
}

.ticket-id-wrap{
    gap:8px;
}
.row-copy{
    opacity:.55;
}
tr.clickable:hover .row-copy,
tr.clickable:hover .row-arrow{
    opacity:1;
    color:#ffffff;
}

.row-arrow{
    opacity:.68;
    transition:opacity .18s ease, transform .18s ease;
}
tr.clickable:hover .row-arrow{
    transform:translateX(2px);
}

.status-pill{
    letter-spacing:.01em;
}

.search-input:focus,
.tool-select:focus{
    border-color:rgba(125,211,252,.45);
    box-shadow:0 0 0 3px rgba(96,165,250,.12);
}

.nav a,
.nav-submenu a{
    transition:background .18s ease, border-color .18s ease, transform .18s ease;
}
.nav a:hover,
.nav-submenu a:hover{
    transform:translateX(1px);
}

@media (max-width: 900px){
    .top-actions,
    .table-header{
        align-items:stretch;
    }
    .action-left, .action-right, .table-tools{
        width:100%;
    }
    .top-actions .search-input,
    .table-tools .search-input{
        flex:1;
        min-width:unset;
    }
}


.sidebar{
    transition: all .25s ease;
}
.sidebar.collapsed{
    width:70px !important;
}
.sidebar.collapsed .brand-text,
.sidebar.collapsed .nav a span:not(.nav-icon),
.sidebar.collapsed .nav-group,
.sidebar.collapsed .sidebar-status{
    opacity:0;
    pointer-events:none;
}
.main{
    transition: margin .25s ease;
}
.main.collapsed{
    margin-left:70px !important;
}


.spa-view{
    animation:fadeIn .2s ease;
}

.spa-view table{
    width:100%;
    border-collapse:collapse;
}

.spa-view th, .spa-view td{
    padding:10px 12px;
    border-bottom:1px solid rgba(255,255,255,.08);
}

.spa-view input{
    width:100%;
    padding:12px;
    border-radius:12px;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.1);
    color:white;
}

.spa-view button{
    padding:10px 14px;
    border-radius:12px;
    border:none;
    background:linear-gradient(135deg,#3b82f6,#6366f1);
    color:white;
    font-weight:700;
}

@keyframes fadeIn{
    from{opacity:.6; transform:translateY(4px);}
    to{opacity:1; transform:translateY(0);}
}


#app-loading{
    position:absolute;
    inset:0;
    display:flex;
    align-items:center;
    justify-content:center;
    background:rgba(10,20,40,.4);
    backdrop-filter:blur(6px);
    border-radius:20px;
    z-index:5;
}

.loader{
    width:36px;
    height:36px;
    border:3px solid rgba(255,255,255,.2);
    border-top:3px solid #60a5fa;
    border-radius:50%;
    animation:spin 0.8s linear infinite;
}

@keyframes spin{
    to{transform:rotate(360deg);}
}


.nav a{
    transition:all .2s ease;
}
.nav a:hover{
    transform:translateX(4px);
    background:rgba(255,255,255,.08);
}


.kb-view{
    padding:10px;
}

.kb-view h1, .kb-view h2{
    color:#f8fbff;
    font-weight:800;
}

.kb-view p{
    color:#c7d2e8;
}

.kb-view input{
    width:100%;
    padding:12px;
    border-radius:12px;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.1);
    color:white;
    margin-bottom:10px;
}

.kb-view button{
    padding:10px 14px;
    border-radius:12px;
    border:none;
    background:linear-gradient(135deg,#3b82f6,#6366f1);
    color:white;
    font-weight:700;
}

.kb-view table{
    width:100%;
    border-collapse:collapse;
    margin-top:16px;
    background:rgba(255,255,255,.03);
    border-radius:16px;
    overflow:hidden;
}

.kb-view th{
    text-align:left;
    padding:12px;
    font-size:12px;
    color:#9fb0cf;
    background:rgba(255,255,255,.04);
}

.kb-view td{
    padding:12px;
    border-bottom:1px solid rgba(255,255,255,.06);
    color:#f1f5ff;
}

.kb-view tr:hover{
    background:rgba(255,255,255,.04);
}

.kb-view a{
    color:#60a5fa;
    text-decoration:none;
}

.kb-view a:hover{
    text-decoration:underline;
}

.kb-view img{
    border-radius:10px;
    max-width:80px;
}


.metric-value{
    font-size:42px;
    font-weight:900;
    color:#ffffff !important;
    letter-spacing:-1px;

    /* glow halus biar kebaca di semua gradient */
    text-shadow:
        0 2px 6px rgba(0,0,0,.4),
        0 0 12px rgba(255,255,255,.15);
}

/* khusus tiap card biar lebih hidup */
.metric-card.total .metric-value{
    color:#ffffff;
}

.metric-card.open .metric-value{
    color:#ffffff;
}

.metric-card.progress .metric-value{
    color:#ffffff;
}

.metric-card.closed .metric-value{
    color:#ffffff;
}


.hero{
    padding:20px 24px 18px;
    margin-bottom:16px;
}
.hero h1{
    margin:0;
    font-size:52px;
    line-height:1.04;
    letter-spacing:-0.04em;
    font-weight:900;
    color:#f8fbff;
}
.identity-row{
    margin-top:14px;
}
.top-actions{
    margin-top:16px;
}
.metrics{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:14px;
    margin-bottom:18px;
}
.metric-card{
    text-decoration:none;
    color:inherit;
    min-height:120px;
    padding:16px 18px;
}
.metric-label{
    margin-bottom:10px;
}
.metric-value{
    font-size:42px;
    font-weight:900;
    color:#ffffff !important;
    text-shadow:0 2px 6px rgba(0,0,0,.35), 0 0 10px rgba(255,255,255,.12);
}
.metric-sub{
    font-size:13px;
    color:#eef4ff;
}
.metric-icon{
    width:46px;
    height:46px;
    font-size:20px;
}
.table-wrap{
    margin-top:0;
}


.compact-hero{
    padding:18px 24px 16px !important;
    margin-bottom:14px !important;
    min-height:auto !important;
}

.compact-hero-top{
    display:flex;
    flex-direction:column;
    gap:14px;
    align-items:flex-start;
}

.hero-title-wrap{
    width:100%;
}

.compact-hero h1{
    margin:0;
    font-size:40px !important;
    line-height:1.05;
    letter-spacing:-0.04em;
    font-weight:900;
}

.hero-meta-row{
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

.company-mini{
    color:#c7d2e8;
    font-size:13px;
    font-weight:700;
    padding:10px 14px;
    border-radius:999px;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.08);
}

.compact-add-btn{
    min-height:42px !important;
    padding:10px 14px !important;
    border-radius:14px !important;
}

.updated-pill,
.identity-pill{
    min-height:42px;
    padding:10px 14px !important;
    font-size:13px !important;
}

@media (max-width: 900px){
    .compact-hero h1{
        font-size:30px !important;
    }

    .hero-meta-row{
        align-items:stretch;
    }
}


/* ===== HERO FINAL ALIGNMENT FIX ===== */
.hero-meta-row{
    width:100%;
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    flex-wrap:wrap;
}

/* LEFT: button */
.hero-meta-row .btn{
    order:1;
}

/* RIGHT GROUP */
.hero-meta-row .updated-pill{
    order:3;
}

.hero-meta-row .identity-pill{
    order:2;
}

/* force right alignment grouping */
.hero-meta-row{
    display:grid !important;
    grid-template-columns: 1fr auto;
    row-gap:10px;
}

/* posisi */
.hero-meta-row .btn{
    grid-column:1;
    grid-row:1;
    justify-self:start;
}

.hero-meta-row .identity-pill{
    grid-column:2;
    grid-row:1;
    justify-self:end;
}

.hero-meta-row .updated-pill{
    grid-column:2;
    grid-row:2;
    justify-self:end;
}

/* mobile */
@media (max-width:900px){
    .hero-meta-row{
        grid-template-columns:1fr;
    }

    .hero-meta-row .btn,
    .hero-meta-row .identity-pill,
    .hero-meta-row .updated-pill{
        grid-column:1;
        justify-self:start;
    }
}


/* ===== HERO ALIGNMENT FINAL POLISH ===== */

/* bikin hero top align */
.hero-top{
    align-items:flex-start !important;
}

/* RIGHT SIDE: naik ke atas */
.hero-meta-row{
    align-items:flex-start !important;
}

/* identity (Cosmas — Admin) */
.hero-meta-row .identity-pill{
    align-self:flex-start !important;
    margin-top:-6px; /* naik sedikit */
    font-size:14px !important;
    font-weight:700;
}

/* last updated lebih kecil & subtle */
.hero-meta-row .updated-pill{
    font-size:12px !important;
    opacity:0.75;
    padding:8px 12px !important;
    margin-top:4px;
}

/* spacing lebih rapat */
.hero-meta-row{
    row-gap:6px !important;
}

/* title spacing biar balance */
.hero h1{
    margin-bottom:8px !important;
}


/* ===== SUPER COMPACT HERO ===== */

/* container lebih rapat */
.hero{
    padding:14px 24px 12px !important;
}

/* title rapetin */
.hero h1{
    margin-bottom:4px !important;
}

/* RIGHT BLOCK naik lagi */
.hero-meta-row{
    row-gap:4px !important;
}

/* Cosmas — Admin naik lebih tinggi */
.hero-meta-row .identity-pill{
    margin-top:-14px !important;   /* ini yg bikin naik */
    padding:8px 12px !important;
    font-size:13px !important;
}

/* Last updated lebih kecil & lebih dekat */
.hero-meta-row .updated-pill{
    margin-top:-4px !important;
    padding:6px 10px !important;
    font-size:11px !important;
    opacity:0.7;
}

/* button juga sedikit naik */
.hero-meta-row .btn{
    margin-top:-6px !important;
}



    .hero h1{
        padding-right:0;
    }
}


/* ===== HERO TWO-COLUMN CLEAN LAYOUT ===== */
.hero{
    position:relative;
    padding:18px 24px 16px !important;
}

.hero-top,
.compact-hero-top{
    display:grid !important;
    grid-template-columns: 1fr auto;
    gap:16px 24px;
    align-items:start !important;
}

.hero-title-wrap{
    grid-column:1;
    grid-row:1;
}

.hero-meta-layout,
.hero-meta-row{
    grid-column:2;
    grid-row:1;
    display:flex !important;
    flex-direction:column;
    align-items:flex-end;
    gap:8px !important;
    position:static !important;
    margin:0 !important;
}

.hero-meta-left{
    grid-column:1;
    grid-row:2;
    display:flex;
    align-items:center;
    justify-content:flex-start;
}

.hero-meta-right{
    display:flex;
    flex-direction:column;
    align-items:flex-end;
    gap:8px;
    margin:0 !important;
}

.hero h1{
    margin:0 0 6px !important;
    padding-right:0 !important;
    font-size:40px !important;
    line-height:1.05;
}

.hero-meta-row .identity-pill,
.hero-meta-right .identity-pill{
    margin:0 !important;
    padding:8px 14px !important;
    font-size:13px !important;
}

.hero-meta-row .updated-pill,
.hero-meta-right .updated-pill{
    margin:0 !important;
    padding:6px 12px !important;
    font-size:11px !important;
    opacity:.8;
}

.compact-add-btn,
.hero-meta-row .btn,
.hero-meta-left .btn{
    margin:0 !important;
    min-height:42px !important;
    padding:10px 14px !important;
    border-radius:14px !important;
}

@media (max-width: 900px){
    .hero-top,
    .compact-hero-top{
        grid-template-columns:1fr !important;
    }

    .hero-title-wrap,
    .hero-meta-layout,
    .hero-meta-row,
    .hero-meta-left{
        grid-column:1 !important;
        grid-row:auto !important;
    }

    .hero-meta-layout,
    .hero-meta-row,
    .hero-meta-right{
        align-items:flex-start !important;
    }
}


/* ===== FINAL HERO STRUCTURE ===== */

/* container */
.hero{
    position:relative;
    padding:18px 24px 16px !important;
}

/* title */
.hero h1{
    margin:0 0 12px !important;
}

/* tombol kiri */
.hero-meta-left{
    position:absolute;
    left:24px;
    top:80px; /* adjust biar pas di bawah title */
}

/* kanan atas */
.hero-meta-right{
    position:absolute;
    right:24px;
    top:18px;
    display:flex;
    flex-direction:column;
    align-items:flex-end;
    gap:8px;
}

/* identity */
.hero-meta-right .identity-pill{
    padding:8px 14px !important;
    font-size:13px !important;
    margin:0 !important;
}

/* last updated */
.hero-meta-right .updated-pill{
    padding:6px 12px !important;
    font-size:11px !important;
    opacity:0.8;
    margin:0 !important;
}

/* tombol style */
.hero-meta-left .btn{
    margin:0 !important;
}

/* kasih ruang bawah supaya ga ketabrak metrics */
.hero{
    padding-bottom:70px !important;
}

/* mobile fallback */
@media (max-width:900px){
    .hero-meta-left,
    .hero-meta-right{
        position:static !important;
        align-items:flex-start;
        margin-top:10px;
    }
}


/* ===== HERO HARD RESET ===== */
.compact-hero{
    padding: 20px 28px 18px !important;
    margin-bottom: 16px !important;
    min-height: auto !important;
}

.compact-hero .hero-shell{
    display: grid !important;
    grid-template-columns: 1fr auto !important;
    grid-template-areas:
        "title meta"
        "actions meta";
    gap: 14px 24px !important;
    align-items: start !important;
}

.compact-hero .hero-title-wrap{
    grid-area: title;
}

.compact-hero .hero-left-actions{
    grid-area: actions;
    display:flex;
    align-items:center;
    justify-content:flex-start;
}

.compact-hero .hero-right-meta{
    grid-area: meta;
    display:flex !important;
    flex-direction:column !important;
    align-items:flex-end !important;
    justify-content:flex-start !important;
    gap:10px !important;
    margin:0 !important;
    position:static !important;
}

.compact-hero h1{
    margin:0 !important;
    font-size: 42px !important;
    line-height: 1.04 !important;
    letter-spacing: -0.04em !important;
    font-weight: 900 !important;
    color: #f8fbff !important;
    padding-right: 0 !important;
}

.compact-hero .compact-add-btn{
    min-height: 44px !important;
    padding: 10px 16px !important;
    border-radius: 16px !important;
    margin:0 !important;
}

.compact-hero .identity-pill{
    padding: 8px 14px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    margin:0 !important;
}

.compact-hero .updated-pill{
    padding: 6px 12px !important;
    font-size: 11px !important;
    opacity: .82 !important;
    margin:0 !important;
}

.compact-hero .company-mini{
    color:#c7d2e8;
    font-size:12px;
    font-weight:600;
}

@media (max-width: 900px){
    .compact-hero .hero-shell{
        grid-template-columns: 1fr !important;
        grid-template-areas:
            "title"
            "meta"
            "actions";
        gap: 12px !important;
    }

    .compact-hero .hero-right-meta{
        align-items:flex-start !important;
    }

    .compact-hero h1{
        font-size: 32px !important;
    }
}


/* ===== SIDEBAR COLLAPSE ===== */

.sidebar-collapsed .sidebar{
    width:72px !important;
}

.sidebar-collapsed .sidebar .menu-label,
.sidebar-collapsed .sidebar .submenu,
.sidebar-collapsed .sidebar h4{
    display:none !important;
}

.sidebar-collapsed .sidebar{
    align-items:center;
}

.sidebar-collapsed .main-content{
    margin-left:72px !important;
}

/* normal */
.main-content{
    transition:all .25s ease;
}

.sidebar{
    transition:all .25s ease;
}

/* toggle button */
.sidebar-toggle{
    position:absolute;
    top:18px;
    left:18px;
    z-index:999;
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.12);
    color:#fff;
    border-radius:10px;
    padding:6px 10px;
    cursor:pointer;
    backdrop-filter:blur(8px);
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

    $lastUpdated = optional(\App\Models\ProblemLog::latest('updated_at')->first())->updated_at;
@endphp

<div class="app">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-badge">TS</div>
            <div class="brand-text">Operations<br>Console</div>
        </div>

        
<nav class="nav">
    <a href="/problem-logs" class="active"><span class="nav-icon">⌂</span><span>Dashboard</span></a>
    <a href="/problem-logs?panel=kb"><span class="nav-icon">☰</span><span>Knowledge Base</span></a>
    <a href="/problem-logs?panel=sla"><span class="nav-icon">▥</span><span>SLA Dashboard</span></a>
    <a href="/problem-logs?panel=help"><span class="nav-icon">?</span><span>Help</span></a>

    <div class="nav-group is-open" data-group>
        <button type="button" class="nav-group-toggle" data-toggle>
            <span class="nav-group-label"><span class="nav-icon">⚙</span><span>Settings</span></span>
            <span class="nav-arrow">⌄</span>
        </button>
        <div class="nav-submenu">
            
            <a href="/admin/companies/settings"><span class="nav-icon">◌</span><span>Company</span></a>
            <a href="/problem-logs?panel=devices"><span class="nav-icon">▣</span><span>Devices</span></a>
            <a href="/problem-logs?panel=vendors"><span class="nav-icon">◍</span><span>Vendors</span></a>
        </div>
    </div>

    <div class="nav-group is-open" data-group>
        <button type="button" class="nav-group-toggle" data-toggle>
            <span class="nav-group-label"><span class="nav-icon">⎘</span><span>Report</span></span>
            <span class="nav-arrow">⌄</span>
        </button>
        <div class="nav-submenu">
            
            <a href="/problem-logs?panel=analytics"><span class="nav-icon">◫</span><span>Analytics</span></a>
        </div>
    </div>

    <div class="sidebar-status">
        <div class="sidebar-status-dot"></div>
        <div>
            <div class="sidebar-status-title">All systems operational</div>
            <div class="sidebar-status-sub">Navigation ready</div>
        </div>
    </div>
</nav>

    </aside>

    <main class="main">
<div id="app-content">
        
        
        
        <section class="hero compact-hero">
            <div class="hero-shell">
                <div class="hero-title-wrap">
                    <h1>Ticket Monitoring Dashboard</h1>
                </div>

                <div class="hero-left-actions">
                    <a href="/problem-logs/create" class="btn primary compact-add-btn">
                        <span class="icon">＋</span>Add New Ticket
                    </a>
                </div>

                <div class="hero-right-meta">
                    <div class="identity-pill">
                        {{ auth()->user()->name ?? 'User' }} — {{ ucfirst(auth()->user()->role ?? 'User') }}
                    </div>

                    @if((auth()->user()->role ?? null) === 'customer' && optional(auth()->user()->company)->name)
                        <div class="company-mini">
                            {{ optional(auth()->user()->company)->name }}
                        </div>
                    @endif

                    <div class="updated-pill">
                        <span class="icon">◷</span>
                        Last updated: {{ $lastUpdated ? $lastUpdated->format('d M Y, H.i') : '—' }}
                    </div>
                </div>
            </div>
        </section>




        

        <section class="metrics">
            <a href="/problem-logs" class="metric-card metric-blue total">
                <div class="metric-icon">◈</div>
                <div class="metric-label">Total</div>
                <div class="metric-value" data-target="{{ $total }}">{{ $total }}</div>
                <div class="metric-sub">All tickets</div>
            </a>

            <a href="/problem-logs?status=open" class="metric-card metric-cyan open">
                <div class="metric-icon">🔔</div>
                <div class="metric-label">Open</div>
                <div class="metric-value" data-target="{{ $open }}">{{ $open }}</div>
                <div class="metric-sub">Need attention</div>
            </a>

            <a href="/problem-logs?status=in_progress" class="metric-card metric-violet progress">
                <div class="metric-icon">⟳</div>
                <div class="metric-label">In Progress</div>
                <div class="metric-value" data-target="{{ $progress }}">{{ $progress }}</div>
                <div class="metric-sub">Processing</div>
            </a>

            <a href="/problem-logs?status=closed" class="metric-card metric-green closed">
                <div class="metric-icon">✓</div>
                <div class="metric-label">Closed</div>
                <div class="metric-value" data-target="{{ $closed }}">{{ $closed }}</div>
                <div class="metric-sub">Resolved</div>
            </a>
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
                    <div class="filter-btn">⌯</div>
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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($problemLogs as $t)
                            @php
                                $status = method_exists($t, 'normalizedStatus') ? $t->normalizedStatus() : ($t->status ?? 'open');
                                $statusClass = $status === 'closed'
                                    ? 'status-closed'
                                    : ($status === 'in_progress' ? 'status-progress' : 'status-open');
                            @endphp

                            <tr class="clickable" onclick="window.location='/problem-logs/{{ $t->id }}'">
                                <td class="ticket-id">
                                    <div class="ticket-id-wrap">
                                        <span>{{ $t->ticket_number ?? $t->id }}</span>
                                        <span class="row-copy">⧉</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-pill {{ $statusClass }}">
                                        {{ $status === 'in_progress' ? 'In Progress' : ucfirst(str_replace('_', ' ', $status)) }}
                                    </span>
                                </td>
                                <td class="title">{{ $t->title }}</td>
                                <td class="desc">{{ $t->description }}</td>
                                <td class="time">{{ optional($t->created_at)->format('d M Y') }}<br>{{ optional($t->created_at)->format('H.i') }}</td>
                                <td class="row-arrow">›</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="color:#b6c3db;">No tickets found.</td>
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
    </div>
</main>
</div>




<script>

function showSkeleton(){
    document.getElementById('app-content').innerHTML = `
    <div style="padding:20px">
        <div style="height:20px;width:200px;background:rgba(255,255,255,.08);border-radius:8px;margin-bottom:16px;"></div>
        <div style="height:120px;background:rgba(255,255,255,.05);border-radius:16px;margin-bottom:12px;"></div>
        <div style="height:120px;background:rgba(255,255,255,.05);border-radius:16px;"></div>
    </div>`;
}


function loadPage(url){

    showSkeleton();
    setActive(url);

    fetch(url)
    .then(r=>r.text())
    .then(html=>{
        const doc = new DOMParser().parseFromString(html,'text/html');

        let content =
            doc.querySelector('#app-content') ||
            doc.querySelector('.spa-view') ||
            doc.querySelector('.kb-view');

        if(content){
            document.getElementById('app-content').innerHTML = content.innerHTML;
            window.history.pushState({},'',url);
        }else{
            window.location=url;
        }
    });
}
})
    .then(r => r.text())
    .then(html => {
        const doc = new DOMParser().parseFromString(html,'text/html');

        let content =
            doc.querySelector('#app-content') ||
            doc.querySelector('.spa-view') ||
            doc.querySelector('.kb-view');

        if(content){
            document.getElementById('app-content').innerHTML = content.innerHTML;
            window.history.pushState({}, '', url);
            window.scrollTo({top:0, behavior:'smooth'});
        }else{
            window.location = url;
        }
    });
}

document.querySelectorAll('.nav a').forEach(a=>{
    a.addEventListener('click', function(e){
        const url = this.getAttribute('href');
        if(url.startsWith('/')){
            e.preventDefault();
            loadPage(url);
        }
    });
});

// handle back button
window.addEventListener('popstate', ()=>{
    loadPage(location.pathname);
});
</script>


<script>
function setActive(url){
    document.querySelectorAll('.nav a').forEach(a=>{
        a.classList.remove('active');
        if(a.getAttribute('href') === url){
            a.classList.add('active');
        }
    });
}
</script>


<script>
function panelUrl(panel){
    switch(panel){
        case 'kb': return '/resolution-library';
        case 'devices': return '/devices';
        case 'vendors': return '/vendors';
        case 'analytics': return '/analytics';
        case 'sla': return '/sla-dashboard';
        case 'help': return '/help';
        default: return null;
    }
}

function setActiveByPanel(panel){
    document.querySelectorAll('.nav a').forEach(a => a.classList.remove('active'));

    const hrefMap = {
        'kb': '/problem-logs?panel=kb',
        'devices': '/problem-logs?panel=devices',
        'vendors': '/problem-logs?panel=vendors',
        'analytics': '/problem-logs?panel=analytics',
        'sla': '/problem-logs?panel=sla',
        'help': '/problem-logs?panel=help',
        'dashboard': '/problem-logs'
    };

    const target = document.querySelector('.nav a[href="' + hrefMap[panel] + '"]');
    if (target) target.classList.add('active');
}

const dashboardHtml = document.getElementById('app-content').innerHTML;

function loadPanel(panel, push=true){
    if (!panel || panel === 'dashboard'){
        document.getElementById('app-content').innerHTML = dashboardHtml;
        setActiveByPanel('dashboard');
        if (typeof animateAllMetrics === 'function') { animateAllMetrics(document.getElementById('app-content')); }
        if (push) history.pushState({}, '', '/problem-logs');
        return;
    }

    const url = panelUrl(panel);
    if (!url) return;

    document.getElementById('app-content').innerHTML = '<div style="padding:24px;color:white;">Loading...</div>';

    fetch(url, {headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(r => r.text())
    .then(html => {
        const doc = new DOMParser().parseFromString(html, 'text/html');
        const content =
            doc.querySelector('.spa-view') ||
            doc.querySelector('.kb-view') ||
            doc.querySelector('.page-content') ||
            doc.querySelector('main') ||
            doc.body;

        document.getElementById('app-content').innerHTML = content.innerHTML;
        setActiveByPanel(panel);
        if (push) history.pushState({}, '', '/problem-logs?panel=' + panel);
        window.scrollTo({top:0, behavior:'smooth'});
    })
    .catch(() => {
        document.getElementById('app-content').innerHTML = '<div style="padding:24px;color:white;">Failed to load panel.</div>';
    });
}

document.querySelectorAll('.nav a').forEach(a => {
    a.addEventListener('click', function(e){
        const href = this.getAttribute('href');
        if (!href.startsWith('/problem-logs')) return;

        const u = new URL(href, window.location.origin);
        const panel = u.searchParams.get('panel') || 'dashboard';

        e.preventDefault();
        loadPanel(panel, true);
    });
});

window.addEventListener('popstate', function(){
    const panel = new URL(window.location.href).searchParams.get('panel') || 'dashboard';
    loadPanel(panel, false);
});

(function init(){
    const panel = new URL(window.location.href).searchParams.get('panel') || 'dashboard';
    if (panel !== 'dashboard') {
        loadPanel(panel, false);
    } else {
        setActiveByPanel('dashboard');
    }
})();
</script>





<script>
function animateMetric(el){
    const raw = el.getAttribute('data-target');
    const target = parseInt(raw ?? el.textContent ?? '0', 10);

    if (Number.isNaN(target)) return;

    const duration = 900;
    const start = performance.now();

    el.textContent = '0';

    function step(now){
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const value = Math.round(target * eased);
        el.textContent = String(value);

        if(progress < 1){
            requestAnimationFrame(step);
        } else {
            el.textContent = String(target);
        }
    }

    requestAnimationFrame(step);
}

function animateAllMetrics(scope){
    const root = scope || document;
    root.querySelectorAll('.metric-value[data-target]').forEach((el, index) => {
        setTimeout(() => animateMetric(el), index * 120);
    });
}

document.addEventListener('DOMContentLoaded', function(){
    animateAllMetrics(document);
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function(){

    const toggle = document.getElementById('sidebarToggle');

    if(!toggle) return;

    // load state
    if(localStorage.getItem('sidebar-collapsed') === '1'){
        document.body.classList.add('sidebar-collapsed');
    }

    toggle.addEventListener('click', function(){
        document.body.classList.toggle('sidebar-collapsed');

        if(document.body.classList.contains('sidebar-collapsed')){
            localStorage.setItem('sidebar-collapsed', '1');
        } else {
            localStorage.setItem('sidebar-collapsed', '0');
        }
    });

});
</script>

</body>
</html>
