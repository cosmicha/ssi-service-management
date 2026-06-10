<x-app-layout>
<div class="mb-6">
    <h1 class="text-2xl font-black">My Tickets</h1>
    <p class="text-slate-500">Incident tickets for your company.</p>
</div>

<div class="bg-white rounded-2xl border overflow-hidden">
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
@forelse($incidents as $incident)
<tr onclick="window.location='{{ route('customer.portal.incidents.show', $incident) }}'" class="cursor-pointer hover:bg-orange-50">
<td class="px-5 py-4 font-black">{{ $incident->title }}<div class="text-xs text-slate-500">{{ $incident->incident_no }}</div></td>
<td class="px-5 py-4">{{ $incident->asset->name ?? '-' }}</td>
<td class="px-5 py-4 capitalize">{{ $incident->severity }}</td>
<td class="px-5 py-4 capitalize">{{ str_replace('_',' ', $incident->status) }}</td>
<td class="px-5 py-4 capitalize">{{ str_replace('_',' ', $incident->sla_status ?? 'no_sla') }}</td>
</tr>
@empty
<tr><td colspan="5" class="px-5 py-10 text-center text-slate-500">No tickets.</td></tr>
@endforelse
</tbody>
</table>
</div>

<div class="mt-4">{{ $incidents->links() }}</div>
</x-app-layout>
