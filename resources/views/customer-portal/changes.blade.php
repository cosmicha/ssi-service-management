<x-app-layout>
<div class="mb-6">
    <h1 class="text-2xl font-black">My Change Requests</h1>
    <p class="text-slate-500">Change requests for your company.</p>
</div>

<div class="bg-white rounded-2xl border overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-slate-50">
<tr>
<th class="text-left px-5 py-3">Change</th>
<th class="text-left px-5 py-3">Asset</th>
<th class="text-left px-5 py-3">Risk</th>
<th class="text-left px-5 py-3">Status</th>
</tr>
</thead>
<tbody class="divide-y">
@forelse($changes as $change)
<tr onclick="window.location='{{ route('customer.portal.changes.show', $change) }}'" class="cursor-pointer hover:bg-orange-50">
<td class="px-5 py-4 font-black">{{ $change->title }}<div class="text-xs text-slate-500">{{ $change->change_no }}</div></td>
<td class="px-5 py-4">{{ $change->asset->name ?? '-' }}</td>
<td class="px-5 py-4 capitalize">{{ $change->risk_level }}</td>
<td class="px-5 py-4 capitalize">{{ str_replace('_',' ', $change->status) }}</td>
</tr>
@empty
<tr><td colspan="4" class="px-5 py-10 text-center text-slate-500">No changes.</td></tr>
@endforelse
</tbody>
</table>
</div>

<div class="mt-4">{{ $changes->links() }}</div>
</x-app-layout>
