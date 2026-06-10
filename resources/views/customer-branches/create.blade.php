<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900">Add Branch / Site</h1>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('customer-branches.store') }}">
            @csrf
            @include('customer-branches.form', ['branch' => null])
        </form>
    </div>
</x-app-layout>
