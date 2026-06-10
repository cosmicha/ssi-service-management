<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900">Add Asset</h1>
        <p class="text-slate-500 mt-1">Register a device, software, or managed service under a customer branch.</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('assets.store') }}">
            @csrf
            @include('assets.form', ['asset' => null])
        </form>
    </div>
</x-app-layout>
