@if($task)
<div class="bg-white rounded-2xl border border-slate-200 p-6 mt-6">
    <h2 class="text-lg font-black text-slate-900 mb-4">Add Update</h2>

    <form method="POST" enctype="multipart/form-data" action="{{ route('tasks.updates.store', $task) }}">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Update Type</label>
                <select name="update_type" id="task_update_type_panel" class="w-full rounded-xl border-slate-300">
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

        <div id="task_status_field_panel" class="mb-4 hidden">
            <label class="block text-sm font-semibold mb-1">New Status</label>
            <select name="status" class="w-full rounded-xl border-slate-300">
                @foreach(['open'=>'Open','assigned'=>'Assigned','in_progress'=>'In Progress','pending'=>'Pending','cancelled'=>'Cancelled'] as $value => $label)
                    <option value="{{ $value }}" @selected($task->status === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <label class="block text-sm font-semibold mb-1">Activity / Progress Note</label>
        <textarea name="message" rows="4" class="w-full rounded-xl border-slate-300"></textarea>

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
                <div class="flex justify-between gap-4">
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
                                    <div class="text-xs text-slate-500">{{ $file->mime_type ?? '-' }}</div>
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
            <div class="text-slate-500">No updates yet.</div>
        @endforelse
    </div>
</div>
@endif

<script>
function toggleTaskStatusFieldPanel() {
    const type = document.getElementById('task_update_type_panel');
    const field = document.getElementById('task_status_field_panel');
    if (!type || !field) return;
    field.classList.toggle('hidden', type.value !== 'status_change');
}
document.addEventListener('DOMContentLoaded', function () {
    const type = document.getElementById('task_update_type_panel');
    if (type) {
        type.addEventListener('change', toggleTaskStatusFieldPanel);
        toggleTaskStatusFieldPanel();
    }
});
</script>
