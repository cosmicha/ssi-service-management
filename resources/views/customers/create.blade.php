<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900">Add Customer</h1>
        <p class="text-slate-500 mt-1">Create a customer account for SSI operations control.</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" enctype="multipart/form-data" action="{{ route('customers.store') }}">
            @include('customers._form')
        </form>
    </div>
</x-app-layout>
