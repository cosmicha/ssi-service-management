<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Title</label>
        <input name="title" value="{{ old('title', $incident->title ?? '') }}" class="w-full rounded-xl border-slate-300" required>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Customer</label>
        <select name="customer_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @selected(old('customer_id', $incident->customer_id ?? '') == $customer->id)>{{ $customer->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Region</label>
        <select name="customer_region_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Region</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}" @selected(old('customer_region_id', $incident->customer_region_id ?? '') == $region->id)>{{ $region->customer->name ?? '' }} - {{ $region->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Branch / Site</label>
        <select name="customer_branch_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Branch</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}" @selected(old('customer_branch_id', $incident->customer_branch_id ?? '') == $branch->id)>{{ $branch->customer->name ?? '' }} - {{ $branch->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Asset</label>
        <select name="asset_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Asset</option>
            @foreach($assets as $asset)
                <option value="{{ $asset->id }}" @selected(old('asset_id', $incident->asset_id ?? '') == $asset->id)>{{ $asset->name }} - {{ $asset->customer->name ?? '' }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Category</label>
        <select name="incident_category_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('incident_category_id', $incident->incident_category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Severity</label>
        <select name="severity" class="w-full rounded-xl border-slate-300">
            @foreach(['low'=>'Low','medium'=>'Medium','high'=>'High','critical'=>'Critical'] as $value => $label)
                <option value="{{ $value }}" @selected(old('severity', $incident->severity ?? 'medium') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    @if(!isset($incident))
    <div>
        <label class="block text-sm font-semibold mb-1">Assign Engineer</label>
        <select name="assigned_to" class="w-full rounded-xl border-slate-300">
            <option value="">Unassigned</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <div>
        <label class="block text-sm font-semibold mb-1">Reported By</label>
        <input name="reported_by" value="{{ old('reported_by', $incident->reported_by ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Reported At</label>
        <input type="datetime-local" name="reported_at" value="{{ old('reported_at', isset($incident) && $incident->reported_at ? $incident->reported_at->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="flex items-center gap-2 text-sm font-semibold mb-1">
            <input type="checkbox" name="has_sla" value="1" class="rounded border-slate-300" checked>
            Enable SLA
        </label>

        <div class="grid grid-cols-2 gap-3 mt-2">
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Response Minutes</label>
                <input type="number" name="response_minutes" value="30" class="w-full rounded-xl border-slate-300">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Resolution Minutes</label>
                <input type="number" name="resolution_minutes" value="240" class="w-full rounded-xl border-slate-300">
            </div>
        </div>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300">
            @foreach(['open'=>'Open','assigned'=>'Assigned','in_progress'=>'In Progress','resolved'=>'Resolved','closed'=>'Closed'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $incident->status ?? 'open') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Description</label>
        <textarea name="description" rows="4" class="w-full rounded-xl border-slate-300">{{ old('description', $incident->description ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Attachments</label>
        <input type="file" name="attachments[]" multiple class="w-full rounded-xl border border-slate-300 p-2">
        <p class="text-xs text-slate-500 mt-1">Upload photos, screenshots, logs, PDFs, documents, configs, or other evidence. Max 20MB per file.</p>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Save Incident</button>
    <a href="{{ route('incidents.index') }}" class="px-5 py-2.5 bg-white border rounded-xl font-semibold">Cancel</a>
</div>
