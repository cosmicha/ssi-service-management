<x-app-layout>
<div class="mb-6">
    <h1 class="text-2xl font-black">Engineer Dashboard</h1>
    <p class="text-slate-500">Your assigned work orders and field activities.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border p-5 border-b-4 border-b-[#ff8a00]">
        <div class="text-sm text-slate-500">Open Work Orders</div>
        <div class="text-3xl font-black mt-2">{{ $openCount }}</div>
    </div>

    <div class="bg-white rounded-2xl border p-5 border-b-4 border-b-[#ff8a00]">
        <div class="text-sm text-slate-500">Completed Today</div>
        <div class="text-3xl font-black mt-2">{{ $completedToday }}</div>
    </div>

    <div class="bg-black text-white rounded-2xl border p-5 border-b-4 border-b-[#ff8a00]">
        <div class="text-sm text-white/60">Role</div>
        <div class="text-3xl font-black mt-2">Engineer</div>
    </div>
</div>

<div class="bg-white rounded-2xl border overflow-hidden">
    <div class="px-5 py-4 border-b">
        <h2 class="font-black">My Assigned Tasks</h2>
    </div>

    <table class="w-full text-sm">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-5 py-3">Task</th>
                <th class="text-left px-5 py-3">Customer / Location</th>
                <th class="text-left px-5 py-3">Asset</th>
                <th class="text-left px-5 py-3">Priority</th>
                <th class="text-left px-5 py-3">Status</th>
                <th class="text-left px-5 py-3">Dispatch</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse($tasks as $task)
                <tr onclick="window.location='{{ route('tasks.show', $task) }}'" class="cursor-pointer hover:bg-orange-50">
                    <td class="px-5 py-4">
                        <div class="font-black">{{ $task->title }}</div>
                        <div class="text-xs text-slate-500">{{ $task->task_no }}</div>
                    </td>
                    <td class="px-5 py-4">
                        {{ $task->customer->name ?? '-' }}
                        <div class="text-xs text-slate-500">{{ $task->branch->name ?? 'HO / All Locations' }}</div>
                    </td>
                    <td class="px-5 py-4">{{ $task->asset->name ?? '-' }}</td>
                    <td class="px-5 py-4 capitalize">{{ $task->priority }}</td>
                    <td class="px-5 py-4 capitalize">{{ str_replace('_',' ', $task->status) }}</td>
                    <td class="px-5 py-4 capitalize">{{ str_replace('_',' ', $task->dispatch_status ?? 'not_dispatched') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-slate-500">No assigned tasks.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $tasks->links() }}</div>
</x-app-layout>
