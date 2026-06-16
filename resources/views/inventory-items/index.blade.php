<x-app-layout>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-3xl font-black">Inventory</h1>
        <p class="text-slate-500">Spare parts and inventory items.</p>
    </div>

    <a href="{{ route('inventory-items.create') }}" class="px-5 py-3 rounded-xl bg-[#ff8a00] text-white font-black">
        Add Item
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 font-bold">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-3xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="px-5 py-3 text-left">SKU</th>
                <th class="px-5 py-3 text-left">Item</th>
                <th class="px-5 py-3 text-left">Category</th>
                <th class="px-5 py-3 text-left">Brand/Model</th>
                <th class="px-5 py-3 text-left">Unit</th>
                <th class="px-5 py-3 text-left">Min Stock</th>
                <th class="px-5 py-3 text-left">Stock</th>
                <th class="px-5 py-3 text-right">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($inventoryItems as $item)
                <tr class="border-t hover:bg-orange-50">
                    <td class="px-5 py-4">{{ $item->sku ?? '-' }}</td>
                    <td class="px-5 py-4 font-bold">{{ $item->name }}</td>
                    <td class="px-5 py-4">{{ $item->category?->name ?? '-' }}</td>
                    <td class="px-5 py-4">{{ $item->brand ?? '-' }} {{ $item->model ?? '' }}</td>
                    <td class="px-5 py-4">{{ $item->unit }}</td>
                    <td class="px-5 py-4">{{ $item->minimum_stock }}</td>
                    <td class="px-5 py-4 font-black">
{{ $item->currentStock() }}

@if($item->currentStock() <= $item->minimum_stock)
    <div class="text-red-600 text-xs font-black">
        LOW STOCK
    </div>
@endif
</td>
                    <td class="px-5 py-4 text-right">
                        <a href="{{ route('inventory-items.edit', $item) }}" class="text-blue-600 font-bold">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center text-slate-400">
                        No inventory items found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $inventoryItems->links() }}
</div>
</x-app-layout>
