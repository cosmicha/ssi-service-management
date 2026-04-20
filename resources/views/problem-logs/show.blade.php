<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Detail</title>
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
            max-width: 1380px;
            margin: 0 auto;
            padding: 16px 16px 60px;
        }
        .hero {
            color: white;
            padding: 28px 30px 36px;
            border-radius: 28px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.96), rgba(29, 78, 216, 0.88));
            box-shadow: 0 18px 50px rgba(2, 6, 23, 0.28);
            margin-bottom: 28px;
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
            margin-bottom: 14px;
        }
        .brand-mark {
            width: 38px;
            height: 38px;
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
            font-size: 34px;
            line-height: 1.1;
        }
        .hero p {
            margin: 0;
            color: rgba(255,255,255,0.8);
            max-width: 760px;
            font-size: 15px;
        }
        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 16px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }
        .btn-primary { background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; box-shadow: 0 10px 24px rgba(37, 99, 235, 0.35); }
        .btn-secondary { background: rgba(255,255,255,0.10); color: white; border: 1px solid rgba(255,255,255,0.16); }
        .btn-success { background: #16a34a; color: white; }
        .btn-warning { background: #d97706; color: white; }
        .btn-danger { background: #dc2626; color: white; }

        .grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 20px;
        }
        .stack {
            display: grid;
            gap: 20px;
        }
        .card {
            background: rgba(255,255,255,0.92);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid rgba(148, 163, 184, 0.18);
        }
        .section-title {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 10px;
        }
        .muted {
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }
        .meta-box {
            border-radius: 18px;
            background: #f8fbff;
            border: 1px solid #dbeafe;
            padding: 16px;
        }
        .meta-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            margin-bottom: 8px;
            font-weight: 800;
        }
        .meta-value {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.6;
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
        .badge-low { background: #e5e7eb; color: #374151; }
        .badge-medium { background: #dbeafe; color: #1d4ed8; }
        .badge-high { background: #fee2e2; color: #b91c1c; }
        .badge-sla-ok { background: #dcfce7; color: #15803d; }
        .badge-sla-breach { background: #fee2e2; color: #b91c1c; }
        .badge-sla-none { background: #e5e7eb; color: #374151; }

        .photo {
            width: 100%;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
        }
        .empty-box {
            border-radius: 18px;
            padding: 24px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            color: #64748b;
            text-align: center;
        }
        .form-group { margin-bottom: 16px; }
        .label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }
        .input, .select, .textarea {
            width: 100%;
            padding: 12px 14px;
            border-radius: 14px;
            border: 1px solid #cbd5e1;
            background: white;
            font-size: 14px;
            color: #0f172a;
            outline: none;
        }
        .textarea {
            min-height: 110px;
            resize: vertical;
        }
        .timeline {
            display: grid;
            gap: 14px;
        }
        .timeline-item {
            padding: 16px 18px;
            border-radius: 18px;
            background: #f8fbff;
            border: 1px solid #dbeafe;
        }
        .timeline-top {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            margin-bottom: 8px;
            flex-wrap: wrap;
        }
        .timeline-title {
            font-weight: 800;
            color: #0f172a;
        }
        .timeline-time {
            font-size: 12px;
            color: #64748b;
            font-weight: 700;
        }
        .timeline-body {
            color: #475569;
            font-size: 14px;
            line-height: 1.7;
            white-space: pre-wrap;
        }
        .alert-success {
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 16px;
            background: #ecfdf5;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-weight: 600;
        }

        @media (max-width: 980px) {
            .grid { grid-template-columns: 1fr; }
            .meta-grid { grid-template-columns: 1fr; }
        }
    </style>

<style>
.progress-bar {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}

.step {
    text-align: center;
    flex: 1;
    position: relative;
}

.step:not(:last-child)::after {
    content: '';
    position: absolute;
    top: 18px;
    left: 50%;
    width: 100%;
    height: 4px;
    background: #334155;
    z-index: 0;
}

.step.active:not(:last-child)::after {
    background: #22c55e;
}

.circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #334155;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    z-index: 1;
    position: relative;
}

.step.active .circle {
    background: #22c55e;
}

.label {
    margin-top: 8px;
    font-size: 12px;
}
</style>

</head>
<body>
    @php
        $currentUser = auth()->user();
        $currentRole = $currentUser->role ?? '';
        $isAssignedToCurrentEngineer = ($currentRole === 'engineer' && (int)($problemLog->assigned_engineer_id ?? 0) === (int)($currentUser->id ?? 0));
        $isUnassignedOpen = (($problemLog->status ?? 'open') === 'open' && empty($problemLog->assigned_engineer_id));
        $isAssignedOpenToCurrentEngineer = (($problemLog->status ?? 'open') === 'open' && $isAssignedToCurrentEngineer);
    @endphp

    <div class="page">
        @if($problemLog->status === 'closed')
            <div style="
                background:#1e293b;
                color:white;
                padding:14px 16px;
                border-radius:12px;
                margin-bottom:18px;
                font-weight:700;
            ">
                🔒 Ticket Closed — only admin can edit this ticket.
            </div>
        @endif
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="brand">
                        <span class="brand-mark">TK</span>
                        TICKET DETAIL
                    </div>
                    <h1>{{ $problemLog->title }}</h1>
                    <p>{{ $problemLog->description ?: 'No description provided.' }}</p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">Back to Dashboard</a>

                    @if(((method_exists($problemLog, 'normalizedStatus') ? $problemLog->normalizedStatus() : $problemLog->status) !== 'closed') || ($currentUser->role ?? '') === 'admin')
                        <a href="/problem-logs/{{ $problemLog->id }}/edit" class="btn btn-secondary">Edit Ticket</a>
                    @endif

                    @if(($currentUser->role ?? '') === 'admin')
                        <form method="POST"
                              action="/problem-logs/delete/{{ $problemLog->id }}"
                              onsubmit="return confirm('Delete this ticket permanently? This action cannot be undone.');"
                              style="display:inline-flex; margin:0;">
                            @csrf
                            <button type="submit" class="btn btn-danger" style="border:none; cursor:pointer;">Delete Ticket</button>
                        



</form>
                    @endif
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="grid">
            <div class="stack">
                <div class="card">
                    <div class="section-title">Ticket Information</div>
                    <div class="meta-grid">
                        <div class="meta-box">
                            <div class="meta-label">Ticket Number</div>
                            <div class="meta-value">{{ $problemLog->ticket_number ?: '-' }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Company</div>
                            <div class="meta-value">{{ optional($problemLog->company)->name ?? '-' }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Status</div>
                            <div class="meta-value">
                                @if($problemLog->status === 'open')
                                    <span class="badge badge-open">Open</span>
                                @elseif($problemLog->status === 'in_progress')
                                    <span class="badge badge-progress">In Progress</span>
                                @else
                                    <span class="badge badge-closed">Closed</span>
                                @endif
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Priority</div>
                            <div class="meta-value">
                                @if($problemLog->priority === 'high')
                                    <span class="badge badge-high">High</span>
                                @elseif($problemLog->priority === 'medium')
                                    <span class="badge badge-medium">Medium</span>
                                @else
                                    <span class="badge badge-low">Low</span>
                                @endif
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Assigned Engineer</div>
                            <div class="meta-value">{{ optional($problemLog->assignedEngineer)->name ?? $problemLog->engineer_name ?? 'Unassigned' }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Created By</div>
                            <div class="meta-value">{{ optional($problemLog->createdByUser)->name ?? '-' }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Created At</div>
                            <div class="meta-value">{{ $problemLog->created_at ? $problemLog->created_at->format('d M Y H:i') : '-' }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Acknowledged At</div>
                            <div class="meta-value">{{ $problemLog->acknowledged_at ? $problemLog->acknowledged_at->format('d M Y H:i') : '-' }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">In Progress At</div>
                            <div class="meta-value">{{ $problemLog->in_progress_at ? $problemLog->in_progress_at->format('d M Y H:i') : '-' }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Closed At</div>
                            <div class="meta-value">{{ $problemLog->closed_at ? $problemLog->closed_at->format('d M Y H:i') : '-' }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Configured Response Time</div>
                            <div class="meta-value">{{ method_exists($problemLog, 'responseSlaHours') ? $problemLog->responseSlaHours() : ($problemLog->company->sla_response_minutes ?? '-') }} hour(s)</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Configured Resolution Time</div>
                            <div class="meta-value">{{ method_exists($problemLog, 'resolutionSlaHours') ? $problemLog->resolutionSlaHours() : ($problemLog->company->sla_resolution_minutes ?? '-') }} hour(s)</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Response SLA</div>
                            <div class="meta-value">
                                @if($problemLog->responseSlaStatus() === 'breached')
                                    <span class="badge badge-sla-breach">Breach</span>
                                @elseif($problemLog->responseSlaStatus() === 'ok')
                                    <span class="badge badge-sla-ok">On Time</span>
                                @else
                                    <span class="badge badge-sla-none">N/A</span>
                                @endif
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Resolution SLA</div>
                            <div class="meta-value">
                                @if($problemLog->resolutionSlaStatus() === 'breached')
                                    <span class="badge badge-sla-breach">Breach</span>
                                @elseif($problemLog->resolutionSlaStatus() === 'ok')
                                    <span class="badge badge-sla-ok">On Time</span>
                                @else
                                    <span class="badge badge-sla-none">N/A</span>
                                @endif
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Response Time</div>
                            <div class="meta-value">{{ $problemLog->responseDurationText() }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Resolution Time</div>
                            <div class="meta-value">{{ $problemLog->resolutionDurationText() }}</div>
                        </div>
                    </div>
                </div>

                
                
                @if(($groupedAiSuggestions ?? collect())->count())
                <div class="card">
                    <div class="section-title">AI Suggested Resolutions</div>
                    <div class="muted">Suggested from similar known resolutions in the knowledge base.</div>

                    <div class="meta-grid">
                        @foreach(($groupedAiSuggestions ?? collect()) as $group)
                            @php
                                $suggestion = $group['primary'] ?? null;
                                $template = optional($suggestion)->resolutionTemplate;
                            @endphp

                            <div class="meta-box">
                                <div class="meta-label">Match Score</div>
                                <div class="meta-value">
                                    {{ number_format((optional($suggestion)->similarity_score ?? 0) * 100, 1) }}%
                                </div>

                                <div class="meta-label" style="margin-top:10px;">Suggested Resolution</div>
                                <div class="meta-value">
                                    @if($template)
                                        <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                                            <a href="{{ route('resolution-library.show', $template) }}?ticket_id={{ $problemLog->id }}"
                                               target="_blank"
                                               style="font-weight:800; color:#1d4ed8; text-decoration:none;">
                                                {{ $template->displayTitle() }}
                                            </a>

                                            <form method="POST"
                                                  action="{{ route('problem-logs.apply-resolution-template', ['problemLog' => $problemLog->id, 'resolutionTemplate' => $template->id]) }}"
                                                  style="display:inline-flex;">
                                                @csrf
                                                <button type="submit"
                                                        style="padding:7px 10px; border:none; border-radius:10px; background:#16a34a; color:white; font-weight:800; cursor:pointer;">
                                                    Problem Solved
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        -
                                    @endif
                                </div>

                                <div class="meta-label" style="margin-top:10px;">Matched Keywords</div>
                                <div class="meta-value">
                                    {{ optional($suggestion)->matched_keywords ?: '-' }}
                                </div>

                                <div class="meta-label" style="margin-top:10px;">Reason</div>
                                <div class="meta-value">
                                    {{ optional($suggestion)->suggestion_reason ?? '-' }}
                                </div>

                                @if(!empty($group['alternatives']) && count($group['alternatives']))
                                    <div class="meta-label" style="margin-top:10px;">Alternatives</div>
                                    <div class="meta-value">
                                        @foreach($group['alternatives'] as $alt)
                                            @if(optional($alt)->resolutionTemplate)
                                                <div style="margin-bottom:10px; padding-bottom:10px; border-bottom:1px solid #e5e7eb;">
                                                    <div style="display:flex; gap:8px; flex-wrap:wrap; align-items:center;">
                                                        <a href="{{ route('resolution-library.show', $alt->resolutionTemplate) }}?ticket_id={{ $problemLog->id }}"
                                                           target="_blank"
                                                           style="color:#1d4ed8; text-decoration:none;">
                                                            {{ $alt->resolutionTemplate->displayTitle() }}
                                                        </a>
                                                        <span style="color:#64748b;">
                                                            ({{ number_format(($alt->similarity_score ?? 0) * 100, 1) }}%)
                                                        </span>

                                                        <form method="POST"
                                                              action="{{ route('problem-logs.apply-resolution-template', ['problemLog' => $problemLog->id, 'resolutionTemplate' => $alt->resolutionTemplate->id]) }}"
                                                              style="display:inline-flex;">
                                                            @csrf
                                                            <button type="submit"
                                                                    style="padding:7px 10px; border:none; border-radius:10px; background:#16a34a; color:white; font-weight:800; cursor:pointer;">
                                                                Problem Solved
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

<div class="card">
                    <div class="section-title">Structured Ticket Summary</div>

                    <div class="meta-grid">
                        <div class="meta-box">
                            <div class="meta-label">Problem</div>
                            <div class="meta-value">{{ $problemLog->dashboardProblemSummary() }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Current Process</div>
                            <div class="meta-value">{{ $problemLog->dashboardCurrentProcess() }}</div>
                        </div>

                        <div class="meta-box">
                            <div class="meta-label">Reusable Resolution (Knowledge Base)</div>
                            <div class="meta-value">{{ $problemLog->dashboardResolutionSummary() }}</div>
                        </div>
                    </div>
                </div>

<div class="card">
                    <div class="section-title">Progress Timeline</div>
                    <div class="muted">Complete history of activities and updates related to this ticket.</div>

                    <div class="timeline">
                        @forelse($problemLog->updates as $update)
                            <div class="timeline-item">
                                <div class="timeline-top">
                                    <div class="timeline-title">
                                        {{ $update->action ?? 'Update' }}
                                        @if(optional($update->user)->name)
                                            — {{ optional($update->user)->name }}
                                        @endif
                                    </div>
                                    <div class="timeline-time">
                                        {{ $update->created_at ? $update->created_at->format('d M Y H:i') : '-' }}
                                    </div>
                                </div>
                                <div class="timeline-body">
                                    <strong>{{ ucfirst(str_replace('_', ' ', $update->action ?? 'update')) }}</strong><br>
                                    {{ $update->message ?? '-' }}
                                </div>
                            </div>
                        @empty
                            <div class="empty-box">No progress update yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="stack">
                <div class="card">
                    <div class="section-title">
                    {{ $problemLog->status === 'closed' ? 'SLA Summary' : 'SLA Countdown' }}
                </div>
                    <div class="muted">
                    {{ $problemLog->status === 'closed'
                        ? 'Final SLA result for response and resolution after the ticket was closed.'
                        : 'Live SLA timer and progress usage for response and resolution targets.' }}
                </div>

                    @php
                        $effectiveCompany = method_exists($problemLog, 'effectiveCompany') ? $problemLog->effectiveCompany() : $problemLog->company;
                        $responseHours = method_exists($problemLog, 'responseSlaHours') ? $problemLog->responseSlaHours() : ($effectiveCompany->sla_response_minutes ?? null);
                        $resolutionHours = method_exists($problemLog, 'resolutionSlaHours') ? $problemLog->resolutionSlaHours() : ($effectiveCompany->sla_resolution_minutes ?? null);

                        $createdTs = $problemLog->created_at ? $problemLog->created_at->timestamp : null;
                        $ackTs = $problemLog->acknowledged_at ? $problemLog->acknowledged_at->timestamp : null;
                        $closedTs = $problemLog->closed_at ? $problemLog->closed_at->timestamp : null;

                        $responseLimitMinutes = $responseHours ? ($responseHours * 60) : 0;
                        $resolutionLimitMinutes = $resolutionHours ? ($resolutionHours * 60) : 0;
                    @endphp

                    <style>
                        .sla-panel-wrap {
                            display: grid;
                            gap: 16px;
                        }
                        .sla-panel {
                            padding: 16px;
                            border-radius: 18px;
                            background: #f8fbff;
                            border: 1px solid #dbeafe;
                        }
                        .sla-panel-top {
                            display: flex;
                            justify-content: space-between;
                            gap: 12px;
                            align-items: center;
                            flex-wrap: wrap;
                            margin-bottom: 10px;
                        }
                        .sla-name {
                            font-size: 13px;
                            font-weight: 800;
                            text-transform: uppercase;
                            letter-spacing: .08em;
                            color: #64748b;
                        }
                        .sla-time {
                            font-size: 18px;
                            font-weight: 900;
                            line-height: 1.3;
                        }
                        .sla-meta {
                            font-size: 13px;
                            color: #64748b;
                            margin-bottom: 10px;
                        }
                        .sla-progress {
                            width: 100%;
                            height: 14px;
                            background: #e5e7eb;
                            border-radius: 999px;
                            overflow: hidden;
                            position: relative;
                        }
                        .sla-progress-bar {
                            height: 100%;
                            width: 0%;
                            border-radius: 999px;
                            transition: width 1s linear, background-color .2s ease;
                        }
                        .sla-progress-label {
                            margin-top: 8px;
                            font-size: 12px;
                            font-weight: 700;
                            color: #475569;
                        }
                        .sla-safe .sla-time { color: #15803d; }
                        .sla-warning .sla-time { color: #b45309; }
                        .sla-breached .sla-time { color: #b91c1c; }

                        .sla-safe .sla-progress-bar { background: #22c55e; }
                        .sla-warning .sla-progress-bar { background: #f59e0b; }
                        .sla-breached .sla-progress-bar { background: #ef4444; }
                    </style>

                    <div class="sla-panel-wrap">
                        <div class="sla-panel"
                             id="responseSlaPanel"
                             data-created-at="{{ $createdTs }}"
                             data-ended-at="{{ $ackTs }}"
                             data-limit-minutes="{{ $responseLimitMinutes }}">
                            <div class="sla-panel-top">
                                <div class="sla-name">Response SLA</div>
                                <div class="sla-time" id="responseSlaTime">
                                    @if($problemLog->acknowledged_at || $problemLog->status === 'closed')
                                        @if($problemLog->responseSlaStatus() === 'breached')
                                            Breach
                                        @elseif($problemLog->responseSlaStatus() === 'ok')
                                            On Time
                                        @else
                                            N/A
                                        @endif
                                    @else
                                        Calculating...
                                    @endif
                                </div>
                            </div>
                            <div class="sla-meta">Target: {{ $responseHours ?: '-' }} hour(s)</div>
                            @if(!$problemLog->acknowledged_at && ((method_exists($problemLog, 'normalizedStatus') ? $problemLog->normalizedStatus() : $problemLog->status) !== 'closed'))
                                <div class="sla-progress">
                                    <div class="sla-progress-bar" id="responseSlaBar"></div>
                                </div>
                            @endif
                            <div class="sla-progress-label" id="responseSlaLabel">
                                @if($problemLog->acknowledged_at || $problemLog->status === 'closed')
                                    Final response time: {{ $problemLog->responseDurationText() }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>

                        <div class="sla-panel"
                             id="resolutionSlaPanel"
                             data-created-at="{{ $createdTs }}"
                             data-ended-at="{{ $closedTs }}"
                             data-limit-minutes="{{ $resolutionLimitMinutes }}">
                            <div class="sla-panel-top">
                                <div class="sla-name">Resolution SLA</div>
                                <div class="sla-time" id="resolutionSlaTime">
                                    @if($problemLog->status === 'closed')
                                        @if($problemLog->resolutionSlaStatus() === 'breached')
                                            Breached
                                        @elseif($problemLog->resolutionSlaStatus() === 'ok')
                                            On Time
                                        @else
                                            N/A
                                        @endif
                                    @else
                                        Calculating...
                                    @endif
                                </div>
                            </div>
                            <div class="sla-meta">Target: {{ $resolutionHours ?: '-' }} hour(s)</div>
                            @if(((method_exists($problemLog, 'normalizedStatus') ? $problemLog->normalizedStatus() : $problemLog->status) !== 'closed'))
                                <div class="sla-progress">
                                    <div class="sla-progress-bar" id="resolutionSlaBar"></div>
                                </div>
                            @endif
                            <div class="sla-progress-label" id="resolutionSlaLabel">
                                @if($problemLog->status === 'closed')
                                    Final resolution time: {{ $problemLog->resolutionDurationText() }}
                                @else
                                    -
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="section-title">Problem Photo</div>
                    @if($problemLog->photo)
                        <img src="{{ url('/storage/' . $problemLog->photo) }}" alt="Problem Photo" class="photo">
                    @else
                        <div class="empty-box">No photo uploaded.</div>
                    @endif
                </div>

                <div class="card">
                    <div class="section-title">Closed Photo</div>
                    @if($problemLog->closed_photo)
                        <img src="{{ url('/storage/' . $problemLog->closed_photo) }}" alt="Closed Photo" class="photo">
                    @else
                        <div class="empty-box">No closed photo uploaded.</div>
                    @endif
                </div>

                @if($currentRole === 'admin' && ((method_exists($problemLog, 'normalizedStatus') ? $problemLog->normalizedStatus() : $problemLog->status) !== 'closed'))
                    <div class="card">
                        <div class="section-title">Assign Engineer</div>
                        <form method="POST" action="/problem-logs/{{ $problemLog->id }}/assign-engineer">
                            @csrf
                            <div class="form-group">
                                <label class="label">Engineer</label>
                                <select name="assigned_engineer_id" class="select" required>
                                    <option value="">Select Engineer</option>
                                    @foreach($engineers as $engineer)
                                        <option value="{{ $engineer->id }}" {{ $problemLog->assigned_engineer_id == $engineer->id ? 'selected' : '' }}>
                                            {{ $engineer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Assign Engineer</button>
                        </form>
                    </div>

                    @if(($problemLog->status ?? 'open') === 'open')
                        <div class="card">
                            <div class="section-title">Acknowledge Ticket</div>
                            <div class="muted">Admin can acknowledge the ticket to move it into progress.</div>
                            <form method="POST" action="/problem-logs/{{ $problemLog->id }}/acknowledge">
                                @csrf
                                <button type="submit" class="btn btn-warning">Acknowledge</button>
                            </form>
                        </div>
                    @endif
                @endif

                @if($currentRole === 'engineer' && ((method_exists($problemLog, 'normalizedStatus') ? $problemLog->normalizedStatus() : $problemLog->status) !== 'closed') && $isUnassignedOpen)
                    <div class="card">
                        <div class="section-title">Acknowledge Ticket</div>
                        <div class="muted">This ticket is still open and unassigned. Acknowledging it will also claim the ticket for you.</div>
                        <form method="POST" action="/problem-logs/{{ $problemLog->id }}/acknowledge">
                            @csrf
                            <button type="submit" class="btn btn-warning">Acknowledge & Claim</button>
                        </form>
                    </div>
                @endif

                @if($currentRole === 'engineer' && ((method_exists($problemLog, 'normalizedStatus') ? $problemLog->normalizedStatus() : $problemLog->status) !== 'closed') && $isAssignedOpenToCurrentEngineer)
                    <div class="card">
                        <div class="section-title">Take Ticket</div>
                        <div class="muted">This ticket is assigned to you. Taking it will automatically acknowledge the ticket and move it into progress.</div>
                        <form method="POST" action="/problem-logs/{{ $problemLog->id }}/take-ticket">
                            @csrf
                            <button type="submit" class="btn btn-warning">Take Ticket</button>
                        </form>
                    </div>
                @endif

                @if(($currentUser->role ?? '') !== 'customer')
                    

<div class="card">
                    <div class="section-title">Ticket Progress</div>

    @php
        $statusMap = [
            'open' => 1,
            'acknowledged' => 2,
            'in_progress' => 3,
            'closed' => 4
        ];

        $currentStep = $statusMap[$problemLog->status] ?? 1;
    @endphp

    <div class="progress-bar">
        @foreach(['Open','Acknowledged','In Progress','Closed'] as $i => $label)
            @php $step = $i + 1; @endphp

            <div class="step {{ $currentStep >= $step ? 'active' : '' }}">
                <div class="circle">{{ $step }}</div>
                <div class="label">{{ $label }}</div>
            </div>
        @endforeach
    </div>
</div>
<div class="card">
                        <div class="section-title">Add Progress Update</div>
                        <form method="POST" action="/problem-logs/{{ $problemLog->id }}/updates">
                            @csrf
                            <div class="form-group">
                                <label class="label">Update Message</label>
                                <textarea name="message" class="textarea" placeholder="Example: On site checking device, found unstable power connection, temporary fix applied." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Update</button>
                        </form>
                    </div>

                    <div class="card">
                        <div id="close-ticket"></div>
<div class="section-title">Close Ticket</div>
                        <form method="POST" action="/problem-logs/{{ $problemLog->id }}/close" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="label">Resolution</label>
                                                        <input type="hidden" name="selected_resolution_template_id" id="selectedResolutionTemplateId" value="{{ old('selected_resolution_template_id', session('prefill_template_id', '')) }}">
<textarea name="close_note" class="textarea" placeholder="Describe the resolution taken.">{{ old('close_note', session('prefill_close_note', '')) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="label">Closed Photo</label>
                                <input type="file" name="closed_photo" class="input" accept="image/*">
                            </div>
                            
                        <div class="field-group" style="margin-top:18px;">
<button type="submit" class="btn btn-success">Close Ticket</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function formatDuration(totalMinutes) {
            const abs = Math.abs(totalMinutes);
            const h = Math.floor(abs / 60);
            const m = abs % 60;
            return h > 0 ? `${h}h ${m}m` : `${m}m`;
        }

        function updateSlaPanel(panelId, timeId, barId, labelId) {
            const panel = document.getElementById(panelId);
            const timeEl = document.getElementById(timeId);
            const barEl = document.getElementById(barId);
            const labelEl = document.getElementById(labelId);

            if (!panel || !timeEl || !barEl || !labelEl) return;

            const createdAt = parseInt(panel.dataset.createdAt || '0', 10);
            const endedAt = parseInt(panel.dataset.endedAt || '0', 10);
            const limitMinutes = parseInt(panel.dataset.limitMinutes || '0', 10);

            panel.classList.remove('sla-safe', 'sla-warning', 'sla-breached');

            if (!createdAt || !limitMinutes) {
                timeEl.textContent = 'N/A';
                labelEl.textContent = 'No active SLA target';
                barEl.style.width = '0%';
                return;
            }

            const nowTs = Math.floor(Date.now() / 1000);
            const effectiveEnd = endedAt || nowTs;

            const elapsedMinutes = Math.max(0, Math.floor((effectiveEnd - createdAt) / 60));
            const remainingMinutes = limitMinutes - elapsedMinutes;

            let usedPercent = Math.round((elapsedMinutes / limitMinutes) * 100);
            if (usedPercent < 0) usedPercent = 0;
            if (usedPercent > 100) usedPercent = 100;

            barEl.style.width = `${usedPercent}%`;

            if (remainingMinutes < 0) {
                panel.classList.add('sla-breached');
                timeEl.textContent = `Breached by ${formatDuration(remainingMinutes)}`;
                labelEl.textContent = `${usedPercent}% of SLA consumed`;
            } else if (remainingMinutes <= Math.max(30, Math.floor(limitMinutes * 0.2))) {
                panel.classList.add('sla-warning');
                timeEl.textContent = `${formatDuration(remainingMinutes)} remaining`;
                labelEl.textContent = `${usedPercent}% of SLA consumed`;
            } else {
                panel.classList.add('sla-safe');
                timeEl.textContent = `${formatDuration(remainingMinutes)} remaining`;
                labelEl.textContent = `${usedPercent}% of SLA consumed`;
            }

            if (endedAt) {
                if (remainingMinutes < 0) {
                    timeEl.textContent += ' at stop time';
                } else {
                    timeEl.textContent += ' when stopped';
                }
            }
        }

        @if(!$problemLog->acknowledged_at && ((method_exists($problemLog, 'normalizedStatus') ? $problemLog->normalizedStatus() : $problemLog->status) !== 'closed'))
        updateSlaPanel('responseSlaPanel', 'responseSlaTime', 'responseSlaBar', 'responseSlaLabel');
        setInterval(() => {
            updateSlaPanel('responseSlaPanel', 'responseSlaTime', 'responseSlaBar', 'responseSlaLabel');
        }, 1000);
        @endif

        @if(((method_exists($problemLog, 'normalizedStatus') ? $problemLog->normalizedStatus() : $problemLog->status) !== 'closed'))
        updateSlaPanel('resolutionSlaPanel', 'resolutionSlaTime', 'resolutionSlaBar', 'resolutionSlaLabel');
        setInterval(() => {
            updateSlaPanel('resolutionSlaPanel', 'resolutionSlaTime', 'resolutionSlaBar', 'resolutionSlaLabel');
        }, 1000);
        @endif
    </script>




<script>
document.addEventListener('DOMContentLoaded', function () {
    const prefilled = @json(session('prefill_close_note'));
    if (prefilled) {
        const closeSection = document.getElementById('close-ticket');
        if (closeSection) {
            closeSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        const closeTextarea = document.querySelector('textarea[name="close_note"]');
        if (closeTextarea) {
            closeTextarea.style.borderColor = '#16a34a';
            closeTextarea.style.boxShadow = '0 0 0 4px rgba(22,163,74,.12)';
        }
    }
});
</script>
</body>
</html>
