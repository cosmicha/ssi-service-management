<x-app-layout>
<div class="mb-6">
    <h1 class="text-2xl font-black">Reports</h1>
    <p class="text-slate-500">Service summary for your company and location access.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border p-5 border-b-4 border-b-[#ff8a00]">
        <div class="text-sm text-slate-500">Total Assets</div>
        <div class="text-3xl font-black mt-2">{{ $totalAssets }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5 border-b-4 border-b-[#ff8a00]">
        <div class="text-sm text-slate-500">Total Tickets</div>
        <div class="text-3xl font-black mt-2">{{ $totalTickets }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5 border-b-4 border-b-[#ff8a00]">
        <div class="text-sm text-slate-500">Open Tickets</div>
        <div class="text-3xl font-black mt-2">{{ $openTickets }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5 border-b-4 border-b-[#ff8a00]">
        <div class="text-sm text-slate-500">Closed Tickets</div>
        <div class="text-3xl font-black mt-2">{{ $closedTickets }}</div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">SLA Met</div>
        <div class="text-3xl font-black mt-2 text-green-600">{{ $slaMet }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">SLA Breached</div>
        <div class="text-3xl font-black mt-2 text-red-600">{{ $slaBreached }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">No SLA</div>
        <div class="text-3xl font-black mt-2">{{ $noSla }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">Pending Changes</div>
        <div class="text-3xl font-black mt-2">{{ $pendingChanges }}</div>
    </div>
</div>

<div class="bg-white rounded-2xl border overflow-hidden">
    <div class="px-5 py-4 border-b">
        <h2 class="font-black">Recent Tickets</h2>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-5 py-3">Ticket</th>
                <th class="text-left px-5 py-3">Asset</th>
                <th class="text-left px-5 py-3">Location</th>
                <th class="text-left px-5 py-3">Status</th>
                <th class="text-left px-5 py-3">SLA</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($recentTickets as $ticket)
                <tr>
                    <td class="px-5 py-4">
                        <div class="font-black">{{ $ticket->title }}</div>
                        <div class="text-xs text-slate-500">{{ $ticket->incident_no }}</div>
                    </td>
                    <td class="px-5 py-4">{{ $ticket->asset->name ?? '-' }}</td>
                    <td class="px-5 py-4">{{ $ticket->branch->name ?? 'HO / All Locations' }}</td>
                    <td class="px-5 py-4 capitalize">{{ str_replace('_',' ', $ticket->status) }}</td>
                    <td class="px-5 py-4 capitalize">{{ str_replace('_',' ', $ticket->sla_status ?? 'no_sla') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-slate-500">No tickets yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>
