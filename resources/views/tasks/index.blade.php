<x-app-layout>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Tasks</h1>
            <p class="text-slate-500 mt-1">Unified work queue for preventive, corrective, change request, and field operations.</p>
        </div>
        <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-black text-white rounded-xl font-semibold">+ Add Task</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="text-left px-5 py-3">Task</th>
                    <th class="text-left px-5 py-3">Type</th>
                    <th class="text-left px-5 py-3">Customer / Site</th>
                    <th class="text-left px-5 py-3">Asset</th>
                    <th class="text-left px-5 py-3">Assigned To</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Due</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($tasks as $task)
                    <tr onclick="window.location='{{ route('tasks.show', $task) }}'" class="cursor-pointer hover:bg-orange-50/60">
                        <td class="px-5 py-4">
                            <div class="font-black text-slate-900">{{ $task->title }}</div>
                            <div class="text-xs text-slate-500">{{ $task->task_no }} • {{ ucfirst($task->priority) }}</div>
                        </td>
                        <td class="px-5 py-4 capitalize">{{ str_replace('_', ' ', $task->task_type) }}</td>
                        <td class="px-5 py-4">
                            {{ $task->customer->name ?? '-' }}
                            <div class="text-xs text-slate-500">{{ $task->branch->name ?? '-' }}</div>
                        </td>
                        <td class="px-5 py-4">{{ $task->asset->name ?? '-' }}</td>
                        <td class="px-5 py-4">{{ $task->assignee->name ?? 'Unassigned' }}</td>
                        <td class="px-5 py-4 capitalize">{{ str_replace('_', ' ', $task->status) }}</td>
                        <td class="px-5 py-4">{{ $task->due_date ? $task->due_date->format('d M Y H:i') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-slate-500">No tasks yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $tasks->links() }}</div>
</x-app-layout>
