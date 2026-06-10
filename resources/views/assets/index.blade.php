<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Assets</h1>
            <p class="text-slate-500 mt-1">Central registry for devices, software, and managed services.</p>
        </div>
        <a href="{{ route('assets.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">+ Add Asset</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-5 py-3">Asset</th>
                    <th class="text-left px-5 py-3">Category</th>
                    <th class="text-left px-5 py-3">Customer</th>
                    <th class="text-left px-5 py-3">Branch</th>
                    <th class="text-left px-5 py-3">IP / Host</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-right px-5 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($assets as $asset)
                    <tr>
                        <td class="px-5 py-4">
                            <a href="{{ route('assets.show', $asset) }}" class="font-bold text-slate-900 hover:underline">{{ $asset->name }}</a>
                            <div class="text-xs text-slate-500">{{ $asset->asset_code ?? '-' }} • {{ $asset->brand ?? '-' }} {{ $asset->model ?? '' }}</div>
                        </td>
                        <td class="px-5 py-4">{{ $asset->category->name ?? '-' }}</td>
                        <td class="px-5 py-4">{{ $asset->customer->name ?? '-' }}</td>
                        <td class="px-5 py-4">{{ $asset->branch->name ?? '-' }}</td>
                        <td class="px-5 py-4">{{ $asset->ip_address ?? '-' }}</td>
                        <td class="px-5 py-4 capitalize">{{ $asset->status }}</td>
                        <td class="px-5 py-4 text-right">
                            <a href="{{ route('assets.edit', $asset) }}" class="font-semibold hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-slate-500">No assets yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $assets->links() }}</div>
</x-app-layout>
