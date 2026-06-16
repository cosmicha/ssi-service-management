@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-3xl font-black">Preventive Maintenance Report</h1>
            <p class="text-slate-500">PM schedule and execution report.</p>
        </div>
        <a href="{{ route('reports.export','preventive') }}?{{ http_build_query(request()->all()) }}" class="px-5 py-3 rounded-2xl bg-slate-900 text-white font-black">Export CSV</a>
    </div>

    @include('reports._filters')

    <div class="bg-white rounded-3xl border shadow-sm overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="p-4 text-left">PM No</th>
                    <th class="p-4 text-left">Schedule</th>
                    <th class="p-4 text-left">Engineer</th>
                    <th class="p-4 text-left">Task</th>
                    <th class="p-4 text-left">Customer</th>
                    <th class="p-4 text-left">Branch</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Completed</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                    <tr class="border-t">
                        <td class="p-4 font-bold">{{ $i->pm_no ?? $i->id }}</td>
                        <td class="p-4">{{ $i->preventiveSchedule?->name ?? '-' }}</td>
                        <td class="p-4">{{ $i->engineer?->name ?? '-' }}</td>
                        <td class="p-4">{{ $i->task?->title ?? '-' }}</td>
                        <td class="p-4">{{ $i->task?->customer?->name ?? '-' }}</td>
                        <td class="p-4">{{ $i->task?->branch?->name ?? '-' }}</td>
                        <td class="p-4">{{ $i->status }}</td>
                        <td class="p-4">{{ $i->completed_at?->format('d M Y H:i') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="p-6 text-center text-slate-500">No data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $items->links() }}</div>
</div>
@endsection
