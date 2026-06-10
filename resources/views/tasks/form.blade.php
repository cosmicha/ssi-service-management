<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold mb-1">Task Type</label>
        <select name="task_type" class="w-full rounded-xl border-slate-300" required>
            @foreach(['preventive'=>'Preventive','corrective'=>'Corrective','change'=>'Change Request','general'=>'General','site_survey'=>'Site Survey','implementation'=>'Implementation'] as $value => $label)
                <option value="{{ $value }}" @selected(old('task_type', $task->task_type ?? 'general') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Priority</label>
        <select name="priority" class="w-full rounded-xl border-slate-300" required>
            @foreach(['low'=>'Low','medium'=>'Medium','high'=>'High','critical'=>'Critical'] as $value => $label)
                <option value="{{ $value }}" @selected(old('priority', $task->priority ?? 'medium') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Title</label>
        <input name="title" value="{{ old('title', $task->title ?? '') }}" class="w-full rounded-xl border-slate-300" required>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Customer</label>
        <select name="customer_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @selected(old('customer_id', $task->customer_id ?? '') == $customer->id)>{{ $customer->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Region</label>
        <select name="customer_region_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Region</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}" @selected(old('customer_region_id', $task->customer_region_id ?? '') == $region->id)>{{ $region->customer->name ?? '' }} - {{ $region->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Branch / Site</label>
        <select name="customer_branch_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Branch</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}" @selected(old('customer_branch_id', $task->customer_branch_id ?? '') == $branch->id)>{{ $branch->customer->name ?? '' }} - {{ $branch->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Asset</label>
        <select name="asset_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Asset</option>
            @foreach($assets as $asset)
                <option value="{{ $asset->id }}" @selected(old('asset_id', $task->asset_id ?? '') == $asset->id)>{{ $asset->name }} - {{ $asset->customer->name ?? '' }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Assign To</label>
        <select name="assigned_to" class="w-full rounded-xl border-slate-300">
            <option value="">Unassigned</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('assigned_to', $task->assigned_to ?? '') == $user->id)>{{ $user->name }} {{ isset($user->role) ? '(' . $user->role . ')' : '' }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300" required>
            @foreach(['open'=>'Open','assigned'=>'Assigned','in_progress'=>'In Progress','pending'=>'Pending','completed'=>'Completed','cancelled'=>'Cancelled'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $task->status ?? 'open') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Planned Date</label>
        <input type="date" name="planned_date" value="{{ old('planned_date', isset($task) && $task->planned_date ? $task->planned_date->format('Y-m-d') : '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Due Date</label>
        <input type="datetime-local" name="due_date" value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full rounded-xl border-slate-300">{{ old('description', $task->description ?? '') }}</textarea>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Save Task</button>
    <a href="{{ route('tasks.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-xl font-semibold text-slate-700">Cancel</a>
</div>
