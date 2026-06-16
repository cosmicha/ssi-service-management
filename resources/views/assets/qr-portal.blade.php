@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 space-y-6">
    <div class="bg-slate-950 text-white rounded-3xl p-8">
        <div class="text-sm font-black uppercase tracking-widest text-[#ff8a00]">QR Asset Portal</div>
        <h1 class="text-4xl font-black mt-2">{{ $asset->name }}</h1>
        <p class="text-white/60 mt-2">{{ $asset->customer?->name ?? '-' }} / {{ $asset->branch?->name ?? '-' }}</p>
    </div>

    <div class="grid md:grid-cols-3 gap-5">
        @foreach([
            ['Asset Code', $asset->asset_code ?? '-'],
            ['Category', $asset->category?->name ?? '-'],
            ['Status', $asset->status ?? '-'],
            ['Brand', $asset->brand ?? '-'],
            ['Model', $asset->model ?? '-'],
            ['Serial Number', $asset->serial_number ?? '-'],
            ['Warranty End', $asset->warranty_end_date ?? $asset->warranty_expiry ?? '-'],
            ['QR UUID', $asset->qr_uuid ?? $asset->id],
            ['Location', $asset->branch?->name ?? '-'],
        ] as [$label,$value])
            <div class="bg-white rounded-3xl border shadow-sm p-5">
                <div class="text-xs font-black text-slate-500 uppercase">{{ $label }}</div>
                <div class="text-lg font-black mt-2">{{ $value }}</div>
            </div>
        @endforeach
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl border shadow-sm p-6">
            <h2 class="text-xl font-black mb-4">Recent Incidents</h2>
            <div class="divide-y">
                @forelse($incidents as $incident)
                    <div class="py-3">
                        <div class="font-bold">{{ $incident->title }}</div>
                        <div class="text-sm text-slate-500">{{ $incident->status }} · {{ $incident->created_at?->format('d M Y') }}</div>
                    </div>
                @empty
                    <div class="text-slate-500">No incident history.</div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-3xl border shadow-sm p-6">
            <h2 class="text-xl font-black mb-4">Recent Work Orders</h2>
            <div class="divide-y">
                @forelse($tasks as $task)
                    <div class="py-3">
                        <div class="font-bold">{{ $task->title }}</div>
                        <div class="text-sm text-slate-500">{{ $task->status }} · {{ $task->created_at?->format('d M Y') }}</div>
                    </div>
                @empty
                    <div class="text-slate-500">No work order history.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
