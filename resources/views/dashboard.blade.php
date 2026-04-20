<x-app-layout>
    <div style="min-height:100vh; background:#f3f4f6;">
        <div style="display:flex; min-height:100vh;">

            <!-- SIDEBAR -->
            <aside style="width:260px; background:#ffffff; border-right:1px solid #e5e7eb; padding:24px 20px;">
                <div style="font-size:22px; font-weight:800; margin-bottom:28px; color:#111827;">
                    Xion1 Support
                </div>

                <nav style="display:flex; flex-direction:column; gap:10px;">
                    <a href="/" style="text-decoration:none; color:#111827; font-weight:600; padding:10px 12px; border-radius:12px; background:#f3f4f6;">Dashboard</a>
                    <a href="/problem-logs" style="text-decoration:none; color:#111827; font-weight:600; padding:10px 12px; border-radius:12px;">Tickets</a>
                    <a href="/devices" style="text-decoration:none; color:#111827; font-weight:600; padding:10px 12px; border-radius:12px;">Devices</a>
                    <a href="/vendors" style="text-decoration:none; color:#111827; font-weight:600; padding:10px 12px; border-radius:12px;">Vendors</a>
                    <a href="/resolution-library" style="text-decoration:none; color:#111827; font-weight:600; padding:10px 12px; border-radius:12px;">Knowledge Base</a>
                    <a href="/analytics" style="text-decoration:none; color:#111827; font-weight:600; padding:10px 12px; border-radius:12px;">Analytics</a>
                    <a href="/sla-dashboard" style="text-decoration:none; color:#111827; font-weight:600; padding:10px 12px; border-radius:12px;">SLA Dashboard</a>
                    <a href="/help" style="text-decoration:none; color:#111827; font-weight:600; padding:10px 12px; border-radius:12px;">Help</a>
                </nav>
            </aside>

            <!-- MAIN -->
            <main style="flex:1; padding:28px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
                    <div>
                        <h1 style="margin:0; font-size:30px; font-weight:800; color:#111827;">Dashboard</h1>
                        <div style="margin-top:6px; color:#6b7280;">Overview of tickets and support activity.</div>
                    </div>

                    <div style="display:flex; gap:12px;">
                        <a href="/problem-logs/create" style="background:#111827; color:white; text-decoration:none; padding:12px 16px; border-radius:12px; font-weight:700;">
                            + New Ticket
                        </a>
                    </div>
                </div>

                @php
                    $openCount = \App\Models\ProblemLog::where('status', 'open')->count();
                    $progressCount = \App\Models\ProblemLog::where('status', 'in_progress')->count();
                    $resolvedCount = \App\Models\ProblemLog::where('status', 'closed')->count();
                    $latestTickets = \App\Models\ProblemLog::latest()->take(10)->get();
                @endphp

                <!-- SUMMARY CARDS -->
                <div style="display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:20px; margin-bottom:28px;">
                    <div style="background:white; border-radius:20px; padding:26px; box-shadow:0 8px 20px rgba(0,0,0,.05);">
                        <div style="font-size:15px; font-weight:700; color:#111827; margin-bottom:24px;">Open</div>
                        <div style="font-size:48px; font-weight:900; color:#111827;">{{ $openCount }}</div>
                    </div>

                    <div style="background:white; border-radius:20px; padding:26px; box-shadow:0 8px 20px rgba(0,0,0,.05);">
                        <div style="font-size:15px; font-weight:700; color:#111827; margin-bottom:24px;">In Progress</div>
                        <div style="font-size:48px; font-weight:900; color:#111827;">{{ $progressCount }}</div>
                    </div>

                    <div style="background:white; border-radius:20px; padding:26px; box-shadow:0 8px 20px rgba(0,0,0,.05);">
                        <div style="font-size:15px; font-weight:700; color:#111827; margin-bottom:24px;">Resolved</div>
                        <div style="font-size:48px; font-weight:900; color:#111827;">{{ $resolvedCount }}</div>
                    </div>
                </div>

                <!-- TICKET TABLE -->
                <div style="background:white; border-radius:20px; padding:24px; box-shadow:0 8px 20px rgba(0,0,0,.05);">
                    <div style="font-size:18px; font-weight:800; margin-bottom:18px; color:#111827;">Your Tickets</div>

                    <div style="overflow-x:auto;">
                        <table style="width:100%; border-collapse:collapse;">
                            <thead>
                                <tr>
                                    <th style="text-align:left; padding:14px 12px; color:#6b7280; font-size:13px; border-bottom:1px solid #e5e7eb;">Ticket ID</th>
                                    <th style="text-align:left; padding:14px 12px; color:#6b7280; font-size:13px; border-bottom:1px solid #e5e7eb;">Status</th>
                                    <th style="text-align:left; padding:14px 12px; color:#6b7280; font-size:13px; border-bottom:1px solid #e5e7eb;">Title</th>
                                    <th style="text-align:left; padding:14px 12px; color:#6b7280; font-size:13px; border-bottom:1px solid #e5e7eb;">Description</th>
                                    <th style="text-align:left; padding:14px 12px; color:#6b7280; font-size:13px; border-bottom:1px solid #e5e7eb;">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestTickets as $ticket)
                                    <tr>
                                        <td style="padding:14px 12px; border-bottom:1px solid #f1f5f9; color:#111827;">{{ $ticket->ticket_number ?? $ticket->id }}</td>
                                        <td style="padding:14px 12px; border-bottom:1px solid #f1f5f9;">
                                            @php
                                                $status = $ticket->status ?? 'open';
                                                $bg = $status === 'closed' ? '#22c55e' : ($status === 'in_progress' ? '#f59e0b' : '#3b82f6');
                                                $label = $status === 'closed' ? 'Resolved' : ($status === 'in_progress' ? 'In Progress' : 'Open');
                                            @endphp
                                            <span style="display:inline-block; padding:6px 12px; border-radius:999px; background:{{ $bg }}; color:white; font-size:12px; font-weight:700;">
                                                {{ $label }}
                                            </span>
                                        </td>
                                        <td style="padding:14px 12px; border-bottom:1px solid #f1f5f9; color:#111827; font-weight:600;">
                                            <a href="/problem-logs/{{ $ticket->id }}" style="color:#111827; text-decoration:none;">
                                                {{ $ticket->title }}
                                            </a>
                                        </td>
                                        <td style="padding:14px 12px; border-bottom:1px solid #f1f5f9; color:#374151; max-width:420px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            {{ $ticket->description }}
                                        </td>
                                        <td style="padding:14px 12px; border-bottom:1px solid #f1f5f9; color:#374151;">
                                            {{ optional($ticket->created_at)->format('d M Y, H.i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="padding:18px 12px; color:#6b7280;">No tickets found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
