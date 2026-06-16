<x-app-layout>

<div class="mb-6">
    <div class="rounded-[2rem] bg-black text-white p-8 relative overflow-hidden">
        <div class="absolute -right-16 -bottom-20 w-72 h-72 rounded-full bg-[#ff8a00]/30"></div>

        <div class="relative z-10 flex items-start justify-between gap-6">
            <div>
                <div class="text-[#ff8a00] text-sm font-black uppercase tracking-widest">Service Level Monitoring</div>
                <h1 class="text-4xl font-black mt-2">SLA Dashboard</h1>
                <p class="text-white/60 mt-2">Response, resolution, breach risk, and compliance overview.</p>
            </div>

            <form method="POST" action="{{ route('sla.refresh') }}">
                @csrf
                <button class="px-5 py-3 rounded-2xl bg-[#ff8a00] text-black font-black hover:bg-white transition">
                    Refresh SLA
                </button>
            </form>
        </div>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
    <div class="rounded-3xl bg-white border p-5 shadow-sm">
        <div class="text-xs text-slate-500 font-bold">Compliance</div>
        <div class="text-3xl font-black text-[#ff8a00] mt-1">{{ $compliance }}%</div>
    </div>

    <div class="rounded-3xl bg-white border p-5 shadow-sm">
        <div class="text-xs text-slate-500 font-bold">Total</div>
        <div class="text-3xl font-black mt-1">{{ $total }}</div>
    </div>

    <div class="rounded-3xl bg-white border p-5 shadow-sm">
        <div class="text-xs text-slate-500 font-bold">On Track</div>
        <div class="text-3xl font-black text-blue-600 mt-1">{{ $onTrack }}</div>
    </div>

    <div class="rounded-3xl bg-white border p-5 shadow-sm">
        <div class="text-xs text-slate-500 font-bold">Near</div>
        <div class="text-3xl font-black text-yellow-600 mt-1">{{ $nearBreach }}</div>
    </div>

    <div class="rounded-3xl bg-white border p-5 shadow-sm">
        <div class="text-xs text-slate-500 font-bold">Breached</div>
        <div class="text-3xl font-black text-red-600 mt-1">{{ $breached }}</div>
    </div>

    <div class="rounded-3xl bg-white border p-5 shadow-sm">
        <div class="text-xs text-slate-500 font-bold">Met</div>
        <div class="text-3xl font-black text-green-600 mt-1">{{ $met }}</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    <div class="bg-white rounded-3xl border shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b bg-yellow-50 flex items-center justify-between">
            <div>
                <div class="font-black">Near Breach</div>
                <div class="text-xs text-slate-500">Tickets requiring attention</div>
            </div>
            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-black">{{ $nearBreach }}</span>
        </div>

        <div class="divide-y max-h-[420px] overflow-y-auto">
            @forelse($nearBreaches as $incident)
                <a href="{{ route('incidents.show', $incident) }}" class="block px-5 py-4 hover:bg-orange-50">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="font-black">{{ $incident->title }}</div>
                            <div class="text-xs text-slate-500 mt-1">
                                {{ $incident->customer?->name }} • {{ $incident->asset?->asset_code ?? '-' }}
                            </div>
                        </div>
                        <div class="text-xs font-black text-yellow-700 whitespace-nowrap">
                            {{ $incident->resolution_due_at?->format('d M H:i') ?? '-' }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-slate-400">No near breach tickets.</div>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-3xl border shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b bg-red-50 flex items-center justify-between">
            <div>
                <div class="font-black">Breached</div>
                <div class="text-xs text-slate-500">Tickets already missed SLA</div>
            </div>
            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-black">{{ $breached }}</span>
        </div>

        <div class="divide-y max-h-[420px] overflow-y-auto">
            @forelse($recentBreaches as $incident)
                <a href="{{ route('incidents.show', $incident) }}" class="block px-5 py-4 hover:bg-red-50">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="font-black">{{ $incident->title }}</div>
                            <div class="text-xs text-slate-500 mt-1">
                                {{ $incident->customer?->name }} • {{ $incident->asset?->asset_code ?? '-' }}
                            </div>
                        </div>
                        <div class="text-xs font-black text-red-700 whitespace-nowrap">
                            {{ $incident->sla_breached_at?->format('d M H:i') ?? '-' }}
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-slate-400">No breached tickets.</div>
            @endforelse
        </div>
    </div>
</div>

</x-app-layout>
