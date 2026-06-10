<x-app-layout>
<div class="mb-6">
    <h1 class="text-2xl font-black">Preventive Maintenance</h1>
    <p class="text-slate-500">View scheduled and completed maintenance activities for your assets.</p>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h2 class="font-black">Upcoming PM Schedule</h2>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="text-left px-5 py-3">Schedule</th>
                    <th class="text-left px-5 py-3">Asset</th>
                    <th class="text-left px-5 py-3">Location</th>
                    <th class="text-left px-5 py-3">Next Run</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($schedules as $schedule)
                    <tr>
                        <td class="px-5 py-4 font-black">{{ $schedule->name }}</td>
                        <td class="px-5 py-4">{{ $schedule->asset->name ?? '-' }}</td>
                        <td class="px-5 py-4">{{ $schedule->asset->branch->name ?? 'HO / All Locations' }}</td>
                        <td class="px-5 py-4">{{ $schedule->next_run_date?->format('d M Y') ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-slate-500">No upcoming PM schedule.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">{{ $schedules->links() }}</div>
    </div>

    <div class="bg-white rounded-2xl border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h2 class="font-black">PM History</h2>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="text-left px-5 py-3">PM</th>
                    <th class="text-left px-5 py-3">Asset</th>
                    <th class="text-left px-5 py-3">Engineer</th>
                    <th class="text-left px-5 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($executions as $execution)
                    <tr>
                        <td class="px-5 py-4">
                            <div class="font-black">{{ $execution->pm_no ?? 'PM' }}</div>
                            <div class="text-xs text-slate-500">{{ $execution->created_at?->format('d M Y H:i') }}</div>
                        </td>
                        <td class="px-5 py-4">{{ $execution->task->asset->name ?? '-' }}</td>
                        <td class="px-5 py-4">{{ $execution->engineer->name ?? '-' }}</td>
                        <td class="px-5 py-4">{{ $execution->completed_at ? 'Completed' : 'In Progress' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-slate-500">No PM history yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">{{ $executions->links() }}</div>
    </div>
</div>
</x-app-layout>
