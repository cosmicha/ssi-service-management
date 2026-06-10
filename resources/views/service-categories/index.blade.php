<x-app-layout>
<div class="flex justify-between items-center mb-6">
    <div><h1 class="text-2xl font-black">Service Categories</h1><p class="text-slate-500">Group SSI managed services.</p></div>
    <a href="{{ route('service-categories.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">+ Add Category</a>
</div>
@if(session('success'))<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">{{ session('success') }}</div>@endif
<div class="bg-white rounded-2xl border overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-slate-50"><tr><th class="text-left px-5 py-3">Name</th><th class="text-left px-5 py-3">Catalogs</th><th class="text-left px-5 py-3">Status</th><th class="text-right px-5 py-3">Action</th></tr></thead>
<tbody class="divide-y">
@forelse($categories as $category)
<tr>
<td class="px-5 py-4"><div class="font-bold">{{ $category->name }}</div><div class="text-xs text-slate-500">{{ $category->description }}</div></td>
<td class="px-5 py-4">{{ $category->catalogs_count }}</td>
<td class="px-5 py-4 capitalize">{{ $category->status }}</td>
<td class="px-5 py-4 text-right"><a href="{{ route('service-categories.edit', $category) }}" class="font-semibold">Edit</a></td>
</tr>
@empty
<tr><td colspan="4" class="px-5 py-10 text-center text-slate-500">No service categories.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="mt-4">{{ $categories->links() }}</div>
</x-app-layout>
