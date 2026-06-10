<x-app-layout>
<div class="flex justify-between items-center mb-6"><div><h1 class="text-2xl font-black">Service Catalog</h1><p class="text-slate-500">Standard SSI managed services.</p></div><a href="{{ route('service-catalogs.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">+ Add Service</a></div>
@if(session('success'))<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">{{ session('success') }}</div>@endif
<div class="bg-white rounded-2xl border overflow-hidden"><table class="w-full text-sm"><thead class="bg-slate-50"><tr><th class="text-left px-5 py-3">Service</th><th class="text-left px-5 py-3">Category</th><th class="text-left px-5 py-3">SLA</th><th class="text-left px-5 py-3">PM</th><th class="text-left px-5 py-3">Contracts</th><th class="text-right px-5 py-3">Action</th></tr></thead><tbody class="divide-y">
@forelse($catalogs as $catalog)
<tr><td class="px-5 py-4"><div class="font-bold">{{ $catalog->name }}</div><div class="text-xs text-slate-500">{{ $catalog->code ?? '-' }}</div></td><td class="px-5 py-4">{{ $catalog->category->name ?? '-' }}</td><td class="px-5 py-4">{{ $catalog->default_support_hour ?? '-' }} / {{ $catalog->default_response_minutes ?? '-' }} min</td><td class="px-5 py-4 capitalize">{{ $catalog->default_pm_frequency }}</td><td class="px-5 py-4">{{ $catalog->contracts_count }}</td><td class="px-5 py-4 text-right"><a href="{{ route('service-catalogs.edit',$catalog) }}" class="font-semibold">Edit</a></td></tr>
@empty<tr><td colspan="6" class="px-5 py-10 text-center text-slate-500">No services.</td></tr>@endforelse
</tbody></table></div><div class="mt-4">{{ $catalogs->links() }}</div>
</x-app-layout>
