<x-app-layout>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-black">Asset Categories</h1>
        <p class="text-slate-500">Asset classification for SSI Operations.</p>
    </div>

    <a href="{{ route('asset-categories.create') }}"
       class="px-4 py-2 bg-slate-900 text-white rounded-xl">
       + Add Category
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
<table class="w-full">
<thead class="bg-slate-50">
<tr>
<th class="text-left px-5 py-3">Category</th>
<th class="text-left px-5 py-3">Assets</th>
<th class="text-left px-5 py-3">Status</th>
<th class="text-right px-5 py-3">Action</th>
</tr>
</thead>

<tbody>
@foreach($categories as $category)
<tr class="border-t">
<td class="px-5 py-4">
<div class="font-bold">{{ $category->name }}</div>
<div class="text-xs text-slate-500">{{ $category->description }}</div>
</td>

<td class="px-5 py-4">
{{ $category->assets_count }}
</td>

<td class="px-5 py-4">
{{ ucfirst($category->status) }}
</td>

<td class="px-5 py-4 text-right">
<a href="{{ route('asset-categories.edit',$category) }}"
   class="font-semibold">
   Edit
</a>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</x-app-layout>
