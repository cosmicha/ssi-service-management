<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900">Edit Region</h1>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('customer-regions.update', $customerRegion) }}">
            @csrf
            @method('PUT')
            @include('customer-regions.form', ['region' => $customerRegion, 'selectedCustomerId' => $customerRegion->customer_id])
        </form>
    </div>
</x-app-layout>
