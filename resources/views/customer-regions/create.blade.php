<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900">Add Region</h1>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('customer-regions.store') }}">
            @csrf
            @include('customer-regions.form', ['region' => null])
        </form>
    </div>
</x-app-layout>
