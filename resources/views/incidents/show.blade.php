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
</x-app-layout>
