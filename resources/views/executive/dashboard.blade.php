@extends('layouts.app')

@section('content')

<style>
.executive-wrap{
    padding:24px;
}

.executive-header{
    background:linear-gradient(135deg,#0f172a,#1e293b);
    color:white;
    border-radius:28px;
    padding:34px 38px;
    margin-bottom:26px;
    box-shadow:0 20px 45px rgba(15,23,42,.18);
}

.executive-header-title{
    font-size:28px;
    font-weight:900;
    margin-bottom:8px;
}

.executive-header-subtitle{
    color:rgba(255,255,255,.72);
    font-size:17px;
}

.executive-date{
    font-size:36px;
    font-weight:900;
    margin-top:8px;
}

.executive-kpi-grid{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:16px;
    margin-bottom:24px;
}

.executive-card{
    background:white;
    border-radius:22px;
    padding:22px;
    box-shadow:0 14px 34px rgba(15,23,42,.08);
    border:1px solid #eef2f7;
    min-height:128px;
}

.kpi-label{
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:1.3px;
    color:#64748b;
    font-weight:800;
    margin-bottom:14px;
}

.kpi-value{
    font-size:40px;
    line-height:1;
    font-weight:950;
    color:#0f172a;
}

.kpi-money{
    font-size:24px;
    line-height:1.15;
    font-weight:950;
    color:#0f172a;
}

.executive-chart-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:20px;
    margin-top:22px;
}

.executive-bottom-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-top:22px;
}

.panel{
    background:white;
    border-radius:24px;
    padding:22px;
    box-shadow:0 14px 34px rgba(15,23,42,.08);
    border:1px solid #eef2f7;
}

.panel-title{
    font-size:18px;
    font-weight:900;
    color:#0f172a;
    margin-bottom:18px;
}

.executive-table{
    width:100%;
    border-collapse:collapse;
}

.executive-table td{
    padding:14px 0;
    border-bottom:1px solid #eef2f7;
    color:#0f172a;
    font-weight:700;
}

.executive-table td:last-child{
    text-align:right;
    color:#64748b;
}

@media(max-width:1400px){
    .executive-kpi-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }
}

@media(max-width:900px){
    .executive-kpi-grid,
    .executive-chart-grid,
    .executive-bottom-grid{
        grid-template-columns:1fr;
    }

    .executive-header{
        padding:26px;
    }
}
</style>

