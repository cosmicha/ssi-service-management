<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Customers</h1>
            <p class="text-slate-500 mt-1">Manage customer hierarchy for branches, assets, services, reports, and operations.</p>
        </div>
        <a href="{{ route('customers.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">+ Add Customer</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-5 py-3">Customer</th>
                    <th class="text-left px-5 py-3">Industry</th>
                    <th class="text-left px-5 py-3">Regions</th>
                    <th class="text-left px-5 py-3">Branches</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Structure</th>
<th class="text-right px-5 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($customers as $customer)
                    <tr>
                        <td class="px-5 py-4">
                            <a href="{{ route('customers.show', $customer) }}" class="font-bold text-slate-900 hover:underline">{{ $customer->name }}</a>
                            <div class="text-xs text-slate-500">{{ $customer->code }}</div>
                        </td>
                        <td class="px-5 py-4 text-slate-600">{{ $customer->industry ?? '-' }}</td>
                        <td class="px-5 py-4">{{ $customer->regions_count }}</td>
                        <td class="px-5 py-4">{{ $customer->branches_count }}</td>
                        <td class="px-5 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">{{ ucfirst($customer->status) }}</span>
                        </td>
                        <td class="px-5 py-4">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('customer-regions.index', ['customer' => $customer->id]) }}" class="text-xs px-3 py-1 rounded-lg bg-orange-50 text-[#ff8a00] font-bold">Regions</a>
                <a href="{{ route('customer-branches.index', ['customer' => $customer->id]) }}" class="text-xs px-3 py-1 rounded-lg bg-orange-50 text-[#ff8a00] font-bold">Branches</a>
                <a href="{{ route('assets.index', ['customer' => $customer->id]) }}" class="text-xs px-3 py-1 rounded-lg bg-orange-50 text-[#ff8a00] font-bold">Assets</a>
                <a href="{{ route('accounts.index') }}" class="text-xs px-3 py-1 rounded-lg bg-orange-50 text-[#ff8a00] font-bold">Users</a>
            </div>
        </td>

        <td class="px-5 py-4 text-right">
                            <a href="{{ route('customers.edit', $customer) }}" class="text-slate-700 font-semibold hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-500">No customers yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $customers->links() }}</div>
</x-app-layout>
