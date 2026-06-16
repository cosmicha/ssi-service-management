<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $task->task_no }} Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        .header { border-bottom: 3px solid #ff8a00; padding-bottom: 16px; margin-bottom: 24px; }
        .title { font-size: 24px; font-weight: bold; }
        .muted { color: #6b7280; }
        .section { margin-top: 24px; }
        .section-title { font-size: 16px; font-weight: bold; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #e5e7eb; padding: 8px; vertical-align: top; }
        th { background: #f3f4f6; text-align: left; }
        .badge { display:inline-block; padding:4px 8px; background:#ff8a00; color:#fff; border-radius:4px; font-weight:bold; }
    </style>
</head>
<body>

<div class="header">
    <div class="title">{{ $setting->company_name ?? 'SSI' }}</div>
    <div class="muted">{{ $setting->app_name ?? 'Service Management' }} - Work Order Report</div>
</div>

<div class="section">
    <div class="section-title">Task Information</div>
    <table>
        <tr><th>Task No</th><td>{{ $task->task_no }}</td></tr>
        <tr><th>Title</th><td>{{ $task->title }}</td></tr>
        <tr><th>Status</th><td><span class="badge">{{ strtoupper(str_replace('_',' ', $task->status)) }}</span></td></tr>
        <tr><th>Priority</th><td>{{ ucfirst($task->priority ?? '-') }}</td></tr>
        <tr><th>Engineer</th><td>{{ $task->assignee?->name ?? '-' }}</td></tr>
        <tr><th>Customer</th><td>{{ $task->customer?->name ?? '-' }}</td></tr>
        <tr><th>Branch</th><td>{{ $task->branch?->name ?? '-' }}</td></tr>
        <tr><th>Asset</th><td>{{ $task->asset?->asset_code }} - {{ $task->asset?->name }}</td></tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Schedule & Execution</div>
    <table>
        <tr><th>Planned Start</th><td>{{ $task->planned_start_at?->format('d M Y H:i') ?? '-' }}</td></tr>
        <tr><th>Planned Finish</th><td>{{ $task->planned_finish_at?->format('d M Y H:i') ?? '-' }}</td></tr>
        <tr><th>Actual Start</th><td>{{ $task->actual_start_at?->format('d M Y H:i') ?? '-' }}</td></tr>
        <tr><th>Actual Finish</th><td>{{ $task->actual_finish_at?->format('d M Y H:i') ?? '-' }}</td></tr>
    </table>
</div>

<div class="section">
    <div class="section-title">Used Parts</div>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Location</th>
                <th>Qty</th>
                <th>Unit Cost</th>
            </tr>
        </thead>
        <tbody>
            @forelse($task->partUsages as $usage)
                <tr>
                    <td>{{ $usage->item?->name }}</td>
                    <td>{{ $usage->location?->name ?? '-' }}</td>
                    <td>{{ $usage->quantity }}</td>
                    <td>Rp {{ number_format($usage->unit_cost,0,',','.') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No parts used.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="section">
    <div class="section-title">Customer Sign-Off</div>
    <table>
        <tr><th>Name</th><td>{{ $task->customer_signoff_name ?? '-' }}</td></tr>
        <tr><th>Signed At</th><td>{{ $task->customer_signed_at?->format('d M Y H:i') ?? '-' }}</td></tr>
        <tr><th>Notes</th><td>{{ $task->customer_signoff_notes ?? '-' }}</td></tr>
    </table>
</div>

</body>
</html>
