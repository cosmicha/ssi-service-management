<x-app-layout>
<div class="mb-6 flex justify-between items-start">
<div>
<h1 class="text-2xl font-black">{{ $incident->title }}</h1>
<p class="text-slate-500">{{ $incident->incident_no }} • {{ ucfirst($incident->severity) }}</p>
</div>
<a href="{{ route('incidents.edit',$incident) }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">Edit Incident</a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
<div class="bg-white rounded-2xl border p-5"><div class="text-sm text-slate-500">Status</div><div class="text-lg font-black capitalize">{{ str_replace('_',' ', $incident->status) }}</div></div>
<div class="bg-white rounded-2xl border p-5"><div class="text-sm text-slate-500">Customer</div><div class="text-lg font-black">{{ $incident->customer->name ?? '-' }}</div></div>
<div class="bg-white rounded-2xl border p-5"><div class="text-sm text-slate-500">Branch</div><div class="text-lg font-black">{{ $incident->branch->name ?? '-' }}</div></div>
<div class="bg-white rounded-2xl border p-5"><div class="text-sm text-slate-500">Asset</div><div class="text-lg font-black">{{ $incident->asset->name ?? '-' }}</div></div>
</div>

<div class="bg-white rounded-2xl border p-6 mb-6">
<h2 class="font-black mb-4">SLA Status</h2>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
    <div>
        <div class="text-slate-500">SLA</div>
        <div class="font-black capitalize">{{ str_replace('_',' ', $incident->sla_status ?? 'on_track') }}</div>
    </div>
    <div>
        <div class="text-slate-500">Response Due</div>
        <div class="font-black">{{ $incident->response_due_at?->format('d M Y H:i') ?? '-' }}</div>
    </div>
    <div>
        <div class="text-slate-500">Resolution Due</div>
        <div class="font-black">{{ $incident->resolution_due_at?->format('d M Y H:i') ?? '-' }}</div>
    </div>
    <div>
        <div class="text-slate-500">First Response</div>
        <div class="font-black">{{ $incident->first_response_at?->format('d M Y H:i') ?? '-' }}</div>
    </div>
</div>
</div>

<div class="bg-white rounded-2xl border p-6 mb-6">
<h2 class="font-black mb-4">Incident Details</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
<div><span class="font-semibold">Category:</span> {{ $incident->category->name ?? '-' }}</div>
<div><span class="font-semibold">Reported By:</span> {{ $incident->reported_by ?? '-' }}</div>
<div><span class="font-semibold">Reported At:</span> {{ $incident->reported_at?->format('d M Y H:i') ?? '-' }}</div>
<div><span class="font-semibold">Task:</span> @if($incident->task)<a href="{{ route('tasks.show',$incident->task) }}" class="text-blue-600 font-semibold">{{ $incident->task->task_no }}</a>@else - @endif</div>
</div>
<div class="mt-4 whitespace-pre-line text-slate-600">{{ $incident->description ?? 'No description.' }}</div>

@if($incident->task)
    <div class="mt-6">
        <a href="{{ route('tasks.show', $incident->task) }}"
           class="inline-flex px-5 py-3 bg-black text-white rounded-xl font-semibold">
            Open Work Task / Activity Timeline
        </a>
    </div>
@endif
</div>

<div class="bg-white rounded-2xl border p-6">
<h2 class="font-black mb-4">Attachments</h2>

<div class="space-y-3">
@forelse($incident->attachments as $attachment)
    <div class="flex items-center justify-between border border-slate-200 rounded-xl p-3">
        <div>
            <div class="font-semibold">{{ $attachment->file_name }}</div>
            <div class="text-xs text-slate-500">
                {{ $attachment->mime_type ?? '-' }} •
                {{ $attachment->file_size ? number_format($attachment->file_size / 1024, 1) . ' KB' : '-' }} •
                Uploaded by {{ $attachment->uploader->name ?? '-' }}
            </div>
        </div>
        <div class="flex gap-3 items-center">
            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="text-blue-600 font-semibold">
                View / Download
            </a>

            <form method="POST" action="{{ route('incidents.attachments.destroy', $attachment) }}">
                @csrf
                @method('DELETE')
                <button class="text-red-600 font-semibold">Delete</button>
            </form>
        </div>
    </div>
@empty
    <div class="text-slate-500">No attachments uploaded.</div>
@endforelse
</div>
</div>

@include('tasks._activity-panel', ['task' => $incident->task])

<div class="bg-white rounded-2xl border border-slate-200 p-6 mb-6">
    <div class="flex items-start justify-between gap-4 mb-5">
        <div>
            <h2 class="text-lg font-black">SLA Information</h2>
            <p class="text-sm text-slate-500">Response and resolution SLA tracking.</p>
        </div>

        @php
            $slaColor = match($incident->sla_status ?? 'no_sla') {
                'met' => 'bg-green-100 text-green-700',
                'near_breach' => 'bg-yellow-100 text-yellow-700',
                'breached' => 'bg-red-100 text-red-700',
                'on_track' => 'bg-blue-100 text-blue-700',
                default => 'bg-slate-100 text-slate-600',
            };
        @endphp

        <span class="px-4 py-2 rounded-full text-xs font-black {{ $slaColor }}">
            {{ strtoupper(str_replace('_',' ', $incident->sla_status ?? 'NO SLA')) }}
        </span>
    </div>

    @if($incident->sla_status === 'near_breach')
        <div class="mb-5 p-4 rounded-2xl bg-yellow-50 border border-yellow-200 text-yellow-800 font-bold">
            ⚠ SLA is near breach. Please prioritize this ticket.
        </div>
    @endif

    @if($incident->sla_status === 'breached')
        <div class="mb-5 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 font-bold">
            🚨 SLA breached. Immediate attention required.
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="rounded-xl bg-slate-50 p-4">
            <div class="text-xs text-slate-500">Response Due</div>
            <div class="font-black mt-1">{{ $incident->response_due_at?->format('d M Y H:i') ?? '-' }}</div>
            <div class="text-xs mt-1 capitalize text-slate-500">
                {{ str_replace('_',' ', $incident->response_sla_status ?? 'no_sla') }}
            </div>
        </div>

        <div class="rounded-xl bg-slate-50 p-4">
            <div class="text-xs text-slate-500">Responded At</div>
            <div class="font-black mt-1">{{ $incident->responded_at?->format('d M Y H:i') ?? '-' }}</div>
        </div>

        <div class="rounded-xl bg-slate-50 p-4">
            <div class="text-xs text-slate-500">Resolution Due</div>
            <div class="font-black mt-1">{{ $incident->resolution_due_at?->format('d M Y H:i') ?? '-' }}</div>
            <div class="text-xs mt-1 capitalize text-slate-500">
                {{ str_replace('_',' ', $incident->resolution_sla_status ?? 'no_sla') }}
            </div>
        </div>

        <div class="rounded-xl bg-slate-50 p-4">
            <div class="text-xs text-slate-500">Resolved At</div>
            <div class="font-black mt-1">{{ $incident->resolved_at?->format('d M Y H:i') ?? '-' }}</div>
        </div>
    </div>
</div>

</x-app-layout>
