<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Template Name</label>
        <input name="name" value="{{ old('name', $template->name ?? '') }}" class="w-full rounded-xl border-slate-300" required>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Asset Category</label>
        <select name="asset_category_id" class="w-full rounded-xl border-slate-300">
            <option value="">General / All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('asset_category_id', $template->asset_category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Frequency</label>
        <select name="frequency" class="w-full rounded-xl border-slate-300">
            @foreach(['daily'=>'Daily','weekly'=>'Weekly','monthly'=>'Monthly','quarterly'=>'Quarterly','semester'=>'Semester','yearly'=>'Yearly','manual'=>'Manual'] as $value => $label)
                <option value="{{ $value }}" @selected(old('frequency', $template->frequency ?? 'monthly') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300">
            <option value="active" @selected(old('status', $template->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $template->status ?? 'active') === 'inactive')>Inactive</option>
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-slate-700 mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full rounded-xl border-slate-300">{{ old('description', $template->description ?? '') }}</textarea>
    </div>
</div>

<div class="mt-6 flex gap-3">
    <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Save Template</button>
    <a href="{{ route('checklist-templates.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 rounded-xl font-semibold text-slate-700">Cancel</a>
</div>
