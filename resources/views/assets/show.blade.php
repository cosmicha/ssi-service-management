<x-app-layout>
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
</x-app-layout>
