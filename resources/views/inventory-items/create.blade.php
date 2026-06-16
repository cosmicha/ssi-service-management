<x-app-layout>
<div class="mb-6">
    <h1 class="text-3xl font-black">Add Inventory Item</h1>
    <p class="text-slate-500">Create sparepart or consumable item.</p>
</div>

<div class="bg-white rounded-3xl border p-6">
    <form method="POST" action="{{ route('inventory-items.store') }}">
        @csrf
        @include('inventory-items.form')
    </form>
</div>
</x-app-layout>
