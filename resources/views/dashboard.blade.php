<x-app-layout>
    <div class="mb-8">
        <div class="flex items-start justify-between gap-4 mb-6">
    <div>
        <h1 class="text-3xl font-black text-slate-950">Dashboard</h1>
        <p class="text-slate-500 mt-1">Service operation summary and SLA health.</p>
    </div>

    <form method="POST" action="{{ route('sla.refresh') }}">
        @csrf
        <button class="px-4 py-2.5 rounded-xl bg-black text-white font-bold hover:bg-[#ff8a00] hover:text-black">
            Refresh SLA
        </button>
    </form>
</div>
        <p class="text-slate-500 mt-1">Operations overview and real-time summary of your service management.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-8 gap-3 mb-6">
        <a href="{{ route('incidents.create') }}" class="group bg-white rounded-2xl border border-slate-200 p-4 text-center shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="text-2xl text-[#ff8a00] mb-2">⚠</div>
            <div class="font-black text-sm">New Incident</div>
        </a>

        <a href="{{ route('change-requests.create') }}" class="group bg-white rounded-2xl border border-slate-200 p-4 text-center shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="text-2xl text-[#ff8a00] mb-2">⇄</div>
            <div class="font-black text-sm">New Change</div>
        </a>

        <a href="{{ route('preventive-schedules.create') }}" class="group bg-white rounded-2xl border border-slate-200 p-4 text-center shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="text-2xl text-[#ff8a00] mb-2">▣</div>
            <div class="font-black text-sm">PM Schedule</div>
        </a>

        <a href="{{ route('tasks.create') }}" class="group bg-white rounded-2xl border border-slate-200 p-4 text-center shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="text-2xl text-[#ff8a00] mb-2">☑</div>
            <div class="font-black text-sm">New Task</div>
        </a>

        <a href="{{ route('assets.create') }}" class="group bg-white rounded-2xl border border-slate-200 p-4 text-center shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="text-2xl text-[#ff8a00] mb-2">▤</div>
            <div class="font-black text-sm">New Asset</div>
        </a>

        <a href="{{ route('customers.create') }}" class="group bg-white rounded-2xl border border-slate-200 p-4 text-center shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="text-2xl text-[#ff8a00] mb-2">♟</div>
            <div class="font-black text-sm">New Customer</div>
        </a>

        <a href="{{ route('tasks.index') }}" class="group bg-white rounded-2xl border border-slate-200 p-4 text-center shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="text-2xl text-[#ff8a00] mb-2">◴</div>
            <div class="font-black text-sm">Tasks</div>
        </a>

        <a href="#" class="group bg-white rounded-2xl border border-slate-200 p-4 text-center shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="text-2xl text-[#ff8a00] mb-2">▥</div>
            <div class="font-black text-sm">Reports</div>
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
        <a href="{{ route('tasks.index') }}" class="block bg-white rounded-2xl border border-slate-200 p-4 shadow-sm border-b-4 border-b-[#ff8a00] hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="h-9 w-9 rounded-xl bg-orange-100 text-[#ff8a00] flex items-center justify-center text-xl mb-3">☑</div>
            <div class="font-black">Open Tasks</div>
            <div class="text-3xl font-black mt-2">{{ $openTasks }}</div>
            <div class="text-xs text-slate-500 mt-1">Tasks in progress</div>
        </a>

        <a href="{{ route('incidents.index') }}" class="block bg-white rounded-2xl border border-slate-200 p-4 shadow-sm border-b-4 border-b-[#ff8a00] hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="h-9 w-9 rounded-xl bg-orange-100 text-[#ff8a00] flex items-center justify-center text-xl mb-3">⚠</div>
            <div class="font-black">Open Incidents</div>
            <div class="text-3xl font-black mt-2">{{ $openIncidents }}</div>
            <div class="text-xs text-slate-500 mt-1">Incidents active</div>
        </a>

        <div class="bg-black rounded-2xl border border-black p-6 shadow-sm border-b-4 border-b-[#ff8a00] text-white">
            <div class="h-9 w-9 rounded-xl bg-black text-[#ff8a00] border border-[#ff8a00] flex items-center justify-center text-xl mb-3">⚠</div>
            <div class="font-black">Critical Incidents</div>
            <div class="text-3xl font-black mt-2">{{ $criticalIncidents }}</div>
            <div class="text-xs text-white/70 mt-1">Requires immediate attention</div>
        </div>

        <a href="{{ route('change-requests.index') }}" class="block bg-white rounded-2xl border border-slate-200 p-4 shadow-sm border-b-4 border-b-[#ff8a00] hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="h-9 w-9 rounded-xl bg-orange-100 text-[#ff8a00] flex items-center justify-center text-xl mb-3">▤</div>
            <div class="font-black">Pending Changes</div>
            <div class="text-3xl font-black mt-2">{{ $pendingChanges }}</div>
            <div class="text-xs text-slate-500 mt-1">Awaiting approval / execution</div>
        </a>

        <a href="{{ route('preventive-schedules.index') }}" class="block bg-white rounded-2xl border border-slate-200 p-4 shadow-sm border-b-4 border-b-[#ff8a00] hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="h-9 w-9 rounded-xl bg-orange-100 text-[#ff8a00] flex items-center justify-center text-xl mb-3">▣</div>
            <div class="font-black">PM Due</div>
            <div class="text-3xl font-black mt-2">{{ $pmDue }}</div>
            <div class="text-xs text-slate-500 mt-1">Due for execution</div>
        </a>

        <a href="{{ route('assets.index') }}" class="block bg-white rounded-2xl border border-slate-200 p-4 shadow-sm border-b-4 border-b-[#ff8a00] hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="h-9 w-9 rounded-xl bg-orange-100 text-[#ff8a00] flex items-center justify-center text-xl mb-3">▦</div>
            <div class="font-black">Total Assets</div>
            <div class="text-3xl font-black mt-2">{{ $totalAssets }}</div>
            <div class="text-xs text-slate-500 mt-1">Assets registered</div>
        </a>

        <a href="{{ route('incidents.index') }}" class="block bg-white rounded-2xl border border-slate-200 p-4 shadow-sm border-b-4 border-b-red-500 hover:shadow-lg hover:-translate-y-0.5 transition">
            <div class="h-9 w-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center text-xl mb-3">⏱</div>
            <div class="font-black">SLA Breach</div>
            <div class="text-3xl font-black mt-2">{{ $slaBreached }}</div>
            <div class="text-xs text-slate-500 mt-1">{{ $slaNoSla }} no SLA tickets</div>
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <div class="flex justify-between items-center mb-5">
                <div class="flex items-center gap-3">
                    <div class="text-[#ff8a00] text-2xl">◷</div>
                    <h2 class="text-xl font-black">Recent Tasks</h2>
                </div>
                <a href="{{ route('tasks.index') }}" class="text-[#ff8a00] font-bold">View All Tasks →</a>
            </div>

            <div class="overflow-hidden rounded-xl border border-slate-100">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                        <tr>
                            <th class="text-left px-4 py-3">Task No.</th>
                            <th class="text-left px-4 py-3">Title</th>
                            <th class="text-left px-4 py-3">Type</th>
                            <th class="text-left px-4 py-3">Customer</th>
                            <th class="text-left px-4 py-3">Asset</th>
                            <th class="text-left px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentTasks as $task)
                            <tr onclick="window.location='{{ route('tasks.show', $task) }}'" class="hover:bg-orange-50/40 cursor-pointer">
                                <td class="px-4 py-4 text-slate-600">{{ $task->task_no }}</td>
                                <td class="px-4 py-4">
                                    <a href="{{ route('tasks.show', $task) }}" class="font-semibold hover:underline">{{ $task->title }}</a>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="px-3 py-1 rounded-lg text-xs font-bold bg-orange-100 text-[#ff8a00] capitalize">
                                        {{ str_replace('_',' ', $task->task_type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">{{ $task->customer->name ?? '-' }}</td>
                                <td class="px-4 py-4">{{ $task->asset->name ?? '-' }}</td>
                                <td class="px-4 py-4">
                                    <span class="px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 capitalize">
                                        {{ str_replace('_',' ', $task->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-10 text-center text-slate-500">No tasks yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
            <div class="flex justify-between items-center mb-5">
                <div class="flex items-center gap-3">
                    <div class="text-[#ff8a00] text-2xl">▣</div>
                    <h2 class="text-xl font-black">Upcoming PM</h2>
                </div>
                <a href="{{ route('preventive-schedules.index') }}" class="text-[#ff8a00] font-bold">View All →</a>
            </div>

            <div class="space-y-4">
                @foreach(\App\Models\PreventiveSchedule::with(['asset','contract'])->where('status','active')->orderBy('next_run_date')->limit(4)->get() as $pm)
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex gap-3">
                            <div class="w-12 rounded-xl bg-orange-50 text-center py-2">
                                <div class="text-xs font-black text-[#ff8a00] uppercase">{{ $pm->next_run_date?->format('M') ?? '-' }}</div>
                                <div class="text-xl font-black">{{ $pm->next_run_date?->format('d') ?? '-' }}</div>
                            </div>
                            <div>
                                <div class="font-black">{{ $pm->name }}</div>
                                <div class="text-sm text-slate-500">{{ $pm->asset->name ?? $pm->contract->name ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="text-xs font-bold bg-orange-50 text-[#ff8a00] px-3 py-1 rounded-lg">
                            Due
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
