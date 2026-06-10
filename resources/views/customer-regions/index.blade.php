<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Customer Regions</h1>
            <p class="text-slate-500 mt-1">Manage area or regional hierarchy under each customer.</p>
        </div>
        <a href="{{ route('customer-regions.create', ['customer' => $customerId]) }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">+ Add Region</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-5 py-3">Region</th>
                    <th class="text-left px-5 py-3">Customer</th>
                    <th class="text-left px-5 py-3">Branches</th>
                    <th class="text-left px-5 py-3">PIC</th>
                    <th class="text-right px-5 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($regions as $region)
                    <tr>
                        <td class="px-5 py-4">
                            <div class="font-bold text-slate-900">{{ $region->name }}</div>
                            <div class="text-xs text-slate-500">{{ $region->code ?? '-' }}</div>
                        </td>
                        <td class="px-5 py-4">{{ $region->customer->name }}</td>
                        <td class="px-5 py-4">{{ $region->branches_count }}</td>
                        <td class="px-5 py-4">{{ $region->contact_person ?? '-' }}</td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('customer-regions.edit', $region) }}" class="font-semibold hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-5 py-10 text-center text-slate-500">No regions yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $regions->links() }}</div>
</x-app-layout>
