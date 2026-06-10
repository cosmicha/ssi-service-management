<x-app-layout>
<div class="mb-6 flex justify-between items-start">
<div>
<h1 class="text-2xl font-black">{{ $changeRequest->title }}</h1>
<p class="text-slate-500">{{ $changeRequest->change_no }} • {{ ucfirst($changeRequest->risk_level) }} Risk</p>
</div>
<a href="{{ route('change-requests.edit',$changeRequest) }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">Edit CR</a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
<div class="bg-white rounded-2xl border p-5"><div class="text-sm text-slate-500">Status</div><div class="text-lg font-black capitalize">{{ str_replace('_',' ', $changeRequest->status) }}</div></div>
<div class="bg-white rounded-2xl border p-5"><div class="text-sm text-slate-500">Customer</div><div class="text-lg font-black">{{ $changeRequest->customer->name ?? '-' }}</div></div>
<div class="bg-white rounded-2xl border p-5"><div class="text-sm text-slate-500">Asset</div><div class="text-lg font-black">{{ $changeRequest->asset->name ?? '-' }}</div></div>
<div class="bg-white rounded-2xl border p-5"><div class="text-sm text-slate-500">Implementation</div><div class="text-lg font-black">{{ $changeRequest->implementation_date?->format('d M Y H:i') ?? '-' }}</div></div>
</div>

<div class="bg-white rounded-2xl border p-6 mb-6">
<h2 class="font-black mb-4">Workflow</h2>
<div class="flex flex-wrap gap-3">
@if($changeRequest->status === 'draft')
<form method="POST" action="{{ route('change-requests.submit',$changeRequest) }}">@csrf <button class="px-4 py-2 bg-blue-600 text-white rounded-xl font-semibold">Submit</button></form>
@endif
@if($changeRequest->status === 'submitted')
<form method="POST" action="{{ route('change-requests.approve',$changeRequest) }}">@csrf <button class="px-4 py-2 bg-green-600 text-white rounded-xl font-semibold">Approve</button></form>
<form method="POST" action="{{ route('change-requests.reject',$changeRequest) }}">@csrf <button class="px-4 py-2 bg-red-600 text-white rounded-xl font-semibold">Reject</button></form>
@endif
@if($changeRequest->status === 'approved' && !$changeRequest->task)
<form method="POST" action="{{ route('change-requests.generate-task',$changeRequest) }}" class="flex gap-2">
@csrf
<select name="assigned_to" class="rounded-xl border-slate-300">
<option value="">Unassigned</option>
@foreach(\App\Models\User::orderBy('name')->get() as $user)
<option value="{{ $user->id }}">{{ $user->name }}</option>
@endforeach
</select>
<button class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">Generate Implementation Task</button>
</form>
@endif
@if($changeRequest->task)
<a href="{{ route('tasks.show',$changeRequest->task) }}" class="px-4 py-2 bg-black text-white border rounded-xl font-semibold">Open Work Task / Activity Timeline {{ $changeRequest->task->task_no }}</a>
@endif
</div>
</div>

<div class="bg-white rounded-2xl border p-6 mb-6">
<h2 class="font-black mb-4">Change Details</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
<div><span class="font-semibold">Category:</span> {{ $changeRequest->category->name ?? '-' }}</div>
<div><span class="font-semibold">Requested By:</span> {{ $changeRequest->requested_by ?? '-' }}</div>
<div><span class="font-semibold">Requested Date:</span> {{ $changeRequest->requested_date?->format('d M Y H:i') ?? '-' }}</div>
<div><span class="font-semibold">Approved By:</span> {{ $changeRequest->approver->name ?? '-' }}</div>
</div>
<hr class="my-4">
<h3 class="font-bold mb-2">Business Reason</h3>
<div class="text-slate-600 whitespace-pre-line mb-4">{{ $changeRequest->business_reason ?? '-' }}</div>
<h3 class="font-bold mb-2">Implementation Plan</h3>
<div class="text-slate-600 whitespace-pre-line mb-4">{{ $changeRequest->implementation_plan ?? '-' }}</div>
<h3 class="font-bold mb-2">Rollback Plan</h3>
<div class="text-slate-600 whitespace-pre-line mb-4">{{ $changeRequest->rollback_plan ?? '-' }}</div>
<h3 class="font-bold mb-2">Verification Notes</h3>
<div class="text-slate-600 whitespace-pre-line">{{ $changeRequest->verification_notes ?? '-' }}</div>
</div>

<div class="bg-white rounded-2xl border p-6">
<h2 class="font-black mb-4">Attachments</h2>
<div class="space-y-3">
@forelse($changeRequest->attachments as $attachment)
<div class="flex items-center justify-between border border-slate-200 rounded-xl p-3">
<div>
<div class="font-semibold">{{ $attachment->file_name }}</div>
<div class="text-xs text-slate-500">{{ ucfirst(str_replace('_',' ', $attachment->attachment_type)) }} • {{ $attachment->mime_type ?? '-' }} • {{ $attachment->file_size ? number_format($attachment->file_size / 1024, 1) . ' KB' : '-' }}</div>
</div>
<div class="flex gap-3 items-center">
<a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="text-blue-600 font-semibold">View / Download</a>
<form method="POST" action="{{ route('change-attachments.destroy', $attachment) }}">
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
@include('tasks._activity-panel', ['task' => $changeRequest->task])
</x-app-layout>
