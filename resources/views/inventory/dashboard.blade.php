<x-app-layout>
<div class="mb-8">
    <h1 class="text-3xl font-black">Inventory Management</h1>
    <p class="text-slate-500 mt-2">Enterprise inventory, sparepart, tools, and stock movement management.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-5 gap-6">
    <div class="bg-white rounded-3xl p-6 border shadow-sm">
        <div class="text-slate-500 text-sm">Categories</div>
        <div class="text-4xl font-black mt-2">{{ $categories }}</div>
    </div>

    <div class="bg-white rounded-3xl p-6 border shadow-sm">
        <div class="text-slate-500 text-sm">Items</div>
        <div class="text-4xl font-black mt-2">{{ $items }}</div>
    </div>

    <div class="bg-white rounded-3xl p-6 border shadow-sm">
        <div class="text-slate-500 text-sm">Locations</div>
        <div class="text-4xl font-black mt-2">{{ $locations }}</div>
    </div>

    <div class="bg-white rounded-3xl p-6 border shadow-sm">
        <div class="text-slate-500 text-sm">Transactions</div>
        <div class="text-4xl font-black mt-2">{{ $transactions }}</div>
    </div>
    <div class="bg-white rounded-3xl p-6 border shadow-sm">
        <div class="text-slate-500 text-sm">
            Low Stock
        </div>

        <div class="text-4xl font-black mt-2 text-red-600">
            {{ $lowStock }}
        </div>
    </div>


<div class="bg-white rounded-3xl p-6 border shadow-sm">
    <div class="text-slate-500 text-sm">
        Inventory Value
    </div>

    <div class="text-2xl font-black mt-2">
        Rp {{ number_format($inventoryValue,0,',','.') }}
    </div>
</div>

</div>

<div class="grid md:grid-cols-3 gap-6 mt-8">
    <a href="/inventory-items" class="bg-white rounded-3xl p-8 border shadow-sm hover:border-[#ff8a00]">
        <div class="text-2xl font-black">Inventory Items</div>
        <div class="text-slate-500 mt-2">HVAC, IT, network, security, electrical, tools, and consumables.</div>
    </a>

    <a href="/inventory-locations" class="bg-white rounded-3xl p-8 border shadow-sm hover:border-[#ff8a00]">
        <div class="text-2xl font-black">Stock Locations</div>
        <div class="text-slate-500 mt-2">Warehouses, customer branches, engineer stock, and vehicle stock.</div>
    </a>

    <a href="/inventory-transactions" class="bg-white rounded-3xl p-8 border shadow-sm hover:border-[#ff8a00]">
        <div class="text-2xl font-black">Stock Movements</div>
        <div class="text-slate-500 mt-2">Stock in, stock out, adjustment, transfer, and used parts.</div>
    </a>
</div>
</x-app-layout>
