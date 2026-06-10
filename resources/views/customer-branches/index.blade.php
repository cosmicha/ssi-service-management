<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Branches / Sites</h1>
            <p class="text-slate-500 mt-1">Each branch becomes the operational anchor for assets, tasks, PM, incidents, and reports.</p>
        </div>
        <a href="{{ route('customer-branches.create', ['customer' => $customerId]) }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">+ Add Branch</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-5 py-3">Branch / Site</th>
                    <th class="text-left px-5 py-3">Customer</th>
                    <th class="text-left px-5 py-3">Region</th>
                    <th class="text-left px-5 py-3">City</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-right px-5 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($branches as $branch)
                    <tr>
                        <td class="px-5 py-4">
                            <div class="font-bold text-slate-900">{{ $branch->name }}</div>
                            <div class="text-xs text-slate-500">{{ $branch->code ?? '-' }} • {{ $branch->site_type ?? 'Site' }}</div>
                        </td>
                        <td class="px-5 py-4">{{ $branch->customer->name }}</td>
                        <td class="px-5 py-4">{{ $branch->region->name ?? '-' }}</td>
                        <td class="px-5 py-4">{{ $branch->city ?? '-' }}</td>
                        <td class="px-5 py-4 capitalize">{{ $branch->status }}</td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('customer-branches.edit', $branch) }}" class="font-semibold hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-slate-500">No branches yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $branches->links() }}</div>
</x-app-layout>
