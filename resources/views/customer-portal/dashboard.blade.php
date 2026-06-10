<x-app-layout>
<div class="mb-6">
    <h1 class="text-2xl font-black">Customer Portal</h1>
    <p class="text-slate-500">Service overview for your assets, incidents, changes, and preventive maintenance.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
    <a href="{{ route('customer.portal.incidents.create') }}" class="p-4 bg-black text-white rounded-2xl font-black text-center">+ Create Ticket</a>
    <a href="{{ route('customer.portal.changes.create') }}" class="p-4 bg-[#ff8a00] text-black rounded-2xl font-black text-center">+ Create Change Request</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('customer.portal.assets') }}" class="block bg-white rounded-2xl border p-5 hover:shadow-lg hover:-translate-y-0.5 transition border-b-4 border-b-[#ff8a00]">
        <div class="text-sm text-slate-500">Managed Assets</div>
        <div class="text-3xl font-black mt-2">{{ $assetCount }}</div>
        <div class="text-xs text-slate-500 mt-1">Registered assets</div>
    </a>

    <a href="{{ route('customer.portal.incidents') }}" class="block bg-white rounded-2xl border p-5 hover:shadow-lg hover:-translate-y-0.5 transition border-b-4 border-b-[#ff8a00]">
        <div class="text-sm text-slate-500">Open Tickets</div>
        <div class="text-3xl font-black mt-2">{{ $openIncidents }}</div>
        <div class="text-xs text-slate-500 mt-1">Need attention</div>
    </a>

    <a href="{{ route('customer.portal.changes') }}" class="block bg-white rounded-2xl border p-5 hover:shadow-lg hover:-translate-y-0.5 transition border-b-4 border-b-[#ff8a00]">
        <div class="text-sm text-slate-500">Pending Changes</div>
        <div class="text-3xl font-black mt-2">{{ $pendingChanges }}</div>
        <div class="text-xs text-slate-500 mt-1">Awaiting review</div>
    </a>

    <a href="#" class="block bg-white rounded-2xl border p-5 hover:shadow-lg hover:-translate-y-0.5 transition border-b-4 border-b-[#ff8a00]">
        <div class="text-sm text-slate-500">Upcoming PM</div>
        <div class="text-3xl font-black mt-2">{{ $pmSchedules }}</div>
        <div class="text-xs text-slate-500 mt-1">Scheduled maintenance</div>
    </a>
</div>

<div class="bg-white rounded-2xl border overflow-hidden">
    <div class="px-5 py-4 border-b">
        <h2 class="font-black">Recent Incidents</h2>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-5 py-3">Ticket</th>
                <th class="text-left px-5 py-3">Asset</th>
                <th class="text-left px-5 py-3">Severity</th>
                <th class="text-left px-5 py-3">Status</th>
                <th class="text-left px-5 py-3">SLA</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($recentIncidents as $incident)
                <tr onclick="window.location='{{ route('incidents.show', $incident) }}'" class="cursor-pointer hover:bg-orange-50">
                    <td class="px-5 py-4">
                        <div class="font-black">{{ $incident->title }}</div>
                        <div class="text-xs text-slate-500">{{ $incident->incident_no }}</div>
                    </td>
                    <td class="px-5 py-4">{{ $incident->asset->name ?? '-' }}</td>
                    <td class="px-5 py-4 capitalize">{{ $incident->severity }}</td>
                    <td class="px-5 py-4 capitalize">{{ str_replace('_',' ', $incident->status) }}</td>
                    <td class="px-5 py-4 capitalize">{{ str_replace('_',' ', $incident->sla_status ?? 'no_sla') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-slate-500">No incidents yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</x-app-layout>
