<x-app-layout>

@php
$assetHistory = $assetHistory ?? [
    'tasks' => collect(),
    'usedParts' => collect(),
];
@endphp

    <div class="mb-6 flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900">{{ $asset->name }}</h1>
            <p class="text-slate-500 mt-1">{{ $asset->category->name ?? 'Uncategorized' }} • {{ $asset->asset_code ?? 'No asset code' }}</p>
        </div>
        <a href="{{ route('assets.edit', $asset) }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">Edit Asset</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-sm text-slate-500">Customer</div>
            <div class="text-lg font-black mt-2">{{ $asset->customer->name ?? '-' }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-sm text-slate-500">Region</div>
            <div class="text-lg font-black mt-2">{{ $asset->region->name ?? '-' }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-sm text-slate-500">Branch</div>
            <div class="text-lg font-black mt-2">{{ $asset->branch->name ?? '-' }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-sm text-slate-500">Status</div>
            <div class="text-lg font-black mt-2 capitalize">{{ $asset->status }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
        <h2 class="text-lg font-black text-slate-900 mb-4">Asset Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div><span class="font-semibold">Brand:</span> {{ $asset->brand ?? '-' }}</div>
            <div><span class="font-semibold">Model:</span> {{ $asset->model ?? '-' }}</div>
            <div><span class="font-semibold">Serial Number:</span> {{ $asset->serial_number ?? '-' }}</div>
            <div><span class="font-semibold">IP / Host:</span> {{ $asset->ip_address ?? '-' }}</div>
            <div><span class="font-semibold">Purchase Date:</span> {{ $asset->purchase_date ?? '-' }}</div>
            <div><span class="font-semibold">Warranty Expiry:</span> {{ $asset->warranty_expiry ?? '-' }}</div>
        </div>
        <div class="mt-4 text-sm text-slate-600">
            {{ $asset->description ?? 'No description.' }}
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
        <h2 class="text-lg font-black text-slate-900 mb-4">PM History</h2>

        <div class="overflow-hidden border border-slate-200 rounded-xl">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-4 py-3">Date</th>
                        <th class="text-left px-4 py-3">Task</th>
                        <th class="text-left px-4 py-3">Engineer</th>
                        <th class="text-left px-4 py-3">Result</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-right px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pmExecutions as $execution)
                        <tr>
                            <td class="px-4 py-3">{{ $execution->created_at?->format('d M Y') }}</td>
                            <td class="px-4 py-3">{{ $execution->task->title ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $execution->engineer->name ?? '-' }}</td>
                            <td class="px-4 py-3 capitalize">{{ $execution->overall_result ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $execution->completed_at ? 'Completed' : 'In Progress' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('preventive-executions.show', $execution) }}" class="font-semibold text-blue-600">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">No PM history yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
        <h2 class="text-lg font-black text-slate-900 mb-4">Incident History</h2>

        <div class="overflow-hidden border border-slate-200 rounded-xl">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-4 py-3">Date</th>
                        <th class="text-left px-4 py-3">Incident</th>
                        <th class="text-left px-4 py-3">Category</th>
                        <th class="text-left px-4 py-3">Severity</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-right px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($incidents as $incident)
                        <tr>
                            <td class="px-4 py-3">{{ $incident->created_at?->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="font-semibold">{{ $incident->title }}</div>
                                <div class="text-xs text-slate-500">{{ $incident->incident_no }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $incident->category->name ?? '-' }}</td>
                            <td class="px-4 py-3 capitalize">{{ $incident->severity }}</td>
                            <td class="px-4 py-3 capitalize">{{ str_replace('_', ' ', $incident->status) }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('incidents.show', $incident) }}" class="font-semibold text-blue-600">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">No incident history yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
        <h2 class="text-lg font-black text-slate-900 mb-4">Change History</h2>

        <div class="overflow-hidden border border-slate-200 rounded-xl">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-4 py-3">Date</th>
                        <th class="text-left px-4 py-3">Change</th>
                        <th class="text-left px-4 py-3">Category</th>
                        <th class="text-left px-4 py-3">Risk</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-right px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($changeRequests as $change)
                        <tr>
                            <td class="px-4 py-3">{{ $change->created_at?->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="font-semibold">{{ $change->title }}</div>
                                <div class="text-xs text-slate-500">{{ $change->change_no }}</div>
                            </td>
                            <td class="px-4 py-3">{{ $change->category->name ?? '-' }}</td>
                            <td class="px-4 py-3 capitalize">{{ $change->risk_level }}</td>
                            <td class="px-4 py-3 capitalize">{{ str_replace('_', ' ', $change->status) }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('change-requests.show', $change) }}" class="font-semibold text-blue-600">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-500">No change history yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
        <h2 class="text-lg font-black mb-4">Documents & Files</h2>

        <form
            method="POST"
            action="{{ route('assets.attachments.store',$asset) }}"
            enctype="multipart/form-data"
            class="mb-6"
        >
            @csrf

            <div class="grid md:grid-cols-2 gap-4">

                <select
                    name="attachment_type"
                    class="rounded-xl border-slate-300"
                >
                    <option value="photo">Photo</option>
                    <option value="manual">Manual</option>
                    <option value="configuration">Configuration</option>
                    <option value="diagram">Diagram</option>
                    <option value="license">License</option>
                    <option value="warranty">Warranty</option>
                    <option value="invoice">Invoice</option>
                    <option value="document">Document</option>
                    <option value="other">Other</option>
                </select>

                <input
                    type="file"
                    name="attachments[]"
                    multiple
                    class="border rounded-xl p-2"
                />

            </div>

            <button
                class="mt-3 px-4 py-2 bg-slate-900 text-white rounded-xl"
            >
                Upload Files
            </button>

        </form>

        <div class="space-y-3">

            @forelse($asset->attachments as $file)

                <div class="border rounded-xl p-3 flex justify-between">

                    <div>
                        <div class="font-semibold">
                            {{ $file->file_name }}
                        </div>

                        <div class="text-xs text-slate-500">
                            {{ ucfirst($file->attachment_type) }}
                        </div>
                    </div>

                    <div class="flex gap-3 items-center">

                        <a
                            href="{{ asset('storage/'.$file->file_path) }}"
                            target="_blank"
                            class="text-blue-600 font-semibold"
                        >
                            View
                        </a>

                        <form
                            method="POST"
                            action="{{ route('asset-attachments.destroy',$file) }}"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                class="text-red-600 font-semibold"
                            >
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            @empty

                <div class="text-slate-500">
                    No documents uploaded.
                </div>

            @endforelse

        </div>

    </div>


    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <h2 class="text-lg font-black text-slate-900 mb-4">Operations</h2>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            <a href="#" class="p-4 rounded-xl border border-slate-200 text-slate-400 font-semibold">Preventive</a>
            <a href="#" class="p-4 rounded-xl border border-slate-200 text-slate-400 font-semibold">Corrective</a>
            <a href="#" class="p-4 rounded-xl border border-slate-200 text-slate-400 font-semibold">Change Requests</a>
            <a href="#" class="p-4 rounded-xl border border-slate-200 text-slate-400 font-semibold">Documents</a>
            <a href="#" class="p-4 rounded-xl border border-slate-200 text-slate-400 font-semibold">History</a>
        </div>
    </div>

<div class="bg-white rounded-3xl shadow p-6 mt-6">
    <h2 class="text-xl font-black mb-4">
        Asset Service History
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="rounded-2xl bg-slate-50 p-4">
            <div class="text-xs text-slate-500">Incidents</div>
            <div class="text-3xl font-black">{{ $assetHistory['incidents']->count() ?? 0 }}</div>
        </div>

        <div class="rounded-2xl bg-slate-50 p-4">
            <div class="text-xs text-slate-500">Tasks</div>
            <div class="text-3xl font-black">{{ $assetHistory['tasks']->count() ?? 0 }}</div>
        </div>

        <div class="rounded-2xl bg-slate-50 p-4">
            <div class="text-xs text-slate-500">Changes</div>
            <div class="text-3xl font-black">{{ $assetHistory['changes']->count() ?? 0 }}</div>
        </div>

        <div class="rounded-2xl bg-slate-50 p-4">
            <div class="text-xs text-slate-500">Parts Used</div>
            <div class="text-3xl font-black">{{ $assetHistory['usedParts']->sum('quantity') ?? 0 }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="rounded-2xl border overflow-hidden">
            <div class="px-5 py-4 bg-slate-50 font-black">
                Recent Tasks
            </div>

            <div class="divide-y">
                @forelse($assetHistory['tasks'] ?? [] as $task)
                    <a href="{{ route('tasks.show', $task) }}" class="block p-5 hover:bg-orange-50">
                        <div class="font-black">{{ $task->title }}</div>
                        <div class="text-xs text-slate-500 mt-1">
                            {{ $task->task_no }} • {{ ucfirst(str_replace('_',' ', $task->status)) }}
                            • {{ $task->created_at?->format('d M Y') }}
                        </div>

                        @if($task->partUsages->count())
                            <div class="mt-2 text-xs text-slate-600">
                                Parts:
                                @foreach($task->partUsages as $usage)
                                    <span class="inline-block mr-2">
                                        {{ $usage->item?->name }} x{{ $usage->quantity }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </a>
                @empty
                    <div class="p-5 text-slate-400">No task history.</div>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border overflow-hidden">
            <div class="px-5 py-4 bg-slate-50 font-black">
                Used Parts History
            </div>

            <div class="divide-y">
                @forelse($assetHistory['usedParts'] ?? [] as $usage)
                    <div class="p-5">
                        <div class="font-black">{{ $usage->item?->name }}</div>
                        <div class="text-xs text-slate-500 mt-1">
                            Qty {{ $usage->quantity }}
                            • {{ $usage->used_at?->format('d M Y H:i') }}
                            @if($usage->task)
                                • Task {{ $usage->task->task_no }}
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-slate-400">No parts used.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>


<div class="bg-white rounded-3xl shadow p-6 mt-6">
    <div class="flex items-start justify-between gap-4 mb-5">
        <div>
            <h2 class="text-xl font-black">Lifecycle Management</h2>
            <p class="text-sm text-slate-500">Track asset operational lifecycle status.</p>
        </div>

        @php
            $lifeColor = match($asset->lifecycle_status ?? 'active') {
                'active' => 'bg-green-100 text-green-700',
                'under_repair' => 'bg-yellow-100 text-yellow-700',
                'standby' => 'bg-blue-100 text-blue-700',
                'retired' => 'bg-slate-100 text-slate-700',
                'disposed' => 'bg-red-100 text-red-700',
                default => 'bg-slate-100 text-slate-700',
            };
        @endphp

        <span class="px-4 py-2 rounded-full text-xs font-black {{ $lifeColor }}">
            {{ strtoupper(str_replace('_',' ', $asset->lifecycle_status ?? 'ACTIVE')) }}
        </span>
    </div>

    <form method="POST" action="{{ route('assets.lifecycle.update', $asset) }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @csrf
        @method('PATCH')

        <div>
            <label class="block text-sm font-black mb-2">Lifecycle Status</label>
            <select name="lifecycle_status" class="w-full rounded-xl border-slate-300">
                @foreach(['active','under_repair','standby','retired','disposed'] as $status)
                    <option value="{{ $status }}" @selected(($asset->lifecycle_status ?? 'active') === $status)>
                        {{ ucfirst(str_replace('_',' ', $status)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-black mb-2">Lifecycle Notes</label>
            <input name="lifecycle_notes" value="{{ old('lifecycle_notes', $asset->lifecycle_notes) }}" class="w-full rounded-xl border-slate-300" placeholder="Reason, condition, or disposal note">
        </div>

        <div>
            <button class="px-5 py-3 rounded-xl bg-black text-white font-black">
                Update Lifecycle
            </button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
        <div class="rounded-2xl bg-slate-50 p-4">
            <div class="text-xs text-slate-500">Retired At</div>
            <div class="font-black mt-1">{{ $asset->retired_at?->format('d M Y H:i') ?? '-' }}</div>
        </div>

        <div class="rounded-2xl bg-slate-50 p-4">
            <div class="text-xs text-slate-500">Disposed At</div>
            <div class="font-black mt-1">{{ $asset->disposed_at?->format('d M Y H:i') ?? '-' }}</div>
        </div>
    </div>
</div>


<div class="bg-white rounded-3xl shadow p-6 mt-6">

    <h2 class="text-xl font-black mb-5">
        Asset QR Code
    </h2>

    <div class="flex flex-col items-center">

        
@if($asset->qr_uuid)

    {!! QrCode::size(220)->generate(
        route('asset.qr',$asset->qr_uuid)
    ) !!}

@else

    <div class="p-6 rounded-xl bg-red-50 text-red-600">
        QR UUID Missing
    </div>

@endif


        <div class="mt-4 text-sm text-slate-500 text-center break-all">
            
@if($asset->qr_uuid)
{{ route('asset.qr',$asset->qr_uuid) }}
@endif

        </div>

    </div>

</div>


<div class="bg-white rounded-3xl shadow p-6 mt-6">
    <h2 class="text-xl font-black mb-5">Asset Timeline</h2>

    <div class="space-y-4">
        @forelse(($assetTimeline ?? collect()) as $event)
            <div class="flex gap-4">
                <div class="w-28 text-xs text-slate-500 pt-1">
                    {{ $event['date']?->format('d M Y') }}
                </div>

                <div class="w-3 flex flex-col items-center">
                    <div class="w-3 h-3 rounded-full bg-[#ff8a00] mt-1"></div>
                    <div class="w-px bg-slate-200 flex-1"></div>
                </div>

                <div class="flex-1 rounded-2xl border p-4 hover:bg-orange-50">
                    <div class="text-xs font-black text-[#ff8a00]">
                        {{ $event['type'] }}
                    </div>

                    <div class="font-black mt-1">
                        @if($event['url'])
                            <a href="{{ $event['url'] }}" class="hover:underline">
                                {{ $event['title'] }}
                            </a>
                        @else
                            {{ $event['title'] }}
                        @endif
                    </div>

                    @if($event['description'])
                        <div class="text-sm text-slate-500 mt-1 capitalize">
                            {{ str_replace('_',' ', $event['description']) }}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-slate-400 text-center py-10">
                No timeline available.
            </div>
        @endforelse
    </div>
</div>

</x-app-layout>
