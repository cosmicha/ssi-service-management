
<div class="spa-view">
    
    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="brand">
                        <span class="brand-mark">SLA</span>
                        GLOBAL MONITORING
                    </div>
                    <h2>SLA Dashboard</h2>
                    <p>Real-time operational visibility for all tickets, with correct final SLA states after acknowledge and close events.</p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">Back to Dashboard</a>
                    <a href="/problem-logs/export" class="btn btn-primary">Export</a>
                </div>
            </div>

            <div class="summary">
                <div class="summary-card total">
                    <div class="summary-label">Total</div>
                    <div class="summary-value">{{ $summary['total'] }}</div>
                </div>
                <div class="summary-card safe">
                    <div class="summary-label">Safe</div>
                    <div class="summary-value">{{ $summary['safe'] }}</div>
                </div>
                <div class="summary-card warning">
                    <div class="summary-label">Warning</div>
                    <div class="summary-value">{{ $summary['warning'] }}</div>
                </div>
                <div class="summary-card breach">
                    <div class="summary-label">Breach</div>
                    <div class="summary-value">{{ $summary['breach'] }}</div>
                </div>
                <div class="summary-card na">
                    <div class="summary-label">No SLA</div>
                    <div class="summary-value">{{ $summary['na'] }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="toolbar">
                <div>
                    <div class="card-title">Live SLA Ticket Board</div>
                    <div class="muted">Response SLA stops after acknowledge. Resolution SLA stops after close. Rows are clickable.</div>
                </div>
                <div class="live-chip" id="liveRefreshText">Auto refresh: 30s</div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Ticket</th>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Engineer</th>
                            <th>Status</th>
                            <th>Response SLA</th>
                            <th>Resolution SLA</th>
                            <th>Overall</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($logs as $log)
                        <tr class="row-link row-{{ $log->sla_state }}" onclick="window.location='/problem-logs/{{ $log->id }}'">
                            <td>{{ $log->ticket_number ?: ('TICKET-' . $log->id) }}</td>
                            <td>{{ $log->title }}</td>
                            <td>{{ $log->company->name ?? '-' }}</td>
                            <td>{{ optional($log->assignedEngineer)->name ?? $log->engineer_name ?? '-' }}</td>
                            <td class="status">{{ ucfirst(str_replace('_', ' ', $log->status ?? '-')) }}</td>

                            <td>
                                @if($log->response_sla_state === 'breach')
                                    <span class="pill pill-breach">Breach</span>
                                @elseif($log->response_sla_state === 'warning')
                                    <span class="pill pill-warning">{{ $log->response_sla_label }}</span>
                                @elseif($log->response_sla_state === 'counting')
                                    <span class="pill pill-safe">{{ $log->response_sla_label }}</span>
                                @elseif($log->response_sla_state === 'ontime')
                                    <span class="pill pill-safe">On Time</span>
                                @else
                                    <span class="pill pill-na">N/A</span>
                                @endif
                            </td>

                            <td>
                                @if($log->resolution_sla_state === 'breach')
                                    <span class="pill pill-breach">Breach</span>
                                @elseif($log->resolution_sla_state === 'warning')
                                    <span class="pill pill-warning">{{ $log->resolution_sla_label }}</span>
                                @elseif($log->resolution_sla_state === 'counting')
                                    <span class="pill pill-safe">{{ $log->resolution_sla_label }}</span>
                                @elseif($log->resolution_sla_state === 'ontime')
                                    <span class="pill pill-safe">On Time</span>
                                @else
                                    <span class="pill pill-na">N/A</span>
                                @endif
                            </td>

                            <td>
                                @if($log->sla_state === 'breach')
                                    <span class="pill pill-breach">Breach</span>
                                @elseif($log->sla_state === 'warning')
                                    <span class="pill pill-warning">Warning</span>
                                @elseif($log->sla_state === 'safe')
                                    <span class="pill pill-safe">Safe</span>
                                @else
                                    <span class="pill pill-na">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        let countdown = 30;
        const chip = document.getElementById('liveRefreshText');

        setInterval(() => {
            countdown--;
            if (countdown <= 0) {
                chip.textContent = 'Refreshing...';
                window.location.reload();
                return;
            }
            chip.textContent = `Auto refresh: ${countdown}s`;
        }, 1000);
    </script>

</div>
