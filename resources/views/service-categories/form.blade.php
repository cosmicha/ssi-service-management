<div class="space-y-4">
    <div>
        <label class="block text-sm font-semibold mb-1">Name</label>
        <input name="name" value="{{ old('name', $category->name ?? '') }}" class="w-full rounded-xl border-slate-300" required>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full rounded-xl border-slate-300">{{ old('description', $category->description ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-1">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300">
            <option value="active" @selected(old('status', $category->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $category->status ?? 'active') === 'inactive')>Inactive</option>
        </select>
    </div>
</div>
<div class="mt-6 flex gap-3">
    <button class="px-5 py-2.5 bg-slate-900 text-white rounded-xl font-semibold">Save</button>
    <a href="{{ route('service-categories.index') }}" class="px-5 py-2.5 bg-white border rounded-xl font-semibold">Cancel</a>
</div>
