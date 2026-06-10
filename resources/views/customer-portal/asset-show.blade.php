<x-app-layout>
<div class="mb-6 flex items-start justify-between">
    <div>
        <h1 class="text-2xl font-black">{{ $asset->name }}</h1>
        <p class="text-slate-500 mt-1">
            {{ $asset->customer->name ?? '-' }}
            —
            {{ $asset->branch->name ?? 'HO / All Locations' }}
        </p>
    </div>

    <a href="{{ route('customer.portal.assets') }}" class="px-4 py-2 bg-white border rounded-xl font-semibold">
        Back to Assets
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">Asset Code</div>
        <div class="text-lg font-black mt-2">{{ $asset->asset_code ?? '-' }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">Category</div>
        <div class="text-lg font-black mt-2">{{ $asset->category->name ?? '-' }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">Location</div>
        <div class="text-lg font-black mt-2">{{ $asset->branch->name ?? 'HO / All Locations' }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5">
        <div class="text-sm text-slate-500">Status</div>
        <div class="text-lg font-black mt-2 capitalize">{{ $asset->status }}</div>
    </div>
</div>

<div class="bg-white rounded-2xl border p-6 mb-6">
    <h2 class="font-black mb-4">Asset Information</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
        <div><span class="font-semibold">Brand:</span> {{ $asset->brand ?? '-' }}</div>
        <div><span class="font-semibold">Model:</span> {{ $asset->model ?? '-' }}</div>
        <div><span class="font-semibold">Serial Number:</span> {{ $asset->serial_number ?? '-' }}</div>
        <div><span class="font-semibold">IP / Host:</span> {{ $asset->ip_address ?? '-' }}</div>
        <div><span class="font-semibold">Purchase Date:</span> {{ $asset->purchase_date ?? '-' }}</div>
        <div><span class="font-semibold">Warranty Expiry:</span> {{ $asset->warranty_expiry ?? '-' }}</div>
    </div>

    <div class="mt-4 text-slate-600 whitespace-pre-line">
        {{ $asset->description ?? 'No description.' }}
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-2xl border p-6">
        <h2 class="font-black mb-4">Asset Documents</h2>

        <div class="space-y-3">
            @forelse($asset->attachments as $file)
                <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                    <div>
                        <div class="font-semibold">{{ $file->file_name }}</div>
                        <div class="text-xs text-slate-500">{{ ucfirst($file->attachment_type) }}</div>
                    </div>
                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-blue-600 font-semibold">
                        View
                    </a>
                </div>
            @empty
                <div class="text-slate-500">No documents available.</div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-2xl border p-6">
        <h2 class="font-black mb-4">PM History</h2>

        <div class="space-y-3">
            @forelse($pmExecutions as $pm)
                <div class="rounded-xl border px-4 py-3">
                    <div class="font-semibold">{{ $pm->pm_no ?? 'PM' }}</div>
                    <div class="text-xs text-slate-500">
                        {{ $pm->created_at?->format('d M Y H:i') }}
                        —
                        {{ $pm->completed_at ? 'Completed' : 'In Progress' }}
                    </div>
                </div>
            @empty
                <div class="text-slate-500">No PM history yet.</div>
            @endforelse
        </div>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border p-6">
        <h2 class="font-black mb-4">Recent Tickets</h2>

        <div class="space-y-3">
            @forelse($incidents as $incident)
                <a href="{{ route('incidents.show', $incident) }}" class="block rounded-xl border px-4 py-3 hover:bg-orange-50">
                    <div class="font-semibold">{{ $incident->title }}</div>
                    <div class="text-xs text-slate-500">
                        {{ $incident->incident_no }}
                        —
                        {{ ucfirst(str_replace('_',' ', $incident->status)) }}
                    </div>
                </a>
            @empty
                <div class="text-slate-500">No tickets for this asset.</div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-2xl border p-6">
        <h2 class="font-black mb-4">Recent Change Requests</h2>

        <div class="space-y-3">
            @forelse($changes as $change)
                <a href="{{ route('change-requests.show', $change) }}" class="block rounded-xl border px-4 py-3 hover:bg-orange-50">
                    <div class="font-semibold">{{ $change->title }}</div>
                    <div class="text-xs text-slate-500">
                        {{ $change->change_no }}
                        —
                        {{ ucfirst(str_replace('_',' ', $change->status)) }}
                    </div>
                </a>
            @empty
                <div class="text-slate-500">No change requests for this asset.</div>
            @endforelse
        </div>
    </div>
</div>
</x-app-layout>
