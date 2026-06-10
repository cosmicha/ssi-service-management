<x-app-layout>
<div class="mb-6">
    <h1 class="text-2xl font-black">My Assets</h1>
    <p class="text-slate-500">Assets registered under your company.</p>
</div>

<div class="bg-white rounded-2xl border overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-slate-50">
<tr>
<th class="text-left px-5 py-3">Asset</th>
<th class="text-left px-5 py-3">Category</th>
<th class="text-left px-5 py-3">Branch</th>
<th class="text-left px-5 py-3">Status</th>
</tr>
</thead>
<tbody class="divide-y">
@forelse($assets as $asset)
<tr onclick="window.location='{{ route('customer.portal.assets.show', $asset) }}'" class="cursor-pointer hover:bg-orange-50">
<td class="px-5 py-4 font-black">{{ $asset->name }}<div class="text-xs text-slate-500">{{ $asset->asset_code }}</div></td>
<td class="px-5 py-4">{{ $asset->category->name ?? '-' }}</td>
<td class="px-5 py-4">{{ $asset->branch->name ?? '-' }}</td>
<td class="px-5 py-4 capitalize">{{ $asset->status }}</td>
</tr>
@empty
<tr><td colspan="4" class="px-5 py-10 text-center text-slate-500">No assets.</td></tr>
@endforelse
</tbody>
</table>
</div>

<div class="mt-4">{{ $assets->links() }}</div>
</x-app-layout>
