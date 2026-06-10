<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900">Add Asset Category</h1>
        <p class="text-slate-500 mt-1">Create asset grouping for preventive checklist, corrective incidents, and change requests.</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 max-w-2xl">
        <form method="POST" action="{{ route('asset-categories.store') }}">
            @csrf
            @include('asset-categories.form', ['category' => null])
        </form>
    </div>
</x-app-layout>
