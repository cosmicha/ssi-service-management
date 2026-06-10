<x-app-layout>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-black">Change Requests</h1>
        <p class="text-slate-500">Controlled production changes, approval, implementation, rollback, and evidence.</p>
    </div>
    <a href="{{ route('change-requests.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">+ Add Change Request</a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-2xl border overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-slate-50">
<tr>
<th class="text-left px-5 py-3">Change</th>
<th class="text-left px-5 py-3">Customer / Site</th>
<th class="text-left px-5 py-3">Asset</th>
<th class="text-left px-5 py-3">Risk</th>
<th class="text-left px-5 py-3">Status</th>
<th class="text-left px-5 py-3">Task</th>
<th class="text-right px-5 py-3">Action</th>
</tr>
</thead>
<tbody class="divide-y">
@forelse($changes as $change)
<tr>
<td class="px-5 py-4">
<a href="{{ route('change-requests.show', $change) }}" class="font-bold hover:underline">{{ $change->title }}</a>
<div class="text-xs text-slate-500">{{ $change->change_no }}</div>
</td>
<td class="px-5 py-4">{{ $change->customer->name ?? '-' }}<div class="text-xs text-slate-500">{{ $change->branch->name ?? '-' }}</div></td>
<td class="px-5 py-4">{{ $change->asset->name ?? '-' }}</td>
<td class="px-5 py-4 capitalize">{{ $change->risk_level }}</td>
<td class="px-5 py-4 capitalize">{{ str_replace('_',' ', $change->status) }}</td>
<td class="px-5 py-4">@if($change->task)<a href="{{ route('tasks.show',$change->task) }}" class="text-blue-600 font-semibold">{{ $change->task->task_no }}</a>@else - @endif</td>
<td class="px-5 py-4 text-right"><a href="{{ route('change-requests.edit',$change) }}" class="font-semibold">Edit</a></td>
</tr>
@empty
<tr><td colspan="7" class="px-5 py-10 text-center text-slate-500">No change requests.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="mt-4">{{ $changes->links() }}</div>
</x-app-layout>
