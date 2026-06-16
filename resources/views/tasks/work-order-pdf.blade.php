<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Work Order {{ $task->work_order_no ?? $task->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; color: #111827; margin: 32px; }
        .header { display: flex; justify-content: space-between; border-bottom: 3px solid #ff8a00; padding-bottom: 18px; margin-bottom: 24px; }
        .brand { font-size: 26px; font-weight: 900; }
        .muted { color: #64748b; font-size: 13px; }
        .box { border: 1px solid #e5e7eb; border-radius: 14px; padding: 18px; margin-bottom: 16px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .label { font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; }
        .value { font-size: 15px; font-weight: 700; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border-bottom: 1px solid #e5e7eb; padding: 10px; text-align: left; font-size: 13px; }
        th { background: #f8fafc; color: #64748b; }
        .sign { height: 90px; border-bottom: 1px solid #111827; margin-top: 40px; }
        @media print { .no-print { display: none; } body { margin: 16px; } }
    </style>
</head>
<body>
    <button onclick="window.print()" class="no-print" style="padding:10px 16px;background:#ff8a00;border:0;border-radius:10px;font-weight:800;margin-bottom:20px;">Print / Save PDF</button>

    <div class="header">
        <div>
            <div class="brand">SSI Work Order</div>
            <div class="muted">Service Management Platform</div>
        </div>
        <div style="text-align:right">
            <div class="label">Work Order No</div>
            <div class="value">{{ $task->work_order_no ?? 'WO-'.$task->id }}</div>
            <div class="muted">{{ now()->format('d M Y H:i') }}</div>
        </div>
    </div>

    <div class="grid">
        <div class="box">
            <div class="label">Customer</div>
            <div class="value">{{ $task->customer?->name ?? '-' }}</div>
            <br>
            <div class="label">Branch / Site</div>
            <div class="value">{{ $task->branch?->name ?? '-' }}</div>
        </div>
        <div class="box">
            <div class="label">Engineer</div>
            <div class="value">{{ $task->assignee?->name ?? $task->engineer?->name ?? '-' }}</div>
            <br>
            <div class="label">Status</div>
            <div class="value">{{ ucfirst(str_replace('_',' ', $task->status ?? '-')) }}</div>
        </div>
    </div>

    <div class="box">
        <div class="label">Task Title</div>
        <div class="value">{{ $task->title ?? '-' }}</div>
        <br>
        <div class="label">Description</div>
        <div>{{ $task->description ?? $task->notes ?? '-' }}</div>
    </div>

    <div class="box">
        <div class="label">Asset</div>
        <div class="value">{{ $task->asset?->name ?? '-' }}</div>
        <div class="muted">
            Code: {{ $task->asset?->asset_code ?? '-' }} |
            Serial: {{ $task->asset?->serial_number ?? '-' }}
        </div>
    </div>

    <div class="box">
        <div class="label">Work Updates</div>
        <table>
            <thead>
                <tr><th>Date</th><th>Status</th><th>Note</th></tr>
            </thead>
            <tbody>
                @forelse(($task->updates ?? collect()) as $update)
                    <tr>
                        <td>{{ $update->created_at?->format('d M Y H:i') }}</td>
                        <td>{{ $update->status ?? '-' }}</td>
                        <td>{{ $update->note ?? $update->description ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">No updates.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="grid">
        <div>
            <div class="label">Engineer Signature</div>
            <div class="sign"></div>
        </div>
        <div>
            <div class="label">Customer Sign-Off</div>
            <div class="sign"></div>
        </div>
    </div>
</body>
</html>
