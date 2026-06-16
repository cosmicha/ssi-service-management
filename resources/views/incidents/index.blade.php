<x-app-layout>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-black">Incidents</h1>
        <p class="text-slate-500">Corrective issue management and engineer task creation.</p>
    </div>
    <a href="{{ route('incidents.create') }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">+ Add Incident</a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-2xl border overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-slate-50">
<tr>
<th class="text-left px-5 py-3">Incident</th>
<th class="text-left px-5 py-3">Customer / Site</th>
<th class="text-left px-5 py-3">Asset</th>
<th class="text-left px-5 py-3">Severity</th>
<th class="text-left px-5 py-3">Status</th>
<th class="text-left px-5 py-3">SLA Status</th>\n<th class="text-left px-5 py-3">SLA</th>
<th class="text-left px-5 py-3">Task</th>
<th class="text-right px-5 py-3">Action</th>
</tr>
</thead>
<tbody class="divide-y">
@forelse($incidents as $incident)
<tr>
<td class="px-5 py-4">
<a href="{{ route('incidents.show', $incident) }}" class="font-bold hover:underline">{{ $incident->title }}</a>
<div class="text-xs text-slate-500">{{ $incident->incident_no }}</div>
</td>
<td class="px-5 py-4">{{ $incident->customer->name ?? '-' }}<div class="text-xs text-slate-500">{{ $incident->branch->name ?? '-' }}</div></td>
<td class="px-5 py-4">{{ $incident->asset->name ?? '-' }}</td>
<td class="px-5 py-4 capitalize">{{ $incident->severity }}</td>
<td class="px-5 py-4 capitalize">{{ str_replace('_',' ', $incident->status) }}</td>
<td class="px-5 py-4">
    @php
        $slaColor = match($incident->sla_status ?? 'no_sla') {
            'met' => 'bg-green-100 text-green-700',
            'near_breach' => 'bg-yellow-100 text-yellow-700',
            'breached' => 'bg-red-100 text-red-700',
            'on_track' => 'bg-blue-100 text-blue-700',
            default => 'bg-slate-100 text-slate-600',
        };
    @endphp
    <span class="px-3 py-1 rounded-full text-xs font-black {{ $slaColor }}">
        {{ strtoupper(str_replace('_',' ', $incident->sla_status ?? 'NO SLA')) }}
    </span>
</td>
<td class="px-5 py-4">
    @php
        $sla = $incident->sla_status ?? 'no_sla';
        $slaClass = match($sla) {
            'breached' => 'bg-red-100 text-red-700',
            'met' => 'bg-green-100 text-green-700',
            'on_track' => 'bg-orange-100 text-[#ff8a00]',
            default => 'bg-slate-100 text-slate-600',
        };
    @endphp
    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $slaClass }}">
        {{ $sla === 'no_sla' ? 'No SLA' : ucfirst(str_replace('_',' ', $sla)) }}
    </span>
</td>
<td class="px-5 py-4">@if($incident->task)<a href="{{ route('tasks.show',$incident->task) }}" class="text-blue-600 font-semibold">{{ $incident->task->task_no }}</a>@else - @endif</td>
<td class="px-5 py-4 text-right"><a href="{{ route('incidents.edit',$incident) }}" class="font-semibold">Edit</a></td>
</tr>
@empty
<tr><td colspan="8" class="px-5 py-10 text-center text-slate-500">No incidents.</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="mt-4">{{ $incidents->links() }}</div>
</x-app-layout>
