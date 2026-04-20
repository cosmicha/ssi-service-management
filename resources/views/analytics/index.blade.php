
<div class="spa-view">
    
    @php
        $maxCompany = max(1, $byCompany->max('count') ?? 1);
        $maxEngineer = max(1, $byEngineer->max('count') ?? 1);
        $maxBreachCompany = max(1, $topBreachedCompanies->max('count') ?? 1);
        $maxTopEngineer = max(1, $topEngineers->max('count') ?? 1);
        $maxAging = max(1, max($agingBuckets));
        $maxMonthlyTickets = max(1, $monthlyTickets->max() ?? 1);
        $maxMonthlyClosed = max(1, $monthlyClosed->max() ?? 1);
        $maxMonthlyBreaches = max(1, $monthlyBreaches->max() ?? 1);
        $maxIssueCategory = max(1, $topIssueCategories->max() ?? 1);
    @endphp

    <div class="page">
        <div class="hero">
            <div class="hero-top">
                <div>
                    <div class="brand">
                        <span class="brand-mark">AN</span>
                        ANALYTICS DASHBOARD
                    </div>
                    <h1>Executive Operations Analytics</h1>
                    <p>Board-level visibility into ticket volume, SLA risk, aging backlog, engineer workload, monthly movement, and critical operational priorities.</p>
                </div>

                <div class="hero-actions">
                    <a href="/problem-logs" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>

        <div class="grid-4">
            <div class="card">
                <div class="stat-label">Total Tickets</div>
                <div class="stat-value">{{ $total }}</div>
                <div class="stat-sub">All recorded incidents</div>
            </div>

            <div class="card">
                <div class="stat-label">Open</div>
                <div class="stat-value">{{ $open }}</div>
                <div class="stat-sub">Waiting for action</div>
            </div>

            <div class="card">
                <div class="stat-label">In Progress</div>
                <div class="stat-value">{{ $progress }}</div>
                <div class="stat-sub">Currently being handled</div>
            </div>

            <div class="card success">
                <div class="stat-label">Closure Rate</div>
                <div class="stat-value">{{ $closureRate }}%</div>
                <div class="stat-sub">Closed vs total tickets</div>
            </div>
        </div>

        <div class="grid-3">
            <div class="card danger">
                <div class="stat-label">Response SLA Breached</div>
                <div class="stat-value">{{ $responseBreached }}</div>
                <div class="stat-sub">Exceeded response target</div>
            </div>

            <div class="card danger">
                <div class="stat-label">Resolution SLA Breached</div>
                <div class="stat-value">{{ $resolutionBreached }}</div>
                <div class="stat-sub">Exceeded resolution target</div>
            </div>

            <div class="card warning">
                <div class="stat-label">Overdue Now</div>
                <div class="stat-value">{{ $overdueNow }}</div>
                <div class="stat-sub">Active tickets already overdue</div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="stat-label">Average Response Time</div>
                <div class="stat-value">{{ round(($avgResponse ?? 0) / 60, 1) }} min</div>
                <div class="stat-sub">Average time to acknowledge or start handling</div>
            </div>

            <div class="card">
                <div class="stat-label">Average Resolution Time</div>
                <div class="stat-value">{{ round(($avgResolution ?? 0) / 60, 1) }} min</div>
                <div class="stat-sub">Average time from in progress to closed</div>
            </div>
        </div>

        <div class="grid-3">
            <div class="card">
                <div class="section-title">Monthly Ticket Trend</div>
                <div class="muted">New tickets created in the last 6 months.</div>
                <div class="mini-chart">
                    @foreach($monthlyTickets as $month => $count)
                        <div class="mini-col">
                            <div class="mini-value">{{ $count }}</div>
                            <div class="mini-bar-wrap">
                                <div class="mini-bar" style="height: {{ ($count / $maxMonthlyTickets) * 100 }}%; background: linear-gradient(135deg, #3b82f6, #2563eb);"></div>
                            </div>
                            <div class="mini-label">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M y') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Monthly Closure Trend</div>
                <div class="muted">Tickets closed in the last 6 months.</div>
                <div class="mini-chart">
                    @foreach($monthlyClosed as $month => $count)
                        <div class="mini-col">
                            <div class="mini-value">{{ $count }}</div>
                            <div class="mini-bar-wrap">
                                <div class="mini-bar" style="height: {{ ($count / $maxMonthlyClosed) * 100 }}%; background: linear-gradient(135deg, #22c55e, #16a34a);"></div>
                            </div>
                            <div class="mini-label">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M y') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Monthly SLA Breach Trend</div>
                <div class="muted">Tickets created in each month that breached SLA.</div>
                <div class="mini-chart">
                    @foreach($monthlyBreaches as $month => $count)
                        <div class="mini-col">
                            <div class="mini-value">{{ $count }}</div>
                            <div class="mini-bar-wrap">
                                <div class="mini-bar" style="height: {{ ($count / $maxMonthlyBreaches) * 100 }}%; background: linear-gradient(135deg, #ef4444, #dc2626);"></div>
                            </div>
                            <div class="mini-label">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M y') }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="section-title">Aging Buckets</div>
                <div class="muted">Current active ticket age distribution.</div>

                <div class="list">
                    @foreach($agingBuckets as $label => $count)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $label }}</div>
                                <div class="list-count">{{ $count }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar bar-warning" style="width: {{ ($count / $maxAging) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Most Critical Tickets</div>
                <div class="muted">High priority or SLA-risk tickets that need immediate focus.</div>

                <div class="list">
                    @forelse($criticalTickets as $ticket)
                        <div class="ticket">
                            <div class="ticket-title">{{ $ticket->title }}</div>
                            <div class="ticket-meta">
                                Ticket: {{ $ticket->ticket_number ?: '-' }}<br>
                                Company: {{ optional($ticket->company)->name ?? '-' }}<br>
                                Engineer: {{ optional($ticket->assignedEngineer)->name ?? 'Unassigned' }}<br>
                                Status: {{ $ticket->status }} | Priority: {{ $ticket->priority }}
                            </div>
                        </div>
                    @empty
                        <div class="list-item">
                            <div class="list-name">No critical tickets right now.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="section-title">Tickets by Company</div>
                <div class="muted">Volume distribution across customer companies.</div>

                <div class="list">
                    @foreach($byCompany as $name => $data)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $name }}</div>
                                <div class="list-count">{{ $data['count'] }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar" style="width: {{ ($data['count'] / $maxCompany) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Tickets by Engineer</div>
                <div class="muted">Handling load across assigned engineers.</div>

                <div class="list">
                    @foreach($byEngineer as $name => $data)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $name }}</div>
                                <div class="list-count">{{ $data['count'] }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar" style="width: {{ ($data['count'] / $maxEngineer) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="section-title">Top Breached Companies</div>
                <div class="muted">Companies with the highest number of SLA breaches.</div>

                <div class="list">
                    @foreach($topBreachedCompanies as $name => $data)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $name }}</div>
                                <div class="list-count">{{ $data['count'] }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar bar-danger" style="width: {{ ($data['count'] / $maxBreachCompany) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Top Loaded Engineers</div>
                <div class="muted">Engineers with the highest assigned ticket volume.</div>

                <div class="list">
                    @foreach($topEngineers as $name => $data)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $name }}</div>
                                <div class="list-count">{{ $data['count'] }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar" style="width: {{ ($data['count'] / $maxTopEngineer) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid-2">
            <div class="card">
                <div class="section-title">Top Issue Categories</div>
                <div class="muted">Most common incident types inferred from ticket titles.</div>

                <div class="list">
                    @foreach($topIssueCategories as $name => $count)
                        <div class="list-item">
                            <div class="list-top">
                                <div class="list-name">{{ $name }}</div>
                                <div class="list-count">{{ $count }}</div>
                            </div>
                            <div class="bar-wrap">
                                <div class="bar bar-success" style="width: {{ ($count / $maxIssueCategory) * 100 }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="section-title">Executive Summary</div>
                <div class="muted">Quick interpretation of the current operating condition.</div>

                <div class="list">
                    <div class="list-item">
                        <div class="list-name">Current backlog</div>
                        <div class="list-count">{{ $open + $progress }}</div>
                    </div>
                    <div class="list-item">
                        <div class="list-name">Immediate SLA risk</div>
                        <div class="list-count">{{ $overdueNow }}</div>
                    </div>
                    <div class="list-item">
                        <div class="list-name">Most pressured area</div>
                        <div class="list-count">{{ $topBreachedCompanies->keys()->first() ?? 'N/A' }}</div>
                    </div>
                    <div class="list-item">
                        <div class="list-name">Top workload owner</div>
                        <div class="list-count">{{ $topEngineers->keys()->first() ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
