<x-app-layout>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-black">Preventive Schedules</h1>
        <p class="text-slate-500">Recurring preventive maintenance plans.</p>
    </div>

    <a href="{{ route('preventive-schedules.create') }}"
       class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">
        + Add Schedule
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl border overflow-hidden">
<table class="w-full text-sm">
<thead class="bg-slate-50">
<tr>
    <th class="text-left px-5 py-3">Schedule</th>
    <th class="text-left px-5 py-3">Contract</th>
    <th class="text-left px-5 py-3">Asset</th>
    <th class="text-left px-5 py-3">Template</th>
    <th class="text-left px-5 py-3">Engineer</th>
    <th class="text-left px-5 py-3">Next Run</th>
    <th class="text-left px-5 py-3">Status</th>
    <th class="text-right px-5 py-3">Action</th>
</tr>
</thead>

<tbody class="divide-y">
@forelse($schedules as $schedule)
<tr>
    <td class="px-5 py-4">
        <div class="font-bold">{{ $schedule->name }}</div>
        <div class="text-xs text-slate-500">
            {{ ucfirst($schedule->frequency) }}
        </div>
    </td>

    <td class="px-5 py-4">
        {{ $schedule->contract->name ?? '-' }}
    </td>

    <td class="px-5 py-4">
        {{ $schedule->asset->name ?? '-' }}
    </td>

    <td class="px-5 py-4">
        {{ $schedule->template->name ?? '-' }}
    </td>

    <td class="px-5 py-4">
        {{ $schedule->assignee->name ?? '-' }}
    </td>

    <td class="px-5 py-4">
        {{ $schedule->next_run_date?->format('d M Y') }}
    </td>

    <td class="px-5 py-4 capitalize">
        {{ $schedule->status }}
    </td>

    <td class="px-5 py-4 text-right">

        <form method="POST"
              action="{{ route('preventive-schedules.generate-task',$schedule) }}"
              class="inline">
            @csrf
            <button class="text-blue-600 font-semibold mr-3">
                Generate PM
            </button>
        </form>

        <a href="{{ route('preventive-schedules.edit',$schedule) }}"
           class="font-semibold">
            Edit
        </a>

    </td>
</tr>
@empty
<tr>
    <td colspan="8"
        class="px-5 py-10 text-center text-slate-500">
        No preventive schedules.
    </td>
</tr>
@endforelse
</tbody>
</table>
</div>

<div class="mt-4">
{{ $schedules->links() }}
</div>

</x-app-layout>
