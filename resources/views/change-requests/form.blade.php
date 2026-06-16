<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Title</label>
        <input name="title" value="{{ old('title', $changeRequest->title ?? '') }}" class="w-full rounded-xl border-slate-300" required>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Customer</label>
        <select name="customer_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @selected(old('customer_id', $changeRequest->customer_id ?? '') == $customer->id)>{{ $customer->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Branch / Site</label>
        <select name="customer_branch_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Branch</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}" @selected(old('customer_branch_id', $changeRequest->customer_branch_id ?? '') == $branch->id)>{{ $branch->customer->name ?? '' }} - {{ $branch->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Region</label>
        <select name="customer_region_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Region</option>
            @foreach($regions as $region)
                <option value="{{ $region->id }}" @selected(old('customer_region_id', $changeRequest->customer_region_id ?? '') == $region->id)>{{ $region->customer->name ?? '' }} - {{ $region->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Asset</label>
        <select name="asset_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Asset</option>
            @foreach($assets as $asset)
                <option value="{{ $asset->id }}" @selected(old('asset_id', $changeRequest->asset_id ?? '') == $asset->id)>{{ $asset->name }} - {{ $asset->customer->name ?? '' }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Category</label>
        <select name="change_category_id" class="w-full rounded-xl border-slate-300">
            <option value="">No Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('change_category_id', $changeRequest->change_category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Risk Level</label>
        <select name="risk_level" class="w-full rounded-xl border-slate-300">
            @foreach(['low'=>'Low','medium'=>'Medium','high'=>'High'] as $value => $label)
                <option value="{{ $value }}" @selected(old('risk_level', $changeRequest->risk_level ?? 'medium') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Requested By</label>
        <input name="requested_by" value="{{ old('requested_by', $changeRequest->requested_by ?? '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Requested Date</label>
        <input type="datetime-local" name="requested_date" value="{{ old('requested_date', isset($changeRequest) && $changeRequest->requested_date ? $changeRequest->requested_date->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Implementation Date</label>
        <input type="datetime-local" name="implementation_date" value="{{ old('implementation_date', isset($changeRequest) && $changeRequest->implementation_date ? $changeRequest->implementation_date->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border-slate-300">
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300">
            @foreach(['open','assigned','resolved','closed'] as $status)
                <option value="{{ $status }}" @selected(old('status', $changeRequest->status ?? 'open') === $status)>{{ ucfirst(str_replace('_',' ', $status)) }}</option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full rounded-xl border-slate-300">{{ old('description', $changeRequest->description ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Business Reason</label>
        <textarea name="business_reason" rows="3" class="w-full rounded-xl border-slate-300">{{ old('business_reason', $changeRequest->business_reason ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Implementation Plan</label>
        <textarea name="implementation_plan" rows="4" class="w-full rounded-xl border-slate-300">{{ old('implementation_plan', $changeRequest->implementation_plan ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Rollback Plan</label>
        <textarea name="rollback_plan" rows="4" class="w-full rounded-xl border-slate-300">{{ old('rollback_plan', $changeRequest->rollback_plan ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold mb-1">Verification Notes</label>
        <textarea name="verification_notes" rows="3" class="w-full rounded-xl border-slate-300">{{ old('verification_notes', $changeRequest->verification_notes ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Attachment Type</label>
        <select name="attachment_type" class="w-full rounded-xl border-slate-300">
            @foreach(['supporting_document','implementation_plan','rollback_plan','diagram','config_backup','evidence'] as $type)
                <option value="{{ $type }}">{{ ucfirst(str_replace('_',' ', $type)) }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold mb-1">Attachments</label>
        <input type="file" name="attachments[]" multiple class="w-full rounded-xl border border-slate-300 p-2">
        <p class="text-xs text-slate-500 mt-1">Multiple files allowed. Max 20MB per file.</p>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Save Change Request</button>
    <a href="{{ route('change-requests.index') }}" class="px-5 py-2.5 bg-white border rounded-xl font-semibold">Cancel</a>
</div>
