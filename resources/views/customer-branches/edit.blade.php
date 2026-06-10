<x-app-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-black text-slate-900">Edit Branch / Site</h1>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('customer-branches.update', $customerBranch) }}">
            @csrf
            @method('PUT')
            @include('customer-branches.form', ['branch' => $customerBranch, 'selectedCustomerId' => $customerBranch->customer_id])
        </form>
    </div>
</x-app-layout>
