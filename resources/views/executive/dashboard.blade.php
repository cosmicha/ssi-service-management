@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-8">

    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
        <div>
            <div class="text-sm font-black uppercase tracking-widest text-[#ff8a00]">Executive Dashboard</div>
            <h1 class="text-4xl font-black text-slate-950 mt-2">SSI Service Performance</h1>
            <p class="text-slate-500 mt-2">Management view for operations, SLA, preventive maintenance, and customer service performance.</p>
        </div>

        <div class="bg-slate-950 text-white rounded-3xl px-6 py-4 shadow-sm">
            <div class="text-xs text-white/60 font-bold uppercase tracking-widest">This Month</div>
            <div class="text-2xl font-black mt-1">{{ $monthlyIncidents }} Incidents</div>
            <div class="text-sm text-white/70">{{ $monthlyResolved }} resolved / closed</div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">
        @foreach([
            ['Customers', $totalCustomers, 'Managed customer accounts', 'customers.index'],
            ['Assets', $totalAssets, 'Registered assets', 'assets.index'],
            ['Open Incidents', $openIncidents, 'Open / assigned tickets', 'incidents.index'],
            ['Critical Incidents', $criticalIncidents, 'High priority open tickets', 'incidents.index'],
            ['Open Changes', $openChanges, 'Active change requests', 'change-requests.index'],
            ['Open Tasks', $openTasks, 'Active work orders', 'tasks.index'],
            ['PM Compliance', $pmCompliance.'%', 'Preventive completion rate', 'reports.preventive'],
            ['SLA Compliance', $slaCompliance.'%', 'Service level achievement', 'reports.incidents'],
        ] as [$label, $value, $desc, $route])
            <a href="{{ route($route) }}" class="bg-white rounded-3xl border shadow-sm p-6 hover:border-[#ff8a00] transition">
                <div class="text-sm text-slate-500 font-bold">{{ $label }}</div>
                <div class="text-4xl font-black text-slate-950 mt-3">{{ $value }}</div>
                <div class="text-sm text-slate-500 mt-2">{{ $desc }}</div>
            </a>
        @endforeach
    </div>

    <div class="grid xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-3xl border shadow-sm p-6">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-xl font-black">Incident Trend</h2>
                    <p class="text-sm text-slate-500">Last 6 months ticket volume.</p>
                </div>
                <a href="{{ route('reports.incidents') }}" class="text-[#ff8a00] font-black text-sm">View Report →</a>
            </div>

            <div class="space-y-4">
                @forelse($incidentTrend as $row)
                    @php
                        $max = max($incidentTrend->max('total'), 1);
                        $width = round(($row->total / $max) * 100);
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm font-bold mb-1">
                            <span>{{ $row->period }}</span>
                            <span>{{ $row->total }}</span>
                        </div>
                        <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#ff8a00] rounded-full" style="width: {{ $width }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-slate-500">No incident trend data.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-3xl border shadow-sm p-6">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-xl font-black">Incident by Category</h2>
                    <p class="text-sm text-slate-500">Top problem categories.</p>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($incidentCategory as $name => $total)
                    @php
                        $max = max($incidentCategory->max(), 1);
                        $width = round(($total / $max) * 100);
                    @endphp
                    <div>
                        <div class="flex justify-between text-sm font-bold mb-1">
                            <span>{{ $name }}</span>
                            <span>{{ $total }}</span>
                        </div>
                        <div class="h-3 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-slate-900 rounded-full" style="width: {{ $width }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-slate-500">No category data.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl border shadow-sm p-6">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-xl font-black">Top Customers by Incident</h2>
                    <p class="text-sm text-slate-500">Customers with highest ticket volume.</p>
                </div>
                <a href="{{ route('reports.customers') }}" class="text-[#ff8a00] font-black text-sm">Customer Report →</a>
            </div>

            <div class="divide-y">
                @forelse($topCustomers as $name => $total)
                    <div class="py-3 flex justify-between">
                        <div class="font-bold text-slate-800">{{ $name }}</div>
                        <div class="font-black">{{ $total }}</div>
                    </div>
                @empty
                    <div class="text-slate-500">No customer incident data.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-3xl border shadow-sm p-6">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-xl font-black">Engineer Performance</h2>
                    <p class="text-sm text-slate-500">Task completion by engineer.</p>
                </div>
                <a href="{{ route('tasks.index') }}" class="text-[#ff8a00] font-black text-sm">Tasks →</a>
            </div>

            <div class="divide-y">
                @forelse($engineerPerformance as $name => $data)
                    <div class="py-3">
                        <div class="flex justify-between font-bold">
                            <span>{{ $name }}</span>
                            <span>{{ $data['completed'] }}/{{ $data['total'] }}</span>
                        </div>
                        <div class="mt-2 h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#ff8a00]" style="width: {{ $data['rate'] }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="text-slate-500">No engineer task data.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl border shadow-sm p-6 overflow-x-auto">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-xl font-black">Critical Open Incidents</h2>
                    <p class="text-sm text-slate-500">Critical and high severity tickets requiring attention.</p>
                </div>
                <a href="{{ route('reports.incidents') }}" class="text-[#ff8a00] font-black text-sm">Incident Report →</a>
            </div>

            <table class="w-full text-sm">
                <thead class="text-slate-500 bg-slate-50">
                    <tr>
                        <th class="p-3 text-left">Ticket</th>
                        <th class="p-3 text-left">Customer</th>
                        <th class="p-3 text-left">Severity</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($criticalOpenIncidents as $incident)
                        <tr class="border-t">
                            <td class="p-3 font-bold">
                                <a href="{{ route('incidents.show', $incident) }}" class="text-[#ff8a00]">
                                    {{ $incident->incident_no ?? $incident->ticket_no ?? $incident->id }}
                                </a>
                            </td>
                            <td class="p-3">{{ $incident->customer?->name ?? '-' }}</td>
                            <td class="p-3">{{ ucfirst($incident->severity) }}</td>
                            <td class="p-3">{{ ucfirst($incident->status) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-5 text-center text-slate-500">No critical open incident.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-3xl border shadow-sm p-6 overflow-x-auto">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-xl font-black">Upcoming / Active PM</h2>
                    <p class="text-sm text-slate-500">Preventive maintenance requiring execution.</p>
                </div>
                <a href="{{ route('reports.preventive') }}" class="text-[#ff8a00] font-black text-sm">PM Report →</a>
            </div>

            <table class="w-full text-sm">
                <thead class="text-slate-500 bg-slate-50">
                    <tr>
                        <th class="p-3 text-left">PM</th>
                        <th class="p-3 text-left">Customer</th>
                        <th class="p-3 text-left">Engineer</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($upcomingPm as $pm)
                        <tr class="border-t">
                            <td class="p-3 font-bold">{{ $pm->pm_no ?? $pm->id }}</td>
                            <td class="p-3">{{ $pm->task?->customer?->name ?? '-' }}</td>
                            <td class="p-3">{{ $pm->engineer?->name ?? '-' }}</td>
                            <td class="p-3">{{ str_replace('_', ' ', ucfirst($pm->status)) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-5 text-center text-slate-500">No active PM.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
