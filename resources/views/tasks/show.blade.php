<x-app-layout>
    <div class="mb-6 flex items-start justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900">{{ $task->title }}</h1>
            <p class="text-slate-500 mt-1">{{ $task->task_no }} • {{ ucfirst($task->priority) }} • {{ ucfirst(str_replace('_', ' ', $task->task_type)) }}</p>
        </div>
        <a href="{{ route('tasks.edit', $task) }}" class="px-4 py-2 bg-slate-900 text-white rounded-xl font-semibold">Edit Task</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-sm text-slate-500">Status</div>
            <div class="text-lg font-black mt-2 capitalize">{{ str_replace('_', ' ', $task->status) }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-sm text-slate-500">Assigned To</div>
            <div class="text-lg font-black mt-2">{{ $task->assignee->name ?? 'Unassigned' }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-sm text-slate-500">Planned</div>
            <div class="text-lg font-black mt-2">{{ $task->planned_date ? $task->planned_date->format('d M Y') : '-' }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="text-sm text-slate-500">Due</div>
            <div class="text-lg font-black mt-2">{{ $task->due_date ? $task->due_date->format('d M Y H:i') : '-' }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 p-6">
            <h2 class="text-lg font-black text-slate-900 mb-4">Task Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm mb-6">
                <div><span class="font-semibold">Customer:</span> {{ $task->customer->name ?? '-' }}</div>
                <div><span class="font-semibold">Region:</span> {{ $task->region->name ?? '-' }}</div>
                <div><span class="font-semibold">Branch:</span> {{ $task->branch->name ?? '-' }}</div>
                <div><span class="font-semibold">Asset:</span> {{ $task->asset->name ?? '-' }}</div>
                <div><span class="font-semibold">Created By:</span> {{ $task->creator->name ?? '-' }}</div>
                <div><span class="font-semibold">Started:</span> {{ $task->started_at ? $task->started_at->format('d M Y H:i') : '-' }}</div>
                <div><span class="font-semibold">Completed:</span> {{ $task->completed_at ? $task->completed_at->format('d M Y H:i') : '-' }}</div>
            </div>

            <h3 class="font-black text-slate-900 mb-2">Description</h3>
            <div class="text-slate-600 whitespace-pre-line">{{ $task->description ?? 'No description.' }}</div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            @if($task->task_type === 'preventive')
            <form method="POST" action="{{ route('preventive-executions.start', $task) }}" class="mb-4">
                @csrf
                <button class="w-full px-5 py-2.5 bg-blue-600 text-white rounded-xl font-semibold">
                    Start Preventive Maintenance
                </button>
            </form>
            @endif

            <h2 class="text-lg font-black text-slate-900 mb-4">Update Status</h2>
            <form method="POST" action="{{ route('tasks.update-status', $task) }}" class="space-y-4">
                @csrf
                @method('PATCH')
                <select name="status" class="w-full rounded-xl border-slate-300">
                    @foreach(['open'=>'Open','assigned'=>'Assigned','in_progress'=>'In Progress','pending'=>'Pending','completed'=>'Completed','cancelled'=>'Cancelled'] as $value => $label)
                        <option value="{{ $value }}" @selected($task->status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="w-full px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Update Status</button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 mt-6">
        <h2 class="text-lg font-black text-slate-900 mb-4">Add Task Update</h2>

        <form method="POST" enctype="multipart/form-data" action="{{ route('tasks.updates.store', $task) }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Update Type</label>
                    <select name="update_type" id="task_update_type" class="w-full rounded-xl border-slate-300">
                        <option value="comment">Comment / Customer Update</option>
                        <option value="work_log">Work Log / Activity</option>
                        <option value="status_change">Change Status</option>
                        <option value="assignment">Assignment Note</option>
                        <option value="resolution">Resolution / Complete Task</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Attachments</label>
                    <input type="file" name="attachments[]" multiple class="w-full rounded-xl border border-slate-300 p-2">
                </div>
            </div>

            <div id="task_status_field" class="mb-4 hidden">
                <label class="block text-sm font-semibold mb-1">New Status</label>
                <select name="status" class="w-full rounded-xl border-slate-300">
                    @foreach(['open'=>'Open','assigned'=>'Assigned','in_progress'=>'In Progress','pending'=>'Pending','cancelled'=>'Cancelled'] as $value => $label)
                        <option value="{{ $value }}" @selected($task->status === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Activity / Progress Note</label>
                <textarea name="message" rows="4" class="w-full rounded-xl border-slate-300" placeholder="Write activity, finding, action taken, resolution, or customer update..."></textarea>
            </div>

            <button class="mt-4 px-5 py-2.5 bg-black text-white rounded-xl font-semibold">
                Add Update
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-6 mt-6">
        <h2 class="text-lg font-black text-slate-900 mb-4">Activity Timeline</h2>

        <div class="space-y-4">
            @forelse($task->updates as $update)
                <div class="border border-slate-200 rounded-2xl p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="font-black capitalize">{{ str_replace('_', ' ', $update->update_type) }}</div>
                            <div class="text-xs text-slate-500">
                                {{ $update->user->name ?? '-' }} • {{ $update->created_at?->format('d M Y H:i') }}
                            </div>
                        </div>

                        @if($update->old_status !== $update->new_status)
                            <div class="text-xs font-bold px-3 py-1 rounded-full bg-orange-100 text-[#ff8a00]">
                                {{ str_replace('_',' ', $update->old_status) }} → {{ str_replace('_',' ', $update->new_status) }}
                            </div>
                        @endif
                    </div>

                    @if($update->message)
                        <div class="mt-3 text-slate-700 whitespace-pre-line">{{ $update->message }}</div>
                    @endif

                    @if($update->attachments->count())
                        <div class="mt-4 space-y-2">
                            @foreach($update->attachments as $file)
                                <div class="flex items-center justify-between rounded-xl bg-slate-50 px-3 py-2">
                                    <div>
                                        <div class="font-semibold text-sm">{{ $file->file_name }}</div>
                                        <div class="text-xs text-slate-500">
                                            {{ $file->mime_type ?? '-' }} • {{ $file->file_size ? number_format($file->file_size / 1024, 1) . ' KB' : '-' }}
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-blue-600 font-semibold text-sm">
                                        View / Download
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-slate-500">No task updates yet.</div>
            @endforelse
        </div>
    </div>


<script>
function toggleTaskStatusField() {
    const type = document.getElementById('task_update_type');
    const field = document.getElementById('task_status_field');
    if (!type || !field) return;
    field.classList.toggle('hidden', type.value !== 'status_change');
}
document.addEventListener('DOMContentLoaded', function () {
    const type = document.getElementById('task_update_type');
    if (type) {
        type.addEventListener('change', toggleTaskStatusField);
        toggleTaskStatusField();
    }
});
</script>
</x-app-layout>