<div class="executive-wrap">

    <div class="executive-header">
        <div style="display:flex;justify-content:space-between;gap:24px;align-items:flex-start;flex-wrap:wrap;">
            <div>
                <div class="executive-header-title">
                    SSI Service Operations Center
                </div>
                <div class="executive-header-subtitle">
                    Real-Time Operational Visibility & Service Performance Dashboard
                </div>
            </div>

            <div style="text-align:right;">
                <div style="font-size:13px;color:rgba(255,255,255,.7);font-weight:800;letter-spacing:1px;text-transform:uppercase;">
                    Executive View
                </div>
                <div class="executive-date">
                    {{ now()->format('d M Y') }}
                </div>
            </div>
        </div>
    </div>

    <div class="panel" style="margin-bottom:22px;">
        <form method="GET" action="{{ route('executive.dashboard') }}" style="display:flex;gap:14px;align-items:end;flex-wrap:wrap;">
            <div style="min-width:280px;">
                <div class="kpi-label">Customer Filter</div>
                <select name="customer_id"
                        style="width:100%;border:1px solid #e2e8f0;border-radius:14px;padding:12px 14px;font-weight:700;">
                    <option value="">All Customers</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" @selected((string)$customerId === (string)$customer->id)>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button style="background:#ff8a00;color:#111827;border:0;border-radius:14px;padding:13px 22px;font-weight:900;">
                Apply
            </button>

            @if($customerId)
                <a href="{{ route('executive.dashboard') }}"
                   style="color:#64748b;text-decoration:none;font-weight:800;padding:13px 0;">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <div class="executive-kpi-grid">

        <div class="executive-card">
            <div class="kpi-label">Assets</div>
            <div class="kpi-value">{{ $assets }}</div>
        </div>

        <div class="executive-card">
            <div class="kpi-label">Open Incidents</div>
            <div class="kpi-value">{{ $openIncidents }}</div>
        </div>

        <div class="executive-card">
            <div class="kpi-label">Open Tasks</div>
            <div class="kpi-value">{{ $openTasks }}</div>
        </div>

        <div class="executive-card">
            <div class="kpi-label">PM Compliance</div>
            <div class="kpi-value">{{ $pmCompliance }}%</div>
        </div>

        <div class="executive-card">
            <div class="kpi-label">SLA Achievement</div>
            <div class="kpi-value">{{ $slaAchievement }}%</div>
        </div>

        <div class="executive-card">
            <div class="kpi-label">Inventory Value</div>
            <div class="kpi-money">
                Rp {{ number_format($inventoryValue,0,',','.') }}
            </div>
        </div>

        <div class="executive-card">
            <div class="kpi-label">MTTA</div>
            <div class="kpi-value">{{ $mtta }}</div>
        </div>

        <div class="executive-card">
            <div class="kpi-label">MTTR</div>
            <div class="kpi-value">{{ $mttr }}</div>
        </div>

    </div>

    <div class="executive-chart-grid">

        <div class="panel">
            <div class="panel-title">Incident Trend</div>
            <canvas id="incidentTrend" height="110"></canvas>
        </div>

        <div class="panel">
            <div class="panel-title">Incident Category</div>
            <canvas id="incidentCategory" height="220"></canvas>
        </div>

    </div>

    <div class="executive-bottom-grid">

        <div class="panel">
            <div class="panel-title">Top Problem Assets</div>
            <table class="executive-table">
                @forelse($topAssets as $assetName => $count)
                <tr>
                    <td>{{ $assetName }}</td>
                    <td>{{ $count }} incidents</td>
                </tr>
                @empty
                <tr>
                    <td>No asset incidents</td>
                    <td>-</td>
                </tr>
                @endforelse
            </table>
        </div>

        <div class="panel">
            <div class="panel-title">Engineer Performance</div>
            <table class="executive-table">
                @forelse($engineerPerformance as $engineerName => $score)
                <tr>
                    <td>{{ $engineerName }}</td>
                    <td>{{ $score }}%</td>
                </tr>
                @empty
                <tr>
                    <td>No engineer data</td>
                    <td>-</td>
                </tr>
                @endforelse
            </table>
        </div>

    </div>

    <div class="executive-bottom-grid">

        <div class="panel">
            <div class="panel-title">Customer Ranking by Incidents</div>
            <table class="executive-table">
                @forelse($customerRanking as $customerName => $count)
                <tr>
                    <td>{{ $customerName }}</td>
                    <td>{{ $count }} incidents</td>
                </tr>
                @empty
                <tr>
                    <td>No customer data</td>
                    <td>-</td>
                </tr>
                @endforelse
            </table>
        </div>

        <div class="panel">
            <div class="panel-title">Branch / Site Ranking</div>
            <table class="executive-table">
                @forelse($branchRanking as $branchName => $count)
                <tr>
                    <td>{{ $branchName }}</td>
                    <td>{{ $count }} incidents</td>
                </tr>
                @empty
                <tr>
                    <td>No branch data</td>
                    <td>-</td>
                </tr>
                @endforelse
            </table>
        </div>

    </div>


    <div class="panel" style="margin-top:22px;">

        <div class="panel-title">
            Critical Open Incidents
        </div>

        <table class="executive-table">

            @forelse($criticalIncidents as $incident)

            <tr>
                <td>
                    {{ $incident->incident_no ?? $incident->id }}
                    <br>
                    <small>
                        {{ $incident->title }}
                    </small>
                </td>

                <td>
                    {{ strtoupper($incident->severity ?? '-') }}
                </td>

                <td>
                    {{ $incident->customer?->name }}
                </td>

                <td>
                    {{ strtoupper($incident->status ?? '-') }}
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="4">
                    No critical incidents
                </td>
            </tr>

            @endforelse

        </table>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(
    document.getElementById('incidentTrend'),
    {
        type:'line',
        data:{
            labels:@json($incidentTrend->pluck('month')->map(fn($m) => DateTime::createFromFormat('!m', $m)->format('M'))->values()),
            datasets:[{
                label:'Incidents',
                data:@json($incidentTrend->pluck('total')->values()),
                tension:0.42,
                borderWidth:3,
                pointRadius:4
            }]
        },
        options:{
            responsive:true,
            plugins:{
                legend:{display:false}
            },
            scales:{
                y:{beginAtZero:true}
            }
        }
    }
);

new Chart(
    document.getElementById('incidentCategory'),
    {
        type:'doughnut',
        data:{
            labels:@json($incidentCategory->keys()->values()),
            datasets:[{
                data:@json($incidentCategory->values())
            }]
        },
        options:{
            responsive:true,
            plugins:{
                legend:{
                    position:'bottom'
                }
            }
        }
    }
);
</script>

@endsection
