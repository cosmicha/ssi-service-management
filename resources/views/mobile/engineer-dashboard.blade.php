@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4 space-y-5">
    <div class="bg-slate-950 text-white rounded-3xl p-6">
        <div class="text-sm font-black uppercase tracking-widest text-[#ff8a00]">Engineer Mobile View</div>
        <h1 class="text-3xl font-black mt-2">My Work Today</h1>
        <p class="text-white/60 mt-1">Tasks, incidents, and preventive maintenance assigned to you.</p>
    </div>

    <div class="bg-white rounded-3xl border shadow-sm p-5">
        <h2 class="text-xl font-black mb-4">My Tasks</h2>
        <div class="space-y-4">
            @forelse($tasks as $task)
                <form method="POST" action="{{ route('engineer.mobile.tasks.update', $task) }}" class="border rounded-2xl p-4">
                    @csrf
                    <div class="font-black">{{ $task->title }}</div>
                    <div class="text-sm text-slate-500">{{ $task->customer?->name ?? '-' }} / {{ $task->branch?->name ?? '-' }}</div>
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <select name="status" class="rounded-xl border-slate-300">
                            @foreach(['assigned','in_progress','pending','completed'] as $status)
                                <option value="{{ $status }}" @selected($task->status === $status)>{{ ucfirst(str_replace('_',' ', $status)) }}</option>
                            @endforeach
                        </select>
                        <button class="rounded-xl bg-[#ff8a00] font-black">Update</button>
                    </div>
                    <textarea name="note" class="mt-3 w-full rounded-xl border-slate-300" placeholder="Progress note"></textarea>
                </form>
            @empty
                <div class="text-slate-500">No active task assigned.</div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-3xl border shadow-sm p-5">
        <h2 class="text-xl font-black mb-4">Assigned Incidents</h2>
        <div class="divide-y">
            @forelse($incidents as $incident)
                <div class="py-3">
                    <div class="font-bold">{{ $incident->title }}</div>
                    <div class="text-sm text-slate-500">{{ $incident->customer?->name ?? '-' }} · {{ $incident->status }}</div>
                </div>
            @empty
                <div class="text-slate-500">No active assigned incident.</div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-3xl border shadow-sm p-5">
        <h2 class="text-xl font-black mb-4">Preventive Maintenance</h2>
        <div class="divide-y">
            @forelse($pms as $pm)
                <div class="py-3">
                    <div class="font-bold">{{ $pm->pm_no ?? 'PM-'.$pm->id }}</div>
                    <div class="text-sm text-slate-500">{{ $pm->task?->customer?->name ?? '-' }} · {{ $pm->status }}</div>
                </div>
            @empty
                <div class="text-slate-500">No active PM assigned.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
