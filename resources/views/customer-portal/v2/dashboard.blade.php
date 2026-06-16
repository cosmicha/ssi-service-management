@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">
    <div class="bg-slate-950 text-white rounded-3xl p-8">
        <div class="text-sm font-black uppercase tracking-widest text-[#ff8a00]">Customer Portal v2</div>
        <h1 class="text-4xl font-black mt-2">Service Dashboard</h1>
        <p class="text-white/60 mt-2">Your assets, tickets, work orders, and service status.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-5">
        <a href="{{ route('customer.v2.assets') }}" class="bg-white rounded-3xl border p-6 shadow-sm">
            <div class="text-sm font-bold text-slate-500">Assets</div>
            <div class="text-4xl font-black mt-2">{{ $assets }}</div>
        </a>
        <a href="{{ route('customer.v2.tickets') }}" class="bg-white rounded-3xl border p-6 shadow-sm">
            <div class="text-sm font-bold text-slate-500">Open Incidents</div>
            <div class="text-4xl font-black mt-2">{{ $openIncidents }}</div>
        </a>
        <div class="bg-white rounded-3xl border p-6 shadow-sm">
            <div class="text-sm font-bold text-slate-500">Open Changes</div>
            <div class="text-4xl font-black mt-2">{{ $openChanges }}</div>
        </div>
    </div>

    <div class="grid xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl border shadow-sm p-6">
            <h2 class="text-xl font-black mb-4">Latest Tickets</h2>
            <div class="divide-y">
                @forelse($incidents as $incident)
                    <div class="py-3">
                        <div class="font-bold">{{ $incident->title }}</div>
                        <div class="text-sm text-slate-500">{{ $incident->branch?->name ?? '-' }} · {{ $incident->status }}</div>
                    </div>
                @empty
                    <div class="text-slate-500">No tickets.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-3xl border shadow-sm p-6">
            <h2 class="text-xl font-black mb-4">Latest Work Orders</h2>
            <div class="divide-y">
                @forelse($tasks as $task)
                    <div class="py-3">
                        <div class="font-bold">{{ $task->title }}</div>
                        <div class="text-sm text-slate-500">{{ $task->branch?->name ?? '-' }} · {{ $task->status }}</div>
                    </div>
                @empty
                    <div class="text-slate-500">No work orders.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
