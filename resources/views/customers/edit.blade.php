<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900">Edit Customer</h1>
        <p class="text-slate-500 mt-1">{{ $customer->name }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" enctype="multipart/form-data" action="{{ route('customers.update', $customer) }}">
            @method('PUT')
            @include('customers._form')
        </form>
    </div>
</x-app-layout>
